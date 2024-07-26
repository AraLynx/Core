<?php
namespace app\components\fields;
use app\components\fields\Field;

class Upload extends Field
{
    /*Field Child Properties*/
    //protected string|int|array $childProperty;

    /*Field Custom Attributes*/
    //protected string|int|array $customFieldAttribute;
    protected string $inputType;

    /*customJsObjParam*/
    //protected string|int|array $customJsObjParam;
    protected string $asyncSaveUrl;
    protected string $asyncRemoveUrl;
    protected bool $asyncAutoUpload;
    protected bool $asyncBatch;

    protected int $validationMaxFileSize;
    protected array $validationAllowedExtensions;

    protected bool $isMultiple;

    protected bool|string $onSelectFunction;
    protected bool|string $onUploadFunction;
    protected bool|string $onProgressFunction;
    protected bool|string $onCancelFunction;
    protected bool|string $onRemoveFunction;
    protected bool|string $onSuccessFunction;
        protected bool|string $onSuccessUploadFunction;
        protected bool|string $onSuccessRemoveFunction;
    protected bool|string $onCompleteFunction;
    protected bool|string $onErrorFunction;
        protected bool|string $onErrorUploadFunction;
        protected bool|string $onErrorRemoveFunction;

    public function __construct(array $params)
    {
        parent::__construct($params);

        /*Field Properties*/
        $this->elementTag = "input";
        $this->jsClassName = "TDEFieldUpload";
        /*Field Properties : dihapus aja klo isinya seperti diatas, itu semua nilai default*/

        /*Field Child Properties*/
        //$this->childProperty = $params["childProperty"] ?? "";

        /*Field Custom Attributes*/
        //$this->customFieldAttribute = $params["customFieldAttribute"] ?? "";
        $this->inputType = "file";

        /*customJsObjParam*/
        //$this->customJsObjParam = $params["customJsObjParam"] ?? "";
        $this->asyncSaveUrl = $params["uploadAsyncSaveUrl"] ?? TDE_ROOT_FOR_JS."/Chronos/ajax/kendoUploadSave.php";
        $this->asyncRemoveUrl = $params["uploadAsyncRemoveUrl"] ?? TDE_ROOT_FOR_JS."/Chronos/ajax/kendoUploadRemove.php";
        $this->asyncAutoUpload = $params["uploadAsyncAutoUpload"] ?? true;
        $this->asyncBatch = $params["uploadAsyncBatch"] ?? true;

        $this->validationMaxFileSize = $params["uploadMaxFileSize"] ?? 2097152;//2MB
        $this->validationAllowedExtensions = $params["uploadFileTypes"] ?? [];

        $this->isMultiple = $params["uploadMultiple"] ?? false;

        $this->onSelectFunction = $params["uploadOnSelectFunction"] ?? false;
        $this->onUploadFunction = $params["uploadOnUploadFunction"] ?? false;
        $this->onProgressFunction = $params["uploadOnProgressFunction"] ?? false;
        $this->onCancelFunction = $params["uploadOnCancelFunction"] ?? false;
        $this->onRemoveFunction = $params["uploadOnRemoveFunction"] ?? false;
        $this->onSuccessFunction = $params["uploadOnSuccessFunction"] ?? false;
            $this->onSuccessUploadFunction = $params["uploadOnSuccessUploadFunction"] ?? false;
            $this->onSuccessRemoveFunction = $params["uploadOnSuccessRemoveFunction"] ?? false;
        $this->onCompleteFunction = $params["uploadOnCompleteFunction"] ?? false;
        $this->onErrorFunction = $params["uploadOnErrorFunction"] ?? false;
            $this->onErrorUploadFunction = $params["uploadOnErrorUploadFunction"] ?? false;
            $this->onErrorRemoveFunction = $params["uploadOnErrorRemoveFunction"] ?? false;

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

        //if($this->customFieldAttribute)$this->customFieldAttributes[] = ["key" => "customFieldAttribute","value" => $this->customFieldAttribute];
        $this->customFieldAttributes[] = ["key" => "type","value" => $this->inputType];
    }
    protected function generateCustomJsObjParams()
    {
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        //if($this->customJsObjParam)$this->customJsObjParams[] = ["key" => "customJsObjParam","value" => "'{$this->customJsObjParam}'"];
        if($this->asyncSaveUrl)$this->customJsObjParams[] = ["key" => "asyncSaveUrl","value" => "'{$this->asyncSaveUrl}'"];
        if($this->asyncRemoveUrl)$this->customJsObjParams[] = ["key" => "asyncRemoveUrl","value" => "'{$this->asyncRemoveUrl}'"];
        if(!$this->asyncAutoUpload)$this->customJsObjParams[] = ["key" => "asyncAutoUpload","value" => "false"];
        if($this->asyncBatch)$this->customJsObjParams[] = ["key" => "asyncBatch","value" => "true"];

        if($this->validationMaxFileSize)$this->customJsObjParams[] = ["key" => "validationMaxFileSize","value" => "{$this->validationMaxFileSize}"];
        if(count($this->validationAllowedExtensions))$this->customJsObjParams[] = ["key" => "validationAllowedExtensions","value" => json_encode($this->validationAllowedExtensions)];

        if(!$this->isMultiple)$this->customJsObjParams[] = ["key" => "isMultiple","value" => "false"];

        if($this->onSelectFunction)$this->customJsObjParams[] = ["key" => "onSelectFunction","value" => "'{$this->onSelectFunction}'"];
        if($this->onUploadFunction)$this->customJsObjParams[] = ["key" => "onUploadFunction","value" => "'{$this->onUploadFunction}'"];
        if($this->onProgressFunction)$this->customJsObjParams[] = ["key" => "onProgressFunction","value" => "'{$this->onProgressFunction}'"];
        if($this->onCancelFunction)$this->customJsObjParams[] = ["key" => "onCancelFunction","value" => "'{$this->onCancelFunction}'"];
        if($this->onRemoveFunction)$this->customJsObjParams[] = ["key" => "onRemoveFunction","value" => "'{$this->onRemoveFunction}'"];
        if($this->onSuccessFunction)$this->customJsObjParams[] = ["key" => "onSuccessFunction","value" => "'{$this->onSuccessFunction}'"];
            if($this->onSuccessUploadFunction)$this->customJsObjParams[] = ["key" => "onSuccessUploadFunction","value" => "'{$this->onSuccessUploadFunction}'"];
            if($this->onSuccessRemoveFunction)$this->customJsObjParams[] = ["key" => "onSuccessRemoveFunction","value" => "'{$this->onSuccessRemoveFunction}'"];
        if($this->onCompleteFunction)$this->customJsObjParams[] = ["key" => "onCompleteFunction","value" => "'{$this->onCompleteFunction}'"];
        if($this->onErrorFunction)$this->customJsObjParams[] = ["key" => "onErrorFunction","value" => "'{$this->onErrorFunction}'"];
            if($this->onErrorUploadFunction)$this->customJsObjParams[] = ["key" => "onErrorUploadFunction","value" => "'{$this->onErrorUploadFunction}'"];
            if($this->onErrorRemoveFunction)$this->customJsObjParams[] = ["key" => "onErrorRemoveFunction","value" => "'{$this->onErrorRemoveFunction}'"];
    }

