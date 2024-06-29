<?php
namespace app\modelAlls;
use app\core\ModelAll;
use app\core\Record;

class PlutusService extends ModelAll
{
    public function __construct($params = NULL)
    {
        $params["dbName"] = "plutus";
        $params["dataName"] = "Service";

        parent::__construct($params);
    }
}

class PlutusServiceRecord extends Record
{
    protected int $serviceId;
    protected array $luxuryFactorIds;

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

#region get service luxury factor
public function getServiceLuxuryFactors(array $params = [])
{
    if($this->getStatusCode() != 100) return null;

    if(isset($params["serviceId"])) $this->serviceId = $params["serviceId"];
    if($this->serviceId) $this->getServiceLuxuryFactorIds();

    $luxuryFactorDatas = [];
    if($this->luxuryFactorIds) {
        foreach ($this->luxuryFactorIds as $relId => $luxuryGroupId) {
            $luxuryFactors = new \app\modelDims\PlutusLuxuryFactor();
            $luxuryFactors->addParameters(["Id" => $luxuryGroupId, "IsEnable" => 1]);
            $luxuryFactor = $luxuryFactors->f5()[0];

            $luxuryFactorDatas[] = [
                "relId" => $relId,
                "LuxuryFactorId" => $luxuryFactor->Id,
                "LuxuryFactor" => $luxuryFactor->Name,
                "FlatRate" => $luxuryFactor->FlatRate,
            ];
        }
    }

    return $luxuryFactorDatas;
}
    protected function getServiceLuxuryFactorIds()
    {
        if($this->getStatusCode() != 100) return null;

        $this->luxuryFactorIds = [];

        $relServiceLuxuryFactors = new \app\modelRels\PlutusServiceLuxuryGroup();
        $relServiceLuxuryFactors->addParameter("ServiceId", $this->serviceId);

        if($relServiceLuxuryFactors->f5()) {
            foreach ($relServiceLuxuryFactors->f5() as $relServiceLuxuryFactor) {
                $this->luxuryFactorIds[$relServiceLuxuryFactor->Id] = $relServiceLuxuryFactor->LuxuryGroupId;
            }
        }

    }
#endregion

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
