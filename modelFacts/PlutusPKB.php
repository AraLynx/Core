<?php
namespace app\modelFacts;
use app\core\ModelFact;
use app\core\Record;

class PlutusPKB extends ModelFact
{
    public function __construct($params = [])
    {
        $params["dbName"] = "Plutus";
        $params["dataName"] = "PKB";

        parent::__construct($params);
    }
}

class PlutusPKBRecord extends Record
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

        //$this->generateSomething();
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

        if(isset($params))$this->generateSomething($params);
        return $this->something;
    }
#endregion  getting / returning variable

#region data process
    protected function generateSomething(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        $something = $this->field1;
        $something .= $this->field2;
        $this->something = $something;
    }
#endregion data process
}