    protected function generateField($params = [])
    {
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        $isHtml = $params["isHtml"] ?? true;
        $isJs = $params["isJs"] ?? true;

        if($isHtml)
        {
            $this->html .= "<div class='col-lg-{$this->col}'>";
                $this->html .= "<div class='d-lg-flex justify-content-between'>";
                    $inputGroupCount = count($this->fieldGroups);

                    foreach($this->fieldGroups AS $fieldGroup)
                    {
                        $this->generateId($fieldGroup);
                        $this->generateName($fieldGroup);

                        $this->html .= "<div style='width:calc(100%/{$inputGroupCount});'>";
                            $this->generateFieldElement(["name" => "{$this->page}/{$this->group}/{$this->formId}/{$this->name}"]);
                            $this->html .= "<input id='{$this->id}File' name='{$this->name}' type='hidden' form='{$this->formElementId}'/>
                                <input id='{$this->id}FileDirectory' name='{$this->name}FileDirectory' type='hidden' form='{$this->formElementId}'/>
                                <input id='{$this->id}FileOriginalName' name='{$this->name}FileOriginalName' type='hidden' form='{$this->formElementId}'/>
                                <input id='{$this->id}FileUniqueName' name='{$this->name}FileUniqueName' type='hidden' form='{$this->formElementId}'/>
                                <input id='{$this->id}FileSize' name='{$this->name}FileSize' type='hidden' form='{$this->formElementId}'/>
                                <input id='{$this->id}FileType' name='{$this->name}FileType' type='hidden' form='{$this->formElementId}'/>
                                <input id='{$this->id}FileExtension' name='{$this->name}FileExtension' type='hidden' form='{$this->formElementId}'/>";
                            $this->generateFieldInvalidFeedback();
                            $this->html .= $this->getCustomFieldEndHtml();
                        $this->html .= "</div>";

                        if($isJs)
                        {
                            $this->generateFieldJs();
                        }
                    }
                $this->html .= "</div>";
            $this->html .= "</div>";
        }
    }
#endregion data process
}
