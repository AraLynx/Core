<?php
namespace app\pages;
use app\core\Page;

class KendoBarcode extends Page
{
    protected string $renderAs;
    protected string $background;
    protected string $borderColor;
    protected string $borderDashType;
    protected int $borderWidth;
    protected bool $checksum;
    protected string $color;
    protected int $height;
    protected int $paddingTop;
    protected int $paddingLeft;
    protected int $paddingRight;
    protected int $paddingBottom;
    protected string $textColor;
    protected string $textFont;
    protected int $textMarginTop;
    protected int $textMarginLeft;
    protected int $textMarginRight;
    protected int $textMarginBottom;
    protected bool $textVisible;
    protected string $type;
    protected string $value;
    protected int $width;

    protected int $idCounter = 0;

    public function __construct(array $params)
    {
        parent::__construct($params["page"]);
        //$this->id = $params["id"] ?? "";
        $this->group = $params["group"] ?? "";

        //$this->value = $params["value"];

        $this->renderAs = $params["renderAs"] ?? "svg";
        $this->background = $params["background"] ?? "#fff";
        $this->borderColor = $params["borderColor"] ?? "#000";
        $this->borderDashType = $params["borderDashType"] ?? "solid";
        $this->borderWidth = $params["borderWidth"] ?? 0;
        $this->checksum = $params["checksum"] ?? false;
        $this->color = $params["color"] ?? "#000";
        $this->height = $params["height"] ?? 100;
        $this->paddingTop = $params["paddingTop"] ?? 0;
        $this->paddingLeft = $params["paddingLeft"] ?? 0;
        $this->paddingRight = $params["paddingRight"] ?? 0;
        $this->paddingBottom = $params["paddingBottom"] ?? 0;
        $this->textColor = $params["textColor"] ?? "#000";
        $this->textFont = $params["textFont"] ?? "16px Consolas, Monaco, Sans Mono, monospace, sans-serif";
        $this->textMarginTop = $params["textMarginTop"] ?? 0;
        $this->textMarginLeft = $params["textMarginLeft"] ?? 0;
        $this->textMarginRight = $params["textMarginRight"] ?? 0;
        $this->textMarginBottom = $params["textMarginBottom"] ?? 0;
        $this->textVisible = $params["textVisible"] ?? true;
        $this->type = $params["type"] ?? "Code128";
        $this->width = $params["width"] ?? 300;
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
    }
    public function end()
    {
        if($this->getStatusCode() != 100) {return false;}
        if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        $this->isEnd = 1;

        /*
        $this->html .= "";
        $this->html .= "<script>
            $('#{$this->elementId}').kendoKendoBarcode({

            });
            TDE.{$this->elementId} = $('#{$this->elementId}').data('kendoKendoBarcode');
        </script>";
        */
    }

#endregion

#region setting variable
#endregion setting variable

#region getting / returning variable
    public function generate(string $value, string $id = null, $params = []){
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        if(!isset($id))
        {
            $id = $this->idCounter;
            $this->idCounter++;
        }

        $this->id = $id;
        $this->elementId = "{$this->group}KendoBarcode{$this->id}";

        $this->renderAs = $params["renderAs"] ?? $this->renderAs;
        $this->background = $params["background"] ?? $this->background;
        $this->borderColor = $params["borderColor"] ?? $this->borderColor;
        $this->borderDashType = $params["borderDashType"] ?? $this->borderDashType;
        $this->borderWidth = $params["borderWidth"] ?? $this->borderWidth;
        $this->checksum = $params["checksum"] ?? $this->checksum;
        $this->color = $params["color"] ?? $this->color;
        $this->height = $params["height"] ?? $this->height;
        $this->paddingTop = $params["paddingTop"] ?? $this->paddingTop;
        $this->paddingLeft = $params["paddingLeft"] ?? $this->paddingLeft;
        $this->paddingRight = $params["paddingRight"] ?? $this->paddingRight;
        $this->paddingBottom = $params["paddingBottom"] ?? $this->paddingBottom;
        $this->textColor = $params["textColor"] ?? $this->textColor;
        $this->textFont = $params["textFont"] ?? $this->textFont;
        $this->textMarginTop = $params["textMarginTop"] ?? $this->textMarginTop;
        $this->textMarginLeft = $params["textMarginLeft"] ?? $this->textMarginLeft;
        $this->textMarginRight = $params["textMarginRight"] ?? $this->textMarginRight;
        $this->textMarginBottom = $params["textMarginBottom"] ?? $this->textMarginBottom;

        $this->textVisible = $params["textVisible"] ?? $this->textVisible;

        $this->type = $params["type"] ?? $this->type;
        $this->width = $params["width"] ?? $this->width;

        $checksum = ($this->checksum ? 'true' : 'false');
        $textVisible = ($this->textVisible ? 'true' : 'false');


        $this->html = "<div id='{$this->elementId}'></div>";
        $this->js = "$('#{$this->elementId}').kendoBarcode({
            renderAs: '{$this->renderAs}',
            background: '{$this->background}',
            border:{
                color: '{$this->borderColor}',
                dashType: '{$this->borderDashType}',
                width: {$this->borderWidth},
            },
            checksum: {$checksum},
            color: '{$this->color}',
            height: {$this->height},
            padding: {
                top: {$this->paddingTop},
                left: {$this->paddingLeft},
                right: {$this->paddingRight},
                bottom: {$this->paddingBottom},
              },
            text:{
                color: '{$this->textColor}',
                font: '{$this->textFont}',
                visible: {$textVisible},
                margin: {
                    top: {$this->textMarginTop},
                    left: {$this->textMarginLeft},
                    right: {$this->textMarginRight},
                    bottom: {$this->textMarginBottom},
                }
            },
            type: '{$this->type}',
            value: '{$value}',
            width: {$this->width},
        });";

        $return = $this->html;
        $return .= "<script>";
            $return .= "$(document).ready(function(){{$this->js}});";
        $return .= "</script>";

        return $return;
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
#endregion data process
}
