<?php
namespace app\components\fields;
use app\components\fields\Field;

class Time extends Field
{
    /*Field Child Properties*/
    protected string|array $min;
    protected string|array $max;

    /*Field Custom Attributes*/
    //protected string|int|array $customFieldAttribute;
    protected string $inputType;

    /*customJsObjParam*/
    //protected string|int|array $customJsObjParam;
    protected string $format;
        protected int $minHour;
        protected int $minMinute;
        protected int $minSecond;

        protected int $maxHour;
        protected int $maxMinute;
        protected int $maxSecond;

    public function __construct(array $params)
    {
        //dd($params);
        parent::__construct($params);
        $this->type = "time";
        $this->elementTag = "input";
        $this->jsClassName = "TDEFieldDateTime";

        /*Field Child Properties*/
        $this->min = $params["dateTimeMin"] ?? "";
        $this->max = $params["dateTimeMax"] ?? "";

        /*Field Custom Attributes*/
        //$this->customFieldAttribute = $params["customFieldAttribute"] ?? "";
        $this->inputType = "time";

        /*customJsObjParam*/
        //$this->customJsObjParam = $params["customJsObjParam"] ?? "";
        $this->format = $params["dateTimeFormat"] ?? "HH:mm:ss";

        $this->init();
    }
#region init
    protected function init()
    {
        if($this->getStatusCode() != 100){return false;}

        if(!$this->value)$this->value = "now";/* DEFAULT = NOW*/

        if($this->value == "x")$this->value = "null";/* UTK BUAT JADI NYA KOSONG */
        else if($this->value == "now")$this->value = date("H:i:s");

        if($this->value)/* CONVERSI KE new Date versi JS*/
        {
            $timeParts = explode(" ",$this->value);
            if(count($timeParts) == 3)
            {
                $hour = $timeParts[0];
                $minute = $timeParts[1];
                $second = $timeParts[2];
            }

            $this->value = "new Date(0,0,0,{$hour},{$minute},{$second})";
        }

        $this->generateMinYmdHis();
        $this->generateMaxYmdHis();
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
    protected function generateMinYmdHis()
    {
        $minHour = 0;
        $minMinute = 0;
        $minSecond = 0;
        if($this->min)
        {
            if(is_array($this->min))
            {
                if(count($this->min) == 3){$minHour = $this->min[0];$minMinute = $this->min[1] - 1;$minSecond = $this->min[2];}
            }
            /*
            if($this->min == "x") {$minYear = 1900;$minMonth = 0;$minDate = 1;}
            if($this->min == "today") {$minYear = date("Y");$minMonth = date("m") - 1;$minDate = date("d");}

            if($this->min == "last month") {$minYear = date("Y");$minMonth = date("m") - 2;$minDate = 1;}
            if($this->min == "last year") {$minYear = date("Y") - 1;$minMonth = 0;$minDate = 1;}

            if($this->min == "this month") {$minYear = date("Y");$minMonth = date("m") - 1;$minDate = 1;}//DEFAULT
            if($this->min == "this year") {$minYear = date("Y");$minMonth = 0;$minDate = 1;}

            if($this->min == "next month") {$minYear = date("Y");$minMonth = date("m");$minDate = 1;}
            if($this->min == "next year") {$minYear = date("Y") +1;$minMonth = 0;$minDate = 1;}

            if(substr($this->min, 0, 2) == "y-") {
                $subtractYear = substr($this->min, 2);

                $minYear = Date("Y", strtotime("-{$subtractYear} years"));
                $minMonth = 0;
                $minDate = 1;
            }
            if(substr($this->min, 0, 2) == "m-") {
                $subtractMonth = substr($this->min, 2);

                $minYear = Date("Y", strtotime("-{$subtractMonth} month"));
                $minMonth = Date("m", strtotime("-{$subtractMonth} month")) - 1;
                $minDate = 1;
            }
            if(substr($this->min, 0, 2) == "h-") {
                $subtractDay = substr($this->min, 2);

                $minYear = Date("Y", strtotime("-{$subtractDay} days"));
                $minMonth = Date("m", strtotime("-{$subtractDay} days")) - 1;
                $minDate = Date("d", strtotime("-{$subtractDay} days"));
            }
            */
        }
        $this->minHour = $minHour;
        $this->minMinute = $minMinute;
        $this->minSecond = $minSecond;
    }
    protected function generateMaxYmdHis()
    {
        $maxHour = date("H");
        $maxMinute = date("i");
        $maxSecond = date("s");
        if(isset($this->max))
        {
            if(is_array($this->max))
            {
                if(count($this->max) == 3){$maxHour = $this->min[0];$maxMinute = $this->min[1] - 1;$maxSecond = $this->min[2];}
            }
            /*
            if($this->max == "x") {$maxYear = 2099;$maxMonth = 12;$maxDate = 0;}

            if($this->max == "today") {$maxYear = date("Y");$maxMonth = date("m") -1;$maxDate = date("d");}//DEFAULT

            if($this->max == "last month") {$maxYear = date("Y");$maxMonth = date("m") -1;$maxDate = 0;}
            if($this->max == "last year") {$maxYear = date("Y") - 1;$maxMonth = 12;$maxDate = 0;}

            if($this->max == "this month") {$maxYear = date("Y");$maxMonth = date("m");$maxDate = 0;}
            if($this->max == "this year") {$maxYear = date("Y");$maxMonth = 12;$maxDate = 0;}

            if($this->max == "next month") {$maxYear = date("Y");$maxMonth = date("m") +1;$maxDate = 0;}
            if($this->max == "next year") {$maxYear = date("Y") +1;$maxMonth = 12;$maxDate = 0;}

            if(substr($this->max, 0, 2) == "h+") {
                $addDay = substr($this->max, 2);

                $maxYear = Date("Y", strtotime("+{$addDay} days"));
                $maxMonth = Date("m", strtotime("+{$addDay} days")) - 1;
                $maxDate = Date("d", strtotime("+{$addDay} days"));
            }
            */
        }
        $this->maxHour = $maxHour;
        $this->maxMinute = $maxMinute;
        $this->maxSecond = $maxSecond;
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

        $this->customJsObjParams[] = ["key" => "customValue","value" => "{$this->value}"];//HARUS DIMASUKIN KE CUSTOME VALUE, KRN DEFAULT VALUE DI FIELD PAKAI PETIK
        $this->customJsObjParams[] = ["key" => "format","value" => "'{$this->format}'"];
        $this->customJsObjParams[] = ["key" => "min","value" => "new Date(0,0,0,{$this->minHour},{$this->minMinute},{$this->minSecond})"];
        $this->customJsObjParams[] = ["key" => "max","value" => "new Date(0,0,0,{$this->maxHour},{$this->maxMinute},{$this->maxSecond})"];
    }
#endregion data process
}
