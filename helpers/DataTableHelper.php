<?php
namespace app\TDEs;
use app\core\TDE;

class DataTableHelper extends TDE
{
    public array $hierarchy;
    public function __construct()
    {
        parent::__construct();
        $this->prepare("DataTableHelper");
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
    public function generateKeyData(string $varName, $columnKeys)
    {
        if($this->getStatusCode() != 100) return null;

        foreach($this->datas[$varName] AS $index => $data)
        {
            if(is_string($columnKeys))$key = $data[$columnKeys];
            else
            {
                $keys = [];
                foreach($columnKeys AS $index=>$columnKey)
                {
                    $keys[] = $data[$columnKey];
                }
                $key = implode("_",$keys);
            }

            if(!isset($NewData[$key]))$NewData[$key] = array();
            $NewData[$key][] = $data;
        }
        $NewVarName = $varName."WithKey";
        $this->addData($NewVarName, $NewData);
        $this->saveData($NewVarName);
    }
#endregion data process
}
