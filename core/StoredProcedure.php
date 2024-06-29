<?php
namespace app\core;

class StoredProcedure
{
    public Application $app;
    public Database $db;

    protected string $dbName;
    protected string $spName;
    protected int $objectId;
    protected array $columns = [];
    protected array $columnProperties = [];
    protected array $declaredParameters = [];

    protected string $query = "";
    protected $statement;
    public array $row = [];

    protected array $recordParams;
    protected string $recordClass = "";
    protected bool $noClassRecord = false;
    protected array $returnColumns;

    protected array $parameters = [];
    protected array $sanitations;

    protected bool $returnIdAsKey = false;

    protected bool $isTran = false;
    protected bool $isTranTry = false;

    protected array $additionalFields = [];

    public function __construct(string $dbName = NULL, string $spName = NULL, array $params = NULL)
    {
        $this->app = Application::$app;
        $this->dbName = strtolower($dbName ?? $this->app->configs["app_name"]);
        if(isset($spName))$this->spName = $spName;

        $this->recordParams = $params["recordParams"] ?? [];

        $this->init();
    }
    //REDIRECT TO APP
    public function setStatusParams(array $statusParams){$this->app->setStatusParams($statusParams);}
    public function setStatusCode(int $statusCode, array $statusParams = NULL){$this->app->setStatusCode($statusCode, $statusParams);}
    public function getStatusCode(){return $this->app->getStatusCode();}
    public function statusMessage(){return $this->app->statusMessage();}

    #region initiation
        protected function init()
        {
            if($this->getStatusCode() != 100) return null;

            $dbConfigs = $this->app->configs["db"][$this->dbName];
            $this->db = new Database($dbConfigs);

            if(isset($this->spName))$this->initObjectId();
        }
            protected function initObjectId()
            {
                $q = "IF EXISTS(SELECT * FROM [sys].[procedures] WHERE [Name] = '{$this->spName}')
                    BEGIN SELECT [OBJECT_ID] FROM [sys].[procedures] WHERE [Name] = '{$this->spName}' END
                    ELSE BEGIN SELECT 0 END";
                $this->SPPrepare($q);
                $this->execute();
                $this->objectId = $this->getRow()[0]["OBJECT_ID"];

                if(!$this->objectId) $this->setStatusCode(710, [$this->dbName, $this->spName]);//SP NAME NOT FOUND
                else
                {
                    $this->initDeclaredParameters();
                    $this->initColumns();
                }
            }
            protected function initDeclaredParameters()
            {
                if($this->getStatusCode() != 100) return null;

                $q = "EXEC [SP_Sys_GetParameter] @objectId = {$this->objectId}";
                $this->SPPrepare($q);
                $this->addSanitation("name",["string"]);
                $this->addSanitation("parameter_id",["int"]);
                $this->addSanitation("system_type_id",["int"]);
                $this->addSanitation("max_length",["int"]);
                $this->addSanitation("precision",["int"]);
                $this->addSanitation("is_nullable",["bool"]);
                $this->execute();
                foreach($this->getRow() AS $index => $row)
                {
                    $row["name"] = str_replace("@","",$row["name"]);
                    $this->declaredParameters[$row["name"]] = [
                        "name" => $row["name"],
                        "order" => $row["parameter_id"],
                        "systemTypeId" => $row["system_type_id"],
                        "maxLenth" => $row["max_length"],
                        "precision" => $row["precision"],
                        "isNullable" => $row["is_nullable"],
                    ];
                }
            }
            protected function initColumns()
            {
                if($this->getStatusCode() != 100) return null;

                $q = "EXEC sp_describe_first_result_set [{$this->spName}]";
                $this->SPPrepare($q);
                $this->addSanitation("column_ordinal",["int"]);
                $this->addSanitation("name",["string"]);
                $this->addSanitation("is_nullable",["bool"]);
                $this->addSanitation("system_type_id",["int"]);
                $this->addSanitation("system_type_name",["string"]);
                $this->addSanitation("max_length",["int"]);
                $this->addSanitation("precision",["int"]);
                $this->addSanitation("is_identity_column",["bool"]);
                $this->execute();
                foreach($this->getRow() AS $index => $row)
                {
                    $this->columns[] = $row["name"];

                    $this->columnProperties[$row["name"]] = [
                        "order" => $row["column_ordinal"],
                        "name" => $row["name"],
                        "isNullable" => $row["is_nullable"],
                        "systemTypeId" => $row["system_type_id"],
                        "systemTypeName" => $row["system_type_name"],
                        "maxLenth" => $row["max_length"],
                        "precision" => $row["precision"],
                        "isIdentity" => $row["is_identity_column"],
                    ];
                }
            }
    #endregion initiation

