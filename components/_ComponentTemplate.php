<?php
namespace app\components;
use app\core\Component;

class ComponentTemplate extends Component
{
    public function __construct(array $params)
    {
        parent::__construct($params["page"]);
        $this->id = $params["id"] ?? "";
        $this->group = $params["group"] ?? "";
    }
#region init
#endregion init

#region set status
    public function begin()
    {
        if($this->getStatusCode() != 100){return false;}
        if($this->isBegin){$this->setStatusCode(601);return false;}//Page is already begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        $this->isBegin = 1;
        $this->elementId = "{$this->group}ComponentTemplate{$this->id}";
    }
    public function end()
    {
        if($this->getStatusCode() != 100) {return false;}
        if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        $this->isEnd = 1;

        $this->html .= "";
        $this->html .= "<script>
            $('#{$this->elementId}').kendoComponentTemplate({

            });
            TDE.{$this->elementId} = $('#{$this->elementId}').data('kendoComponentTemplate');
        </script>";
    }

#endregion

#region setting variable
#endregion setting variable

#region getting / returning variable
#endregion  getting / returning variable

#region data process
    public function doSometing()
    {
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended
        /*
        DO SOMETHING HERE
        */
    }
    public function doSometingAfterEnd()
    {
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if(!$this->isEnd){$this->setStatusCode(604);return false;}//Page is not yet ended
        /*
        DO SOMETHING HERE
        */
    }
#endregion data process
}
