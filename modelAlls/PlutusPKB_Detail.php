<?php
namespace app\modelAlls;
use app\core\ModelAll;
use app\core\Record;

class PlutusPKB_Detail extends ModelAll
{
    public function __construct($params = NULL)
    {
        $params["dbName"] = "plutus";
        $params["dataName"] = "PKB_Detail";

        parent::__construct($params);
    }
}

class PlutusPKB_DetailRecord extends Record
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

        $this->generateNumberTextProfile();
        $this->cleansingVehiclePoliceNumber();
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

        if(isset($params))$this->generateNumberTextProfile($params);
        return $this->numberTextProfile;
    }
#endregion  getting / returning variable

#region data process
    protected function generateNumberTextProfile(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        $glue = $params["glue"] ?? "<br/>";

        $NumberTexts = [];
        if(isset($this->PKBNumberText) && $this->PKBNumberText)$NumberTexts[] = $this->PKBNumberText;
        if(isset($this->BookingNumberText) && $this->BookingNumberText)$NumberTexts[] = $this->BookingNumberText;
        if(isset($this->PrePKBNumberText) && $this->PrePKBNumberText)$NumberTexts[] = $this->PrePKBNumberText;
        if(isset($this->ReferenceNumber) && $this->ReferenceNumber)$NumberTexts[] = $this->ReferenceNumber;

        $this->numberTextProfile = implode($glue, $NumberTexts);
    }
    protected function cleansingVehiclePoliceNumber(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        $this->VehiclePoliceNumber = str_replace("_","",$this->VehiclePoliceNumber);
    }
#endregion data process
}