    #region set variable
        public function initParameter(array $params)
        {
            if($this->getStatusCode() != 100) return null;
            $this->parameters = $params;
        }
        public function setReturnIdAsKey(bool $returnIdAsKey)
        {
            $this->returnIdAsKey = $returnIdAsKey;
        }
        public function renameParameter(string $oldField, string $newField)
        {
            if($this->getStatusCode() != 100) return null;
            foreach($this->parameters AS $field => $value)
            {
                if($field == $oldField)
                {
                    $this->addParameter($newField,$value);
                    $this->removeParameter($field);
                }
            }
        }
        public function addParameters(array $params)
        {
            if($this->getStatusCode() != 100) return null;
            foreach($params AS $field => $value)
            {
                $this->addParameter($field,$value);
            }
        }
            public function addParameter(string $field, $value)
            {
                if($this->getStatusCode() != 100) return null;
                if(!isset($this->parameters[$field]))$this->parameters[$field] = $value;
            }
        public function removeParameters($params)
        {
            if($this->getStatusCode() != 100) return null;
            if(is_array($params))
            {
                foreach($params AS $index => $field)
                {
                    $this->removeParameter($field);
                }
            }
            else
            {
                $this->removeParameter($params);
            }
        }
            protected function removeParameter(string $field)
            {
                if($this->getStatusCode() != 100) return null;
                if(isset($this->parameters[$field]))unset($this->parameters[$field]);
            }
        public function resetParamters()
        {
            if($this->getStatusCode() != 100) return null;
            $this->parameters = [];
        }
        public function addSanitation(string $key, array $rules)
        {
            if($this->getStatusCode() != 100) return null;

            $this->sanitations[$key] = $rules;
        }
        protected function autoSanitize()
        {
            if($this->getStatusCode() != 100) return null;

            foreach($this->columnProperties AS $field => $properties)
            {
                //echo "<br/>{$field} -> {$properties["systemTypeId"]}";
                if(!array_key_exists($field, $this->sanitations))
                {
                    switch($properties["systemTypeId"])
                    {
                        case 48 : $this->addSanitation($field, ["int"]);break;//"tinyint
                        case 56 : $this->addSanitation($field, ["int"]);break;//"int
                        case 127 : $this->addSanitation($field, ["int"]);break;//"bigint
                        case 106 : $this->addSanitation($field, ["dec"]);break;//"decimal
                        case 35 : $this->addSanitation($field, ["string"]);break;//"text
                        case 167 : $this->addSanitation($field, ["string"]);break;//"varchar
                        case 40 : $this->addSanitation($field, ["date"]);break;//"date
                        case 41 : $this->addSanitation($field, ["time"]);break;//"time
                        case 61 : $this->addSanitation($field, ["dateTime"]);break;//"datetime
                        case 231 : $this->addSanitation($field, ["json"]);break;//"json
                    }
                }
            }
        }
        public function setRecordClass(string $recordClass)
        {
            if($this->getStatusCode() != 100) return null;

            $this->recordClass = $recordClass;
        }
        public function setNoClassRecord(bool $bool)
        {
            if($this->getStatusCode() != 100) return null;

            $this->noClassRecord = $bool;
        }
        public function setReturnColumns(array $columnName)
        {
            if($this->getStatusCode() != 100) return null;

            $this->returnColumns = $columnName;
        }
        protected function setQuery(string $query)
        {
            if($this->getStatusCode() != 100) return null;
            if(!$query)$this->setStatusCode(781);//'Stored Procedure : Preparation error (missing query)';

            else $this->query = "SET NOCOUNT ON ;".$query;
        }

