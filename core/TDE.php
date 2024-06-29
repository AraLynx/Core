<?php
namespace app\core;

require_once dirname(__DIR__,1)."/functions/numeric.php";

class TDE
{
    protected Application $app;
    protected string $type;

    protected array $datas;
    protected array $savedData;

    protected array $additionalFieldRules = [];

    public function __construct()
    {
        $this->app = Application::$app;
    }
    //REDIRECT TO APP
    public function setStatusParams(array $statusParams){$this->app->setStatusParams($statusParams);}
    public function setStatusCode(int $statusCode, array $statusParams = NULL){$this->app->setStatusCode($statusCode, $statusParams);}
    public function getStatusCode(){return $this->app->getStatusCode();}
    public function statusMessage(){return $this->app->statusMessage();}

    #region init
        public function prepare(string $type)
        {
            if($this->getStatusCode() != 100) return null;

            $this->type = $type;
        }
    #endregion init

    #region set status
    #endregion

    #region setting variable
        public function addDatas($params, $otherParams = null)
        {
            if($this->getStatusCode() != 100) return null;
            /*
            $TDE->addDatas($varName, $data);
            $TDE->addDatas(array(
                    $varName1=>$data1,
                    $varName2=>$data2
                ));
            */
            if(is_string($params))
            {
                $varName = $params;
                $data  = $otherParams;
                $this->addData($varName,$data);
            }
            else if(is_array($params))
            {
                foreach($params AS  $varName => $data)
                {
                    $this->addData($varName,$data);
                }
            }
        }
            protected function addData(string $varName, $data)
            {
                if($this->getStatusCode() != 100) return null;
                $this->datas[$varName] = $data;
            }
        public function saveData(string $varName)
        {
            $this->savedData[$varName] = $this->datas[$varName];
        }

        public function addField(string $varName, string $newFieldName, string $ruleType, array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            if(!isset($this->additionalFieldRules[$varName]))$this->additionalFieldRules[$varName] = [];
            $this->additionalFieldRules[$varName][] = ["fieldName" => $newFieldName, "ruleType" => $ruleType, "params" => $params];
        }
    #endregion setting variable

    #region getting / returning variable
    #endregion  getting / returning variable

