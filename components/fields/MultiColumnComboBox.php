<?php
namespace app\components\fields;

class MultiColumnComboBox extends Select
{
    /*Field Child Properties*/
    //protected string|int|array $childProperty;

    /*Field Custom Attributes*/
    //protected string|int|array $customFieldAttribute;

    /*customJsObjParam*/
    //protected string|int|array $customJsObjParam;
    protected bool $suggest;

    public function __construct(array $params)
    {
        parent::__construct($params);

        /*Field Properties*/
        $this->elementTag = "select";/* Nama element, DEFAULT INPUT */
        $this->jsClassName = "TDEFieldMultiColumnComboBox";/* Nama class javascript, DEFAULT TDEFieldText */
        /*Field Properties : dihapus aja klo isinya seperti diatas, itu semua nilai default*/

        /*Field Child Properties*/
        //$this->childProperty = $params["childProperty"] ?? "";

        /*Field Custom Element Attributes*/
        //$this->customFieldAttribute = $params["customFieldAttribute"] ?? "";

        /*customJsObjParam*/
        //$this->customJsObjParam = $params["customJsObjParam"] ?? "";
        $this->suggest = $params["inputSuggest"] ?? true;

        $this->init();
    }
#region init
    protected function init()
    {
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

        //if($this->customJsObjParam)$this->customJsObjParams[] = ["key" => "customJsObjParam","value" => "'{$this->customJsObjParam}'"];
        if($this->suggest)$this->customJsObjParams[] = ["key" => "suggest","value" => "true"];
    }
#endregion data process
}