        public function setAdditionalField(string $fieldName, array $rule)
        {
            $this->additionalFields[$fieldName] = $rule;
        }

        #region transaction
            public function tranStart()
            {
                if($this->getStatusCode() != 100) return null;
                if($this->isTran) {$this->setStatusCode(770); return null;}

                $this->isTran = true;
                $this->query = "SET NOCOUNT ON ;BEGIN TRANSACTION";

                $this->tranDeclare("DB_VALIDATION_MESSAGE", "VARCHAR(MAX)");
                $this->tranDeclare("IsCatch", "INT");
            }
            public function tranDeclare(string $paramName, string $dataType)
            {
                if($this->getStatusCode() != 100) return null;
                if(!$this->isTran) {$this->setStatusCode(771); return null;}
                if($this->isTranTry) {$this->setStatusCode(772); return null;}
                if(in_array($paramName, $this->declaredParameters)){$this->setStatusCode(775,[$paramName]); return null;}

                $this->query .= " DECLARE @{$paramName} {$dataType};";

                $this->declaredParameters[] = $paramName;
            }
            public function tranTry(string $SPName, array $params = [])
            {
                if($this->getStatusCode() != 100) return null;
                if(!$this->isTran) {$this->setStatusCode(771); return null;}

                if(!$this->isTranTry)
                {
                    $this->query .= " BEGIN TRY";
                    $this->query .= " SET @IsCatch = 0;";
                    $this->isTranTry = true;
                }

                $this->query .= " IF(@DB_VALIDATION_MESSAGE IS NULL) BEGIN
                    EXEC [{$SPName}]";
                    $qParams = [];
                    foreach($params AS $paramName => $paramValue)
                    {
                        if(is_numeric($paramValue))
                            $qParams[] = " @{$paramName} = {$paramValue}";
                        else
                            if(substr($paramValue,0,1) == "@")
                            {
                                $paramValue = str_replace("@","",$paramValue);//BUANG @
                                if(!in_array($paramValue, $this->declaredParameters)){$this->setStatusCode(776,[$paramValue]); return null;}
                                $qParams[] = " @{$paramName} = @{$paramValue} OUTPUT";
                            }
                            else if(substr($paramValue,0,1) == "!")
                            {
                                $paramValue = str_replace("!","",$paramValue);//BUANG !
                                if(!in_array($paramValue, $this->declaredParameters)){$this->setStatusCode(776,[$paramValue]); return null;}
                                $qParams[] = " @{$paramName} = @{$paramValue}";
                            }
                            else
                                $qParams[] = " @{$paramName} = '{$paramValue}'";
                    }
                    $this->query .= " ".implode(",",$qParams);
                    $this->query .= ";";
                $this->query .= " END;";
            }
            public function tranEnd()
            {
                if($this->getStatusCode() != 100) return null;
                if(!$this->isTran) {$this->setStatusCode(771); return null;}

                $this->isTran = false;
                $this->query .= " END TRY
                    BEGIN CATCH
                        ROLLBACK TRANSACTION;

                        SET @IsCatch = 1;

                        SELECT 1[IsError]
                        ,ERROR_NUMBER()[ErrorNumber]
                        ,ERROR_SEVERITY()[ErrorSeverity]
                        ,ERROR_STATE()[ErrorState]
                        ,ERROR_PROCEDURE()[ErrorProcedure]
                        ,ERROR_LINE()[ErrorLine]
                        ,ERROR_MESSAGE()[ErrorMessage];
                    END CATCH

                    IF(@IsCatch = 0) BEGIN
                        IF (@DB_VALIDATION_MESSAGE IS NOT NULL AND @DB_VALIDATION_MESSAGE != '') BEGIN
                            ROLLBACK TRANSACTION;

                            SELECT 2[IsError]
                            ,@DB_VALIDATION_MESSAGE[DBValidationMessage];
                        END
                        ELSE IF @@TRANCOUNT = 1 BEGIN
                            COMMIT TRANSACTION;
                            SELECT 0[IsError];
                        END
                        ELSE BEGIN
                            ROLLBACK TRANSACTION;

                            SELECT 3[IsError]
                            ,'@@TRANSCOUNT = '+CAST(@@TRANCOUNT AS VARCHAR(100))[DBValidationMessage];
                        END
                    END";
            }
        #endregion transaction
    #endregion set variable

