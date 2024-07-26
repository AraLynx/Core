<?php
namespace app\components\fields;
use app\components\fields\Field;

class TextArea extends Field
{
    /*Field Child Properties*/
    //protected string|int|array $childProperty;

    /*Field Custom Attributes*/
    //protected string|int|array $customFieldAttribute;

    /*customJsObjParam*/
    //protected string|int|array $customJsObjParam;
    protected int $rows;
    protected int $maxLength;
    protected bool $isShowCounter;

    public function __construct(array $params)
    {
        parent::__construct($params);

        /*Field Properties*/
        $this->elementTag = "textarea";
        $this->jsClassName = "TDEFieldTextArea";

        /*Field Child Properties*/
        //$this->childProperty = $params["childProperty"] ?? "";

        /*Field Custom Attributes*/
        //$this->customFieldAttribute = $params["customFieldAttribute"] ?? "";

        /*customJsObjParam*/
        //$this->customJsObjParam = $params["customJsObjParam"] ?? "";
        $this->rows = $params["textareaRow"] ?? 5;
        $this->maxLength = $params["textareaMaxLength"] ?? 500;
        $this->isShowCounter = $params["textareaShowCounter"] ?? true;

        $this->init();
    }
#region init
    protected function init()
    {
        //dd("TextArea init");
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

        //if($this->customFieldAttribute)$this->customFieldAttributes[] = ["key" => "customFieldAttribute","value" => $this->customFieldAttribute];
    }
    protected function generateCustomJsObjParams()
    {
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        if($this->rows)$this->customJsObjParams[] = ["key" => "rows","value" => $this->rows];
        if($this->maxLength) $this->customJsObjParams[] = ["key" => "maxLength","value" => $this->maxLength];
        if($this->isShowCounter)$this->customJsObjParams[] = ["key" => "isShowCounter","value" => "true"];
    }
#endregion data process
}
