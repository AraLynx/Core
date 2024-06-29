<?php
namespace app\modelAlls;
use app\core\ModelAll;
use app\core\Record;

class PlutusSPK extends ModelAll
{
    public function __construct($params = NULL)
    {
        $params["dbName"] = "plutus";
        $params["dataName"] = "SPK";

        parent::__construct($params);
    }
}

class PlutusSPKRecord extends Record
{
    public function __construct(array $params, array $record)
    {
        parent::__construct($params, $record);

        $this->initialize();
    }

#region init
    protected function initialize()
    {
        if($this->getStatusCode() != 100) return null;

    }
#endregion init

#region set status
#endregion

#region setting variable
#endregion setting variable

#region getting / returning variable
    public function getSomething(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

    }
#endregion  getting / returning variable

#region data process
    protected function generateNumberTextProfile(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;
    }
#endregion data process
}
