<?php
namespace app\components\fields;
use app\components\fields\Field;

class DateRange extends Field
{
    /*Field Child Properties*/
    //protected string|int|array $childProperty;

    /*Field Custom Attributes*/
    //protected string|int|array $customFieldAttribute;

    /*customJsObjParam*/
    //protected string|int|array $customJsObjParam;
    protected string $valueStart;
    protected string $valueEnd;
    protected string $format;
        protected int $minYear;
        protected int $minMonth;
        protected int $minDate;
        protected int $maxYear;
        protected int $maxMonth;
        protected int $maxDate;

    public function __construct(array $params)
    {
        parent::__construct($params);

        /*Field Properties*/
        $this->type = "date";
        $this->elementTag = "input";
        $this->jsClassName = "TDEFieldDateRange";
        /*Field Properties : dihapus aja klo isinya seperti diatas, itu semua nilai default*/

        /*Field Child Properties*/
        //$this->childProperty = $params["childProperty"] ?? "";
        $this->min = $params["dateTimeMin"] ?? "";
        $this->max = $params["dateTimeMax"] ?? "";

        /*Field Custom Attributes*/
        //$this->customFieldAttribute = $params["customFieldAttribute"] ?? "";
        $this->inputType = "date";

        /*customJsObjParam*/
        //$this->customJsObjParam = $params["customJsObjParam"] ?? "";
        $this->format = $params["dateTimeFormat"] ?? "yyyy-MM-dd";

        $this->init();
    }
#region init
    protected function init()
    {
        if($this->getStatusCode() != 100){return false;}

        if(is_array($this->value))
        {
            $this->valueStart = $this->value[0];
            $this->valueEnd = $this->value[1];
        }
        else if($this->value)
        {
            $this->valueStart = $this->value;
            $this->valueEnd = $this->value;
        }
        else
        {
            $this->valueStart = date("Y-m-01");
            $this->valueEnd = date("Y-m-d");
        }

        $this->valueStart = $this->datePhpToJs($this->valueStart);
        $this->valueEnd = $this->datePhpToJs($this->valueEnd);

        $this->generateMinYmd();
        $this->generateMaxYmd();
    }
        protected function datePhpToJs(string $datePhp)
        {
            $dateParts = explode("-",$datePhp);
            $year = $dateParts[0];
            $month = $dateParts[1];
                $month--;/* VERSI JS HARUS KURANGIN 1, KRN JANUARI = 0*/
            $date = $dateParts[2];

            return "new Date({$year},{$month},{$date})";
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
    protected function generateMinYmd()
    {
        $minYear = 1900;
        $minMonth = 0;
        $minDate = 1;
        if($this->min)
        {
            if(is_array($this->min) && count($this->min) == 3) {$minYear = $this->min[0];$minMonth = $this->min[1] - 1;$minDate = $this->min[2];}
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
        }
        $this->minYear = $minYear;
        $this->minMonth = $minMonth;
        $this->minDate = $minDate;
    }
    protected function generateMaxYmd()
    {
        $maxYear = 2099;
        $maxMonth = 11;
        $maxDate = 31;
        if(isset($this->max))
        {
            if(is_array($this->max) && count($this->max) == 3) {$maxYear = $this->max[0];$maxMonth = $this->max[1] - 1;$maxDate = $this->max[2];}
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
        }
        $this->maxYear = $maxYear;
        $this->maxMonth = $maxMonth;
        $this->maxDate = $maxDate;
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
        $this->customJsObjParams[] = ["key" => "valueStart","value" => "{$this->valueStart}"];//HARUS DIMASUKIN KE CUSTOME VALUE, KRN DEFAULT VALUE DI FIELD PAKAI PETIK
        $this->customJsObjParams[] = ["key" => "valueEnd","value" => "{$this->valueEnd}"];//HARUS DIMASUKIN KE CUSTOME VALUE, KRN DEFAULT VALUE DI FIELD PAKAI PETIK
        $this->customJsObjParams[] = ["key" => "format","value" => "'{$this->format}'"];
        $this->customJsObjParams[] = ["key" => "min","value" => "new Date({$this->minYear},{$this->minMonth},{$this->minDate})"];
        $this->customJsObjParams[] = ["key" => "max","value" => "new Date({$this->maxYear},{$this->maxMonth},{$this->maxDate})"];
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
                            $this->generateFieldElement(["sufix" => "Start"]);
                            $this->html .= " s/d ";
                            $this->generateFieldElement(["sufix" => "End"]);
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
