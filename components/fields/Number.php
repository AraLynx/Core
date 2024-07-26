<?php
namespace app\components\fields;
use app\components\fields\Field;

class Number extends Field
{
    /*Field Child Properties*/
    //protected string|int|array $childProperty;
    protected string $typeDetail;

    /*Field Custom Attributes*/
    //protected string|int|array $customFieldAttribute;
    protected string $inputType;

    /*customJsObjParam*/
    //protected string|int|array $customJsObjParam;
    protected bool $isNegaitve;
    protected string $isSpinner;
    protected string $step;
    protected string $onSpin;
    protected string $onSpinFunction;
    protected string $min;
    protected string $max;
    protected string $decimals;
    protected string $format;

    public function __construct(array $params)
    {
        parent::__construct($params);

        /*Field Properties*/
        $this->jsClassName = "TDEFieldNumber";

        /*Field Child Properties*/
        //$this->childProperty = $params["childProperty"] ?? "";

        /*Field Custom Attributes*/
        //$this->customFieldAttribute = $params["customFieldAttribute"] ?? "";
        $this->inputType = "number";

        /*customJsObjParam*/
        //$this->customJsObjParam = $params["customJsObjParam"] ?? "";
        $this->isNegaitve = $params["numericIsNegaitve"] ?? false;

        $this->typeDetail = $params["numericTypeDetail"] ?? "";
        $this->isSpinner = "true";
        if(isset($params["numericIsSpinner"]))
        {
            if($params["numericIsSpinner"])$this->isSpinner = "true";
            else $this->isSpinner = "false";
        }
        $this->step = $params["numericStep"] ?? "'x'";
        $this->onSpin = $params["numericOnSpin"] ?? false;
        $this->min = $params["numericMin"] ?? 0;
        $this->max = $params["numericMax"] ?? "'x'";
        $this->decimals = $params["numericDecimals"] ?? "'x'";
        $this->format = $params["numericFormat"] ?? "#";

        $this->init();
    }
#region init
    protected function init()
    {
        //dd("Number init");

        if(!$this->value)$this->value = 0;
        if($this->isNegaitve)$this->min = "'x'";

        switch($this->typeDetail)
        {
            case "percentage":
                $this->step = "0.01";
                $this->decimals = "2";
                $this->format = "#.## \'%\'";
                break;
            case "dec1":
                $this->step = "0.1";
                $this->decimals = "1";
                $this->format = "n1";
                break;
            case "dec2":
                $this->step = "0.01";
                $this->decimals = "2";
                $this->format = "n2";
                break;
            case "dec3":
                $this->step = "0.001";
                $this->decimals = "3";
                $this->format = "n3";
                break;
            case "dec4":
                $this->step = "0.0001";
                $this->decimals = "4";
                $this->format = "n4";
                break;
            case "currency":
                $this->format = "Rp #,0";
                break;
            default:
                $this->step = "'x'";
                $this->decimals = "'x'";
                $this->format = "#";
                break;
        }

        $this->childSetting = $this->typeDetail;
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

        if($this->isNegaitve)$this->customJsObjParams[] = ["key" => "isNegaitve","value" => "'{$this->isNegaitve}'"];
        if($this->isSpinner)$this->customJsObjParams[] = ["key" => "isSpinner","value" => "{$this->isSpinner}"];
        if($this->step)$this->customJsObjParams[] = ["key" => "step","value" => "{$this->step}"];
        if($this->onSpin)$this->customJsObjParams[] = ["key" => "onSpin","value" => "'{$this->onSpin}'"];
        if($this->min)$this->customJsObjParams[] = ["key" => "min","value" => "{$this->min}"];
        if($this->max)$this->customJsObjParams[] = ["key" => "max","value" => "{$this->max}"];
        if($this->decimals)$this->customJsObjParams[] = ["key" => "decimals","value" => "{$this->decimals}"];
        if($this->format)$this->customJsObjParams[] = ["key" => "format","value" => "'{$this->format}'"];
    }
#endregion data process
}
