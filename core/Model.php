<?php
namespace app\core;

class Model
{
    protected Application $app;
    protected StoredProcedure $SP;
    protected string $type;

    protected string $namespace;
    protected string $dbName;
    protected string $dataName;
    protected string $suffixName;
    protected string $tableName;

    protected int $recursiveOrder;
    protected array $children = [];
    protected array $childParameters = [];

    protected $parent;

    protected bool $isGenerateDim;
    protected array $dims = [];

    protected string $idColumn;

    protected array $recordParams;
    protected string $recordClass;
    protected array $records;

    public function __construct(array $params = [])
    {
        $this->app = Application::$app;
        $this->namespace = $params["namespace"] ?? "app";
        $this->dbName = $params["dbName"];
        $this->dataName = $params["dataName"];
        $this->suffixName = $params["suffixName"];
            $this->tableName = $this->suffixName."_".$this->dataName;
            $spName = "SP_".$this->tableName;
        $this->recursiveOrder = $params["recursiveOrder"] ?? 0;
        $this->isGenerateDim = $params["isGenerateDim"] ?? false;

        $this->recordParams = $params["recordParams"] ?? [];

        $SPParams = [
            "recordParams" => $this->recordParams
        ];
        $this->SP = new StoredProcedure($this->dbName, $spName, $SPParams);
        $this->init();

        if(isset($params["parameters"]))
        {
            foreach($params["parameters"] AS $index => $parameter)
            {
                $this->addParameter($parameter[0], $parameter[1]);
            }
        }
        if(isset($params["childParameters"]))
        {
            foreach($params["childParameters"] AS $childClassName => $parameters)
            {
                foreach($parameters AS $index => $parameter)
                {
                    $this->addChildParameters($childClassName, $parameter);
                }
            }
        }

        $parentRecordClass = "";
        if($this->suffixName == "FACT")$parentRecordClass = "ModelFacts";
        if($this->suffixName == "DIM")$parentRecordClass = "ModelDims";
        if($this->suffixName == "REL")$parentRecordClass = "ModelRels";
        if($this->suffixName == "TEMP")$parentRecordClass = "ModelTemps";
        if($this->suffixName == "ALL")$parentRecordClass = "ModelAlls";

        $tryRecordClass = "\\{$this->namespace}\\{$parentRecordClass}\\{$this->dbName}{$this->dataName}Record";
        if(class_exists($tryRecordClass))
        {
            $this->recordClass = $tryRecordClass;
            $this->SP->setRecordClass($this->recordClass);
        }
    }
    //REDIRECT TO APP
    public function setStatusParams(array $statusParams){$this->app->setStatusParams($statusParams);}
    public function setStatusCode(int $statusCode, array $statusParams = NULL){$this->app->setStatusCode($statusCode, $statusParams);}
    public function getStatusCode(){return $this->app->getStatusCode();}
    public function statusMessage(){return $this->app->statusMessage();}

    #region initiation
        public function init()
        {
            if($this->getStatusCode() != 100) return null;

            foreach($this->SP->getColumns() AS $index => $columnName)
            {
                if(strtolower($columnName) == "id")$this->setIdColumn($columnName);
                //else if(substr($columnName, -2) == "Id")$this->tryFindRelation($columnName);
            }
        }
    #endregion initiation

    #region set status
        protected function checkColumnExist(string $columnName)
        {
            if($this->getStatusCode() != 100) return null;
            if(!in_array($columnName, $this->SP->getColumns())){$this->setStatusCode(711,[$this->dbName, $this->SP->getSpName(), $columnName]);return false;}
            return true;
        }
        protected function checkParameterExist(string $parameterName)
        {
            if($this->getStatusCode() != 100) return null;
            if(!array_key_exists($parameterName, $this->SP->getAllDeclaredParameters())){$this->setStatusCode(713,[$this->dbName, $this->SP->getSpName(), $parameterName]);return false;}
            return true;
        }
        protected function checkChildExist(string $childClassName)
        {
            if($this->getStatusCode() != 100) return null;

            if(!array_key_exists($childClassName, $this->children)){$this->setStatusCode(717,[$this->dbName, $this->SP->getSpName(), $childClassName]);return false;}
            return true;
        }
        protected function checkIdColumnExist()
        {
            if($this->getStatusCode() != 100) return null;
            if(!isset($this->idColumn)){$this->setStatusCode(714,[$this->dbName, $this->SP->getSpName()]);return false;}
            return true;
        }
        protected function checkModelClassExist($modelClassName)
        {
            if($this->getStatusCode() != 100) return null;
            if(!class_exists($modelClassName)) {$this->setStatusCode(715,[$modelClassName]);return null;}
            return true;
        }
    #endregion set status

