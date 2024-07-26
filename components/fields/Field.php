<?php
namespace app\components\fields;
use app\core\Page;

class Field extends Page
{
    protected string $formId;
    protected string $formElementId;
    protected string $theme;
    protected string $type;//field type

    protected bool $labelIsShow;
    protected int $labelCol;
    protected string $labelText;

    protected string $elementTag;
    protected string $elementType;
    protected string $originalName;
    protected string $name;
    protected $value;
    protected int $col;
    protected array $fieldGroups;
    protected string $fieldGroupName;
    protected string|array $array;
    protected string $placeHolder;
    protected string $style;
    protected string $size;
    protected string $class;
    protected array $dataCustoms;

    protected bool $isReadOnly;
    protected bool $isDisable;
    protected bool $isRequired;

    protected bool|string $onChange;
    protected bool|string $onPaste;
    protected array $onKeyDowns;

    protected string $info;

    protected array $customFieldAttributes;
    protected string $customFieldEndHtml;
    protected array $customJsObjParams;

    protected string $jsClassName;

    protected string $childSetting;

    public function __construct(array $params)
    {
        //dd($params);
        parent::__construct($params["page"]);

        $this->elementTag = "input";
        $this->jsClassName = "TDEFieldText";
        $this->type = $params["type"] ?? "text";

        $this->group = $params["group"] ?? "";
        $this->formId = $params["formId"] ?? "";
        $this->formElementId = $params["formElementId"] ?? "";
        $this->invalidFeedbackIsShow = $params["invalidFeedbackIsShow"] ?? true;
        $this->theme = $params["theme"] ?? "kendo";

        $this->originalName = $params["inputName"] ?? "";
        $this->value = $params["inputValue"] ?? "";
            $defaultLabelIsShow = $params["defaultLabelIsShow"] ?? true;
            $labelIsShow = $params["labelIsShow"] ?? $defaultLabelIsShow;
            $labelCol = $params["labelCol"] ?? ($labelIsShow ? $defaultLabelIsShow : 0);
            //if($this->formElementId == "caroserieMasterFormGetCaroserieMasters" && $this->originalName == "Status")dd($labelCol, $params["inputCol"]);
        $this->col = $params["inputCol"] ?? 12 - $labelCol;
        $this->fieldGroups = $params["inputGroup"] ?? [""];
        $this->array = $params["inputArray"] ?? "";
        $this->placeHolder = $params["inputPlaceHolder"] ?? $this->originalName;
        $this->style = $params["inputStyle"] ?? "";
        $this->size = $params["inputSize"] ?? "";
        $this->class = $params["inputClass"] ?? "";
        $this->dataCustoms = $params["inputDataCustom"] ?? [];

        $this->isReadOnly = $params["inputIsReadOnly"] ?? false;
        $this->isRequired = $params["required"] ?? false;
        $this->isDisable = $params["inputIsDisable "] ?? false;

        $this->onChange = $params["inputOnChange"]  ?? false;
        $this->onPaste = $params["inputOnPaste"]  ?? false;
        $this->onKeyDowns = $params["inputOnKeyDowns"] ?? [];

        $this->info = $params["inputInfo"] ?? "";

        $this->dynamicForm = $params["dynamicForm"] ?? "";
            $this->originalName = $this->dynamicForm.$this->originalName;
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
        $this->customFieldAttributes = [];
        $this->customFieldEndHtml = "";
        $this->customJsObjParams = [];

        $this->generateFieldWidth();
    }
    public function end()
    {
        if($this->getStatusCode() != 100) {return false;}
        if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        $this->isEnd = 1;
    }

#endregion

#region setting variable
#endregion setting variable

#region getting / returning variable
    public function getFormId(){
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        return $this->formId;
    }
    public function getElementId(){
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        return $this->elementId;
    }
    public function getElementName(){
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        return $this->elementName;
    }

