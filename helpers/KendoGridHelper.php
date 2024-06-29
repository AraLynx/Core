<?php
namespace app\TDEs;
use app\core\TDE;

class KendoGridHelper extends TDE
{
    protected array $parentDatas;

    protected array $addColumnCombineRules;

    protected array $additionalFields = [];

    protected array $actions = [];

    public function __construct()
    {
        parent::__construct();
        $this->prepare("KendoGridHelper");
    }

#region init
#endregion init

#region set status
#endregion

#region setting variable
    public function setParentData(string $parentVar, $parentKeys = "Id")
    {
        if($this->getStatusCode() != 100) return null;

        $this->parentDatas = [];
        foreach($this->datas[$parentVar] AS $parentIndex => $data)
        {
            if(is_array($parentKeys))
            {
                $parentKeyValues  = [];
                foreach($parentKeys AS $index => $parentKey)
                {
                    $parentKeyValues[] = $data[$parentKey];
                }
                $parentKeyValue = implode("_",$parentKeyValues);
            }
            else
            {
                $parentKeyValue = $data[$parentKeys];
            }

            $this->parentDatas[$parentKeyValue] = $data;
        }
    }
    public function setChildData(string $childVar, $childForeignKeys, string $parentChildName = "Items")
    {
        if($this->getStatusCode() != 100) return null;
        foreach($this->datas[$childVar] AS $childIndex => $data)
        {
            if(is_array($childForeignKeys))
            {
                $parentKeyValues  = [];
                foreach($childForeignKeys AS $index => $childForeignKey)
                {
                    $parentKeyValues[] = $data[$childForeignKey];
                }
                $parentKeyValue = implode("_",$parentKeyValues);
            }
            else
            {
                $parentKeyValue = $data[$childForeignKeys];
            }

            if(!isset($this->parentDatas[$parentKeyValue])) $this->parentDatas[$parentKeyValue] = [];
            if(!isset($this->parentDatas[$parentKeyValue][$parentChildName])) $this->parentDatas[$parentKeyValue][$parentChildName] = [];

            $this->parentDatas[$parentKeyValue][$parentChildName][] = $data;
        }
    }
    public function addActions(string $varName, $actions)
    {
        if($this->getStatusCode() != 100) return null;
        if(!isset($this->actions[$varName]))$this->actions[$varName] = [];

        foreach($actions AS $action)
            $this->addAction($varName, $action);
    }
    public function addAction(string $varName, $action)
    {
        if($this->getStatusCode() != 100) return null;
        if(!isset($this->actions[$varName]))$this->actions[$varName] = [];

        $this->actions[$varName][] = $action;
    }
    public function addRowClass(string $varName)
    {
        $this->addField($varName, "RowClass", "ifs", [
            ["args" => [["IsCancel",1]], "result"=> "text-x"],
            ["args" => [["IsEnable",0]], "result"=> "text-nu"],
            ["args" => [["IsComplete",1]], "result"=> "text-co"],
            ["args" => [["IsRelease",1], ["StatusCode","RL WAP"]], "result"=> "text-rl-wap"],
            ["args" => [["IsRelease",1], ["StatusCode","RL AP"]], "result"=> "text-rl-ap"],
            ["args" => [["IsRelease",1], ["StatusCode","RL AAP"]], "result"=> "text-rl-aap"],
            ["args" => [["IsRelease",1], ["StatusCode","RL DAP"]], "result"=> "text-rl-dap"],
            ["args" => [["IsRelease",1]], "result"=> "text-rl"],
            ["result"=> "text-os"],
        ]);
    }
#endregion setting variable

#region getting / returning variable
#endregion  getting / returning variable

#region data process
    public function generateAction()
    {
        if($this->getStatusCode() != 100) return null;
        foreach($this->actions AS $varName => $actions)
        {
            foreach($this->datas[$varName] AS $rowIndex => $row)
            {
                $actionElement = "";
                foreach($actions AS $action)
                {
                    $ifs = $action["ifs"] ?? [];
                    $ifOk = true;//UNTUK BY PASS KLO TIDAK ADA PERSYARATAN IF
                    if(count($ifs))
                    {
                        $ifOk = false;
                        $rule = $ifs["rule"] ?? "and";
                        $args = $ifs["args"];

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
                        }
                        if($rule == "or")
                        {
                            if(in_array(true,$subIfOks))$ifOk = true;//KLO ADA 1 SAJA YG TRUE = TRUE
                        }
                        else if($rule == "and")
                        {
                            $ifOk = true;
                            if(in_array(false,$subIfOks))$ifOk = false;//KLO ADA 1 SAJA YG FALSE = FALSE
                        }
                    }

                    if($ifOk)
                    {
                        $faIcon = $action["faIcon"];
                        $title = $action["title"] ?? "";
                        $functions = $action["functions"];
                        $functionElement = "";
                        foreach($functions AS $function)
                        {
                            $fnName = $function["name"];
                            $args = $function["args"];
                            $fnArgValues = [];
                            foreach($args AS $arg)
                            {
                                if(isset($row[$arg]))
                                {
                                    if(is_numeric($row[$arg]))$fnArgValues[] = $row[$arg];
                                    else $fnArgValues[] = "&quot;{$row[$arg]}&quot;";
                                }
                                else
                                {
                                    $fnArgValues[] = "&quot;{$arg}&quot;";
                                }
                            }
                            //dd($fnArgValues);
                            $fnArgText = implode(",",$fnArgValues);
                            $functionElement .= "{$fnName}({$fnArgText});";
                        }

                        $actionElement .= "<button class='btn btn-sm btn-outline-dark' onClick='{$functionElement}' title='{$title}'><i class='fa-fw {$faIcon}'></i></button>";
                    }
                }



                $this->datas[$varName][$rowIndex]["Action"] = $actionElement;
            }

        }
    }
    public function saveParentData(string $varName)
    {
        if($this->getStatusCode() != 100) return null;
        $this->savedData = [];
        $this->savedData[$varName] = $this->parentDatas;
    }
    public function removeItemKey($originalDatas, string $ItemKey = "Items")
    {
        $finalDatas = [];
        foreach($originalDatas AS $index => $originalData)
        {
            $finalData = [];
            foreach($originalData AS $key => $value)
            {
                if($key == $ItemKey)
                {
                    $originalItems = $value;
                    $finalItems = [];

                    if(array_key_exists($ItemKey, $originalItems))
                    {
                        $finalItems = $this->removeItemKey($items, $ItemKey);
                    }
                    else
                    {
                        foreach($originalItems AS $itemKey => $items)
                        {
                            $finalItems[] = $items;
                        }
                    }
                    $finalData[$ItemKey] = $finalItems;
                }
                else
                {
                    $finalData[$key] = $value;
                }
            }
            $finalDatas[] = $finalData;
        }
        return $finalDatas;
    }
#endregion data process
}
