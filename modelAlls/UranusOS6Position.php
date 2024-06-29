<?php
namespace app\modelAlls;
use app\core\ModelAll;
use app\core\Record;

class UranusOS6Position extends ModelAll
{
    public function __construct($params = NULL)
    {
        $params["dbName"] = "uranus";
        $params["dataName"] = "OS6Position";

        parent::__construct($params);
    }
}

class UranusOS6PositionRecord extends Record
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
#endregion  getting / returning variable

#region data process
#endregion data process
}