    protected function getCustomFieldAttributes()
    {
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        $attributes = [];
        $attributeText = "";
        foreach($this->customFieldAttributes AS $customFieldAttribute)
        {
            $attributes[] = "{$customFieldAttribute["key"]}='{$customFieldAttribute["value"]}'";
        }

        if(count($this->customFieldAttributes))$attributeText = " ".implode(" ",$attributes);
        return $attributeText;
    }
    protected function getCustomFieldEndHtml()
    {
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        return $this->customFieldEndHtml;
    }
    protected function getCustomJsObjParams()
    {
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        $params = [];
        foreach($this->customJsObjParams AS $customJsObjParam)
        {
            $key = $customJsObjParam["key"];
            $value = $customJsObjParam["value"];

            if(substr($value,0,4) == "this" || substr($value,0,5) == "'this")
            {
                if(substr($value,0,1) == "'")
                {
                    //buang ' di depan dan di belakang
                    $value = substr($value,1,strlen($value) - 2);
                }

                $explode = explode(":",$value);
                if($explode[1] == "property")
                {
                    $propertyName = $explode[2];
                    $value = $this->$propertyName;
                }
                else if($explode[1] == "method")
                {
                    $methodName = $explode[2];
                    $value = $this->$methodName();
                }

                if(is_string($value))$value = "'{$value}'";
            }

            $params[] = "{$key}:{$value}";
        }

        return implode(",",$params);
    }
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
    protected function generateFieldWidth()
    {
        //dd("generateFieldId");
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        if($this->size)$this->style .= ";width:{$this->size}";
        else if($this->theme == "kendo")
        {
            if($this->type == "hidden")$this->style = "";
            else if($this->type == "checkbox")$this->style .= "";
            else if($this->type == "number")
            {
                $typeDetail = $this->childSetting;
                switch($typeDetail)
                {
                    case "percentage": $this->style .= ";width:9rem";break;
                    case "dec1": $this->style .= ";width:9.1rem";break;
                    case "dec2": $this->style .= ";width:9.1rem";break;
                    case "dec3": $this->style .= ";width:11rem";break;
                    case "dec4": $this->style .= ";width:11.8rem";break;
                    case "currency": $this->style .= ";width:15rem";break;
                    default:$this->style .= ";width:7.3rem";break;
                }
            }
            else if($this->type == "date")$this->style .= ";width:10rem";
            else if($this->type == "time")$this->style .= ";width:9.1rem";
            else if($this->type == "datetime")$this->style .= ";width:17.3rem";
            else if($this->type == "month")$this->style .= ";width:9.1rem";
            else if($this->type == "year")$this->style .= ";width:9.1rem";

            else if($this->type == "rangedate")$this->style .= ";width:10rem";
            else if($this->type == "kendoMaskedTextBox")
            {
                $mask = $this->childSetting;
                switch($mask)
                {
                    case "postalCode" : $this->style .= ";width:70px";break;
                    case "rt" : $this->style .= ";width:50px";break;
                    case "rw" : $this->style .= ";width:50px";break;
                    case "npwp" : $this->style .= ";width:140px";break;
                    case "pkp" : $this->style .= ";width:140px";break;
                    case "ktp" : $this->style .= ";width:140px";break;
                }
            }
            else $this->style .= ";width:100%";
        }
    }
    protected function generateId($fieldGroupName = "")
    {
        //dd("generateFieldId");
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        $Id = $this->group.$this->formId.(str_replace("[]","",$this->originalName));
        //dd($this->group,$this->formId);

        if($fieldGroupName)
        {
            $Id .= "_{$fieldGroupName}";
        }
        if($this->array)
        {
            if(is_string($this->array))
            {
                $Id .= "_{$this->array}";
            }
            if(is_array($this->array))
            {
                $Id .= "_".implode("_",$this->array);
            }
        }

        $this->id = $Id;
    }
    protected function generateName($fieldGroupName = "")
    {
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        $Name = $this->originalName;

        if($fieldGroupName)
        {
            $Name .= "[{$fieldGroupName}]";
        }
        if($this->array)
        {
            if(is_string($this->array))
            {
                $Name .= "[{$this->array}]";
            }
            if(is_array($this->array))
            {
                $Name .= "[".implode("][",$this->array)."]";
            }
        }

        $this->name = $Name;
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
                        $this->fieldGroupName = $fieldGroup;

                        $this->generateId($fieldGroup);
                        $this->generateName($fieldGroup);

                        if($this->type != "hidden")$this->html .= "<div style='width:calc(100%/{$inputGroupCount});'>";
                            $this->generateFieldElement();
                            $this->generateFieldInfo();
                            $this->generateFieldInvalidFeedback();
                            $this->html .= $this->getCustomFieldEndHtml();
                        if($this->type != "hidden")$this->html .= "</div>";

                        if($isJs)
                        {
                            $this->generateFieldJs();
                        }
                    }
                $this->html .= "</div>";
            $this->html .= "</div>";
        }
    }
        protected function generateFieldElement($params = [])
        {
            if($this->getStatusCode() != 100){return false;}
            if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
            if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

            $name = $params["name"] ?? $this->name;
            $sufix = $params["sufix"] ?? "";

            $elementName = "{$name}{$sufix}";

            $childClass = get_class($this);
            if($childClass == 'app\components\fields\MultiSelect')
            {
                $elementName .= "[]";
            }

            $this->html .= "<{$this->elementTag}";
                if($this->id) $this->html .= " id='{$this->id}{$sufix}'";
                if($this->class) $this->html .= " class='{$this->class}'";
                if($this->formElementId) $this->html .= " form='{$this->formElementId}'";
                if($name || $sufix) $this->html .= " name='{$name}{$sufix}'";

                foreach($this->dataCustoms AS $dataCustom)
                {
                    $key = $dataCustom[0];
                    $value = $dataCustom[1];
                    $this->html .= " data-tde-{$key}='{$value}'";
                }
                if($this->style) $this->html .= " style='{$this->style}'";

                if(count($this->onKeyDowns))
                {
                    $this->html .= " onkeydown='";
                    foreach($this->onKeyDowns AS $keyCode => $onKeyDown)
                    {
                        $functionNames = $onKeyDown["functionNames"] ?? [];
                        $confirmMessageIsShow = $onKeyDown["confirmMessageIsShow"] ?? false;
                        $delayTimeOut = $onKeyDown["delayTimeOut"] ?? 0;

                        $this->html .= "if(event.keyCode === {$keyCode}){";
                            if($delayTimeOut)$this->html .= "setTimeout(function() {";
                                foreach($functionNames AS $functionName)
                                {
                                    $this->html .= "{$functionName}";
                                    if($confirmMessageIsShow)$this->html .= "ConfirmationMessage";
                                    $this->html .= "();";
                                }
                            if($delayTimeOut)$this->html .= "}, {$delayTimeOut});";
                        $this->html .= "};";
                    }
                    $this->html .= "'";
                }

                if($this->onPaste)
                {
                    if(is_string($this->onPaste))$onPasteFunction = $this->onPaste;
                    else $onPasteFunction =  $this->id."Paste";

                    if($onPasteFunction)$this->html .= " onpaste='{$onPasteFunction}();'";
                }

                if($this->onChange)
                {
                    if(is_string($this->onChange))$onChangeFunction = "{$this->onChange}";
                    else $onChangeFunction =  "{$this->id}Change";

                    if(!in_array($this->theme,["kendo"])) /*kendo on change menggunakan bind*/
                    {
                        $this->html .= " onchange='{$onChangeFunction}();'";
                    }
                    else
                    {
                        if($this->theme == "kendo")
                        {
                            $this->customJsObjParams[] = ["key" => "onChange","value" => "'{$onChangeFunction}'"];
                        }
                    }
                }

                $this->html .= $this->getCustomFieldAttributes();

            if(in_array($this->elementTag, ["input"]))
                $this->html .= "/>";
            else
                $this->html .= "></{$this->elementTag}>";
        }
        protected function generateFieldInfo($params = [])
        {
            if($this->getStatusCode() != 100){return false;}
            if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
            if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

            if($this->info)
            {
                $this->html .= "<span id='{$this->id}Info' class='ms-2'>{$this->info}</span>";
            }
        }
        protected function generateFieldInvalidFeedback($params = [])
        {
            if($this->getStatusCode() != 100){return false;}
            if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
            if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

            if($this->invalidFeedbackIsShow)
            {
                $this->html .= "<div id='{$this->group}{$this->formId}InvalidFeedback{$this->name}' class='invalid-feedback'></div>";
            }
        }
        protected function generateFieldJs($params = [])
        {
            if($this->getStatusCode() != 100){return false;}
            if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
            if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

            $this->js .= "TDE.fields.{$this->id} = new {$this->jsClassName}(";
                $this->js .= "{";
                    if($this->id) $this->js .= "id:'{$this->id}',";
                    if($this->theme)$this->js .= "theme:'{$this->theme}',";
                    if($this->value) $this->js .= "value:'{$this->value}',";
                    if($this->placeHolder) $this->js .= "placeHolder:'{$this->placeHolder}',";
                    if($this->isReadOnly) $this->js .= "isReadOnly:true,";
                    if($this->isDisable) $this->js .= "isDisable:true,";
                    if($this->info) $this->js .= "isInfo:true,";

                    $this->js .= $this->getCustomJsObjParams();
                $this->js .= "}";
            $this->js .= ");";

            if($this->formElementId)
            {
                //$this->js .= "console.log('{$this->formElementId}');";
                $this->js .= "TDE.forms.{$this->formElementId}.addFieldObj(TDE.fields.{$this->id});";
            }
        }
#endregion data process
}