    #region data process
        public function generateAdditionalFields()
        {
            if($this->getStatusCode() != 100) return null;
            foreach($this->datas AS $varName => $rows)
            {
                if(isset($this->additionalFieldRules[$varName]))
                {
                    foreach($rows AS $rowIndex => $row)
                    {
                        foreach($this->additionalFieldRules[$varName] AS $additionalFieldRules)
                        {
                            $fieldName = $additionalFieldRules["fieldName"];
                            $ruleType = $additionalFieldRules["ruleType"];
                            $ruleParams = $additionalFieldRules["params"];

                            if($ruleType == "implode")
                            {
                                $this->datas[$varName][$rowIndex][$fieldName] = "";
                                $implodeValues = [];

                                $glue = $ruleParams[0];
                                $fieldsOrTexts = $ruleParams[1];
                                foreach($fieldsOrTexts AS $fieldOrText)
                                {
                                    if(isset($this->datas[$varName][$rowIndex][$fieldOrText]))//IF COLUMN EXIST
                                    {
                                        if($this->datas[$varName][$rowIndex][$fieldOrText])//AND HAS VALUE
                                            $implodeValues[] = $this->datas[$varName][$rowIndex][$fieldOrText];
                                    }
                                    else
                                    {
                                        $implodeValues[] = $fieldOrText;
                                    }
                                }
                                $this->datas[$varName][$rowIndex][$fieldName] = implode($glue, $implodeValues);
                            }
                            if($ruleType == "concat" || $ruleType == "concatenate")
                            {
                                $this->datas[$varName][$rowIndex][$fieldName] = "";
                                $implodeValues = [];

                                $fieldsOrTexts = $ruleParams;
                                foreach($fieldsOrTexts AS $fieldOrText)
                                {
                                    if(isset($this->datas[$varName][$rowIndex][$fieldOrText]))//IF COLUMN EXIST
                                    {
                                        if($this->datas[$varName][$rowIndex][$fieldOrText])//AND HAS VALUE
                                            $this->datas[$varName][$rowIndex][$fieldName] .= $this->datas[$varName][$rowIndex][$fieldOrText];
                                    }
                                    else
                                    {
                                        $this->datas[$varName][$rowIndex][$fieldName] .= $fieldOrText;
                                    }
                                }
                            }
                            if($ruleType == "price")
                            {
                                $this->datas[$varName][$rowIndex][$fieldName] = "";

                                $nominalFieldName = $ruleParams[0];
                                $currency = $ruleParams[1] ?? "rupiah";
                                $value = $this->datas[$varName][$rowIndex][$nominalFieldName];

                                $this->datas[$varName][$rowIndex][$fieldName] = generatePrice($value, $currency);
                            }
                            if($ruleType == "replace")
                            {
                                $this->datas[$varName][$rowIndex][$fieldName] = "";

                                $find = $ruleParams[0];
                                $replacement = $ruleParams[1];
                                $string = $this->datas[$varName][$rowIndex][$ruleParams[2]];

                                $this->datas[$varName][$rowIndex][$fieldName] = str_replace($find, $replacement, $string);
                            }
                            if($ruleType == "ifs")
                            {
                                $this->datas[$varName][$rowIndex][$fieldName] = "";

                                $ifs = $ruleParams;
                                $trueResult = "";
                                foreach($ifs AS $if)
                                {
                                    if(!$trueResult)
                                    {
                                        $rule = $if["rule"] ?? "and";
                                        $args = $if["args"] ?? [];
                                        $result = $if["result"];

                                        $subIfOks = [];
                                        foreach($args AS $arg)
                                        {
                                            $fieldToCheck = $arg[0];
                                            $valueCompare = $arg[1];
                                            $comparator = $arg[2] ?? "e";

                                            $valueToCheck = $this->datas[$varName][$rowIndex][$fieldToCheck];
                                            if($comparator == "e" || $comparator == "=")//EQUAL
                                            {
                                                if(is_array($valueCompare))
                                                {
                                                    if(in_array($valueToCheck, $valueCompare))$subIfOks[] = true;
                                                    else $subIfOks[] = false;
                                                }
                                                else if($valueToCheck == $valueCompare) $subIfOk = true;
                                                else $subIfOks[] = false;
                                            }
                                            else if($comparator == "ne" || $comparator == "!" || $comparator == "!=")
                                            {
                                                if($valueToCheck != $valueCompare) $subIfOk[] = true;
                                                else $subIfOks[] = false;
                                            }
                                            else if($comparator == "lt" || $comparator == "<")
                                            {
                                                if($valueToCheck < $valueCompare) $subIfOk[] = true;
                                                else $subIfOks[] = false;
                                            }
                                            else if($comparator == "lte" || $comparator == "<=")
                                            {
                                                if($valueToCheck <= $valueCompare) $subIfOk[] = true;
                                                else $subIfOks[] = false;
                                            }
                                            else if($comparator == "gt" || $comparator == ">")
                                            {
                                                if($valueToCheck > $valueCompare) $subIfOk[] = true;
                                                else $subIfOks[] = false;
                                            }
                                            else if($comparator == "gte" || $comparator == ">=")
                                            {
                                                if($valueToCheck >= $valueCompare) $subIfOk[] = true;
                                                else $subIfOks[] = false;
                                            }
                                            //if($isTrue) $this->datas[$varName][$rowIndex][$fieldName] = $trueResult;
                                        }
                                        if($rule == "or")
                                        {
                                            if(in_array(true,$subIfOks))//KLO ADA 1 SAJA YG TRUE = TRUE
                                            {
                                                if(isset($this->datas[$varName][$rowIndex][$result]))$trueResult = $this->datas[$varName][$rowIndex][$result];
                                                else $trueResult = $result;
                                            }
                                        }
                                        else if($rule == "and")
                                        {
                                            if(isset($this->datas[$varName][$rowIndex][$result]))$trueResult = $this->datas[$varName][$rowIndex][$result];
                                            else $trueResult = $result;

                                            if(in_array(false,$subIfOks))$trueResult = "";//KLO ADA 1 SAJA YG FALSE = FALSE
                                        }
                                    }
                                }
                                $this->datas[$varName][$rowIndex][$fieldName] = $trueResult;
                            }

                            //calculate
                            if($ruleType == "add")
                            {
                                $this->datas[$varName][$rowIndex][$fieldName] = 0;
                                $fieldsOrNums = $ruleParams[0];
                                foreach($fieldsOrNums AS $fieldOrNum)
                                {
                                    if(is_numeric($fieldOrNum))
                                    {
                                        $this->datas[$varName][$rowIndex][$fieldName] += $fieldOrNum;
                                    }
                                    else if(isset($this->datas[$varName][$rowIndex][$fieldOrText]))//IF COLUMN EXIST
                                    {
                                        if($this->datas[$varName][$rowIndex][$fieldOrText])//AND HAS VALUE
                                        $this->datas[$varName][$rowIndex][$fieldName] += $this->datas[$varName][$rowIndex][$fieldOrText];
                                    }
                                }
                            }
                            if($ruleType == "sub" || $ruleType == "substract")
                            {
                                $this->datas[$varName][$rowIndex][$fieldName] = 0;
                                $fieldsOrNums = $ruleParams[0];
                                foreach($fieldsOrNums AS $fieldOrNum)
                                {
                                    if(is_numeric($fieldOrNum))
                                    {
                                        $this->datas[$varName][$rowIndex][$fieldName] -= $fieldOrNum;
                                    }
                                    else if(isset($this->datas[$varName][$rowIndex][$fieldOrText]))//IF COLUMN EXIST
                                    {
                                        if($this->datas[$varName][$rowIndex][$fieldOrText])//AND HAS VALUE
                                        $this->datas[$varName][$rowIndex][$fieldName] -= $this->datas[$varName][$rowIndex][$fieldOrText];
                                    }
                                }
                            }
                            if($ruleType == "times")
                            {
                                $this->datas[$varName][$rowIndex][$fieldName] = 1;
                                $fieldsOrNums = $ruleParams[0];
                                foreach($fieldsOrNums AS $fieldOrNum)
                                {
                                    if(is_numeric($fieldOrNum))
                                    {
                                        $this->datas[$varName][$rowIndex][$fieldName] *= $fieldOrNum;
                                    }
                                    else if(isset($this->datas[$varName][$rowIndex][$fieldOrText]))//IF COLUMN EXIST
                                    {
                                        $this->datas[$varName][$rowIndex][$fieldName] *= $this->datas[$varName][$rowIndex][$fieldOrText];
                                    }
                                }
                            }
                            if($ruleType == "divide")
                            {

                            }
                        }

                        foreach($this->additionalFieldRules[$varName] AS $additionalFieldRules)
                        {
                            $fieldName = $additionalFieldRules["fieldName"];
                            if(substr($fieldName, 0, 5) == "TEMP_")
                                unset($this->datas[$varName][$rowIndex][$fieldName]);
                        }
                    }
                }
            }
        }
        public function getSavedData($varNames = null, bool $removeKey = true)
        {
            if($this->getStatusCode() != 100) return [];

            //if(isset($this->additionalFieldRules))$this->generateAdditionalFields();
            if($varNames == null)
            {
                if(!$removeKey)return $this->savedData;

                $return = [];
                foreach($this->savedData AS $varName => $datas)
                {
                    $return[$varName] = [];
                    foreach($datas AS $key => $data)
                    {
                        $return[$varName][] = $data;
                    }
                }
                return $return;
            }
            else
            {
                if(is_string($varNames))
                {
                    $varName = $varNames;
                    if(!$removeKey)return $this->savedData[$varName];

                    $return = [];
                    foreach($this->savedData[$varName] AS $key => $data)
                    {
                        $return[] = $data;
                    }
                    return $return;
                }
                else
                {
                    $return = [];
                    foreach($varNames AS $varName)
                    {
                        if(!$removeKey)$return[$varName] = $this->savedData[$varName];
                        else
                        {
                            foreach($this->savedData[$varName] AS $key => $data)
                            {
                                $return[$varName][] = $data;
                            }
                        }
                    }
                    return $return;
                }
            }
        }
    #endregion data process
}