    #region get variable
        public function getSpName()
        {
            if($this->getStatusCode() != 100) return null;
            return $this->spName;
        }
        public function getColumns()
        {
            if($this->getStatusCode() != 100) return null;
            return $this->columns;
        }
        public function getColumnProperties(string $columnName)
        {
            if($this->getStatusCode() != 100) return null;
            return $this->columnProperties[$columnName];
        }
        public function getAllColumnProperties()
        {
            if($this->getStatusCode() != 100) return null;
            return $this->columnProperties;
        }
        public function getDeclaredParameters(string $columnName)
        {
            if($this->getStatusCode() != 100) return null;
            return $this->declaredParameters[$columnName];
        }
        public function getAllDeclaredParameters()
        {
            if($this->getStatusCode() != 100) return null;
            return $this->declaredParameters;
        }
        public function getReturnColumns()
        {
            if($this->getStatusCode() != 100) return null;

            return $this->returnColumns;
        }
        public function getRow()
        {
            if($this->getStatusCode() != 100) return [];

            return $this->row;
        }
        public function getQuery()
        {
            if($this->getStatusCode() != 100) return null;

            return $this->query;
        }
    #endregion get variable

    #region data process
        protected function prepare(string $query, array $options = NULL)
        {
            if($this->getStatusCode() != 100) return null;

            $options = $options ?? [\PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL];
            $this->statement = $this->db->pdo->prepare($query, $options);
        }
        public function execute()
        {
            if($this->getStatusCode() != 100) return null;

            if(!$this->query)
            {
                $this->setStatusCode(781);//'Stored Procedure : Preparation error (missing query)',
                return null;
            }

            $this->statement->execute();

            $this->fetch();

            return $this->getStatusCode();
        }
            protected function fetch()
            {
                if($this->getStatusCode() != 100) return null;

                $this->row = [];
                if($this->statement->columnCount())
                {
                    while($row = $this->statement->fetch(\PDO::FETCH_ASSOC))
                    {
                        foreach($row AS $field => $value)
                        {
                            $isOk = 1;
                            if(isset($this->returnColumns))
                            {
                                if(!in_array($field, $this->returnColumns))
                                    $isOk = 0;
                            }

                            if($isOk)
                            {
                                if(isset($this->sanitations[$field]))
                                {
                                    $rules = $this->sanitations[$field];

                                    foreach($rules AS $rule)
                                    {
                                        $ruleName = $rule;

                                        if(is_array($ruleName))
                                        {
                                            $ruleName = $rule[0];
                                        }

                                        if($ruleName == 'string')
                                        {
                                            $row[$field] = ltrim(rtrim(addslashes(strval($row[$field]))));
                                        }
                                        if($ruleName == 'json')
                                        {
                                            $row[$field] = ltrim(rtrim(strval($row[$field])));
                                            $row[$field] = json_decode($row[$field]);
                                        }
                                        if($ruleName == 'upper')
                                        {
                                            $row[$field] = strtoupper($row[$field]);
                                        }
                                        if($ruleName == 'date')
                                        {
                                            $row[$field] = substr(strval($row[$field]),0,10);
                                        }
                                        if($ruleName == 'time')
                                        {
                                            $row[$field] = substr(strval($row[$field]),0,8);
                                        }
                                        if($ruleName == 'dateTime')
                                        {
                                            $row[$field] = substr(strval($row[$field]),0,19);
                                        }
                                        if($ruleName == 'bool' || $ruleName == 'boolean')
                                        {
                                            $row[$field] = $row[$field] ? 1 : 0;
                                        }
                                        if($ruleName == 'int' || $ruleName == 'integer')
                                        {
                                            $row[$field] = intval($row[$field]);
                                        }
                                        if($ruleName == 'dec' || $ruleName == 'decimal')
                                        {
                                            $precision = 2;
                                            if(is_array($rule))
                                            {
                                                if(!isset($rule[1]))$precision = 2;
                                                else $precision = $rule[1];
                                            }
                                            $row[$field] = round(floatval($row[$field]),$precision);
                                        }
                                        if($ruleName == 'ecrypt')
                                        {
                                            $algo = PASSWORD_DEFAULT;
                                            if(is_array($rule))
                                            {
                                                if(!isset($rule[1]))$algo = PASSWORD_DEFAULT;
                                                else
                                                {
                                                    if($rule[1] == "hash")$algo = PASSWORD_DEFAULT;
                                                    else if($rule[1] == "bcrypt")$algo = PASSWORD_BCRYPT;
                                                    else if($rule[1] == "argon2i")$algo = PASSWORD_ARGON2I;
                                                    else if($rule[1] == "argon2id")$algo = PASSWORD_ARGON2ID;
                                                    else $algo = PASSWORD_DEFAULT;
                                                }
                                            }
                                            $row[$field] = password_hash($row[$field], PASSWORD_DEFAULT);
                                        }
                                    }
                                }
                                else
                                {
                                    //MANUAL SANITASI
                                    if(is_numeric($row[$field]))
                                    {
                                        if($row[$field] == intval($row[$field]))$row[$field] = intval($row[$field]);
                                        else $row[$field] = $row[$field] * 1;//klo decimal
                                    }
                                    else $row[$field] = ltrim(rtrim(addslashes(strval($row[$field]))));
                                }
                            }
                            else unset($row[$field]);
                        }

                        if(!$this->recordClass || $this->noClassRecord)
                        {
                            #region ADDITIONAL FIELDS
                                foreach($this->additionalFields AS $fieldName => $rule)
                                {
                                    if($rule[0] == "add")
                                    {
                                        $row[$fieldName] = 0;
                                        $params = $rule[1];
                                        foreach($params AS $index => $param)
                                        {
                                            if(is_numeric($param))
                                            {
                                                $row[$fieldName] += $param;
                                            }
                                            else if(isset($row[$param]))
                                            {
                                                //COLUMN EXIST
                                                $row[$fieldName] += $row[$param];
                                            }
                                        }
                                    }
                                    if($rule[0] == "substract")
                                    {
                                        $row[$fieldName] = 0;
                                        $params = $rule[1];
                                        foreach($params AS $index => $param)
                                        {
                                            if(is_numeric($param))
                                            {
                                                if(!$index)$row[$fieldName] = $param;
                                                else $row[$fieldName] -= $param;
                                            }
                                            else if(isset($row[$param]))
                                            {
                                                //COLUMN EXIST
                                                if(!$index)$row[$fieldName] = $row[$param];
                                                else $row[$fieldName] -= $row[$param];
                                            }
                                        }
                                    }
                                    if($rule[0] == "times")
                                    {
                                        $row[$fieldName] = 0;
                                        $params = $rule[1];
                                        foreach($params AS $index => $param)
                                        {
                                            if(is_numeric($param))
                                            {
                                                if(!$index)$row[$fieldName] = $param;
                                                else $row[$fieldName] *= $param;
                                            }
                                            else if(isset($row[$param]))
                                            {
                                                //COLUMN EXIST
                                                if(!$index)$row[$fieldName] = $row[$param];
                                                else $row[$fieldName] *= $row[$param];
                                            }
                                        }
                                    }
                                    if(substr($rule[0], 0, 6) == "divide")
                                    {
                                        $row[$fieldName] = 0;
                                        $params = $rule[1];
                                        foreach($params AS $index => $param)
                                        {
                                            if(is_numeric($param))
                                            {
                                                if(!$index)$row[$fieldName] = $param;
                                                else
                                                {
                                                    if($row[$fieldName] && $param)
                                                        $row[$fieldName] = $row[$fieldName] / $param;
                                                    else $row[$fieldName] = 0;
                                                }
                                            }
                                            else if(isset($row[$param]))
                                            {
                                                //COLUMN EXIST
                                                if(!$index)$row[$fieldName] = $row[$param];
                                                else
                                                {
                                                    if($row[$fieldName] && $row[$param])
                                                        $row[$fieldName] = $row[$fieldName] / $row[$param];
                                                    else $row[$fieldName] = 0;
                                                }
                                            }
                                        }

                                        if($rule[0] == "divide_down") $row[$fieldName] = floor($row[$fieldName]);
                                        else if($rule[0] == "divide_up") $row[$fieldName] = ceil($row[$fieldName]);
                                        else
                                        {
                                            $precision = 0;
                                            if(strlen($rule[0]) > 7)$precision = substr($rule[0], 7);
                                            $row[$fieldName] = round($row[$fieldName], $precision);
                                        }
                                    }
                                    if($rule[0] == "implode")
                                    {
                                        $row[$fieldName] = "";
                                        $fieldValues = [];
                                        $glue = $rule[1];
                                        $params = $rule[2];
                                        foreach($params AS $index => $param)
                                        {
                                            if(isset($row[$param]))
                                            {
                                                //COLUMN EXIST
                                                if($row[$param])$fieldValues[] = $row[$param];
                                            }
                                            else
                                            {
                                                $fieldValues[] = $param;
                                            }
                                        }
                                        $row[$fieldName] = implode($glue, $fieldValues);
                                    }
                                    if($rule[0] == "concatenate" || $rule[0] == "concat")
                                    {
                                        $row[$fieldName] = "";
                                        $fieldValues = [];
                                        $params = $rule[1];
                                        foreach($params AS $index => $param)
                                        {
                                            if(isset($row[$param]))
                                            {
                                                //COLUMN EXIST
                                                if($row[$param])$fieldValues[] = $row[$param];
                                            }
                                            else
                                            {
                                                $fieldValues[] = $param;
                                            }
                                        }
                                        $row[$fieldName] = implode("", $fieldValues);
                                    }
                                    if($rule[0] == "if")
                                    {
                                        $ifs = $rule[1];
                                        $row[$fieldName] = "";
                                        foreach($ifs AS $if)
                                        {
                                            $fieldToCheck = $if[0];
                                            $comparator = $if[1];
                                            $valueToCheck = $if[2];
                                            $trueResult = $if[3];

                                            if($comparator == "e")
                                            {
                                                if(isset($row[$valueToCheck]))//check if valueToCheck is a valid column name
                                                    $valueToCheck = $row[$valueToCheck];
                                                if($row[$fieldToCheck] == $valueToCheck)
                                                    $row[$fieldName] = $trueResult;
                                            }
                                            else if($comparator == "lt")
                                            {
                                                if(isset($row[$valueToCheck]))//check if valueToCheck is a valid column name
                                                    $valueToCheck = $row[$valueToCheck];
                                                if($row[$fieldToCheck] < $valueToCheck)
                                                    $row[$fieldName] = $trueResult;
                                            }
                                            else if($comparator == "lte")
                                            {
                                                if(isset($row[$valueToCheck]))//check if valueToCheck is a valid column name
                                                    $valueToCheck = $row[$valueToCheck];
                                                if($row[$fieldToCheck] <= $valueToCheck)
                                                    $row[$fieldName] = $trueResult;
                                            }
                                            else if($comparator == "gt")
                                            {
                                                if(isset($row[$valueToCheck]))//check if valueToCheck is a valid column name
                                                    $valueToCheck = $row[$valueToCheck];
                                                if($row[$fieldToCheck] > $valueToCheck)
                                                    $row[$fieldName] = $trueResult;
                                            }
                                            else if($comparator == "gte")
                                            {
                                                if(isset($row[$valueToCheck]))//check if valueToCheck is a valid column name
                                                    $valueToCheck = $row[$valueToCheck];
                                                if($row[$fieldToCheck] >= $valueToCheck)
                                                    $row[$fieldName] = $trueResult;
                                            }
                                        }

                                    }
                                    if($rule[0] == "replace")
                                    {
                                        $find = $rule[1];
                                        $replacement = $rule[2];
                                        $string = $row[$rule[3]];

                                        $row[$fieldName] = str_replace($find, $replacement, $string);
                                    }
                                }
                                if(count($this->additionalFields))
                                {
                                    foreach($this->additionalFields AS $fieldName => $rule)
                                    {
                                        if(substr($fieldName, 0, 5) == "TEMP_")
                                            unset($row[$fieldName]);
                                    }
                                }
                            #endregion ADDITIONAL FIELDS
                            if(!$this->returnIdAsKey)$this->row[] = $row;
                            else
                            {
                                $key = $row["Id"];
                                $this->row[$key] = $row;
                            }
                        }
                        else
                        {
                            $recordParams = [
                                "objectId" => $this->objectId
                                ,"columns" => $this->columns
                                ,"columnProperties" => $this->columnProperties
                            ];
                            foreach($this->recordParams AS $key => $param)
                            {
                                $recordParams[$key] = $param;
                            }
                            $record = new $this->recordClass($recordParams, $row);
                            //$record->setData($row);

                            #region ADDITIONAL FIELDS
                                foreach($this->additionalFields AS $fieldName => $rule)
                                {
                                    if($rule[0] == "add")
                                    {
                                        $record->$fieldName = 0;
                                        $params = $rule[1];
                                        foreach($params AS $index => $param)
                                        {
                                            if(is_numeric($param))
                                            {
                                                $record->$fieldName += $param;
                                            }
                                            else if(isset($record->$param))
                                            {
                                                //COLUMN EXIST
                                                $record->$fieldName += $record->$param;
                                            }
                                        }
                                    }
                                    if($rule[0] == "substract")
                                    {
                                        $record->$fieldName = 0;
                                        $params = $rule[1];
                                        foreach($params AS $index => $param)
                                        {
                                            if(is_numeric($param))
                                            {
                                                if(!$index)$record->$fieldName = $param;
                                                else $record->$fieldName -= $param;
                                            }
                                            else if(isset($record->$param))
                                            {
                                                //COLUMN EXIST
                                                if(!$index)$record->$fieldName = $record->$param;
                                                else $record->$fieldName -= $record->$param;
                                            }
                                        }
                                    }
                                    if($rule[0] == "times")
                                    {
                                        $record->$fieldName = 0;
                                        $params = $rule[1];
                                        foreach($params AS $index => $param)
                                        {
                                            if(is_numeric($param))
                                            {
                                                if(!$index)$record->$fieldName = $param;
                                                else $record->$fieldName *= $param;
                                            }
                                            else if(isset($record->$param))
                                            {
                                                //COLUMN EXIST
                                                if(!$index)$record->$fieldName = $record->$param;
                                                else $record->$fieldName *= $record->$param;
                                            }
                                        }
                                    }
                                    if(substr($rule[0], 0, 6) == "divide")
                                    {
                                        $record->$fieldName = 0;
                                        $params = $rule[1];
                                        foreach($params AS $index => $param)
                                        {
                                            if(is_numeric($param))
                                            {
                                                if(!$index)$record->$fieldName = $param;
                                                else
                                                {
                                                    if($record->$fieldName && $param)
                                                        $record->$fieldName = $record->$fieldName / $param;
                                                    else $record->$fieldName = 0;
                                                }
                                            }
                                            else if(isset($record->$param))
                                            {
                                                //COLUMN EXIST
                                                if(!$index)$record->$fieldName = $record->$param;
                                                else
                                                {
                                                    if($record->$fieldName && $record->$param)
                                                        $record->$fieldName = $record->$fieldName / $record->$param;
                                                    else $record->$fieldName = 0;
                                                }
                                            }
                                        }

                                        if($rule[0] == "divide_down") $record->$fieldName = floor($record->$fieldName);
                                        else if($rule[0] == "divide_up") $record->$fieldName = ceil($record->$fieldName);
                                        else
                                        {
                                            $precision = 0;
                                            if(strlen($rule[0]) > 7)$precision = substr($rule[0], 7);
                                            $record->$fieldName = round($record->$fieldName, $precision);
                                        }
                                    }
                                    if($rule[0] == "concatenate")
                                    {
                                        $record->$fieldName = "";
                                        $fieldValues = [];
                                        $glue = $rule[1];
                                        $params = $rule[2];
                                        foreach($params AS $index => $param)
                                        {
                                            if(isset($record->$param))
                                            {
                                                //COLUMN EXIST
                                                if($record->$param)$fieldValues[] = $record->$param;
                                            }
                                            else
                                            {
                                                $fieldValues[] = $param;
                                            }
                                        }
                                        $record->$fieldName = implode($glue, $fieldValues);
                                    }
                                }
                                if(count($this->additionalFields))
                                {
                                    foreach($this->additionalFields AS $fieldName => $rule)
                                    {
                                        if(substr($fieldName, 0, 5) == "TEMP_")
                                            unset($record->$fieldName);
                                    }
                                }
                            #endregion ADDITIONAL FIELDS
                            if(!$this->returnIdAsKey)$this->row[] = $record;
                            else
                            {
                                $key = $row["Id"];
                                $this->row[$key] = $record;
                            }
                        }
                    }
                }

                //reset sanitations
                $this->sanitations = [];
            }

