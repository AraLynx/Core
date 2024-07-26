<?php
namespace app\components;

class FieldSet
{
    protected string $theme;
    protected string $type;
    protected array $params;

    protected string $alternateColor;

    protected string $labelElement;
    protected string $labelJs;

    protected string $labelId;
    protected bool $labelIsShow;
    protected int $labelCol;
    protected string $labelText;
    protected string $labelClass;
    protected array $labelAttrs;
    protected string $labelInfo;

    protected $field;

    public function __construct(array $params)
    {
        //parent::__construct($params["page"]);
        $this->params = $params;
        $this->type = $params["type"] ?? "text";

        $this->alternateColor = $params["alternateColor"] ?? "";

        $this->labelId = $params["labelId"] ?? "";
        $this->labelIsShow = $params["labelIsShow"] ?? true;
        $this->labelCol = $params["labelCol"] ?? ($this->labelIsShow ? 1 : 0);
        $this->labelText = $params["labelText"] ?? $params["inputName"] ?? "";
        $this->labelClass = $params["labelClass"] ?? "";
        $this->labelAttrs = $params["labelAttr"] ?? [];
        $this->labelInfo = $params["labelInfo"] ?? "";

        $this->init();
    }
#region init
    protected function init()
    {
        $this->labelElement = "";
        $this->labelJs = "";

        switch($this->type)
        {
            case "hidden":$this->field = new fields\Hidden($this->params);break;
            case "text":$this->field = new fields\Text($this->params);break;
            case "email":$this->field = new fields\Text($this->params);break;
            case "password":$this->field = new fields\Text($this->params);break;
            case "number":$this->field = new fields\Number($this->params);break;

            case "checkbox":$this->field = new fields\CheckBox($this->params);break;
            case "switch":$this->field = new fields\FieldSwitch($this->params);break;

            case "textarea":$this->field = new fields\TextArea($this->params);break;
            case "editor":$this->field = new fields\Editor($this->params);break;

            case "date":$this->field = new fields\Date($this->params);break;
            case "time":$this->field = new fields\Time($this->params);break;
            case "datetime":$this->field = new fields\DateTime($this->params);break;
            case "daterange":$this->field = new fields\DateRange($this->params);break;

            case "upload":$this->field = new fields\Upload($this->params);break;

            case "combobox":$this->field = new fields\ComboBox($this->params);break;
            case "multiselect":$this->field = new fields\MultiSelect($this->params);break;
            case "multicolumncombobox":$this->field = new fields\MultiColumnComboBox($this->params);break;
            case "dropdownlist":$this->field = new fields\DropDownList($this->params);break;
            case "dropdowntree":$this->field = new fields\DropDownTree($this->params);break;

            default: dd($this->type);
        }

        if(isset($this->field))
        {
            $this->field->begin();
            $this->field->end();
        }
    }
#endregion init

#region set status
    public function begin()
    {
        if($this->getStatusCode() != 100){return false;}
        if($this->isBegin){$this->setStatusCode(601);return false;}//Page is already begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        $this->isBegin = 1;
        $this->elementId = "{$this->group}Field{$this->id}";
    }
    public function end()
    {
        if($this->getStatusCode() != 100) {return false;}
        if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        $this->isEnd = 1;

        $this->html .= "";
        $this->html .= "<script></script>";
    }

#endregion

#region setting variable
#endregion setting variable

#region getting / returning variable
    protected function getLabelElement()
    {
        return $this->labelElement;
    }
    protected function getLabelJs()
    {
        return $this->labelJs;
    }
    public function getHtml()
    {
        if($this->type == "hidden")
            return $this->field->getHtml(true);

        $html = "<div class='row mb-1";
            if($this->type != "textarea")$html .= " align-items-center";
            if($this->alternateColor)$html .= " {$this->alternateColor}";
        $html .= "'>";

            $this->generateLabelElement();
            $labelHtml = $this->getLabelElement();
            $html .= $labelHtml;

            //$html .= "<div class='col-lg-{$this->params["inputCol"]}'>";
                //$html .= "<div class='d-lg-flex justify-content-between'>";
            $fieldHtml = $this->field->getHtml(true);
            $html .= $fieldHtml;
                //$html .= "</div>";
            //$html .= "</div>";

        $html .= "</div>";

        return $html;
    }
    public function getJs(bool $isRaw)
    {
        $js = "";

        $this->generateLabelJs();
        $js .= $this->getLabelJs();

        $fieldJs = $this->field->getJs($isRaw);
        $js .= $fieldJs;

        return $js;
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
    protected function generateLabelElement()
    {
        if($this->type == "hidden") return null;

        if($this->labelIsShow && $this->labelText)
        {
            $this->labelElement .= "<label";
                if($this->labelId)$this->labelElement .= " id='{$this->labelId}'";
                if($this->labelClass)$this->labelElement .= " class='{$this->labelClass}'";
                foreach($this->labelAttrs AS $key => $value)
                {
                    $this->labelElement .= " {$key}='{$value}'";
                }
                $this->labelElement .=">";
                $this->labelElement .= "{$this->labelText}";
                if($this->labelInfo)
                {
                    $this->labelElement .= "<span id='{$this->labelId}Info' class='ms-2'>{$this->labelInfo}</span>";
                }
            $this->labelElement .= "</label>";
        }
    }
    protected function generateLabelJs()
    {
        if($this->type == "hidden") return null;

        if($this->labelIsShow && $this->labelText)
        {
            if($this->labelInfo)
            {
                $this->labelJs .= "TDE.{$this->labelId}Info = $('#{$this->labelId}Info');";
            }
            $this->labelJs .= "TDE.{$this->labelId} = $('#{$this->labelId}');";
        }

    }
    public function render()
    {
        //dd("field rendered");
        //$this->field->render();
    }
#endregion data process
}
