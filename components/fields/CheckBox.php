<?php
namespace app\components\fields;
use app\components\fields\Field;

class CheckBox extends Field
{
    /*Field Child Properties*/
    //protected string|int|array $childProperty;

    /*Field Custom Attributes*/
    //protected string|int|array $customFieldAttribute;
    protected string $inputType;

    /*customJsObjParam*/
    //protected string|int|array $customJsObjParam;
    protected bool $checked;
    protected string $label;
    protected string $size;
    protected string $rounded;

    public function __construct(array $params)
    {
        parent::__construct($params);

        /*Field Properties*/
        $this->jsClassName = "TDEFieldCheckBox";

        /*Field Child Properties*/
        //$this->childProperty = $params["childProperty"] ?? "";

        /*Field Custom Attributes*/
        //$this->customFieldAttribute = $params["customFieldAttribute"] ?? "";
        $this->inputType = "checkbox";

        /*customJsObjParam*/
        //$this->customJsObjParam = $params["customJsObjParam"] ?? "";
        $this->checked = $params["checkBoxChecked"] ?? false;
        $this->label = $params["checkBoxLabel"] ?? "this:property:fieldGroupName";
        $this->size = $params["checkBoxSize"] ?? "medium";
        $this->rounded = $params["checkBoxRounded"] ?? "medium";

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

        $this->generateCustomFieldAttributes();
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
        if($this->label)$this->customJsObjParams[] = ["key" => "label","value" => "'{$this->label}'"];
        if($this->size)$this->customJsObjParams[] = ["key" => "size","value" => "'{$this->size}'"];
        if($this->rounded)$this->customJsObjParams[] = ["key" => "rounded","value" => "'{$this->rounded}'"];
    }
#endregion data process
}