        #region stored procedure
            public function SPGenerateParameters(array $params = null)
            {
                if($this->getStatusCode() != 100) return null;

                $paramters = [];
                foreach($this->parameters AS $field => $value)
                {
                    if(!$params)
                    {
                        if($this->generateSPParameter($field, $value))$paramters[] = $this->generateSPParameter($field, $value);
                    }
                    else
                    {
                        foreach($params AS $index => $fieldSought)
                        {
                            if(strtolower($field) == strtolower($fieldSought))
                            {
                                if($this->generateSPParameter($field, $value))$paramters[] = $this->generateSPParameter($field, $value);
                            }
                        }
                    }
                }
                return count($paramters) ? implode(",",$paramters) : "";
            }
                protected function generateSPParameter($field, $value)
                {
                    if($this->getStatusCode() != 100) return null;

                    if(is_int($value))return "@{$field} = {$value}";

                    if($value == "[BLANK]")return "@{$field} = ''";
                    if($value != "*")return "@{$field} = '{$value}'";//$value = * ; ALL / SEMUA
                }
            public function SPPrepare(string $query)
            {
                if($this->getStatusCode() != 100) return null;

                $this->setQuery($query);
                $this->prepare($this->query);
                return $this->getStatusCode();
            }
            public function f5()
            {
                if($this->getStatusCode() != 100) return null;

                $this->SPPrepare($this->SPGenerateQuery());
                $this->autoSanitize();
                //$this->execute();
                //return $this->getRow();

                $returns = [];
                $isExecute = 0;
                do
                {
                    if(!$isExecute)
                    {
                        $this->statement->execute();
                        $isExecute = 1;
                    }
                    $this->fetch();
                    $returns[] = $this->getRow();
                }
                while($this->statement->nextRowSet());

                if(count($returns) == 1)$returns = $returns[0];
                return $returns;
            }
        #endregion stored procedure