    #region set variable
        public function setIdColumn(string $columnName)
        {
            if($this->getStatusCode() != 100) return null;

            if($this->checkColumnExist($columnName))
            {
                $this->idColumn = $columnName;
            }
            return $this;
        }
        public function setRecursiveOrder(int $recursiveOrder)
        {
            $this->recursiveOrder = $recursiveOrder;
            return $this;
        }
        #region PASSING SP METHODS
            public function initParameter(array $params)
            {
                if($this->getStatusCode() != 100) return null;
                $this->SP->initParameter($params);
                return $this;
            }
            public function setReturnIdAsKey(bool $returnIdAsKey)
            {
                if($this->getStatusCode() != 100) return null;
                $this->SP->setReturnIdAsKey($returnIdAsKey);
                return $this;
            }
            public function renameParameter(string $search, string $replace)
            {
                if($this->getStatusCode() != 100) return null;
                if($this->checkParameterExist($replace))
                {
                    $this->SP->renameParameter($search, $replace);
                }
                return $this;
            }
            public function addParameters(array $params)
            {
                if($this->getStatusCode() != 100) return null;
                foreach($params AS $field => $value)
                {
                    $this->addParameter($field,$value);
                }
                return $this;
            }
                public function addParameter(string $parameterName, $value)
                {
                    if($this->getStatusCode() != 100) return null;

                    if($this->checkParameterExist($parameterName))
                    {
                        $this->SP->addParameters([$parameterName => $value]);
                    }
                    return $this;
                }
            public function removeParameters($params)
            {
                if($this->getStatusCode() != 100) return null;
                $this->SP->removeParameters($params);
                return $this;
            }
            public function resetParameter()
            {
                if($this->getStatusCode() != 100) return null;
                $this->SP->resetParamters();
                return $this;
            }
            public function addSanitation(string $key, array $rules)
            {
                if($this->getStatusCode() != 100) return null;

                $this->SP->addSanitation($key, $rules);
                return $this;
            }
            public function setNoClassRecord(bool $bool)
            {
                if($this->getStatusCode() != 100) return null;

                $this->SP->setNoClassRecord($bool);
            }
            public function setReturnColumns(array $columnName)
            {
                if($this->getStatusCode() != 100) return null;

                $this->SP->setReturnColumns($columnName);
            }
            public function setAdditionalField(string $fieldName, array $rule)
            {
                if($this->getStatusCode() != 100) return null;

                $this->SP->setAdditionalField($fieldName, $rule);
            }
            public function getReturnColumns(array $columnName)
            {
                if($this->getStatusCode() != 100) return null;

                return $this->SP->getReturnColumns();
            }
        #endregion PASSING SP METHODS

        public function addChildParameters(string $childClassName, array $parameter)
        {
            if($this->getStatusCode() != 100) return null;

            if(!isset($this->childParameters[$childClassName]))$this->childParameters[$childClassName] = [];
            $this->childParameters[$childClassName][] = $parameter;

            return $this;
        }

        public function setChild(string $childClassName, array $params = NULL)
        {
            if($this->getStatusCode() != 100) return null;
            if(!$this->checkIdColumnExist()) return null;
            if(!$this->recursiveOrder) return null;

            $parentKey = $params["parentKey"] ?? $this->idColumn;

            if(!$this->checkColumnExist($parentKey)) return null;
            if($this->checkModelClassExist($childClassName))
            {
                $child = new $childClassName();
                $columnChildForeignId = "";
                $childColumns = $child->getColumns();
                foreach($childColumns AS $index => $childColumn)
                {
                    if($childColumn == $this->getTableNameWithoutSuffix()."Id")
                    {
                        $columnChildForeignId = $childColumn;
                    }
                }
                if(!$columnChildForeignId){$this->setStatusCode(716,[$childClassName]);return null;}

                $classNameSpaces = [];
                $className = "";
                $explode = explode("\\",$childClassName);
                foreach($explode AS $index => $text)
                {
                    if($text)
                    {
                        if($index+1 != count($explode))$classNameSpaces[] = $text;
                        else $className = $text;
                    }
                }
                $this->children[$className] = [
                    "columnParentKeyId" => $parentKey,
                    "columnChildForeignId" => $columnChildForeignId,
                    "classNameSpace" => "\\".implode("\\",$classNameSpaces),
                    "className" => $className,
                ];
            }
        }
        public function setDim(string $dimClassName, array $params)
        {
            if($this->getStatusCode() != 100) return null;
            if(!$this->checkIdColumnExist()) return null;
            if(!$this->isGenerateDim)return null;

            $foreignKey = $params["foreignKey"];

            if(!isset($this->dims[$foreignKey]))
            {

                $dim = new $dimClassName();
                $dim->SP->setReturnIdAsKey(true);
                $dimension = $dim->f5();

                if(!$this->checkColumnExist($foreignKey)) return null;
                if($this->checkModelClassExist($dimClassName))
                {
                    $classNameSpaces = [];
                    $className = "";
                    $explode = explode("\\",$dimClassName);
                    foreach($explode AS $index => $text)
                    {
                        if($text)
                        {
                            if($index+1 != count($explode))$classNameSpaces[] = $text;
                            else $className = $text;
                        }
                    }

                    $this->dims[$foreignKey] = $dimension;
                }
            }
        }
    #endregion set variable

