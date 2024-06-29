<?php
namespace app\TDEs;
use app\core\TDE;

class KendoComboBoxHelper extends TDE
{
    public function __construct()
    {
        parent::__construct();
        $this->prepare("KendoComboBoxHelper");
    }

#region init
#endregion init

#region set status
#endregion

#region setting variable
#endregion setting variable

#region getting / returning variable
#endregion  getting / returning variable

#region data process
    public function convertData(string $varName, $ColumnNames, bool $isAddAll = false)
    {
        if($this->getStatusCode() != 100) return null;
        $ExistingValues = [];

        if(is_string($ColumnNames))
        {
            $valueColumnNames = [$ColumnNames];
            $textColumnNames = [$ColumnNames];
        }
        else
        {
            if(is_array($ColumnNames[0])) $valueColumnNames = $ColumnNames[0];
            else $valueColumnNames = [$ColumnNames[0]];

            if(is_array($ColumnNames[1])) $textColumnNames = $ColumnNames[1];
            else $textColumnNames = [$ColumnNames[1]];
        }

        $this->savedData[$varName] = [];
        if($isAddAll && count($this->datas[$varName]) > 1)
        {
            $this->savedData[$varName][] = array("Value" => "*", "Text" => "ALL");
        }
        foreach($this->datas[$varName] AS $index => $data)
        {
            $Values = [];
            foreach($valueColumnNames AS $index => $valueColumnName)
                $Values[] = $data[$valueColumnName];
            $Value = implode("_",$Values);

            $Texts = [];
            foreach($textColumnNames AS $index => $textColumnName)
                $Texts[] = $data[$textColumnName];
            $Text = implode(" ",$Texts);

            if(!in_array($Value, $ExistingValues))
            {
                if(!$Value) {$Value = "[BLANK]";$Text = "[BLANK]";}
                $this->savedData[$varName][] = array("Value" => $Value, "Text" => $Text);
                $ExistingValues[] = $Value;
            }
        }
    }
#endregion data process

}