        #region transaction
            public function tranPrepare()
            {
                if($this->getStatusCode() != 100) return null;
                if($this->isTran) {$this->setStatusCode(771); return null;}
                if(!$this->isTranTry) {$this->setStatusCode(773); return null;}

                $this->prepare($this->query);
                return $this->getStatusCode();
            }
            public function tranF5()
            {
                if($this->getStatusCode() != 100) return null;

                $this->tranPrepare();
                $this->addSanitation("IsError", ["int"]);
                $this->addSanitation("ErrorNumber", ["int"]);
                $this->addSanitation("ErrorSeverity", ["int"]);
                $this->addSanitation("ErrorState", ["int"]);
                $this->addSanitation("ErrorProcedure", ["string"]);
                $this->addSanitation("ErrorLine", ["int"]);
                $this->addSanitation("ErrorMessage", ["string"]);
                $this->execute();

                $rows = $this->getRow();
                $row = $rows[0];

                if($row["IsError"] == 1)
                {
                    $this->tranErrorMessage($row);
                }
                else if($row["IsError"] == 2)
                {
                    $this->tranDBValidationMessage($row["DBValidationMessage"]);
                }
                return $row;
            }
            protected function tranErrorMessage(array $row)
            {
                $this->setStatusCode(779, $row);
            }
            protected function tranDBValidationMessage(string $DBValidationMessage)
            {
                $this->setStatusCode(778, [$DBValidationMessage]);
            }
        #endregion transaction

        public function nextRowSet()
        {
            if($this->getStatusCode() != 100) return null;

            $this->statement->nextRowSet();
            $this->fetch();
        }
        public function SPGenerateQuery()
        {
            if($this->getStatusCode() != 100) return null;

            return "EXEC [{$this->spName}] {$this->SPGenerateParameters()}";
        }
    #endregion data process
}
