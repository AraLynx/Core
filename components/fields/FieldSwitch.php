<?php
namespace app\components\fields;
use app\components\fields\Field;

class FieldSwitch extends Field
{
    /*Field Child Properties*/
    //protected string|int|array $childProperty;

    /*Field Custom Attributes*/
    //protected string|int|array $customFieldAttribute;
    protected string $inputType;

    /*customJsObjParam*/
    //protected string|int|array $customJsObjParam;
    protected bool $checked;
    protected string $messageChecked;
    protected string $messageUnchekedl;
    protected string $size;
    protected string $trackRounded;
    protected string $thumbRounded;

    public function __construct(array $params)
    {
        parent::__construct($params);

        /*Field Properties*/
        $this->jsClassName = "TDEFieldSwitch";

        /*Field Child Properties*/
        //$this->childProperty = $params["childProperty"] ?? "";
        $this->inputType = "checkbox";

        /*Field Custom Attributes*/
        //$this->customFieldAttribute = $params["customFieldAttribute"] ?? "";
        $this->checked = $params["switchChecked"] ?? false;
        $this->messageChecked = $params["switchMessagesChecked"] ?? "YES";
        $this->messageUncheked = $params["switchMessagesUnchecked"] ?? "NO";
        $this->size = $params["switchSize"] ?? "small";
        $this->trackRounded = $params["switchTrackRounded"] ?? "small";
        $this->thumbRounded = $params["switchThumbRounded"] ?? "small";

        $this->init();
    }
#region init
    protected function init()
    {
        //dd("CheckBox init");
        if($this->getStatusCode() != 100){return false;}
    }
#endregion init

#region set status
    public function begin()
    {
        parent::begin();

        //$this->generateCustomFieldAttributes();
        $this->generateCustomJsObjParams();
        $this->generateField();
    }
    public function end()
    {
        parent::end();
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
    protected function generateCustomFieldAttributes()
    {
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        if($this->inputType)$this->customFieldAttributes[] = ["key" => "type","value" => $this->inputType];
    }
    protected function generateCustomJsObjParams()
    {
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        if($this->checked)$this->customJsObjParams[] = ["key" => "checked","value" => "true"];
        if($this->messageChecked)$this->customJsObjParams[] = ["key" => "messageChecked","value" => "'{$this->messageChecked}'"];
        if($this->messageUncheked)$this->customJsObjParams[] = ["key" => "messageUncheked","value" => "'{$this->messageUncheked}'"];
        if($this->size)$this->customJsObjParams[] = ["key" => "size","value" => "'{$this->size}'"];
        if($this->trackRounded)$this->customJsObjParams[] = ["key" => "trackRounded","value" => "'{$this->trackRounded}'"];
        if($this->thumbRounded)$this->customJsObjParams[] = ["key" => "thumbRounded","value" => "'{$this->thumbRounded}'"];
    }
#endregion data process
}