    #region get variable
        protected function getTableNameWithoutSuffix()
        {
            if($this->getStatusCode() != 100) return null;

            $return = $this->tableName;
            $return = str_replace(["FACT_","DIM_","REL_","TEMP_","LOG_"],"",$return);

            return $return;
        }
        public function getQuery()
        {
            if($this->getStatusCode() != 100) return null;
            return $this->SP->SPGenerateQuery();
        }
    #endregion get variable

    #region data process
        protected function tryFindRelation(string $columnName)
        {
            if($this->getStatusCode() != 100) return null;

            $search = substr($columnName,0,strlen($columnName) - 2);
            foreach(["Uranus","Gaia","Selene","Plutus"] AS $index2 => $db)
            {
                if(!isset($this->dims[$columnName]))
                {
                    $className = "\{$this->namespace}\modelDims\\{$db}{$search}";
                    if(class_exists("\{$this->namespace}\modelDims\\{$db}{$search}"))
                    {
                        $this->setDim($className, ["foreignKey" => $columnName]);
                        break;
                    }
                }
            }
        }

        protected function SPGenerateQuery()
        {
            if($this->getStatusCode() != 100) return null;

        }
        public function tempF5()
        {
            if($this->getStatusCode() != 100) return null;

            $return = $this->SP->f5();

            foreach($return AS $index => $parent)
            {
                //ENRICHMENT DIM
                if($this->isGenerateDim) $return[$index] = $this->f5Dim($parent);

                //GENERATING CHILDREN
                if($this->recursiveOrder)$return[$index] = $this->f5Children($parent);
            }
            $this->records = $return;
        }
        public function f5()
        {
            if($this->getStatusCode() != 100) return null;

            $this->tempF5();
            return $this->records;
        }
            protected function f5Dim($parent)
            {
                if($this->getStatusCode() != 100) return null;

                foreach($parent AS $column => $value)
                {
                    if(substr($column, -2) == "Id")
                    {
                        $dataName = substr($column,0,strlen($column) - 2);
                        if(isset($this->dims[$column]))
                        {
                            if(isset($this->dims[$column][$value]))
                            {
                                $dim = $this->dims[$column][$value];
                                foreach($dim AS $dimColumn => $dimValue)
                                {
                                    if($dimColumn != "Id")
                                    {
                                        if(is_array($parent)) $parent[$dataName.$dimColumn] = $dimValue;
                                        else $parent->setData([$dataName.$dimColumn => $dimValue]);
                                    }
                                }
                            }
                        }
                    }
                }

                return $parent;
            }
            protected function f5Children($parent)
            {
                if($this->getStatusCode() != 100) return null;

                foreach($this->children AS $childClassName => $child)
                {
                    $columnParentKeyId = $child["columnParentKeyId"];
                    $columnChildForeignId = $child["columnChildForeignId"];
                    $classNameSpace = $child["classNameSpace"];
                    $className = $child["className"];

                    if(is_array($parent)) $parentId = $parent[$columnParentKeyId];
                    else $parentId = $parent->$columnParentKeyId;

                    $fullClassName = "{$classNameSpace}\\{$className}";

                    $params = [];
                    $params["recursiveOrder"] = $this->recursiveOrder - 1;
                    foreach($this->childParameters AS $childParametersIndex => $parameters)
                    {
                        if($childParametersIndex == $childClassName)
                            $params["parameters"] = $this->childParameters[$childClassName];

                        $params["childParameters"][$childParametersIndex] = $parameters;
                    }

                    $children = new $fullClassName($params);

                    if(is_array($parent)) $parent[$className] = $children->addParameter($columnChildForeignId, $parentId)->f5();
                    else $parent->setData([$className => $children->addParameter($columnChildForeignId, $parentId)->f5()]);
                }
                return $parent;
            }
    #endregion data process
}
