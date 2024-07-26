<?php
namespace app\components;
use app\core\Component;
use app\core\CSRF;

class Form extends Component
{
    protected string $key;
    protected bool $isAuth;
    protected bool $isHidden;
    protected bool $isReadOnly;
    protected bool $isSubForm;
    protected string $theme;
    protected bool|string $alternateColor;
    protected bool $autoAlternateColor;

    protected string $defaultLabelIsShow;
    protected int $defaultLabelCol;
    protected bool $invalidFeedbackIsShow;
    protected string $submitDefaultFunctionName;
    protected string $submitFunctionName;
    protected bool $confirmationMessageIsShow;
    protected string $confirmationMessage;
    protected string $dynamicForm =  "";

    //BUTTONS
    protected bool $buttonsIsShow;
        protected string $buttonClass;
        protected string $buttonColorPrefix;
        protected string $buttonJustify;

        protected bool $cancelButtonIsShow;
            protected string $cancelButtonColor;
            protected string $cancelButtonClass;
            protected string $cancelFontAwesomeIcon;
            protected string $cancelText;
            protected array $cancelFunctions;
            protected int $cancelDelayTimeOut;

        protected bool $submitButtonIsShow;
            protected string $submitButtonColor;
            protected string $submitButtonClass;
            protected string $submitFontAwesomeIcon;
            protected string $submitText;
            protected array $submitFunctions;
            protected bool $submitDefaultIsExecute;
            protected int $submitDelayTimeOut;

        protected array $additionalButtons = [];

    //AJAX
    protected bool $ajaxJSIsRender;
     protected string $ajaxJSFile;
     protected array $ajaxJSDataParams;
        protected string $ajaxJSUrl;

        protected bool $ajaxJSIsSuccess;
            protected string $ajaxJSSuccessFunction;
        protected bool $ajaxJSIsDone;
            protected string $ajaxJSDoneFunction;
        protected bool $ajaxJSIsFail;
            protected string $ajaxJSFailFunction;
        protected bool $ajaxJSIsAlways;
            protected string $ajaxJSAlwaysFunction;
        protected bool $ajaxJSIsShowModal = true;

    //COLLAPSABLE
    protected bool $isCollapse = false;
    protected int $collapseCounter = 0;

    //STEPS
    protected bool $isStep = false;
    protected int $stepCounter = 0;
    protected string $stepClass;
    protected string $stepFunctionName;
    protected array $stepValidations = [];
    protected array $stepButtonFunctions = [];

    //COLUMN
    protected bool $isColumn = false;
    protected int $defaultLabelColFromColumn;
    protected array $columnLengths = [];
    protected int $columnCounter;

    protected array $rowIsOdd = [];

    public function __construct(array $params)
    {
        parent::__construct($params["page"]);
        $this->id = $params["id"] ?? "";
        $this->group = $params["group"] ?? "";

        $this->key = $_SESSION["key"];
        $this->isAuth = $params["isAuth"] ?? true;
        $this->isHidden = $params["isHidden"] ?? false;
        $this->isSubForm = $params["isSubForm"] ?? false;
        $this->isReadOnly = $params["isReadOnly"] ?? false;

        $this->theme = $params["theme"] ?? "kendo";

        $this->alternateColor = $params["alternateColor"] ?? false;
        $this->autoAlternateColor = $params["autoAlternateColor"] ?? true;

        $this->defaultLabelIsShow = $params["defaultLabelIsShow"] ?? true;
        $this->setDefaultLabelCol($params["defaultLabelCol"] ?? 1);
        $this->invalidFeedbackIsShow = $params["invalidFeedbackIsShow"] ?? true;
        $this->submitDefaultFunctionName = $this->group.$this->id;
        $this->submitFunctionName = $params["submitFunctionName"] ?? $this->submitDefaultFunctionName;
        $this->confirmationMessageIsShow = $params["confirmationMessageIsShow"] ?? false;
        $this->confirmationMessage = $params["confirmationMessage"] ?? "Are you sure you want to do this action ?";

        $this->buttonClass = "btn ";
        $this->buttonColorPrefix = "btn-";

        $this->buttonsIsShow = $this->isHidden ? false : ($params["buttonsIsShow"] ?? true);
        $this->buttonClass .= ($params["buttonClass"] ?? "");
        $this->buttonJustify = $params["buttonJustify"] ?? "end";

        $this->cancelButtonIsShow = $params["cancelButtonIsShow"] ?? true;
        $this->cancelButtonColor = $this->buttonColorPrefix.($params["cancelButtonColor"] ?? "secondary");
        $this->cancelButtonClass = $this->buttonClass." ".$this->cancelButtonColor;
        $this->cancelFontAwesomeIcon = $params["cancelFontAwesomeIcon"] ?? "fa-solid fa-xmark";
        $this->cancelText = $params["cancelText"] ?? ($this->app->app_name == "Plutus" ? "TUTUP" : "CLOSE");
        $this->cancelFunctions = $params["cancelFunctions"] ?? [];
        $this->cancelDelayTimeOut = $params["cancelDelayTimeOut"] ?? 1;//IN MILISECOND

        $this->submitButtonIsShow = $params["submitButtonIsShow"] ?? true;
        $this->submitButtonColor = $this->buttonColorPrefix.($params["submitButtonColor"] ?? "primary");
        $this->submitButtonClass = $this->buttonClass." ".$this->submitButtonColor;
        $this->submitFontAwesomeIcon = $params["submitFontAwesomeIcon"] ?? "fa-solid fa-check";
        $this->submitText = $params["submitText"] ?? ($this->app->app_name == "Plutus" ? "KIRIM" : "SUBMIT");
        $this->submitFunctions = $params["submitFunctions"] ?? [];
        $this->submitDefaultIsExecute = $params["submitDefaultIsExecute"] ?? true;
        $this->submitDelayTimeOut = $params["submitDelayTimeOut"] ?? 1;//IN MILISECOND

        $this->additionalButtons = $params["additionalButtons"] ?? [];

        $this->stepButtonFunctions = $params["stepButtonFunctions"] ?? [];

        $this->ajaxJSIsShowModal = $params["ajaxJSIsShowModal"] ?? true;

        $this->ajaxJSIsRender = $params["ajaxJSIsRender"] ?? true;
        $this->ajaxJSDataParams = $params["ajaxJSDataParams"] ?? [];
        $this->ajaxJSFile = $params["ajaxJSFile"] ?? $this->group.$this->id;
        $this->ajaxJSUrl = $params["ajaxJSUrl"] ?? "linkAjax+'{$this->ajaxJSFile}";

        $this->ajaxJSIsSuccess = $params["ajaxJSIsSuccess"] ?? true;
        $this->ajaxJSSuccessFunction = $params["ajaxJSSuccessFunction"] ?? $this->submitDefaultFunctionName."Success";

        $this->ajaxJSIsDone = $params["ajaxJSIsDone"] ?? false;
        $this->ajaxJSDoneFunction = $params["ajaxJSDoneFunction"] ?? $this->submitDefaultFunctionName."Done";

        $this->ajaxJSIsFail = $params["ajaxJSIsFail"] ?? false;
        $this->ajaxJSFailFunction = $params["ajaxJSFailFunction"] ?? $this->submitDefaultFunctionName."Fail";

        $this->ajaxJSIsAlways = $params["ajaxJSIsAlways"] ?? false;
        $this->ajaxJSAlwaysFunction = $params["ajaxJSAlwaysFunction"] ?? $this->submitDefaultFunctionName."Always";

    }

    #region init
    #endregion init

    #region set status
    #endregion

    #region setting variable
        public function begin()
        {
            if($this->getStatusCode() != 100){return false;}
            if($this->isBegin){$this->setStatusCode(401);return false;}//Page is already begin
            if($this->isEnd){$this->setStatusCode(403);return false;}//Page is already ended

            $this->isBegin = 1;
            $this->elementId = "{$this->group}Form{$this->id}";

            if(!$this->isSubForm)
            {
                $this->html .= "<form id='{$this->elementId}'";
                if($this->isHidden) $this->html .= " style='display:none;'";
                else $this->html .= " style='padding-bottom:calc(0.375rem + 1px);'";
                $this->html .= ">";
                $this->globalJS .= "TDE.forms.{$this->elementId} = new TDEForm({id:'{$this->elementId}'});";
                $this->globalJS .= "TDE.{$this->elementId} = $('#{$this->elementId}');";
                $this->globalJS .= "TDE.{$this->elementId}.reset = function(){
                        TDE.forms.{$this->elementId}.reset();
                    };";

                $isDebug = false;
                if($this->isAuth)
                {
                    $loginUserId = $_SESSION[APP_NAME]["login"]["userId"];
                    $loginToken = $_SESSION[APP_NAME]["login"]["token"];
                    $loginTokenHash = password_hash($loginToken, PASSWORD_DEFAULT);

                    if(isset($_SESSION[APP_NAME]["login"]["debug"]))$isDebug = true;
                    //$loginKey = $_SESSION["key"];

                    $this->html .= "<input name='loginUserId' type='hidden' form='{$this->elementId}' value='{$loginUserId}'>";
                    $this->html .= "<input name='loginTokenHash' type='hidden' form='{$this->elementId}' value='{$loginTokenHash}'>";
                    if(APP_NAME == "Plutus")
                    {
                        $this->html .= "<input name='loginBranchId' value='{$_SESSION[APP_NAME]["login"]["branchId"]}' type='hidden' form='{$this->elementId}'>";
                    }
                }
                $this->html .= "<input name='isAuth' type='hidden' form='{$this->elementId}' value='{$this->isAuth}'>";
                $this->html .= "<input name='key' type='hidden' form='{$this->elementId}' value='{$this->key}'>";
                $this->html .= "<input name='token' type='hidden' form='{$this->elementId}' value='{$this->generateToken()}'>";
                $this->html .= "<input name='formId' type='hidden' form='{$this->elementId}' value='{$this->elementId}'>";
                $this->html .= "<input name='formGroup' type='hidden' form='{$this->elementId}' value='{$this->group}{$this->id}'>";
                $this->html .= "<input name='appName' type='hidden' form='{$this->elementId}' value='".APP_NAME."'>";
                if($isDebug) $this->html .= "<input name='isDebug' form='{$this->elementId}' type='hidden' value='1'>";
            }
        }
            protected function generateToken()
            {
                if($this->getStatusCode() != 100){return false;}
                if(!$this->isBegin){$this->setStatusCode(402);return false;}//Page is not yet begin
                if($this->isEnd){$this->setStatusCode(403);return false;}//Page is already ended

                /*
                $salt = "token untuk {$this->elementId} tanggal ".date("Y m d");
                $token = hash_hmac("sha256",$salt,$this->key);
                return $token;
                */
                $salt = $this->elementId;
                $CSRF = new CSRF(array("key" => $this->key, "salt" => $salt));
                return $CSRF->getToken();
            }

        public function end()
        {
            if($this->getStatusCode() != 100) {return false;}
            if(!$this->isBegin) {$this->setStatusCode(402);return false;}//Page is not yet begin
            if($this->isEnd){$this->setStatusCode(403);return false;}//Page is already ended

            $this->isEnd = 1;

            if(!$this->isSubForm)
            {
                if($this->dynamicForm)$this->endDynamicForm();
                if($this->isColumn)$this->endColumn();
                if($this->isStep)$this->endStep();
                if($this->isCollapse) $this->endCollapsable();

                $this->html .= "</form>";

                if(!$this->isStep)
                {
                    if($this->buttonsIsShow)
                    {
                        $this->html .= "<div class='d-flex justify-content-{$this->buttonJustify} '>";
                        $this->generateButtons();
                        $this->html .= "</div>";
                    }
                }

                if($this->confirmationMessageIsShow)
                {
                    $footer = "<button class=\'{$this->cancelButtonClass}\' onClick=\'setTimeout(function() {TDE.commonModal.hide();}, {$this->cancelDelayTimeOut});\'><i class=\'fa-solid fa-xmark\'></i> {$this->cancelText}</button>";
                    $footer .= " <button class=\'{$this->submitButtonClass}\' onClick=\'setTimeout(function() {{$this->submitFunctionName}();TDE.commonModal.hide();}, {$this->submitDelayTimeOut});\'><i class=\'{$this->submitFontAwesomeIcon}\'></i> {$this->submitText}</button>";

                    $this->globalJS .= "function {$this->submitFunctionName}ConfirmationMessage(){
                        TDE.commonModal.Display({
                            body: '{$this->confirmationMessage}',
                            footer: '{$footer}'
                        });
                    }";
                }

                if($this->ajaxJSIsRender)
                {
                    $this->globalJS .= "function {$this->submitDefaultFunctionName}(){
                        let ajaxParams = {
                            'url' : {$this->ajaxJSUrl}.php',
                            'formId' : '{$this->elementId}',";
                    if(count($this->ajaxJSDataParams))
                    {
                        $this->globalJS .= "'dataParams' : {";
                            foreach($this->ajaxJSDataParams AS $key => $value)
                            {
                                $this->globalJS .= "{$key}: {$value},";
                            }
                        $this->globalJS .= "},";
                    }
                    $this->globalJS .= "'functionName' : getFuncName()
                        };
                        let ajax = new Ajax(ajaxParams);
                        let runParams = {";
                            if($this->ajaxJSIsSuccess)$this->globalJS .= "'success' : {$this->ajaxJSSuccessFunction},";
                            if($this->ajaxJSIsDone)$this->globalJS .= "'done' : {$this->ajaxJSDoneFunction},";
                            if($this->ajaxJSIsFail)$this->globalJS .= "'fail' : {$this->ajaxJSFailFunction},";
                            if($this->ajaxJSIsAlways)$this->globalJS .= "'always' : {$this->ajaxJSAlwaysFunction},";
                            if($this->ajaxJSIsShowModal)$this->globalJS .= "'isShowModal' : {$this->ajaxJSIsShowModal},";
                        $this->globalJS .= "};
                        ajax.runAjax(runParams);
                    }";
                }
                $this->generateJSStepFunction();
            }
        }

        public function setDefaultLabelCol(int $defaultLabelCol)
        {
            $this->defaultLabelCol = $defaultLabelCol;
        }
    #endregion setting variable

    #region getting / returning variable
        public function getSubmitDefaultFunctionName()
        {
            if($this->getStatusCode() != 100){return false;}
            if(!$this->isBegin){$this->setStatusCode(402);return false;}//Page is not yet begin
            if(!$this->isEnd){$this->setStatusCode(404);return false;}//Page is not yet ended

            return "{$this->submitDefaultFunctionName}";
        }

    #endregion  getting / returning variable

    #region data process
        #region step
            public function addStep($params = null)
            {
                $this->startStep($params);
            }
                protected function startStep($params)
                {
                    if($this->getStatusCode() != 100){return false;}
                    if(!$this->isBegin){$this->setStatusCode(402);return false;}//Page is not yet begin
                    if($this->isEnd){$this->setStatusCode(403);return false;}//Page is already ended

                    if(!$this->isStep)//INIT STEP
                    {
                        $this->isStep = true;
                        $this->stepClass = $this->elementId."Step";
                        $this->stepFunctionName = $this->stepClass."Show";
                    }

                    $this->endStep();//TUTUP DIV STEP SEBELUMNYA

                    $isShowStepTitle = true;
                    $stepTitle = "STEP ".($this->stepCounter + 1);
                    $stepSubTitle = "";

                    if(isset($params))
                    {
                        if(is_array($params))
                        {
                            $isShowStepTitle = $params["isShowStepTitle"] ?? true;
                            $stepTitle = $params["stepTitle"] ?? "STEP ".($this->stepCounter + 1);
                            $stepSubTitle = $params["stepSubTitle"] ?? "";
                        }
                        else
                        {
                            $stepTitle = $params;
                        }
                    }

                    $stepId = $this->stepClass."_".$this->stepCounter;

                    $stepClass = $this->stepClass;
                    if($this->stepCounter)$stepClass .= " d-none";//HIDE SEMUA YANG BUKAN STEP PERTAMA

                    $this->html .= "<div id='{$stepId}' class='{$stepClass}'>";
                        if($isShowStepTitle)
                        {
                            $this->html .= "<h5>{$stepTitle}</h5>";
                            if($stepSubTitle)$this->html .= "{$stepSubTitle}";
                        }

                    $this->stepValidations[$this->stepCounter] = [];

                    $this->stepCounter++;
                }
                protected function endStep()
                {
                    if($this->getStatusCode() != 100){return false;}
                    if(!$this->isBegin){$this->setStatusCode(402);return false;}//Page is not yet begin
                    //if($this->isEnd){$this->setStatusCode(403);return false;}//Page is already ended

                    if($this->stepCounter)
                    {
                        $thisStep = $this->stepCounter - 1;
                        $previouseStep = $thisStep - 1;
                        $nextStep = $thisStep + 1;

                        $this->html .= "<div class='d-flex justify-content-between'>";
                            if($thisStep)
                            {
                                $this->html .= "<div class='{$this->cancelButtonClass}' onClick='{$this->stepFunctionName}({$previouseStep},&quot;b&quot;);";
                                foreach($this->stepButtonFunctions AS $index => $stepButtonFunction)
                                {
                                    $this->html .= "{$stepButtonFunction}();";
                                }
                                $this->html .= "'><i class='fa-solid fa-angle-left'></i> BACK</div>";
                            }
                            else $this->html .= "<div></div>";//DIV KOSONG BUAT RATA KIRI

                            if($this->isEnd)
                            {
                                $this->html .= "<div>";
                                    $this->generateButtons();
                                $this->html .= "</div>";
                            }
                            else
                            {
                                $this->html .= "<div class='{$this->submitButtonClass}' onClick='{$this->stepFunctionName}({$nextStep},&quot;n&quot;);";
                                foreach($this->stepButtonFunctions AS $index => $stepButtonFunction)
                                {
                                    $this->html .= "{$stepButtonFunction}();";
                                }
                                $this->html .= "'>NEXT <i class='fa-solid fa-angle-right'></i></div>";
                            }
                        $this->html .= "</div>";

                        $this->html .= "</div>";//TUTUP DIV STEP
                    }
                }
        #endregion step

        #region collapsable
            public function collapsable($params = NULL)
            {
                if(isset($params))
                {
                    if(is_string($params))
                    {
                        $params = ["text" => $params];
                    }
                }
                else
                {
                    $params = [];
                }
                $this->startCollapsable($params);
            }
                protected function startCollapsable(array $params)
                {
                    if($this->getStatusCode() != 100){return false;}
                    if(!$this->isBegin){$this->setStatusCode(402);return false;}//Page is not yet begin
                    if($this->isEnd){$this->setStatusCode(403);return false;}//Page is already ended

                    $text = $params["text"] ?? "Show detail";
                    $isShow = $params["isShow"] ?? false;
                    $triggerJsFunction = $params["triggerJsFunction"] ?? false;

                    $this->endCollapsable();//TUTUP DIV STEP SEBELUMNYA

                    if(!$this->isCollapse)//INIT COLLAPSE
                    {
                        $this->isCollapse = true;
                        $collapseClass = $this->elementId."Collapse";
                        $collapseId = $collapseClass."_".$this->collapseCounter;
                        $this->html .= "<div class='row mt-3'><div id='' class='fw-bold text-decoration-underline text-primary' role='button' data-bs-toggle='collapse' data-bs-target='#{$collapseId}' aria-expanded='false' aria-controls='{$collapseId}'";
                        if($triggerJsFunction) $this->html .= " onClick='{$triggerJsFunction}();'";
                        $this->html .= ">{$text}</div></div>";

                        $this->html .= "<div id='{$collapseId}' class='collapse";
                        if($isShow)$this->html .= " show";
                        $this->html .= " {$collapseClass}'>";
                        $this->collapseCounter++;
                    }
                }
                protected function endCollapsable()
                {
                    if($this->getStatusCode() != 100){return false;}
                    if(!$this->isBegin){$this->setStatusCode(402);return false;}//Page is not yet begin
                    //if($this->isEnd){$this->setStatusCode(403);return false;}//Page is already ended

                    if($this->isCollapse)
                    {
                        $this->isCollapse = false;
                        $this->html .= "</div>";
                    }
                }
        #endregion collapsable

        #region column
            public function addColumn($params)
            {
                if($this->getStatusCode() != 100){return false;}
                if(!$this->isBegin){$this->setStatusCode(402);return false;}//Page is not yet begin
                if($this->isEnd){$this->setStatusCode(403);return false;}//Page is already ended
                if($this->isColumn){$this->setStatusCode(413);return false;}//Form column already started

                $this->columnLengths = [];
                $this->isColumn = true;

                $columnCount = 0;
                if(is_numeric($params))
                {
                    $columnCount = $params;
                    $totalLength = 12;

                    for($counter = 0 ; $counter < $columnCount ; $counter++)
                    {
                        $columnReminder = $columnCount - $counter;
                        $columnLength = round($totalLength / $columnReminder);
                        $this->columnLengths[] = $columnLength;
                        $totalLength = $totalLength - $columnLength;

                        //echo "{$counter}:{$columnReminder}:{$columnLength}<br/>";
                    }
                }
                else if(is_array($params))
                {
                    $columnCount = count($params);
                    $this->columnLengths = $params;
                }

                $this->columnCounter = 0;

                $this->defaultLabelColFromColumn = $this->defaultLabelCol;
                $this->defaultLabelCol = $this->defaultLabelCol * $columnCount;

                $this->html.= "<div class='row'>";
                    $this->html.= "<div class='col-lg-{$this->columnLengths[$this->columnCounter]}'>";

                $this->columnCounter++;
            }
                public function nextColumn()
                {
                    if($this->getStatusCode() != 100){return false;}
                    if(!$this->isBegin){$this->setStatusCode(402);return false;}//Page is not yet begin
                    if($this->isEnd){$this->setStatusCode(403);return false;}//Page is already ended
                    if(!$this->isColumn){$this->setStatusCode(414);return false;}//Form column not yet init

                    $this->html.= "</div>";
                    $this->html.= "<div class='col-lg-{$this->columnLengths[$this->columnCounter]}'>";
                    $this->columnCounter++;
                }
                public function endColumn()
                {
                    if($this->getStatusCode() != 100){return false;}
                    if(!$this->isBegin){$this->setStatusCode(402);return false;}//Page is not yet begin
                    //if($this->isEnd){$this->setStatusCode(403);return false;}//Page is already ended
                    if(!$this->isColumn){$this->setStatusCode(414);return false;}//Form column not yet init

                    $this->setDefaultLabelCol($this->defaultLabelColFromColumn);
                    $this->isColumn = false;
                        $this->html.= "</div>";
                    $this->html.= "</div>";
                }
        #endregion column

        #region dynamic form
            public function addDynamicForm(string $dynamicForm)
            {
                if($this->getStatusCode() != 100){return false;}
                if($this->dynamicForm)$this->endDynamicForm();

                $this->dynamicForm = $dynamicForm;
                $dynamicFormId = "{$this->elementId}DynamicForm{$this->dynamicForm}";

                $inputElementName = $this->generateInputName("DynamicForm", "BLANK", "");
                $this->html .= "<input name='{$inputElementName}[]' type='hidden' form='{$this->elementId}' value='{$dynamicForm}'/>";

                $this->html .= "<div id='{$dynamicFormId}' class='{$this->elementId}DynamicForm d-none'>";

                $this->js .= "if(typeof TDE.{$this->elementId}.DynamicForm === 'undefined'){
                        TDE.{$this->elementId}.DynamicForm = [];
                    }
                    TDE.{$this->elementId}.DynamicForm.{$this->dynamicForm} = $('#{$dynamicFormId}');
                    TDE.{$this->elementId}.DynamicForm.{$this->dynamicForm}.show = function(){
                        $('.{$this->elementId}DynamicForm').addClass('d-none');
                        $('#{$dynamicFormId}').removeClass('d-none');
                    };";
            }
            public function endDynamicForm()
            {
                if($this->getStatusCode() != 100){return false;}
                $this->dynamicForm = "";
                $this->html .= "</div>";
            }
        #endregion dynamic form

        #region field generator
            public function addField(array $params)
            {
                $this->addFieldSet($params);
            }
            public function addFieldSet(array $params)
            {
                if($this->getStatusCode() != 100){return false;}

                if(!$this->isBegin){$this->setStatusCode(402);return false;}//Page is not yet begin
                if($this->isEnd){$this->setStatusCode(403);return false;}//Page is already ended

                $alternateColor = $params["alternateColor"] ?? $this->alternateColor;
                    if($alternateColor)
                    {
                        if(is_bool($alternateColor))
                        {
                            $alternateColor = "bg-secondary";
                        }

                        if($this->autoAlternateColor)
                        {
                            if(!isset($this->rowIsOdd[$alternateColor]))
                            {
                                $this->rowIsOdd[$alternateColor] = true;
                            }
                            //dd($this->rowIsOdd);

                            if($this->rowIsOdd[$alternateColor] == true)
                            {
                                $this->rowIsOdd[$alternateColor] = false;
                                $alternateColor .= " bg-opacity-10";
                            }
                            else
                            {
                                $this->rowIsOdd[$alternateColor] = true;
                                $alternateColor .= " bg-opacity-25";
                            }
                        }
                    }

                $labelIsShow = $params["labelIsShow"] ?? $this->defaultLabelIsShow;
                    $labelCol = $params["labelCol"] ?? ($labelIsShow ? $this->defaultLabelCol : 0);
                    $labelText = $params["labelText"] ?? $params["inputName"] ?? "";
                    $labelClass = $params["labelClass"] ?? "";
                    $labelInfo = $params["labelInfo"] ?? "";
                    $labelAttr = $params["labelAttr"] ?? [];

                $inputType = $this->isHidden ? "hidden" : ($params["inputType"] ?? "text");
                //$inputName = $params["inputName"] ?? $labelText;
                $inputName = $this->dynamicForm.($params["inputName"] ?? "");
                $inputValue = $params["inputValue"] ?? "";
                $inputCol = $params["inputCol"] ?? 12 - $labelCol;
                $inputGroup = $params["inputGroup"] ?? [""];
                $inputArray = $params["inputArray"] ?? "";
                $inputPlaceHolder = $params["inputPlaceHolder"] ?? $labelText;
                $inputStyle = $params["inputStyle"] ?? "";
                $inputSize = $params["inputSize"] ?? "";
                $inputClass = $params["inputClass"] ?? "";
                $inputDataCustom = $params["inputDataCustom"] ?? [];
                $inputReadOnly = $params["inputReadOnly"] ?? $this->isReadOnly;
                $inputDisable = $params["inputDisable "] ?? false;

                $inputOnChange = $params["inputOnChange"]  ?? false;
                $inputOnPaste = $params["inputOnPaste"]  ?? false;
                $inputOnKeyDown = $params["inputOnKeyDown"]  ?? false;

                $required = $params["required"] ?? false;
                $inputInfo = $params["inputInfo"] ?? "";

                $inputId = $this->group.$this->id.(str_replace("[]","",$inputName));
                //dd($params);

                if($inputSize)$inputStyle .= ";width:{$inputSize}";
                else if($inputType == "kendoDatePicker")$inputStyle .= ";width:10rem";
                else if($inputType == "kendoTimePicker")$inputStyle .= ";width:9.1rem";
                else if($inputType == "kendoDateTimePicker")$inputStyle .= ";width:17.3rem";
                //else if($inputType == "kendoMonthPicker")$inputStyle .= ";width:9.1rem";
                //else if($inputType == "kendoYearPicker")$inputStyle .= ";width:9.1rem";
                else if($inputType == "kendoDatePicker_range")$inputStyle .= ";width:10rem";

                else if($inputType == "kendoNumericTextBox")
                {
                    $numericTypeDetail = $params["numericTypeDetail"] ?? "";

                    if($numericTypeDetail == "currency"){
                        $inputStyle .= ";width:15rem";
                    }
                    else if($numericTypeDetail == "percentage"){
                        $inputStyle .= ";width:9rem";
                    }
                    else{
                        $inputStyle .= ";width:7.3rem";
                        if($numericTypeDetail == "dec1")$inputStyle .= ";width:9.1rem";
                        if($numericTypeDetail == "dec2")$inputStyle .= ";width:9.1rem";
                        if($numericTypeDetail == "dec3")$inputStyle .= ";width:11rem";
                        if($numericTypeDetail == "dec4")$inputStyle .= ";width:11.8rem";
                    }
                }
                else if($inputType == "kendoMaskedTextBox")
                {
                    $mask = $params["mask"];
                    if($mask == "postalCode")$inputStyle .= ";width:70px";
                    else if($mask == "rt")$inputStyle .= ";width:50px";
                    else if($mask == "rw")$inputStyle .= ";width:50px";
                    else if($mask == "npwp")$inputStyle .= ";width:140px";
                    else if($mask == "pkp")$inputStyle .= ";width:140px";
                    else if($mask == "ktp")$inputStyle .= ";width:140px";
                }
                else if($inputType == "checkbox")$inputStyle .= "";
                else $inputStyle .= " width:100%";

                if($required)
                {
                    $labelClass .= " text-danger";
                    if($this->isStep)
                    {
                        /*
                        $this->stepValidations[($this->stepCounter-1)][] = array(
                            "inputName" => $inputName,
                            "inputType" => $inputType,
                            "labelText" => $labelText
                        );
                        */
                        $this->stepValidations[($this->stepCounter-1)][] = $params;
                    }
                }
                if($inputReadOnly)
                {
                    $labelClass .= " light_grey";
                }

                $labelClass .= " col-form-label";
                $labelClass .= " col-lg-{$labelCol}";

                $html = "";
                $js = "";

                /*FORM PROPERTY*/
                $params["type"] = $inputType;
                    if($inputType == "kendoEditor")$params["type"] = "editor";
                    else if($inputType == "kendoNumericTextBox")$params["type"] = "number";
                    else if($inputType == "kendoDatePicker")$params["type"] = "date";
                    else if($inputType == "kendoTimePicker")$params["type"] = "time";
                    else if($inputType == "kendoDateTimePicker")$params["type"] = "datetime";
                    else if($inputType == "kendoDatePicker_range")$params["type"] = "daterange";
                    else if($inputType == "kendoCheckBox")$params["type"] = "checkbox";
                    else if($inputType == "kendoUpload")$params["type"] = "upload";
                    else if($inputType == "kendoComboBox")$params["type"] = "combobox";
                    else if($inputType == "kendoMultiSelect")$params["type"] = "multiselect";
                    else if($inputType == "kendoMultiColumnComboBox")$params["type"] = "multicolumncombobox";
                    else if($inputType == "kendoDropDownList")$params["type"] = "dropdownlist";
                    else if($inputType == "kendoDropDownTree")$params["type"] = "dropdowntree";
                $params["page"] = $this->page;
                $params["group"] = $this->group;
                $params["formId"] = $this->id;
                $params["formElementId"] = $this->elementId;
                $params["invalidFeedbackIsShow"] = $this->invalidFeedbackIsShow;
                $params["dynamicForm"] = $this->dynamicForm ?? "";

                if($this->theme == "kendo")
                {
                    if($inputType == "hidden")
                    {
                        //save singular id & name
                        $FieldSet = new FieldSet($params);
                        $html .= $FieldSet->getHtml();
                        $js .= $FieldSet->getJs(true);
                        /*
                        foreach($inputGroup AS $index => $groupName)
                        {
                            $hiddenType = $params["hiddenType"] ?? "";

                            if(!$hiddenType)
                            {
                                $inputElementId = $this->generateInputId($inputId, $groupName, $inputArray);
                                $inputElementName = $this->generateInputName($inputName, $groupName, $inputArray);
                                $html .= "<input id='{$inputElementId}' name='{$inputElementName}' type='{$inputType}' form='{$this->elementId}' value='{$inputValue}'/>";
                                $js .= "TDE.{$inputElementId} = $('#{$inputElementId}');";
                                $js .= "TDE.{$inputElementId}.value = $('#{$inputElementId}').val;";
                            }
                            if($hiddenType == "readpos")
                            {
                                $hiddenPageId = $params["hiddenPageId"];
                                //on progress
                            }
                        }
                        */
                    }
                    else
                    {
                        /*ROW PROPERTY*/
                        $params["alternateColor"] = $alternateColor;

                        /*LABEL PROPERTY*/
                        $params["labelId"] = $inputId."Label";
                        $params["labelIsShow"] = $labelIsShow;
                        $params["labelCol"] = $labelCol;
                        $params["labelClass"] = $labelClass;

                        /*INPUT PROPERTY*/
                        //$params["inputCol"] = 12 - $labelCol;
                        $params["inputPlaceHolder"] = $inputPlaceHolder;
                        if(!in_array($inputType,["textarea","kendoEditor"]))
                        {
                            $params["inputOnKeyDowns"] = [
                                13 => [
                                    "functionNames" => [$this->submitFunctionName],
                                    "confirmMessageIsShow" => $this->confirmationMessageIsShow,
                                    "delayTimeOut" => $this->submitDelayTimeOut,
                                ]
                            ];
                        }
                        $doneTesting = ["text","email","password","kendoNumericTextBox"
                            ,"checkbox","kendoCheckBox","switch"
                            ,"textarea","kendoEditor"
                            ,"kendoDatePicker","kendoTimePicker","kendoDateTimePicker","kendoDatePicker_range"
                            ,"kendoUpload"
                        ];
                        $stillTesting = "";

                        $doneSelectTesting = ["kendoComboBox","kendoMultiSelect","kendoMultiColumnComboBox","kendoDropDownList","kendoDropDownTree"];
                        $doneSelectTypeTesting = ["", "monthYearPicker", "cbpPicker"];

                        $stillSelectTesting = "";
                        $stillSelectTypeTesting = "else";
                        $selectTypeDetail = $params["selectTypeDetail"] ?? "";

                        $isOld = true;
                        $isTesting = false;

                        if(in_array($inputType,$doneTesting))$isOld = false;
                        else if(in_array($inputType,$doneSelectTesting) && in_array($selectTypeDetail,$doneSelectTypeTesting))$isOld = false;

                        //if($selectTypeDetail == "cbpPicker")dd($isOld);
                        //if($inputName == "NotifPositionIdscationSound")dd($isOld);

                        if($isOld)
                        {
                            $onChangeFunction = "";
                            if($inputOnChange)
                            {
                                if(is_string($inputOnChange))$onChangeFunction = $inputOnChange;
                                else $onChangeFunction =  $inputId."Change";
                            }

                            $onKeyDownFunction = "";
                            if($inputOnKeyDown)
                            {
                                if(is_string($inputOnKeyDown))$onKeyDownFunction = $inputOnKeyDown;
                                else $onKeyDownFunction =  $inputId."KeyDown";
                            }

                            $onPasteFunction = "";
                            if($inputOnPaste)
                            {
                                if(is_string($inputOnPaste))$onPasteFunction = $inputOnPaste;
                                else $onPasteFunction =  $inputId."Paste";
                            }

                            $html = "<div class='row mb-1";
                            if($inputType != "textarea")$html .= " align-items-center";
                            if($alternateColor)$html .= " {$alternateColor}";
                            $html .= "'>";
                                //PRINT LABEL
                                if($labelIsShow)
                                {
                                    $labelElementId = $inputId."Label";
                                    $html .= "<label id='{$labelElementId}' class='{$labelClass}'";
                                        foreach($labelAttr AS $key => $value)
                                        {
                                            $html .= " {$key}='{$value}'";
                                        }
                                    $html .=">";
                                    $html .= "{$labelText}";
                                    if($labelInfo)
                                    {
                                        $labelInfoElementId = "{$labelElementId}Info";
                                        $html .= "<span id='{$labelInfoElementId}' class='ms-2'>{$labelInfo}</span>";
                                        $js .= "TDE.{$labelInfoElementId} = $('#{$labelInfoElementId}');";
                                    }
                                    $html .= "</label>";
                                    $js .= "TDE.{$labelElementId} = $('#{$labelElementId}');";
                                }

                                //SINGLE INPUT COLOUMN
                                $html .= "<div class='col-lg-{$inputCol} col-form-label'>";
                                    //ACTUAL INPUT ELEMENT
                                    $html .= "<div class='d-lg-flex justify-content-between'>";
                                        $inputGroupCount = count($inputGroup);
                                        //save singular id & name
                                        $inputElementIds = [];
                                        foreach($inputGroup AS $index => $groupName)
                                        {
                                            $inputElementId = $this->generateInputId($inputId, $groupName, $inputArray);
                                            $inputElementIds[] = $inputElementId;
                                            $inputElementName = $this->generateInputName($inputName, $groupName, $inputArray);


                                            $html .= "<div style='width:calc(100%/{$inputGroupCount});'>";
                                            /*
                                                if($inputType == "text" || $inputType == "email" || $inputType == "password")
                                                {
                                                    $inputMaxLength = $params["inputMaxLength"] ?? 0;

                                                    $html .= "<input
                                                                id='{$inputElementId}'
                                                                name='{$inputElementName}'
                                                                type='{$inputType}'
                                                                form='{$this->elementId}'
                                                                style='{$inputStyle}'";
                                                        if($inputClass) $html .= " class='{$inputClass}'";
                                                        if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                        if($inputMaxLength)$html .= " maxlength='{$inputMaxLength}'";
                                                        $html .= " onkeydown='if(event.keyCode == 13){
                                                            setTimeout(function() {
                                                                {$this->submitFunctionName}";
                                                                if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                $html .= "();";
                                                                if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                            $html .= "}, {$this->submitDelayTimeOut});
                                                        };'";
                                                        if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                    $html .= ">";
                                                    $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').kendoTextBox({
                                                        placeholder: '{$inputPlaceHolder}'";
                                                        if($inputValue)$js .= ",value: '{$inputValue}'";
                                                        if($inputReadOnly)$js .= ",readonly: true";
                                                        if($inputDisable)$js .= ",enable: false";
                                                        $js .= "}).data('kendoTextBox');";

                                                    $js .= "TDE.{$inputElementId}.reset = function(){
                                                        TDE.{$inputElementId}.value('');
                                                    };";
                                                }
                                                else if($inputType == "checkbox")
                                                {
                                                    $checkboxLabel = $params["checkboxLabel"] ?? "";

                                                    $html .= "<input
                                                                id='{$inputElementId}'
                                                                name='{$inputElementName}'
                                                                type='checkbox'
                                                                form='{$this->elementId}'
                                                                style='{$inputStyle}'";
                                                    if($inputClass) $html .= " class='{$inputClass}'";
                                                    if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                        $html .= " onkeydown='if(event.keyCode == 13){
                                                            setTimeout(function() {
                                                                {$this->submitFunctionName}";
                                                                if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                $html .= "();";
                                                                if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                            $html .= "}, {$this->submitDelayTimeOut});
                                                        };'";
                                                        if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                        $html .= "/>";
                                                    $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').kendoCheckBox({
                                                        label: '{$checkboxLabel}'";
                                                        if($inputValue)$js .= ",checked: true";
                                                        if($inputReadOnly)$js .= ",readonly: true";
                                                        if($inputDisable)$js .= ",enable: false";
                                                    $js .= "}).data('kendoCheckBox');";
                                                }
                                                else if($inputType == "textarea")
                                                {
                                                    $textareaRow = $params["textareaRow"] ?? 5;
                                                    $textareaMaxLength = $params["textareaMaxLength"] ?? 500;
                                                    $textareaShowCounter = $params["textareaShowCounter"] ?? true;

                                                    $html .= "<textarea
                                                                id='{$inputElementId}'
                                                                name='{$inputElementName}'
                                                                style='{$inputStyle}'";
                                                            if($inputClass) $html .= " class='{$inputClass}'";
                                                            if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                            if($onKeyDownFunction)$html .= " onkeydown='{$onKeyDownFunction}();'";
                                                            if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                    $html .= "></textarea>";
                                                    if($textareaShowCounter)
                                                    {
                                                        $inputElementCounterId = "{$inputElementId}TextAreaCounter";
                                                        $html .= "<div id='' class=''><span id='{$inputElementCounterId}'>0</span>/{$textareaMaxLength}</div>";
                                                    }

                                                    $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').kendoTextArea({
                                                        rows: {$textareaRow}
                                                        ,maxLength:{$textareaMaxLength}
                                                        ,placeholder: '{$inputPlaceHolder}'";
                                                        if($inputValue)$js .= ",value: '{$inputValue}'";
                                                        if($inputReadOnly)$js .= ",readonly: true";
                                                        if($inputDisable)$js .= ",enable: false";
                                                        $js .= "}).data('kendoTextArea');";

                                                    if($textareaShowCounter)
                                                    {
                                                        $js .= "TDE.{$inputElementId}.counter = $('#{$inputElementCounterId}');";

                                                        $js .= "TDE.{$inputElementId}.updateCounter = function(){
                                                            TDE.{$inputElementId}.counter.html($('#{$inputElementId}').val().length);
                                                        };";

                                                        $js .= "$('#{$inputElementId}').on('input', function () {
                                                                TDE.{$inputElementId}.updateCounter();
                                                            });";
                                                    }

                                                    $js .= "TDE.{$inputElementId}.reset = function(){
                                                        TDE.{$inputElementId}.value('');";
                                                        if($textareaShowCounter)
                                                        {
                                                            $js .= "TDE.{$inputElementId}.updateCounter();";
                                                        }
                                                    $js .= "};";
                                                }
                                                else if($inputType == "kendoEditor")
                                                {
                                                    $html .= "<textarea
                                                                id='{$inputElementId}'
                                                                name='{$inputElementName}'
                                                                style='{$inputStyle}'";
                                                            if($inputClass) $html .= " class='{$inputClass}'";
                                                            if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                            if($onKeyDownFunction)$html .= " onkeydown='{$onKeyDownFunction}();'";
                                                            if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                    $html .= "></textarea>";

                                                    $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').kendoEditor({
                                                        stylesheets: [
                                                            '/".COMMON_CSS."bootstrap.tde.min.css',
                                                            '/".COMMON_CSS."index.css',
                                                            '/".COMMON_CSS."color.css',
                                                            '/".KENDOUI_ROOT."css/kendo.bootstrap.min.css',
                                                            '/".KENDOUI_ROOT."css/kendo.common-bootstrap.min.css',
                                                            '/".FONTAWESOME_ROOT."css/all.css'
                                                        ]
                                                        ,tools: [
                                                            'bold','italic','underline',
                                                            'undo','redo',
                                                            'justifyLeft','justifyCenter','justifyRight',
                                                            'insertUnorderedList','insertImage',
                                                            'createLink','unlink',
                                                            'tableWizard','tableProperties','tableCellProperties','createTable','addRowAbove','addRowBelow','addColumnLeft','addColumnRight','deleteRow','deleteColumn','mergeCellsHorizontally','mergeCellsVertically','splitCellHorizontally','splitCellVertically','tableAlignLeft','tableAlignCenter','tableAlignRight',
                                                            'formatting',
                                                            {
                                                                name: 'fontName',
                                                                items: [
                                                                    { text: 'Andale Mono', value: '\'Andale Mono\'' },
                                                                    { text: 'Arial', value: 'Arial' },
                                                                    { text: 'Arial Black', value: '\'Arial Black\'' },
                                                                    { text: 'Book Antiqua', value: '\'Book Antiqua\'' },
                                                                    { text: 'Comic Sans MS', value: '\'Comic Sans MS\'' },
                                                                    { text: 'Courier New', value: '\'Courier New\'' },
                                                                    { text: 'Georgia', value: 'Georgia' },
                                                                    { text: 'Helvetica', value: 'Helvetica' },
                                                                    { text: 'Impact', value: 'Impact' },
                                                                    { text: 'Symbol', value: 'Symbol' },
                                                                    { text: 'Tahoma', value: 'Tahoma' },
                                                                    { text: 'Terminal', value: 'Terminal' },
                                                                    { text: 'Times New Roman', value: '\'Times New Roman\'' },
                                                                    { text: 'Trebuchet MS', value: '\'Trebuchet MS\'' },
                                                                    { text: 'Verdana', value: 'Verdana' },
                                                                ]
                                                            },
                                                            'fontSize','foreColor','backColor',
                                                        ]";
                                                        if($inputValue)$js .= ",value: '{$inputValue}'";
                                                        if($inputReadOnly)$js .= ",readonly: true";
                                                        if($inputDisable)$js .= ",enable: false";
                                                        $js .= "}).data('kendoEditor');";

                                                    $js .= "TDE.{$inputElementId}.reset = function(){
                                                        TDE.{$inputElementId}.value('');
                                                    };";
                                                }
                                                else if($inputType == "kendoNumericTextBox")
                                                {
                                                    $numericIsSpinner = $params["numericIsSpinner"] ?? true;
                                                    $numericTypeDetail = $params["numericTypeDetail"] ?? "";
                                                    $numericIsNegaitve = $params["numericIsNegaitve"] ?? false;
                                                    $numericOnSpin = $params["numericOnSpin"]  ?? false;

                                                    if(isset($params["numericMin"]))$numericMin = $params["numericMin"];
                                                    else
                                                    {
                                                        $numericMin = "0";
                                                        if($numericIsNegaitve)$numericMin = "x";
                                                    }

                                                    if(isset($params["numericMax"]))$numericMax = $params["numericMax"];
                                                    else
                                                    {
                                                        $numericMax = "x";
                                                    }

                                                    if(isset($params["numericDecimals"]))$numericDecimals = $params["numericDecimals"];
                                                    else
                                                    {
                                                        $numericDecimals = "x";
                                                        if($numericTypeDetail == "percentage")$numericDecimals = "2";
                                                        if($numericTypeDetail == "dec1")$numericDecimals = "1";
                                                        if($numericTypeDetail == "dec2")$numericDecimals = "2";
                                                        if($numericTypeDetail == "dec3")$numericDecimals = "3";
                                                        if($numericTypeDetail == "dec4")$numericDecimals = "4";
                                                    }

                                                    if(isset($params["numericStep"]))$numericStep = $params["numericStep"];
                                                    else
                                                    {
                                                        $numericStep = "x";
                                                        if($numericTypeDetail == "percentage")$numericStep = "0.01";
                                                        if($numericTypeDetail == "dec1")$numericStep = "0.1";
                                                        if($numericTypeDetail == "dec2")$numericStep = "0.01";
                                                        if($numericTypeDetail == "dec3")$numericStep = "0.001";
                                                        if($numericTypeDetail == "dec4")$numericStep = "0.0001";
                                                    }

                                                    if(isset($params["numericFormat"]))$numericFormat = $params["numericFormat"];
                                                    else
                                                    {
                                                        $numericFormat = "#";
                                                        if($numericTypeDetail == "currency")$numericFormat = "Rp #,0";
                                                        if($numericTypeDetail == "percentage")$numericFormat = "#.## \'%\'";
                                                        if($numericTypeDetail == "dec1")$numericFormat = "n1";
                                                        if($numericTypeDetail == "dec2")$numericFormat = "n2";
                                                        if($numericTypeDetail == "dec3")$numericFormat = "n3";
                                                        if($numericTypeDetail == "dec4")$numericFormat = "n4";
                                                    }

                                                    if(!$inputValue)$inputValue = "0";

                                                    $numericOnSpinFunction = "";
                                                    if($numericOnSpin)
                                                    {
                                                        if(is_string($numericOnSpin))$numericOnSpinFunction = $numericOnSpin;
                                                        else $numericOnSpinFunction =  $inputId."Spin";
                                                    }

                                                    $html .= "<input
                                                                id='{$inputElementId}'
                                                                name='{$inputElementName}'
                                                                type='text'
                                                                form='{$this->elementId}'
                                                                style='{$inputStyle}'";
                                                        if($inputClass) $html .= " class='{$inputClass}'";
                                                        if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                        $html .= " onkeydown='if(event.keyCode == 13){
                                                            setTimeout(function() {
                                                                {$this->submitFunctionName}";
                                                                if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                $html .= "();";
                                                                if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                            $html .= "}, {$this->submitDelayTimeOut});
                                                        };'";
                                                        if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                    $html .= ">";

                                                    $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').kendoNumericTextBox({
                                                        restrictDecimals: true";
                                                        if($inputValue)$js .= ",value: '{$inputValue}'";
                                                        if(!$numericIsSpinner)$js .= ",spinners: false";
                                                        if($numericMin != "x")$js .= ",min:{$numericMin}";
                                                        if($numericMax != "x")$js .= ",max:{$numericMax}";
                                                        if($numericDecimals != "x")$js .= ",decimals:{$numericDecimals}";
                                                        if($numericStep != "x")$js .= ",step:{$numericStep}";
                                                        if($numericFormat != "x")$js .= ",format:'{$numericFormat}'";
                                                    $js .= "}).data('kendoNumericTextBox');";

                                                    if($numericOnSpinFunction)$js .= "TDE.{$inputElementId}.bind('spin', {$numericOnSpinFunction});";

                                                    if($inputReadOnly)$js .= "TDE.{$inputElementId}.readonly();";
                                                    if($inputDisable)$js .= "TDE.{$inputElementId}.enable(false);";

                                                    $js .= "TDE.{$inputElementId}.reset = function(){
                                                        TDE.{$inputElementId}.value(0);
                                                    };";
                                                }
                                                else if($inputType == "kendoDatePicker")
                                                {
                                                    //Note: JavaScript counts months from 0 to 11:
                                                    //January = 0
                                                    //December = 11
                                                    $dateTimeFormat = $params["dateTimeFormat"] ?? "yyyy-MM-dd";
                                                    $backDateFormId = $params["backDateFormId"] ?? $this->group.$this->id;
                                                    $backDatePOSElementIds = $params["backDatePOSElementIds"] ?? "";//element POSId ini urutannya harus di atas kendoDateTimePicker ini

                                                    if(!$inputValue)$inputValue = "now";
                                                    if($inputValue == "x")$inputValue = "";
                                                    if($inputValue == "now")$inputValue = date("Y-m-d");
                                                    if($inputValue == "today")$inputValue = date("Y-m-d");

                                                    $inputMinYear = date("Y");
                                                    $inputMinMonth = date("m") -1;
                                                    $inputMinDate = 1;
                                                    if(isset($params["dateTimeMin"]))
                                                    {
                                                        if(is_array($params["dateTimeMin"]) && count($params["dateTimeMin"]) == 3) {$inputMinYear = $params["dateTimeMin"][0];$inputMinMonth = $params["dateTimeMin"][1] - 1;$inputMinDate = $params["dateTimeMin"][2];}
                                                        if($params["dateTimeMin"] == "x") {$inputMinYear = 1900;$inputMinMonth = 0;$inputMinDate = 1;}
                                                        if($params["dateTimeMin"] == "today") {$inputMinYear = date("Y");$inputMinMonth = date("m") - 1;$inputMinDate = date("d");}

                                                        if($params["dateTimeMin"] == "last month") {$inputMinYear = date("Y");$inputMinMonth = date("m") - 2;$inputMinDate = 1;}
                                                        if($params["dateTimeMin"] == "last year") {$inputMinYear = date("Y") - 1;$inputMinMonth = 0;$inputMinDate = 1;}

                                                        if($params["dateTimeMin"] == "this month") {$inputMinYear = date("Y");$inputMinMonth = date("m") - 1;$inputMinDate = 1;}//DEFAULT
                                                        if($params["dateTimeMin"] == "this year") {$inputMinYear = date("Y");$inputMinMonth = 0;$inputMinDate = 1;}

                                                        if($params["dateTimeMin"] == "next month") {$inputMinYear = date("Y");$inputMinMonth = date("m");$inputMinDate = 1;}
                                                        if($params["dateTimeMin"] == "next year") {$inputMinYear = date("Y") +1;$inputMinMonth = 0;$inputMinDate = 1;}

                                                        if(substr($params["dateTimeMin"], 0, 2) == "y-") {
                                                            $subtractYear = substr($params["dateTimeMin"], 2);

                                                            $inputMinYear = Date("Y", strtotime("-{$subtractYear} years"));
                                                            $inputMinMonth = 0;
                                                            $inputMinDate = 1;
                                                        }
                                                        if(substr($params["dateTimeMin"], 0, 2) == "m-") {
                                                            $subtractMonth = substr($params["dateTimeMin"], 2);

                                                            $inputMinYear = Date("Y", strtotime("-{$subtractMonth} month"));
                                                            $inputMinMonth = Date("m", strtotime("-{$subtractMonth} month")) - 1;
                                                            $inputMinDate = 1;
                                                        }
                                                        if(substr($params["dateTimeMin"], 0, 2) == "h-") {
                                                            $subtractDay = substr($params["dateTimeMin"], 2);

                                                            $inputMinYear = Date("Y", strtotime("-{$subtractDay} days"));
                                                            $inputMinMonth = Date("m", strtotime("-{$subtractDay} days")) - 1;
                                                            $inputMinDate = Date("d", strtotime("-{$subtractDay} days"));
                                                        }
                                                    }

                                                    $inputMaxYear = date("Y");
                                                    $inputMaxMonth = date("m") -1;
                                                    $inputMaxDate = date("d");
                                                    if(isset($params["dateTimeMax"]))
                                                    {
                                                        if(is_array($params["dateTimeMax"]) && count($params["dateTimeMax"]) == 3) {$inputMaxYear = $params["dateTimeMax"][0];$inputMaxMonth = $params["dateTimeMax"][1] - 1;$inputMaxDate = $params["dateTimeMax"][2];}
                                                        if($params["dateTimeMax"] == "x") {$inputMaxYear = 2099;$inputMaxMonth = 12;$inputMaxDate = 0;}

                                                        if($params["dateTimeMax"] == "today") {$inputMaxYear = date("Y");$inputMaxMonth = date("m") -1;$inputMaxDate = date("d");}//DEFAULT

                                                        if($params["dateTimeMax"] == "last month") {$inputMaxYear = date("Y");$inputMaxMonth = date("m") -1;$inputMaxDate = 0;}
                                                        if($params["dateTimeMax"] == "last year") {$inputMaxYear = date("Y") - 1;$inputMaxMonth = 12;$inputMaxDate = 0;}

                                                        if($params["dateTimeMax"] == "this month") {$inputMaxYear = date("Y");$inputMaxMonth = date("m");$inputMaxDate = 0;}
                                                        if($params["dateTimeMax"] == "this year") {$inputMaxYear = date("Y");$inputMaxMonth = 12;$inputMaxDate = 0;}

                                                        if($params["dateTimeMax"] == "next month") {$inputMaxYear = date("Y");$inputMaxMonth = date("m") +1;$inputMaxDate = 0;}
                                                        if($params["dateTimeMax"] == "next year") {$inputMaxYear = date("Y") +1;$inputMaxMonth = 12;$inputMaxDate = 0;}

                                                        if(substr($params["dateTimeMax"], 0, 2) == "h+") {
                                                            $addDay = substr($params["dateTimeMax"], 2);

                                                            $inputMaxYear = Date("Y", strtotime("+{$addDay} days"));
                                                            $inputMaxMonth = Date("m", strtotime("+{$addDay} days")) - 1;
                                                            $inputMaxDate = Date("d", strtotime("+{$addDay} days"));
                                                        }
                                                    }

                                                    $html .= "<input
                                                                id='{$inputElementId}'
                                                                name='{$inputElementName}'
                                                                type='text'
                                                                form='{$this->elementId}'
                                                                value='{$inputValue}'
                                                                style='{$inputStyle}'";
                                                        if($inputClass) $html .= " class='{$inputClass}'";
                                                        if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                        $html .= " onkeydown='if(event.keyCode == 13){
                                                            setTimeout(function() {
                                                                {$this->submitFunctionName}";
                                                                if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                $html .= "();";
                                                                if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                            $html .= "}, {$this->submitDelayTimeOut});
                                                        };'";
                                                        if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                    $html .= ">";

                                                    $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').kendoDatePicker({
                                                        format:'{$dateTimeFormat}'
                                                        ,min:new Date({$inputMinYear},{$inputMinMonth},{$inputMinDate})
                                                        ,max:new Date({$inputMaxYear},{$inputMaxMonth},{$inputMaxDate})
                                                    }).data('kendoDatePicker');";

                                                    if($inputReadOnly)$js .= "TDE.{$inputElementId}.readonly();";
                                                    if($inputDisable)$js .= "TDE.{$inputElementId}.enable(false);";

                                                    if($this->app->app_name == "Plutus")
                                                    {
                                                        $js .= "TDE.{$inputElementId}.backDate = ".json_encode($this->app->getBackDate()).";";
                                                        if(!isset($params["dateTimeMin"]))
                                                        {
                                                            $maxBackDate = 0;
                                                            foreach($this->app->getBackDate() AS $POSId => $monthBackDate)
                                                            {
                                                                if($maxBackDate < $monthBackDate)
                                                                    $maxBackDate = $monthBackDate;
                                                            }
                                                            $js .= "TDE.{$inputElementId}.min(new Date(new Date().getFullYear(), new Date().getMonth() - {$maxBackDate}, 1));";

                                                            if(is_array($backDatePOSElementIds) || (is_string($backDatePOSElementIds) && $backDatePOSElementIds))
                                                            {
                                                                if(is_string($backDatePOSElementIds))
                                                                {
                                                                    $backDatePOSElementIds = [$backDatePOSElementIds];
                                                                }
                                                                $updateBackDateFunctionName = "UpdateBackDate";
                                                                $js .= "TDE.{$inputElementId}.{$updateBackDateFunctionName} = function(){
                                                                    let now = new Date();
                                                                    let year = now.getFullYear();
                                                                    let month = now.getMonth();
                                                                    let backDateMonth = 0;
                                                                    let POSId = 0;";

                                                                    //CHECK AVAILABLE BACK DATE MONTH
                                                                    foreach($backDatePOSElementIds AS $backDatePOSElementId)
                                                                    {
                                                                        $POSIdElementId = $backDateFormId.$backDatePOSElementId;
                                                                        $js .= "POSId = TDE.{$POSIdElementId}.value() * 1;
                                                                            if(POSId in TDE.{$inputElementId}.backDate){
                                                                                if(!backDateMonth) backDateMonth = TDE.{$inputElementId}.backDate[POSId];
                                                                                else if(TDE.{$inputElementId}.backDate[POSId] < backDateMonth)backDateMonth = TDE.{$inputElementId}.backDate[POSId];
                                                                            }
                                                                            else backDateMonth = 0;
                                                                        ";
                                                                    }
                                                                    $js .= "if(backDateMonth == -1){
                                                                            year = 1900;
                                                                            month = 0;
                                                                        }
                                                                        else{
                                                                            month = month - backDateMonth;
                                                                        }

                                                                        let minDate = new Date(year, month, 1);
                                                                        let pickedDate = TDE.{$inputElementId}.value();

                                                                        TDE.{$inputElementId}.min(minDate);
                                                                        if(pickedDate < minDate){
                                                                            TDE.{$inputElementId}.value(minDate);
                                                                        }";
                                                                $js .= "}";
                                                                foreach($backDatePOSElementIds AS $backDatePOSElementId)
                                                                {
                                                                    $js .= "TDE.{$POSIdElementId}.bind('change',TDE.{$inputElementId}.{$updateBackDateFunctionName});";
                                                                }
                                                            }
                                                        }
                                                    }

                                                    $js .= "TDE.{$inputElementId}.reset = function(){
                                                        let min = TDE.{$inputElementId}.min;
                                                        let max = TDE.{$inputElementId}.max;

                                                        let now = new Date();

                                                        let resetDate = now;
                                                        if(min > now)resetDate = min;
                                                        else if(max < now)resetDate = max;

                                                        TDE.{$inputElementId}.value(resetDate);
                                                    };";
                                                }
                                                else if($inputType == "kendoTimePicker")
                                                {
                                                    $dateTimeFormat = $params["dateTimeFormat"] ?? "HH:mm:ss";

                                                    if(!$inputValue)$inputValue = "now";
                                                    if($inputValue == "x")$inputValue = "";
                                                    if($inputValue == "now")$inputValue = date("H:i:s");

                                                    $inputMinHour = 0;
                                                    $inputMinMinute = 0;
                                                    $inputMinSecond = 0;
                                                    if(isset($params["dateTimeMin"]))
                                                    {
                                                        if(is_array($params["dateTimeMin"]) && count($params["dateTimeMin"]) == 3) {$inputMinHour = $params["dateTimeMin"][0];$inputMinMinute = $params["dateTimeMin"][1];$inputMinSecond = $params["dateTimeMin"][2];}
                                                    }

                                                    $inputMaxHour = 23;
                                                    $inputMaxMinute = 59;
                                                    $inputMaxSecond = 59;
                                                    if(isset($params["dateTimeMax"]))
                                                    {
                                                        if(is_array($params["dateTimeMax"]) && count($params["dateTimeMax"]) == 3) {$inputMaxHour = $params["dateTimeMax"][0];$inputMaxMinute = $params["dateTimeMax"][1];$inputMaxSecond = $params["dateTimeMax"][2];}
                                                    }

                                                    $html .= "<input
                                                                id='{$inputElementId}'
                                                                name='{$inputElementName}'
                                                                type='text'
                                                                form='{$this->elementId}'
                                                                value='{$inputValue}'
                                                                style='{$inputStyle}'";
                                                        if($inputClass) $html .= " class='{$inputClass}'";
                                                        if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                        $html .= " onkeydown='if(event.keyCode == 13){
                                                            setTimeout(function() {
                                                                {$this->submitFunctionName}";
                                                                if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                $html .= "();";
                                                                if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                            $html .= "}, {$this->submitDelayTimeOut});
                                                        };'";
                                                        if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                    $html .= ">";

                                                    $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').kendoTimePicker({
                                                        format:'{$dateTimeFormat}'
                                                        ,min:new Date(1900,0,1,{$inputMinHour},{$inputMinMinute},{$inputMinSecond})
                                                        ,max:new Date(1900,0,1,{$inputMaxHour},{$inputMaxMinute},{$inputMaxSecond})
                                                    }).data('kendoTimePicker');";

                                                    if($inputReadOnly)$js .= "TDE.{$inputElementId}.readonly();";
                                                    if($inputDisable)$js .= "TDE.{$inputElementId}.enable(false);";
                                                }
                                                else if($inputType == "kendoDateTimePicker")
                                                {
                                                    //Note: JavaScript counts months from 0 to 11:
                                                    //January = 0
                                                    //December = 11
                                                    $dateTimeFormat = $params["dateTimeFormat"] ?? "yyyy-MM-dd HH:mm:ss";
                                                    $backDateFormId = $params["backDateFormId"] ?? $this->group.$this->id;
                                                    $backDatePOSElementIds = $params["backDatePOSElementIds"] ?? "";//element POSId ini urutannya harus di atas kendoDateTimePicker ini

                                                    if(!$inputValue)$inputValue = "now";
                                                    if($inputValue == "x")$inputValue = "";
                                                    if($inputValue == "now")$inputValue = date("Y-m-d H:i:s");
                                                    if($inputValue == "today")$inputValue = date("Y-m-d H:i:s");

                                                    $inputMinYear = date("Y");
                                                    $inputMinMonth = date("m") -1;
                                                    $inputMinDate = 1;
                                                    $inputMinHour = 0;
                                                    $inputMinMinute = 0;
                                                    $inputMinSecond = 0;
                                                    if(isset($params["dateTimeMin"]))
                                                    {
                                                        if(is_array($params["dateTimeMin"]) && count($params["dateTimeMin"]) == 3) {$inputMinYear = $params["dateTimeMin"][0];$inputMinMonth = $params["dateTimeMin"][1] - 1;$inputMinDate = $params["dateTimeMin"][2];}
                                                        if(is_array($params["dateTimeMin"]) && count($params["dateTimeMin"]) == 6)
                                                        {
                                                            $inputMinYear = $params["dateTimeMin"][0];$inputMinMonth = $params["dateTimeMin"][1] - 1;$inputMinDate = $params["dateTimeMin"][2];
                                                            $inputMinHour = $params["dateTimeMin"][3];$inputMinMinute = $params["dateTimeMin"][4];$inputMinSecond = $params["dateTimeMin"][5];
                                                        }
                                                        if($params["dateTimeMin"] == "x") {$inputMinYear = 1900;$inputMinMonth = 0;$inputMinDate = 1;}
                                                        if($params["dateTimeMin"] == "today") {$inputMinYear = date("Y");$inputMinMonth = date("m") - 1;$inputMinDate = date("d");}

                                                        if($params["dateTimeMin"] == "last month") {$inputMinYear = date("Y");$inputMinMonth = date("m") - 2;$inputMinDate = 1;}
                                                        if($params["dateTimeMin"] == "last year") {$inputMinYear = date("Y") - 1;$inputMinMonth = 0;$inputMinDate = 1;}

                                                        if($params["dateTimeMin"] == "this month") {$inputMinYear = date("Y");$inputMinMonth = date("m") - 1;$inputMinDate = 1;}//DEFAULT
                                                        if($params["dateTimeMin"] == "this year") {$inputMinYear = date("Y");$inputMinMonth = 0;$inputMinDate = 1;}

                                                        if($params["dateTimeMin"] == "next month") {$inputMinYear = date("Y");$inputMinMonth = date("m");$inputMinDate = 1;}
                                                        if($params["dateTimeMin"] == "next year") {$inputMinYear = date("Y") +1;$inputMinMonth = 0;$inputMinDate = 1;}

                                                        if(substr($params["dateTimeMin"], 0, 2) == "y-") {
                                                            $subtractYear = substr($params["dateTimeMin"], 2);

                                                            $inputMinYear = Date("Y", strtotime("-{$subtractYear} years"));
                                                            $inputMinMonth = 0;
                                                            $inputMinDate = 1;
                                                        }
                                                        if(substr($params["dateTimeMin"], 0, 2) == "m-") {
                                                            $subtractMonth = substr($params["dateTimeMin"], 2);

                                                            $inputMinYear = Date("Y", strtotime("-{$subtractMonth} month"));
                                                            $inputMinMonth = Date("m", strtotime("-{$subtractMonth} month")) - 1;
                                                            $inputMinDate = 1;
                                                        }
                                                        if(substr($params["dateTimeMin"], 0, 2) == "h-") {
                                                            $subtractDay = substr($params["dateTimeMin"], 2);

                                                            $inputMinYear = Date("Y", strtotime("-{$subtractDay} days"));
                                                            $inputMinMonth = Date("m", strtotime("-{$subtractDay} days")) - 1;
                                                            $inputMinDate = Date("d", strtotime("-{$subtractDay} days"));
                                                        }
                                                    }

                                                    $inputMaxYear = date("Y");
                                                    $inputMaxMonth = date("m") -1;
                                                    $inputMaxDate = date("d");
                                                    $inputMaxHour = 23;
                                                    $inputMaxMinute = 59;
                                                    $inputMaxSecond = 59;
                                                    if(isset($params["dateTimeMax"]))
                                                    {
                                                        if(is_array($params["dateTimeMax"]) && count($params["dateTimeMax"]) == 3) {$inputMaxYear = $params["dateTimeMax"][0];$inputMaxMonth = $params["dateTimeMax"][1] - 1;$inputMaxDate = $params["dateTimeMax"][2];}
                                                        if(is_array($params["dateTimeMax"]) && count($params["dateTimeMax"]) == 6)
                                                        {
                                                            $inputMaxYear = $params["dateTimeMax"][0];$inputMaxMonth = $params["dateTimeMax"][1] - 1;$inputMaxDate = $params["dateTimeMax"][2];
                                                            $inputMaxHour = $params["dateTimeMax"][3];$inputMaxMinute = $params["dateTimeMax"][4];$inputMaxSecond = $params["dateTimeMax"][5];
                                                        }
                                                        if($params["dateTimeMax"] == "x") {$inputMaxYear = 2099;$inputMaxMonth = 12;$inputMaxDate = 0;}

                                                        if($params["dateTimeMax"] == "today") {$inputMaxYear = date("Y");$inputMaxMonth = date("m") -1;$inputMaxDate = date("d");}//DEFAULT

                                                        if($params["dateTimeMax"] == "last month") {$inputMaxYear = date("Y");$inputMaxMonth = date("m") -1;$inputMaxDate = 0;}
                                                        if($params["dateTimeMax"] == "last year") {$inputMaxYear = date("Y") - 1;$inputMaxMonth = 12;$inputMaxDate = 0;}

                                                        if($params["dateTimeMax"] == "this month") {$inputMaxYear = date("Y");$inputMaxMonth = date("m");$inputMaxDate = 0;}
                                                        if($params["dateTimeMax"] == "this year") {$inputMaxYear = date("Y");$inputMaxMonth = 12;$inputMaxDate = 0;}

                                                        if($params["dateTimeMax"] == "next month") {$inputMaxYear = date("Y");$inputMaxMonth = date("m") +1;$inputMaxDate = 0;}
                                                        if($params["dateTimeMax"] == "next year") {$inputMaxYear = date("Y") +1;$inputMaxMonth = 12;$inputMaxDate = 0;}
                                                    }

                                                    $html .= "<input
                                                                id='{$inputElementId}'
                                                                name='{$inputElementName}'
                                                                type='text'
                                                                form='{$this->elementId}'
                                                                value='{$inputValue}'
                                                                style='{$inputStyle}'";
                                                        if($inputClass) $html .= " class='{$inputClass}'";
                                                        if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                        $html .= " onkeydown='if(event.keyCode == 13){
                                                            setTimeout(function() {
                                                                {$this->submitFunctionName}";
                                                                if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                $html .= "();";
                                                                if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                            $html .= "}, {$this->submitDelayTimeOut});
                                                        };'";
                                                        if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                    $html .= ">";

                                                    $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').kendoDateTimePicker({
                                                        format:'{$dateTimeFormat}'
                                                        ,min:new Date({$inputMinYear},{$inputMinMonth},{$inputMinDate},{$inputMinHour},{$inputMinMinute},{$inputMinSecond})
                                                        ,max:new Date({$inputMaxYear},{$inputMaxMonth},{$inputMaxDate},{$inputMaxHour},{$inputMaxMinute},{$inputMaxSecond})
                                                    }).data('kendoDateTimePicker');";

                                                    if($inputReadOnly)$js .= "TDE.{$inputElementId}.readonly();";
                                                    if($inputDisable)$js .= "TDE.{$inputElementId}.enable(false);";

                                                    if($this->app->app_name == "Plutus")
                                                    {
                                                        $js .= "TDE.{$inputElementId}.backDate = ".json_encode($this->app->getBackDate()).";";
                                                        if(!isset($params["dateTimeMin"]))
                                                        {
                                                            $maxBackDate = 0;
                                                            foreach($this->app->getBackDate() AS $POSId => $monthBackDate)
                                                            {
                                                                if($maxBackDate < $monthBackDate)
                                                                    $maxBackDate = $monthBackDate;
                                                            }
                                                            $js .= "TDE.{$inputElementId}.min(new Date(new Date().getFullYear(), new Date().getMonth() - {$maxBackDate}, 1));";

                                                            if(is_array($backDatePOSElementIds) || (is_string($backDatePOSElementIds) && $backDatePOSElementIds))
                                                            {
                                                                if(is_string($backDatePOSElementIds))
                                                                {
                                                                    $backDatePOSElementIds = [$backDatePOSElementIds];
                                                                }

                                                                $updateBackDateFunctionName = "UpdateBackDate";
                                                                $js .= "TDE.{$inputElementId}.{$updateBackDateFunctionName} = function(){
                                                                    let now = new Date();
                                                                    let year = now.getFullYear();
                                                                    let month = now.getMonth();
                                                                    let backDateMonth = 0;
                                                                    let POSId = 0;";

                                                                    //CHECK AVAILABLE BACK DATE MONTH
                                                                    foreach($backDatePOSElementIds AS $backDatePOSElementId)
                                                                    {
                                                                        $POSIdElementId = $backDateFormId.$backDatePOSElementId;
                                                                        $js .= "POSId = TDE.{$POSIdElementId}.value() * 1;
                                                                            if(POSId in TDE.{$inputElementId}.backDate){
                                                                                if(!backDateMonth) backDateMonth = TDE.{$inputElementId}.backDate[POSId];
                                                                                else if(TDE.{$inputElementId}.backDate[POSId] < backDateMonth)backDateMonth = TDE.{$inputElementId}.backDate[POSId];
                                                                            }
                                                                            else backDateMonth = 0;
                                                                        ";
                                                                    }
                                                                    $js .= "month = month - backDateMonth;

                                                                        let minDate = new Date(year, month, 1);
                                                                        let pickedDate = TDE.{$inputElementId}.value();

                                                                        TDE.{$inputElementId}.min(minDate);
                                                                        if(pickedDate < minDate){
                                                                            TDE.{$inputElementId}.value(minDate);
                                                                        }";
                                                                $js .= "};";
                                                                foreach($backDatePOSElementIds AS $backDatePOSElementId)
                                                                {
                                                                    $js .= "TDE.{$POSIdElementId}.bind('change',TDE.{$inputElementId}.{$updateBackDateFunctionName});";
                                                                }
                                                            }
                                                        }
                                                    }

                                                    $js .= "TDE.{$inputElementId}.reset = function(){
                                                        let min = TDE.{$inputElementId}.min;
                                                        let max = TDE.{$inputElementId}.max;

                                                        let now = new Date();

                                                        let resetDate = now;
                                                        if(min > now)resetDate = min;
                                                        else if(max < now)resetDate = max;

                                                        TDE.{$inputElementId}.value(resetDate);
                                                    };";
                                                }
                                                else if($inputType == "kendoDatePicker_range")
                                                {
                                                    $dateTimeFormat = $params["dateTimeFormat"] ?? "yyyy-MM-dd";
                                                    if(is_array($inputValue))
                                                    {
                                                        $inputValueStart = $inputValue[0];
                                                        $inputValueEnd = $inputValue[1];
                                                    }
                                                    else if($inputValue)
                                                    {
                                                        $inputValueStart = $inputValue;
                                                        $inputValueEnd = $inputValue;
                                                    }
                                                    else
                                                    {
                                                        $inputValueStart = date("Y-m-01");
                                                        $inputValueEnd = date("Y-m-d");
                                                    }
                                                    $inputElementIdStart = $this->generateInputId($inputId."Start", $groupName, $inputArray);
                                                    $inputElementNameStart = $this->generateInputName($inputName."Start", $groupName, $inputArray);

                                                    $inputMinYear = 1900;
                                                    $inputMinMonth = 0;
                                                    $inputMinDate = 1;
                                                    if(isset($params["dateTimeMin"]))
                                                    {
                                                        if(is_array($params["dateTimeMin"]) && count($params["dateTimeMin"]) == 3) {$inputMinYear = $params["dateTimeMin"][0];$inputMinMonth = $params["dateTimeMin"][1] - 1;$inputMinDate = $params["dateTimeMin"][2];}
                                                        if($params["dateTimeMin"] == "x") {$inputMinYear = 1900;$inputMinMonth = 0;$inputMinDate = 1;}//DEFAULT
                                                        if($params["dateTimeMin"] == "today") {$inputMinYear = date("Y");$inputMinMonth = date("m") - 1;$inputMinDate = date("d");}

                                                        if($params["dateTimeMin"] == "last month") {$inputMinYear = date("Y");$inputMinMonth = date("m") - 2;$inputMinDate = 1;}
                                                        if($params["dateTimeMin"] == "last year") {$inputMinYear = date("Y") - 1;$inputMinMonth = 0;$inputMinDate = 1;}

                                                        if($params["dateTimeMin"] == "this month") {$inputMinYear = date("Y");$inputMinMonth = date("m") - 1;$inputMinDate = 1;}
                                                        if($params["dateTimeMin"] == "this year") {$inputMinYear = date("Y");$inputMinMonth = 0;$inputMinDate = 1;}

                                                        if($params["dateTimeMin"] == "next month") {$inputMinYear = date("Y");$inputMinMonth = date("m");$inputMinDate = 1;}
                                                        if($params["dateTimeMin"] == "next year") {$inputMinYear = date("Y") +1;$inputMinMonth = 0;$inputMinDate = 1;}
                                                    }

                                                    $inputElementIdEnd = $this->generateInputId($inputId."End", $groupName, $inputArray);
                                                    $inputElementNameEnd = $this->generateInputName($inputName."End", $groupName, $inputArray);

                                                    $inputMaxYear = 2099;
                                                    $inputMaxMonth = 12;
                                                    $inputMaxDate = 0;
                                                    if(isset($params["dateTimeMax"]))
                                                    {
                                                        if(is_array($params["dateTimeMax"]) && count($params["dateTimeMax"]) == 3) {$inputMaxYear = $params["dateTimeMax"][0];$inputMaxMonth = $params["dateTimeMax"][1] - 1;$inputMaxDate = $params["dateTimeMax"][2];}
                                                        if($params["dateTimeMax"] == "x") {$inputMaxYear = 2099;$inputMaxMonth = 12;$inputMaxDate = 0;}//DEFAULT

                                                        if($params["dateTimeMax"] == "today") {$inputMaxYear = date("Y");$inputMaxMonth = date("m") -1;$inputMaxDate = date("d");}

                                                        if($params["dateTimeMax"] == "last month") {$inputMaxYear = date("Y");$inputMaxMonth = date("m") -1;$inputMaxDate = 0;}
                                                        if($params["dateTimeMax"] == "last year") {$inputMaxYear = date("Y") - 1;$inputMaxMonth = 12;$inputMaxDate = 0;}

                                                        if($params["dateTimeMax"] == "this month") {$inputMaxYear = date("Y");$inputMaxMonth = date("m");$inputMaxDate = 0;}
                                                        if($params["dateTimeMax"] == "this year") {$inputMaxYear = date("Y");$inputMaxMonth = 12;$inputMaxDate = 0;}

                                                        if($params["dateTimeMax"] == "next month") {$inputMaxYear = date("Y");$inputMaxMonth = date("m") +1;$inputMaxDate = 0;}
                                                        if($params["dateTimeMax"] == "next year") {$inputMaxYear = date("Y") +1;$inputMaxMonth = 12;$inputMaxDate = 0;}
                                                    }
                                                    $html .= "<input
                                                                id='{$inputElementIdStart}'
                                                                name='{$inputElementNameStart}'
                                                                type='text'
                                                                form='{$this->elementId}'
                                                                value='{$inputValueStart}'
                                                                style='{$inputStyle}'";
                                                        $html .= " onkeydown='if(event.keyCode == 13){
                                                            setTimeout(function() {
                                                                {$this->submitFunctionName}";
                                                                if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                $html .= "();";
                                                                if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                            $html .= "}, {$this->submitDelayTimeOut});
                                                        };'";
                                                        if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                    $html .= ">
                                                            s/d
                                                            <input
                                                                id='{$inputElementIdEnd}'
                                                                name='{$inputElementNameEnd}'
                                                                type='text'
                                                                form='{$this->elementId}'
                                                                value='{$inputValueEnd}'
                                                                style='{$inputStyle}'";
                                                        $html .= " onkeydown='if(event.keyCode == 13){
                                                            setTimeout(function() {
                                                                {$this->submitFunctionName}";
                                                                if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                $html .= "();";
                                                                if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                            $html .= "}, {$this->submitDelayTimeOut});
                                                        };'";
                                                        if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                    $html .= ">";

                                                    $js .= "function {$inputElementIdStart}DefaultChange() {
                                                        let startDate = TDE.{$inputElementIdStart}.value();
                                                        let endDate = TDE.{$inputElementIdEnd}.value();
                                                        if (startDate) {
                                                            startDate = new Date(startDate);
                                                            startDate.setDate(startDate.getDate());
                                                            TDE.{$inputElementIdEnd}.min(startDate);
                                                        }
                                                        else if (endDate) {
                                                            TDE.{$inputElementIdStart}.max(new Date(endDate));
                                                        }
                                                        else {
                                                            endDate = new Date();
                                                            TDE.{$inputElementIdStart}.max(endDate);
                                                            TDE.{$inputElementIdEnd}.min(endDate);
                                                        }
                                                    }

                                                    function {$inputElementIdEnd}DefaultChange() {
                                                        let endDate = TDE.{$inputElementIdEnd}.value();
                                                        let startDate = TDE.{$inputElementIdStart}.value();
                                                        if (endDate) {
                                                            endDate = new Date(endDate);
                                                            endDate.setDate(endDate.getDate());
                                                            TDE.{$inputElementIdStart}.max(endDate);
                                                        }
                                                        else if (startDate) {
                                                            TDE.{$inputElementIdEnd}.min(new Date(startDate));
                                                        }
                                                        else {
                                                            endDate = new Date();
                                                            TDE.{$inputElementIdStart}.max(endDate);
                                                            TDE.{$inputElementIdEnd}.min(endDate);
                                                        }
                                                    }

                                                    TDE.{$inputElementIdStart} = $('#{$inputElementIdStart}').kendoDatePicker({
                                                        format:'{$dateTimeFormat}'
                                                        ,change:{$inputElementIdStart}DefaultChange
                                                        ,min:new Date({$inputMinYear},{$inputMinMonth},{$inputMinDate})
                                                    }).data('kendoDatePicker');

                                                    TDE.{$inputElementIdEnd} = $('#{$inputElementIdEnd}').kendoDatePicker({
                                                        format:'{$dateTimeFormat}'
                                                        ,change:{$inputElementIdEnd}DefaultChange
                                                        ,max:new Date({$inputMaxYear},{$inputMaxMonth},{$inputMaxDate})
                                                    }).data('kendoDatePicker');

                                                    TDE.{$inputElementIdStart}.max(TDE.{$inputElementIdEnd}.value());
                                                    TDE.{$inputElementIdEnd}.min(TDE.{$inputElementIdStart}.value());";

                                                    if($inputReadOnly)
                                                    {
                                                        $js .= "TDE.{$inputElementIdStart}.readonly();";
                                                        $js .= "TDE.{$inputElementIdEnd}.readonly();";
                                                    }
                                                    if($inputDisable)
                                                    {
                                                        $js .= "TDE.{$inputElementIdStart}.enable(false);";
                                                        $js .= "TDE.{$inputElementIdEnd}.enable(false);";
                                                    }
                                                }
                                                else if($inputType == "kendoMaskedTextBox")
                                                {
                                                    $mask = $params["mask"] ?? "";

                                                    if($mask == "postalCode")
                                                    {
                                                        $mask = "00000";
                                                    }
                                                    else if($mask == "rt")
                                                    {
                                                        $mask = "000";
                                                    }
                                                    else if($mask == "rw")
                                                    {
                                                        $mask = "000";
                                                    }
                                                    else if($mask == "ktp")
                                                    {
                                                        $mask = "0000000000000000";
                                                    }
                                                    else if($mask == "npwp")
                                                    {
                                                        $mask = "00.000.000.0-000.000";
                                                    }
                                                    else if($mask == "pkp")
                                                    {
                                                        $mask = "00.000.000.0-000.000";
                                                    }

                                                    $html .= "<input
                                                            id='{$inputElementId}'
                                                            name='{$inputElementName}'
                                                            form='{$this->elementId}'
                                                            value='{$inputValue}'
                                                            style='{$inputStyle}'";
                                                            if($inputClass) $html .= " class='{$inputClass}'";
                                                            if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                        $html .= " onkeydown='if(event.keyCode == 13){
                                                            setTimeout(function() {
                                                                {$this->submitFunctionName}";
                                                                if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                $html .= "();";
                                                                if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                            $html .= "}, {$this->submitDelayTimeOut});
                                                        };'";
                                                        if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                    $html .= ">";
                                                    $html .= "</input>";

                                                    $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').{$inputType}({
                                                        mask:'{$mask}'";
                                                        if($inputReadOnly)$js .= ",readonly: true";
                                                    $js .= "}).data('{$inputType}');";

                                                    $js .= "TDE.{$inputElementId}.reset = function(){
                                                        TDE.{$inputElementId}.value('');
                                                    };";

                                                    if($inputReadOnly)$js .= "TDE.{$inputElementId}.readonly();";
                                                    if($inputDisable)$js .= "TDE.{$inputElementId}.enable(false);";
                                                }
                                                else if($inputType == "kendoCheckBox")
                                                {
                                                    $checkBoxChecked = $params["checkBoxChecked"] ?? false;
                                                    $kendoCheckLabel = $params["kendoCheckLabel"] ?? $groupName;
                                                    $kendoCheckBoxSize = $params["kendoCheckBoxSize"] ?? "medium";
                                                    $kendoCheckBoxRounded = $params["kendoCheckBoxRounded"] ?? "medium";

                                                    $html .= "<input
                                                                id='{$inputElementId}'
                                                                name='{$inputElementName}'
                                                                type='checkbox'
                                                                form='{$this->elementId}'";
                                                        if($inputClass) $html .= " class='{$inputClass}'";
                                                        if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                        $html .= " onkeydown='if(event.keyCode == 13){
                                                            setTimeout(function() {
                                                                {$this->submitFunctionName}";
                                                                if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                $html .= "();";
                                                                if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                            $html .= "}, {$this->submitDelayTimeOut});
                                                        };'";
                                                        if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                    $html .= ">";

                                                    $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').kendoCheckBox({
                                                        size:'{$kendoCheckBoxSize}',
                                                        rounded:'{$kendoCheckBoxRounded}',";
                                                    if($kendoCheckLabel)$js .= "label: '{$kendoCheckLabel}',";
                                                    if($checkBoxChecked)$js .= "checked: true,";
                                                    if($inputDisable)$js .= "enabled: false,";
                                                    $js .= "}).data('kendoCheckBox');";
                                                }
                                                else if($inputType == "switch")
                                                {
                                                    $switchChecked = $params["switchChecked"] ?? false;
                                                    $switchSize = $params["switchSize"] ?? "small";
                                                    $switchTrackRounded = $params["switchTrackRounded"] ?? "small";
                                                    $switchThumbRounded = $params["switchThumbRounded"] ?? "small";
                                                    $switchMessagesChecked = $params["switchMessagesChecked"] ?? "YES";
                                                    $switchMessagesUnchecked = $params["switchMessagesUnchecked"] ?? "NO";

                                                    $html .= "<input
                                                                id='{$inputElementId}'
                                                                name='{$inputElementName}'
                                                                type='checkbox'
                                                                form='{$this->elementId}'
                                                                value=1";
                                                        if($inputClass) $html .= " class='{$inputClass}'";
                                                        if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                        $html .= " onkeydown='if(event.keyCode == 13){
                                                            setTimeout(function() {
                                                                {$this->submitFunctionName}";
                                                                if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                $html .= "();";
                                                                if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                            $html .= "}, {$this->submitDelayTimeOut});
                                                        };'";
                                                        if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                    $html .= ">";

                                                    $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').kendoSwitch({
                                                        size:'{$switchSize}',
                                                        trackRounded:'{$switchTrackRounded}',
                                                        thumbRounded:'{$switchThumbRounded}',
                                                        messages: {
                                                            checked: '{$switchMessagesChecked}',
                                                            unchecked: '{$switchMessagesUnchecked}'
                                                        },";
                                                    if($switchChecked)$js .= "checked: true,";
                                                    if($inputReadOnly)$js .= "readonly: true,";
                                                    if($inputDisable)$js .= "enable: false,";
                                                    $js .= "}).data('kendoSwitch');";
                                                }
                                                else if($inputType == "kendoUpload")
                                                {
                                                    $uploadMultiple = $params["uploadMultiple"] ?? false;
                                                    $uploadMaxFileSize = $params["uploadMaxFileSize"] ?? 2097152;//2MB
                                                    $uploadFileTypes = $params["uploadFileTypes"] ?? [];

                                                    $uploadOnSelectFunction = $params["uploadOnSelectFunction"] ?? false;
                                                    $uploadOnUploadFunction = $params["uploadOnUploadFunction"] ?? false;
                                                    $uploadOnProgressFunction = $params["uploadOnProgressFunction"] ?? false;
                                                    $uploadOnCancelFunction = $params["uploadOnCancelFunction"] ?? false;
                                                    $uploadOnRemoveFunction = $params["uploadOnRemoveFunction"] ?? false;
                                                    $uploadOnSuccessFunction = $params["uploadOnSuccessFunction"] ?? false;
                                                        $uploadOnSuccessUploadFunction = $params["uploadOnSuccessUploadFunction"] ?? false;
                                                        $uploadOnSuccessRemoveFunction = $params["uploadOnSuccessRemoveFunction"] ?? false;
                                                    $uploadOnCompleteFunction = $params["uploadOnCompleteFunction"] ?? false;
                                                    $uploadOnErrorFunction = $params["uploadOnErrorFunction"] ?? false;
                                                        $uploadOnErrorUploadFunction = $params["uploadOnErrorUploadFunction"] ?? false;
                                                        $uploadOnErrorRemoveFunction = $params["uploadOnErrorRemoveFunction"] ?? false;

                                                    $html .= "<input
                                                                id='{$inputElementId}'
                                                                name='{$this->page}/{$this->group}/{$this->id}/{$inputElementName}'
                                                                type='file'
                                                                form='{$this->elementId}'";
                                                        if($inputClass) $html .= " class='{$inputClass}'";
                                                        if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                        $html .= " onkeydown='if(event.keyCode == 13){
                                                            setTimeout(function() {
                                                                {$this->submitFunctionName}";
                                                                if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                $html .= "();";
                                                                if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                            $html .= "}, {$this->submitDelayTimeOut});
                                                        };'";
                                                        if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                    $html .= ">
                                                            <input id='{$inputElementId}File' name='{$inputElementName}' type='hidden' form='{$this->elementId}'/>
                                                            <input id='{$inputElementId}FileDirectory' name='{$inputElementName}FileDirectory' type='hidden' form='{$this->elementId}'/>
                                                            <input id='{$inputElementId}FileOriginalName' name='{$inputElementName}FileOriginalName' type='hidden' form='{$this->elementId}'/>
                                                            <input id='{$inputElementId}FileUniqueName' name='{$inputElementName}FileUniqueName' type='hidden' form='{$this->elementId}'/>
                                                            <input id='{$inputElementId}FileSize' name='{$inputElementName}FileSize' type='hidden' form='{$this->elementId}'/>
                                                            <input id='{$inputElementId}FileType' name='{$inputElementName}FileType' type='hidden' form='{$this->elementId}'/>
                                                            <input id='{$inputElementId}FileExtension' name='{$inputElementName}FileExtension' type='hidden' form='{$this->elementId}'/>
                                                        ";

                                                    $js .= "let {$inputElementId}Validation = {};
                                                        {$inputElementId}Validation.maxFileSize = {$uploadMaxFileSize};";
                                                    if(count($uploadFileTypes))
                                                    {
                                                        $js .= "{$inputElementId}Validation.allowedExtensions = ['";
                                                        $js .= implode("','",$uploadFileTypes);
                                                        $js .= "'];";
                                                    }
                                                    $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').{$inputType}({
                                                            async: {
                                                                saveUrl: '".TDE_ROOT_FOR_JS."/Chronos/ajax/kendoUploadSave.php',
                                                                removeUrl: '".TDE_ROOT_FOR_JS."/Chronos/ajax/kendoUploadRemove.php',
                                                                autoUpload: true,
                                                                batch: true
                                                            },
                                                            validation: {$inputElementId}Validation,";
                                                            if($uploadMultiple)$js .= "multiple:true,";
                                                            else $js .= "multiple:false,";

                                                            //event documentation : https://docs.telerik.com/kendo-ui/api/javascript/ui/upload#events

                                                            $js .="select: function(e){
                                                                    if($uploadOnSelectFunction)$js .= "{$uploadOnSelectFunction}(e);";
                                                            $js .="},
                                                                upload: function(e){
                                                                    if($uploadOnUploadFunction)$js .= "{$uploadOnUploadFunction}(e);";
                                                            $js .="},
                                                                progress: function(e){
                                                                    if($uploadOnProgressFunction)$js .= "{$uploadOnProgressFunction}(e);";
                                                            $js .="},
                                                                cancel: function(e){
                                                                    if($uploadOnCancelFunction)$js .= "{$uploadOnCancelFunction}(e);";
                                                            $js .="},
                                                                remove: function(e){
                                                                    if($uploadOnRemoveFunction)$js .= "{$uploadOnRemoveFunction}(e);";
                                                            $js .="},
                                                                success: function(e){
                                                                    if($uploadOnSuccessFunction)$js .= "{$uploadOnSuccessFunction}(e);";
                                                                    $js .="if(e.operation == 'upload'){
                                                                        $('#{$inputElementId}File').val(1);
                                                                        $('#{$inputElementId}FileDirectory').val(e.response.fileDirectory);
                                                                        $('#{$inputElementId}FileOriginalName').val(e.response.fileOriginalName);
                                                                        $('#{$inputElementId}FileUniqueName').val(e.response.fileUniqueName);
                                                                        $('#{$inputElementId}FileSize').val(e.response.fileSize);
                                                                        $('#{$inputElementId}FileType').val(e.response.fileType);
                                                                        $('#{$inputElementId}FileExtension').val(e.files[0].extension);";
                                                                        if($uploadOnSuccessUploadFunction)$js .= "{$uploadOnSuccessUploadFunction}(e);";
                                                                    $js .="}
                                                                    if(e.operation == 'remove'){
                                                                        $('#{$inputElementId}File').val(0);
                                                                        $('#{$inputElementId}FileDirectory').val('');
                                                                        $('#{$inputElementId}FileOriginalName').val('');
                                                                        $('#{$inputElementId}FileUniqueName').val('');
                                                                        $('#{$inputElementId}FileSize').val(0);
                                                                        $('#{$inputElementId}FileType').val('');
                                                                        $('#{$inputElementId}FileExtension').val('');";
                                                                        if($uploadOnSuccessRemoveFunction)$js .= "{$uploadOnSuccessRemoveFunction}(e);";
                                                                    $js .="}
                                                                },
                                                                complete: function(e){
                                                                    if($uploadOnCompleteFunction)$js .= "{$uploadOnCompleteFunction}(e);";
                                                            $js .="},
                                                                error: function(e){
                                                                    if($uploadOnErrorFunction)$js .= "{$uploadOnErrorFunction}(e);";
                                                                    $js .="if(e.operation == 'upload'){
                                                                        ";
                                                                        if($uploadOnErrorUploadFunction)$js .= "{$uploadOnErrorUploadFunction}(e);";
                                                                    $js .="}
                                                                    if(e.operation == 'remove'){
                                                                        ";
                                                                        if($uploadOnErrorRemoveFunction)$js .= "{$uploadOnErrorRemoveFunction}(e);";
                                                                    $js .="}
                                                                },
                                                        }).data('{$inputType}');";

                                                        $js .= "TDE.{$inputElementId}.reset = function(){
                                                            TDE.{$inputElementId}.value('');
                                                            $('#{$inputElementId}File').val(0);
                                                            $('#{$inputElementId}FileDirectory').val('');
                                                            $('#{$inputElementId}FileOriginalName').val('');
                                                            $('#{$inputElementId}FileUniqueName').val('');
                                                            $('#{$inputElementId}FileSize').val(0);
                                                            $('#{$inputElementId}FileType').val('');
                                                            $('#{$inputElementId}FileExtension').val('');
                                                        };";
                                                }
                                                else*/if(in_array($inputType,["kendoComboBox","kendoMultiSelect","kendoDropDownList","kendoDropDownTree"]))
                                                {
                                                    $elementType = "select";
                                                    $dataSourceType = "DataSource";

                                                    if($inputType == "kendoDropDownTree")
                                                    {
                                                        $elementType = "input";
                                                        $dataSourceType = "HierarchicalDataSource";
                                                    }

                                                    $selectTextField = $params["selectTextField"] ?? "Text";
                                                    $selectValueField = $params["selectValueField"] ?? "Value";
                                                    $selectListHeight = $params["selectListHeight"] ?? 350;

                                                    $selectTypeDetail = $params["selectTypeDetail"] ?? "";
                                                    $selectFiltering = $params["selectFiltering"] ?? false;
                                                    $selectSelect = $params["selectSelect"] ?? false;

                                                    if($selectTypeDetail == "monthYearPicker")
                                                    {
                                                        $inputElementIds = [];
                                                        $selectTemplates =  $params["selectTemplates"] ?? ["month","year"];
                                                        $selectYearMin = $params["selectYearMin"] ?? 2015;
                                                        $selectYearMax = $params["selectYearMax"] ?? date("Y");

                                                        $yearValue = date("Y");
                                                        $monthValue = date("m");
                                                        if(in_array($inputValue, ["today", "this month"]))
                                                        {
                                                            $yearValue = date("Y");
                                                            $monthValue = date("m");
                                                        }
                                                        if($inputValue == "this year")
                                                        {
                                                            $yearValue = date("Y");
                                                            $monthValue = 1;
                                                        }
                                                        if($inputValue == "end year")
                                                        {
                                                            $yearValue = date("Y");
                                                            $monthValue = 12;
                                                        }
                                                        if($inputValue == "all year")
                                                        {
                                                            $yearValue = "*";
                                                            $monthValue = "*";
                                                        }

                                                        foreach($selectTemplates AS $index => $template)
                                                        {
                                                            if($index) $html.= " ";//for spacer

                                                            if($template == "year")
                                                            {
                                                                $inputElementId = $this->generateInputId($inputId."Year", $groupName, $inputArray);
                                                                $inputElementIds[] = $inputElementId;
                                                                $inputElementName = $this->generateInputName($inputName."Year", $groupName, $inputArray);

                                                                $html .= "<{$elementType}
                                                                            id='{$inputElementId}'
                                                                            name='{$inputElementName}'
                                                                            style='{$inputStyle};width:7.3rem'";
                                                                            if($inputClass) $html .= " class='{$inputClass}'";
                                                                            if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                                    $html .= " onkeydown='if(event.keyCode == 13){
                                                                        setTimeout(function() {
                                                                            {$this->submitFunctionName}";
                                                                            if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                            $html .= "();";
                                                                            if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                                        $html .= "}, {$this->submitDelayTimeOut});
                                                                    };'";
                                                                    if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                                $html .= ">";
                                                                    if($inputValue == "all year")
                                                                    {
                                                                        $html .= "<option value='*' SELECTED>ALL</option>";
                                                                    }
                                                                    for($year = $selectYearMax ; $year > $selectYearMin ; $year--)
                                                                    {
                                                                        $html .= "<option value='{$year}'";
                                                                        if($year == $yearValue)$html .= " SELECTED";
                                                                        $html .= ">{$year}</option>";
                                                                    }
                                                                $html .= "</{$elementType}>";

                                                                $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').{$inputType}({
                                                                    dataTextField:'{$selectTextField}'
                                                                    ,dataValueField:'{$selectValueField}'
                                                                    ,height:{$selectListHeight}";
                                                                    if(in_array($inputType,["kendoComboBox","kendoMultiSelect"]))$js .= ",placeholder: '{$inputPlaceHolder}'";
                                                                    if($inputDisable)$js .= ",enable:false";
                                                                $js .= "}).data('{$inputType}');";

                                                                $js .= "TDE.{$inputElementId}.populate = function(datas){
                                                                    TDE.{$inputElementId}.reset();
                                                                    TDE.{$inputElementId}.setDataSource(new kendo.data.{$dataSourceType}({data:datas}));
                                                                };";

                                                                if($inputReadOnly)$js .= "TDE.{$inputElementId}.readonly();";

                                                                $js .= "TDE.{$inputElementId}.reset = function(datas){
                                                                    TDE.{$inputElementId}.setDataSource(new kendo.data.{$dataSourceType}({data:[]}));
                                                                    TDE.{$inputElementId}.value('');
                                                                    //TDE.{$inputElementId}.select(-1);
                                                                };";
                                                            }
                                                            if($template == "month")
                                                            {
                                                                $monthOptions = array(
                                                                    ["Text" => "January", "Value" => 1]
                                                                    ,["Text" => "February", "Value" => 2]
                                                                    ,["Text" => "March", "Value" => 3]
                                                                    ,["Text" => "April", "Value" => 4]
                                                                    ,["Text" => "May", "Value" => 5]
                                                                    ,["Text" => "June", "Value" => 6]
                                                                    ,["Text" => "July", "Value" => 7]
                                                                    ,["Text" => "August", "Value" => 8]
                                                                    ,["Text" => "September", "Value" => 9]
                                                                    ,["Text" => "October", "Value" => 10]
                                                                    ,["Text" => "November", "Value" => 11]
                                                                    ,["Text" => "December", "Value" => 12]
                                                                );

                                                                $inputElementId = $this->generateInputId($inputId."Month", $groupName, $inputArray);
                                                                $inputElementIds[] = $inputElementId;
                                                                $inputElementName = $this->generateInputName($inputName."Month", $groupName, $inputArray);

                                                                $html .= "<{$elementType}
                                                                            id='{$inputElementId}'
                                                                            name='{$inputElementName}'
                                                                            style='{$inputStyle};width:11rem'";
                                                                            if($inputClass) $html .= " class='{$inputClass}'";
                                                                            if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                                    $html .= " onkeydown='if(event.keyCode == 13){
                                                                        setTimeout(function() {
                                                                            {$this->submitFunctionName}";
                                                                            if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                            $html .= "();";
                                                                            if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                                        $html .= "}, {$this->submitDelayTimeOut});
                                                                    };'";
                                                                    if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                                $html .= ">";
                                                                    foreach($monthOptions AS $index => $monthOption)
                                                                    {
                                                                        $html .= "<option value='{$monthOption["Value"]}'";
                                                                        if($monthOption["Value"] == $monthValue)$html .= " SELECTED";
                                                                        $html .= ">{$monthOption["Text"]}</option>";
                                                                    }
                                                                $html .= "</{$elementType}>";

                                                                $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').{$inputType}({
                                                                    dataTextField:'{$selectTextField}'
                                                                    ,dataValueField:'{$selectValueField}'
                                                                    ,height:{$selectListHeight}";
                                                                    if(in_array($inputType,["kendoComboBox","kendoMultiSelect"]))$js .= ",placeholder: '{$inputPlaceHolder}'";
                                                                    if($inputDisable)$js .= ",enable:false";
                                                                $js .= "}).data('{$inputType}');";

                                                                $js .= "TDE.{$inputElementId}.populate = function(datas){
                                                                    TDE.{$inputElementId}.reset();
                                                                    TDE.{$inputElementId}.setDataSource(new kendo.data.{$dataSourceType}({data:datas}));
                                                                };";

                                                                if($inputReadOnly)$js .= "TDE.{$inputElementId}.readonly();";

                                                                $js .= "TDE.{$inputElementId}.reset = function(datas){
                                                                    TDE.{$inputElementId}.setDataSource(new kendo.data.{$dataSourceType}({data:[]}));
                                                                    TDE.{$inputElementId}.value('');
                                                                    //TDE.{$inputElementId}.select(-1);
                                                                };";
                                                            }
                                                        }
                                                    }

                                                    else if($selectTypeDetail == "cbpPicker")
                                                    {
                                                        $inputElementIds = [];
                                                        $selectFilter = $params["selectFilter"] ?? "contains";
                                                        $selectTemplates =  $params["selectTemplates"] ?? ["brand","company","branch","pos"];
                                                        $selectCBPIsAddAll = $params["selectCBPIsAddAll"] ?? false;
                                                        $selectCBPCabangPOSes = $params["selectCBPCabangPOSes"] ?? [1,2,3];
                                                        $selectCBPIsWS = $params["selectCBPIsWS"] ?? false;
                                                        $selectCBPIsSH = $params["selectCBPIsSH"] ?? false;
                                                        $selectCBPFilters = $params["selectCBPFilters"] ?? [];
                                                        $hiddenInputTemplate = "";
                                                        $cbpPickerIsHO = $params["cbpPickerIsHO"] ?? false;//MUNCUL DI PICKER Brand

                                                        /* SHOW ALL OPTION */
                                                            $selectCBPIsAddAllBrand = false;
                                                            $selectCBPIsAddAllCompany = false;
                                                            $selectCBPIsAddAllBranch = false;
                                                            $selectCBPIsAddAllPOS = false;

                                                            if(is_bool($selectCBPIsAddAll))
                                                            {
                                                                $selectCBPIsAddAllBrand = $selectCBPIsAddAll;
                                                                $selectCBPIsAddAllCompany = $selectCBPIsAddAll;
                                                                $selectCBPIsAddAllBranch = $selectCBPIsAddAll;
                                                                $selectCBPIsAddAllPOS = $selectCBPIsAddAll;
                                                            }
                                                            else if(is_array($selectCBPIsAddAll))
                                                            {
                                                                if(in_array("brand",$selectCBPIsAddAll))$selectCBPIsAddAllBrand = true;
                                                                if(in_array("company",$selectCBPIsAddAll))$selectCBPIsAddAllCompany = true;
                                                                if(in_array("branch",$selectCBPIsAddAll))$selectCBPIsAddAllBranch = true;
                                                                if(in_array("pos",$selectCBPIsAddAll))$selectCBPIsAddAllPOS = true;
                                                            }
                                                        /* SHOW ALL OPTION */

                                                        /* ID FILTERS */
                                                            $filterBrandIds = $selectCBPFilters["brandIds"] ?? [];
                                                            $filterCompanyIds = $selectCBPFilters["companyIds"] ?? [];
                                                            $filterBranchIds = $selectCBPFilters["branchIds"] ?? [];
                                                            $filterPOSIds = $selectCBPFilters["posIds"] ?? [];

                                                            $qParams = [];
                                                            if(count($filterBrandIds))$qParams[] = "@BrandIds = '".implode(";",$filterBrandIds)."'";
                                                            if(count($filterCompanyIds))$qParams[] = "@CompanyIds = '".implode(";",$filterCompanyIds)."'";
                                                            if(count($filterBranchIds))$qParams[] = "@BranchIds = '".implode(";",$filterBranchIds)."'";
                                                            if(count($filterPOSIds))$qParams[]  = "@POSIds = '".implode(";",$filterPOSIds)."'";
                                                            if(count($selectCBPCabangPOSes))$qParams[] = "@CabangPOSes = '".implode(";",$selectCBPCabangPOSes)."'";
                                                            if($selectCBPIsWS)$qParams[]  = "@IsWS = 1";
                                                            if($selectCBPIsSH)$qParams[]  = "@IsSH = 1";
                                                            $qParam = count($qParams) ? " ".implode(",", $qParams) : "";
                                                        /* ID FILTERS */

                                                        /* ON CHANGE TRIGGER */
                                                            $onChangeArrayFunctions = [];
                                                            $onChangeArrayFunctions["Brand"] = "";
                                                            $onChangeArrayFunctions["Company"] = "";
                                                            $onChangeArrayFunctions["Branch"] = "";
                                                            $onChangeArrayFunctions["POS"] = "";
                                                            if(isset($params["inputOnChangeArray"]))
                                                            {
                                                                $inputOnChangeArray = $params["inputOnChangeArray"];
                                                                if(is_bool($inputOnChangeArray) && $inputOnChangeArray)
                                                                {
                                                                    $onChangeFunctionName = "{$inputId}CBPChange";
                                                                    $onChangeArrayFunctions["Brand"] = $onChangeFunctionName;
                                                                    $onChangeArrayFunctions["Company"] = $onChangeFunctionName;
                                                                    $onChangeArrayFunctions["Branch"] = $onChangeFunctionName;
                                                                    $onChangeArrayFunctions["POS"] = $onChangeFunctionName;
                                                                }
                                                                else if(is_string($inputOnChangeArray))
                                                                {
                                                                    $onChangeArrayFunctions["Brand"] = $inputOnChangeArray;
                                                                    $onChangeArrayFunctions["Company"] = $inputOnChangeArray;
                                                                    $onChangeArrayFunctions["Branch"] = $inputOnChangeArray;
                                                                    $onChangeArrayFunctions["POS"] = $inputOnChangeArray;
                                                                }
                                                                else if(is_array($inputOnChangeArray))
                                                                {
                                                                    $onChangeArrayFunctions["Brand"]  = "";
                                                                    $onChangeArrayFunctions["Company"]  = "";
                                                                    $onChangeArrayFunctions["Branch"]  = "";
                                                                    $onChangeArrayFunctions["POS"]  = "";
                                                                    if(isset($inputOnChangeArray["brand"]))
                                                                    {
                                                                        if($inputOnChangeArray["brand"])
                                                                        {
                                                                            if(is_bool($inputOnChangeArray["brand"]))
                                                                            {
                                                                                $onChangeArrayFunctions["Brand"] = $this->generateInputId($inputId."BrandId", $groupName, $inputArray)."Change";
                                                                            }
                                                                            else
                                                                            {
                                                                                $onChangeArrayFunctions["Brand"] = $inputOnChangeArray["brand"];
                                                                            }
                                                                        }
                                                                    }
                                                                    if(isset($inputOnChangeArray["company"]))
                                                                    {
                                                                        if($inputOnChangeArray["company"])
                                                                        {
                                                                            if(is_bool($inputOnChangeArray["company"]))
                                                                            {
                                                                                $onChangeArrayFunctions["Company"] = $this->generateInputId($inputId."CompanyId", $groupName, $inputArray)."Change";
                                                                            }
                                                                            else
                                                                            {
                                                                                $onChangeArrayFunctions["Company"] = $inputOnChangeArray["company"];
                                                                            }
                                                                        }
                                                                    }
                                                                    if(isset($inputOnChangeArray["branch"]))
                                                                    {
                                                                        if($inputOnChangeArray["branch"])
                                                                        {
                                                                            if(is_bool($inputOnChangeArray["branch"]))
                                                                            {
                                                                                $onChangeArrayFunctions["Branch"] = $this->generateInputId($inputId."BranchId", $groupName, $inputArray)."Change";
                                                                            }
                                                                            else
                                                                            {
                                                                                $onChangeArrayFunctions["Branch"] = $inputOnChangeArray["branch"];
                                                                            }
                                                                        }
                                                                    }
                                                                    if(isset($inputOnChangeArray["pos"]))
                                                                    {
                                                                        if($inputOnChangeArray["pos"])
                                                                        {
                                                                            if(is_bool($inputOnChangeArray["pos"]))
                                                                            {
                                                                                $onChangeArrayFunctions["POS"] = $this->generateInputId($inputId."PosId", $groupName, $inputArray)."Change";
                                                                            }
                                                                            else
                                                                            {
                                                                                $onChangeArrayFunctions["POS"] = $inputOnChangeArray["pos"];
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        /* ON CHANGE TRIGGER */

                                                        $SP = new \app\core\StoredProcedure('uranus');
                                                        $isBrand = 0;
                                                        $isCompany = 0;
                                                        $isBranch = 0;
                                                        $isPOS = 0;
                                                        $loopCounter = 1;

                                                        $firstTemplate = "";

                                                        foreach($selectTemplates AS $index => $selectTemplate)
                                                        {
                                                            if(!$firstTemplate) $firstTemplate = $selectTemplate;
                                                            $selectTemplate = ucfirst(strtolower($selectTemplate));
                                                            //$selectId = $inputId.$selectTemplate;
                                                            $inputElementId = $this->generateInputId($inputId.$selectTemplate."Id", $groupName, $inputArray);
                                                            $inputElementIds[] = $inputElementId;
                                                            $inputElementName = $this->generateInputName($inputName.$selectTemplate."Id", $groupName, $inputArray);

                                                            if($selectTemplate == "Brand")
                                                            {
                                                                $isBrand = $loopCounter;

                                                                $hiddenInputTemplate .= "b";

                                                                $inputStyle .= ";width:11rem";

                                                                $ListOfDatas = [];
                                                                if($cbpPickerIsHO)$ListOfDatas[] = ["Id" => 99, "CompanyId" => 0, "Name" => "HEAD OFFICE"];
                                                                //dd($ListOfDatas);

                                                                $q = "EXEC [SP_Sys_Form_GetDBrand]{$qParam}";
                                                                $SP->SPPrepare($q);
                                                                $SP->addSanitation("Id",["int"]);
                                                                $SP->addSanitation("Name",["string"]);
                                                                $SP->addSanitation("CompanyId",["int"]);
                                                                $SP->execute();
                                                                //dd($SP->getRow());
                                                                $ListOfDatas = array_merge($ListOfDatas,$SP->getRow());

                                                                $columnKeys = [];
                                                                if($isCompany)$columnKeys[] = "CompanyId";//COMPANY DULUAN

                                                                $valueColumnNames = [];
                                                                if($isCompany && $isCompany < $isBrand)$valueColumnNames[] = "CompanyId";
                                                                $valueColumnNames[] = "Id";

                                                                $showOptionAll = $selectCBPIsAddAllBrand;
                                                            }
                                                            if($selectTemplate == "Company")
                                                            {
                                                                $isCompany = $loopCounter;

                                                                $hiddenInputTemplate .= "c";

                                                                $inputStyle .= ";max-width:18.2rem";

                                                                $q = "EXEC [SP_Sys_Form_GetDCompany]{$qParam}";
                                                                $SP->SPPrepare($q);
                                                                $SP->addSanitation("Id",["int"]);
                                                                $SP->addSanitation("BrandId",["int"]);
                                                                $SP->addSanitation("Alias",["string"]);
                                                                $SP->addSanitation("Name",["string"]);
                                                                $SP->execute();
                                                                $ListOfDatas = $SP->getRow();

                                                                $columnKeys = [];
                                                                if($isBrand)$columnKeys[] = "BrandId";//BRAND DULUAN

                                                                $valueColumnNames = [];
                                                                if($isBrand && $isBrand < $isCompany)$valueColumnNames[] = "BrandId";
                                                                $valueColumnNames[] = "Id";

                                                                $showOptionAll = $selectCBPIsAddAllCompany;
                                                            }
                                                            if($selectTemplate == "Branch")
                                                            {
                                                                $isBranch = $loopCounter;

                                                                $inputStyle .= ";max-width:18.2rem";

                                                                $q = "EXEC [SP_Sys_Form_GetDBranch]{$qParam}";
                                                                $SP->SPPrepare($q);
                                                                $SP->addSanitation("Id",["int"]);
                                                                $SP->addSanitation("CompanyId",["int"]);
                                                                $SP->addSanitation("BrandId",["int"]);
                                                                $SP->addSanitation("Alias",["string"]);
                                                                $SP->addSanitation("Name",["string"]);
                                                                $SP->execute();
                                                                $ListOfDatas = $SP->getRow();

                                                                $columnKeys = [];
                                                                if($isBrand && $isCompany)
                                                                {
                                                                    if($isBrand < $isCompany)
                                                                    {
                                                                        $columnKeys[] = "BrandId";
                                                                        $columnKeys[] = "CompanyId";
                                                                    }
                                                                    else
                                                                    {
                                                                        $columnKeys[] = "CompanyId";
                                                                        $columnKeys[] = "BrandId";
                                                                    }
                                                                }
                                                                else if($isBrand)$columnKeys[] = "BrandId";
                                                                else if($isCompany)$columnKeys[] = "CompanyId";

                                                                $valueColumnNames = [];
                                                                $valueColumnNames[] = "Id";

                                                                $showOptionAll = $selectCBPIsAddAllBranch;
                                                            }
                                                            if($selectTemplate == "Pos")
                                                            {
                                                                $selectTemplate = "POS";
                                                                $isPOS = $loopCounter;

                                                                $inputStyle .= ";max-width:25rem";

                                                                $q = "EXEC [SP_Sys_Form_GetDPOS]{$qParam}";
                                                                /*
                                                                $qParams = [];
                                                                if(count($qParams))$q .= implode(",",$qParams);
                                                                */
                                                                $SP->SPPrepare($q);
                                                                $SP->addSanitation("Id",["int"]);
                                                                $SP->addSanitation("CompanyId",["int"]);
                                                                $SP->addSanitation("BrandId",["int"]);
                                                                $SP->addSanitation("BranchId",["int"]);
                                                                $SP->addSanitation("Alias",["string"]);
                                                                $SP->addSanitation("Name",["string"]);
                                                                $SP->addSanitation("CabangPOS",["int"]);
                                                                $SP->execute();
                                                                $ListOfDatas = $SP->getRow();

                                                                $columnKeys = [];
                                                                if($isBranch)$columnKeys[] = "BranchId";
                                                                else if($isBrand && $isCompany)
                                                                {
                                                                    if($isBrand < $isCompany)
                                                                    {
                                                                        $columnKeys[] = "BrandId";
                                                                        $columnKeys[] = "CompanyId";
                                                                    }
                                                                    else
                                                                    {
                                                                        $columnKeys[] = "CompanyId";
                                                                        $columnKeys[] = "BrandId";
                                                                    }
                                                                }
                                                                else if($isBrand)$columnKeys[] = "BrandId";
                                                                else if($isCompany)$columnKeys[] = "CompanyId";

                                                                $valueColumnNames = [];
                                                                $valueColumnNames[] = "Id";

                                                                $showOptionAll = $selectCBPIsAddAllPOS;
                                                            }

                                                            if(count($columnKeys))//ADA SELECT BOX SEBELUMNYA, BUAT OBJECT OPSI SELECT BERDASARKAN KEY SEBELUMNYA
                                                            {
                                                                //if($selectTemplate == "Branch")dd($ListOfDatas);
                                                                $Helper = new \app\TDEs\DataTableHelper();
                                                                $Helper->addDatas("data", $ListOfDatas);
                                                                $Helper->generateKeyData("data", $columnKeys);
                                                                $ListOfDatas = $Helper->getSavedData("dataWithKey", false);
                                                                //if($selectTemplate == "Branch")dd($ListOfDatas);
                                                                foreach($ListOfDatas AS $key => $datas)
                                                                {
                                                                    $ListOfDatas[$key] = [];
                                                                    $Helper = new \app\TDEs\KendoComboBoxHelper();
                                                                    $Helper->addDatas($selectTemplate, $datas);
                                                                    $Helper->convertData($selectTemplate, [$valueColumnNames,"Name"], $showOptionAll);
                                                                    $ListOfDatas[$key] = $Helper->getSavedData($selectTemplate);
                                                                }
                                                                //if($selectTemplate == "Branch")dd($selectTemplate,$datas,$valueColumnNames,$showOptionAll);
                                                                //if($selectTemplate == "Branch")dd($ListOfDatas);
                                                            }
                                                            else //1st SELECT, TIDAK PERLU BUAT OBJECT OPSI DGN KEY
                                                            {
                                                                $Helper = new \app\TDEs\KendoComboBoxHelper();
                                                                $Helper->addDatas($selectTemplate, $ListOfDatas);
                                                                $Helper->convertData($selectTemplate, [$valueColumnNames,"Name"], $showOptionAll);
                                                                $ListOfDatas = $Helper->getSavedData($selectTemplate);

                                                                //if($selectTemplate == "Brand")dd($valueColumnNames);
                                                                //if($selectTemplate == "Brand")dd($ListOfDatas);
                                                            }

                                                            if($index)$html .= " ";//spacer
                                                            $html .= "<{$elementType}
                                                                id='{$inputElementId}'
                                                                name='{$inputElementName}'
                                                                style='{$inputStyle}'";
                                                                if($inputClass) $html .= " class='{$inputClass}'";
                                                                if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                                $html .= " onkeydown='if(event.keyCode == 13){
                                                                    setTimeout(function() {
                                                                        {$this->submitFunctionName}";
                                                                        if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                        $html .= "();";
                                                                        if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                                    $html .= "}, {$this->submitDelayTimeOut});
                                                                };'";
                                                                if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                            $html .= "></{$elementType}>";

                                                            $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').{$inputType}({
                                                                dataTextField:'{$selectTextField}'
                                                                ,dataValueField:'{$selectValueField}'
                                                                ,height:{$selectListHeight}
                                                                ,filter:'{$selectFilter}'
                                                                ,value:'{$inputValue}'";
                                                                if(in_array($inputType,["kendoComboBox","kendoMultiSelect"]))$js .= ",placeholder: '{$inputPlaceHolder}'";
                                                                if($inputDisable)$js .= ",enable:false";
                                                                if(in_array($inputType,["kendoComboBox"]))
                                                                {
                                                                    $inputSuggest = $params["inputSuggest"] ?? true;
                                                                    if($inputSuggest)$js .= ",suggest:true,";
                                                                }
                                                            $js .= "}).data('{$inputType}');";

                                                            if($inputReadOnly)$js .= "TDE.{$inputElementId}.readonly();";

                                                            $js .= "TDE.{$inputElementId}.reset = function(datas){
                                                                TDE.{$inputElementId}.setDataSource(new kendo.data.{$dataSourceType}({data:[]}));
                                                                TDE.{$inputElementId}.value('');
                                                                TDE.{$inputElementId}.select(-1);
                                                            };";

                                                            $js .= "TDE.{$inputElementId}.populate = function(datas){
                                                                TDE.{$inputElementId}.reset();
                                                                TDE.{$inputElementId}.setDataSource(new kendo.data.{$dataSourceType}({data:datas}));
                                                            };";

                                                            $js .= "TDE.{$inputElementId}.datas = ".json_encode($ListOfDatas).";";

                                                            //1st index = Data auto populate;
                                                            if(!$index)$js .= "TDE.{$inputElementId}.populate(TDE.{$inputElementId}.datas);";

                                                            if($firstTemplate != $selectTemplate)
                                                            {
                                                                $js .="$(document).ready(function(){
                                                                            /*
                                                                            if(TDE.{$inputElementId}.datas.length == 1){
                                                                                TDE.{$inputElementId}.select(0);
                                                                                if (typeof {$inputElementId}DefaultChange === 'function') {
                                                                                    {$inputElementId}DefaultChange();
                                                                                }
                                                                            }
                                                                            else{
                                                                                TDE.{$inputElementId}.open();
                                                                            }
                                                                            */
                                                                            /*
                                                                            TDE.{$inputElementId}.select(0);
                                                                            if (typeof {$inputElementId}DefaultChange === 'function') {
                                                                                {$inputElementId}DefaultChange();
                                                                            }
                                                                            */
                                                                        });";
                                                            }

                                                            //Check if there's next step
                                                            if(isset($selectTemplates[($index + 1)]))
                                                            {
                                                                //There is
                                                                $js .= "function {$inputElementId}DefaultChange(e){";
                                                                    for($indexLoop = $index + 1 ; $indexLoop < count($selectTemplates) ; $indexLoop++)
                                                                    {
                                                                        //select setelah2nya di reset dulu
                                                                        $nextSelectId = $this->generateInputId($inputId.ucfirst($selectTemplates[$indexLoop])."Id", $groupName, $inputArray);
                                                                        $js .= "TDE.{$nextSelectId}.select(-1);TDE.{$nextSelectId}.populate([]);";
                                                                    }
                                                                    $nextSelectId = $this->generateInputId($inputId.ucfirst($selectTemplates[$index + 1])."Id", $groupName, $inputArray);

                                                                    $js .= "if(TDE.{$inputElementId}.select() != -1){
                                                                        let thisValue = TDE.{$inputElementId}.value();
                                                                        if(thisValue != '*'){
                                                                            if(thisValue in TDE.{$nextSelectId}.datas){
                                                                                TDE.{$nextSelectId}.populate(TDE.{$nextSelectId}.datas[thisValue]);
                                                                                if(TDE.{$nextSelectId}.datas[thisValue].length > 1)
                                                                                    TDE.{$nextSelectId}.open();
                                                                                else {
                                                                                    TDE.{$nextSelectId}.select(0);
                                                                                    if (typeof {$nextSelectId}DefaultChange === 'function') {
                                                                                        {$nextSelectId}DefaultChange();
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }";

                                                                    if($onChangeArrayFunctions[$selectTemplate])$js .= "{$onChangeArrayFunctions[$selectTemplate]}();";

                                                                $js .="}
                                                                TDE.{$inputElementId}.bind('change',{$inputElementId}DefaultChange);";
                                                            }
                                                            else
                                                            {
                                                                //This is the last one
                                                                if($onChangeArrayFunctions[$selectTemplate])
                                                                {
                                                                    $js .="TDE.{$inputElementId}.bind('change',{$onChangeArrayFunctions[$selectTemplate]});";
                                                                }
                                                            }

                                                            if($selectTemplate == "Pos" && $onChangeArrayFunctions["POS"])
                                                            {
                                                                $js .= "TDE.{$inputElementId}.bind('change',{$onChangeArrayFunctions["POS"]});";
                                                            }

                                                            $loopCounter++;
                                                        }

                                                        $inputElementId = $this->generateInputName($inputId."CbpTemplate", $groupName, $inputArray);
                                                        $inputElementName = $this->generateInputName($inputName."CbpTemplate", $groupName, $inputArray);
                                                        $this->html .= "<input id='{$inputElementId}' name='{$inputElementName}' type='hidden' form='{$this->elementId}' value='{$hiddenInputTemplate}'/>";

                                                        if(count($filterBrandIds))
                                                        {
                                                            $inputElementId = $this->generateInputName($inputId."CbpFilterBrandIds", $groupName, $inputArray);
                                                            $inputElementName = $this->generateInputName($inputName."CbpFilterBrandIds", $groupName, $inputArray);
                                                            foreach($filterBrandIds AS $index => $Id)
                                                            {
                                                                $this->html .= "<input id='{$inputElementId}' name='{$inputElementName}[]' type='hidden' form='{$this->elementId}' value='{$Id}'/>";
                                                            }
                                                        }
                                                        if(count($filterCompanyIds))
                                                        {
                                                            $inputElementId = $this->generateInputName($inputId."CbpFilterCompanyIds", $groupName, $inputArray);
                                                            $inputElementName = $this->generateInputName($inputName."CbpFilterCompanyIds", $groupName, $inputArray);
                                                            foreach($filterCompanyIds AS $index => $Id)
                                                            {
                                                                $this->html .= "<input id='{$inputElementId}' name='{$inputElementName}[]' type='hidden' form='{$this->elementId}' value='{$Id}'/>";
                                                            }
                                                        }
                                                        if(count($filterBranchIds))
                                                        {
                                                            $inputElementId = $this->generateInputName($inputId."CbpFilterBranchIds", $groupName, $inputArray);
                                                            $inputElementName = $this->generateInputName($inputName."CbpFilterBranchIds", $groupName, $inputArray);
                                                            foreach($filterBranchIds AS $index => $Id)
                                                            {
                                                                $this->html .= "<input id='{$inputElementId}' name='{$inputElementName}[]' type='hidden' form='{$this->elementId}' value='{$Id}'/>";
                                                            }
                                                        }
                                                        if(count($filterPOSIds))
                                                        {
                                                            $inputElementId = $this->generateInputName($inputId."CbpFilterPOSIds", $groupName, $inputArray);
                                                            $inputElementName = $this->generateInputName($inputName."CbpFilterPOSIds", $groupName, $inputArray);
                                                            foreach($filterPOSIds AS $index => $Id)
                                                            {
                                                                $this->html .= "<input id='{$inputElementId}' name='{$inputElementName}[]' type='hidden' form='{$this->elementId}' value='{$Id}'/>";
                                                            }
                                                        }
                                                    }

                                                    else if($selectTypeDetail == "ampPicker")
                                                    {
                                                        $inputElementIds = [];
                                                        $selectFilter = $params["selectFilter"] ?? "contains";
                                                        $selectTemplates =  $params["selectTemplates"] ?? ["application","module","page"];
                                                        $selectAMPIsAddAll = $params["selectAMPIsAddAll"] ?? false;
                                                        $selectAMPFilters = $params["selectAMPFilters"] ?? [];

                                                        /* SHOW ALL OPTION */
                                                            $selectAMPIsAddAllApplication = false;
                                                            $selectAMPIsAddAllModule = false;
                                                            $selectAMPIsAddAllPage = false;

                                                            if(is_bool($selectAMPIsAddAll))
                                                            {
                                                                $selectAMPIsAddAllApplication = $selectAMPIsAddAll;
                                                                $selectAMPIsAddAllModule = $selectAMPIsAddAll;
                                                                $selectAMPIsAddAllPage = $selectAMPIsAddAll;
                                                            }
                                                            else if(is_array($selectAMPIsAddAll))
                                                            {
                                                                if(in_array("application",$selectAMPIsAddAll))$selectAMPIsAddAllApplication = true;
                                                                if(in_array("module",$selectAMPIsAddAll))$selectAMPIsAddAllModule = true;
                                                                if(in_array("page",$selectAMPIsAddAll))$selectAMPIsAddAllPage = true;
                                                            }
                                                        /* SHOW ALL OPTION */

                                                        /* ID FILTERS */
                                                            $filterApplicationIds = $selectAMPFilters["applicationIds"] ?? [];
                                                            $filterModuleIds = $selectAMPFilters["moduleIds"] ?? [];
                                                            $filterPageIds = $selectAMPFilters["pageIds"] ?? [];

                                                            $qParams = [];
                                                            if(count($filterApplicationIds))$qParams[] = "@ApplicationIds = '".implode(";",$filterApplicationIds)."'";
                                                            if(count($filterModuleIds))$qParams[] = "@ModuleIds = '".implode(";",$filterModuleIds)."'";
                                                            if(count($filterPageIds))$qParams[]  = "@PageIds = '".implode(";",$filterPageIds)."'";
                                                            $qParam = count($qParams) ? " ".implode(",", $qParams) : "";
                                                        /* ID FILTERS */

                                                        /* ON CHANGE TRIGGER */
                                                            $onChangeArrayFunctions = [];
                                                            $onChangeArrayFunctions["Application"] = "";
                                                            $onChangeArrayFunctions["Module"] = "";
                                                            $onChangeArrayFunctions["Page"] = "";
                                                            if(isset($params["inputOnChangeArray"]))
                                                            {
                                                                $inputOnChangeArray = $params["inputOnChangeArray"];
                                                                if(is_string($inputOnChangeArray))
                                                                {
                                                                    $onChangeArrayFunctions["Application"] = $inputOnChangeArray;
                                                                    $onChangeArrayFunctions["Module"] = $inputOnChangeArray;
                                                                    $onChangeArrayFunctions["Page"] = $inputOnChangeArray;
                                                                }
                                                                else if(is_array($inputOnChangeArray))
                                                                {
                                                                    //$onChangeArrayFunctions["Application"] = $inputOnChangeArray["application"] ?? "";
                                                                    //$onChangeArrayFunctions["Module"]  = $inputOnChangeArray["module"] ?? "";
                                                                    //$onChangeArrayFunctions["Page"]  = $inputOnChangeArray["page"] ?? "";

                                                                    $onChangeArrayFunctions["Application"]  = "";
                                                                    $onChangeArrayFunctions["Module"]  = "";
                                                                    $onChangeArrayFunctions["Page"]  = "";
                                                                    if(isset($inputOnChangeArray["application"]))
                                                                    {
                                                                        if($inputOnChangeArray["application"])
                                                                        {
                                                                            if(is_bool($inputOnChangeArray["application"]))
                                                                            {
                                                                                $onChangeArrayFunctions["Application"] = $this->generateInputId($inputId."ApplicationId", $groupName, $inputArray)."Change";
                                                                            }
                                                                            else
                                                                            {
                                                                                $onChangeArrayFunctions["Application"] = $inputOnChangeArray["application"];
                                                                            }
                                                                        }
                                                                    }
                                                                    if(isset($inputOnChangeArray["module"]))
                                                                    {
                                                                        if($inputOnChangeArray["module"])
                                                                        {
                                                                            if(is_bool($inputOnChangeArray["module"]))
                                                                            {
                                                                                $onChangeArrayFunctions["Module"] = $this->generateInputId($inputId."ModuleId", $groupName, $inputArray)."Change";
                                                                            }
                                                                            else
                                                                            {
                                                                                $onChangeArrayFunctions["Module"] = $inputOnChangeArray["module"];
                                                                            }
                                                                        }
                                                                    }
                                                                    if(isset($inputOnChangeArray["page"]))
                                                                    {
                                                                        if($inputOnChangeArray["page"])
                                                                        {
                                                                            if(is_bool($inputOnChangeArray["page"]))
                                                                            {
                                                                                $onChangeArrayFunctions["Page"] = $this->generateInputId($inputId."PageId", $groupName, $inputArray)."Change";
                                                                            }
                                                                            else
                                                                            {
                                                                                $onChangeArrayFunctions["Page"] = $inputOnChangeArray["page"];
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        /* ON CHANGE TRIGGER */

                                                        $SP = new \app\core\StoredProcedure('uranus');
                                                        $isApplication = 0;
                                                        $isModule = 0;
                                                        $isPage = 0;
                                                        $loopCounter = 1;

                                                        $firstTemplate = "";

                                                        foreach($selectTemplates AS $index => $selectTemplate)
                                                        {
                                                            if(!$firstTemplate) $firstTemplate = $selectTemplate;
                                                            $selectTemplate = ucfirst(strtolower($selectTemplate));
                                                            //$selectId = $inputId.$selectTemplate;
                                                            $inputElementId = $this->generateInputId($inputId.$selectTemplate."Id", $groupName, $inputArray);
                                                            $inputElementIds[] = $inputElementId;
                                                            $inputElementName = $this->generateInputName($inputName.$selectTemplate."Id", $groupName, $inputArray);

                                                            if($selectTemplate == "Application")
                                                            {
                                                                $isApplication = $loopCounter;

                                                                $inputStyle .= ";width:12rem";

                                                                $q = "EXEC [SP_Sys_Form_GetDApplication]{$qParam}";
                                                                $SP->SPPrepare($q);
                                                                $SP->addSanitation("Id",["int"]);
                                                                $SP->addSanitation("Name",["string"]);
                                                                $SP->execute();
                                                                $ListOfDatas = $SP->getRow();

                                                                $columnKeys = [];

                                                                $valueColumnNames = [];
                                                                $valueColumnNames[] = "Id";

                                                                $showOptionAll = $selectAMPIsAddAllApplication;
                                                            }
                                                            if($selectTemplate == "Module")
                                                            {
                                                                $isModule = $loopCounter;

                                                                $inputStyle .= ";width:25rem";

                                                                $q = "EXEC [SP_Sys_Form_GetDModule]{$qParam}";
                                                                $SP->SPPrepare($q);
                                                                $SP->addSanitation("ApplicationId",["int"]);
                                                                $SP->addSanitation("Id",["int"]);
                                                                $SP->addSanitation("Name",["string"]);
                                                                $SP->execute();
                                                                $ListOfDatas = $SP->getRow();

                                                                $columnKeys = [];
                                                                if($isApplication)$columnKeys[] = "ApplicationId";

                                                                $valueColumnNames = [];
                                                                if($isApplication)$valueColumnNames[] = "ApplicationId";
                                                                $valueColumnNames[] = "Id";

                                                                $showOptionAll = $selectAMPIsAddAllModule;
                                                            }
                                                            if($selectTemplate == "Page")
                                                            {
                                                                $isPage = $loopCounter;

                                                                $inputStyle .= ";width:25rem";

                                                                $q = "EXEC [SP_Sys_Form_GetDPage]{$qParam}";
                                                                /*
                                                                $qParams = [];
                                                                if(count($qParams))$q .= implode(",",$qParams);
                                                                */
                                                                $SP->SPPrepare($q);
                                                                $SP->addSanitation("ApplicationId",["int"]);
                                                                $SP->addSanitation("ModuleId",["int"]);
                                                                $SP->addSanitation("Id",["int"]);
                                                                $SP->addSanitation("Name",["string"]);
                                                                $SP->execute();
                                                                $ListOfDatas = $SP->getRow();

                                                                $columnKeys = [];
                                                                if($isApplication)$columnKeys[] = "ApplicationId";
                                                                if($isModule)$columnKeys[] = "ModuleId";

                                                                $valueColumnNames = [];
                                                                if($isApplication)$valueColumnNames[] = "ApplicationId";
                                                                if($isModule)$valueColumnNames[] = "ModuleId";
                                                                $valueColumnNames[] = "Id";

                                                                $showOptionAll = $selectAMPIsAddAllPage;
                                                            }

                                                            if(count($columnKeys))//ADA SELECT BOX SEBELUMNYA, BUAT OBJECT OPSI SELECT BERDASARKAN KEY SEBELUMNYA
                                                            {
                                                                //echo $selectTemplate;
                                                                $Helper = new \app\TDEs\DataTableHelper();
                                                                $Helper->addDatas("data", $ListOfDatas);
                                                                $Helper->generateKeyData("data", $columnKeys);
                                                                $ListOfDatas = $Helper->getSavedData("dataWithKey", false);

                                                                foreach($ListOfDatas AS $key => $datas)
                                                                {
                                                                    $ListOfDatas[$key] = [];
                                                                    $Helper = new \app\TDEs\KendoComboBoxHelper();
                                                                    $Helper->addDatas($selectTemplate, $datas);
                                                                    $Helper->convertData($selectTemplate, [$valueColumnNames,"Name"], $showOptionAll);
                                                                    $ListOfDatas[$key] = $Helper->getSavedData($selectTemplate);
                                                                }
                                                                //if($selectTemplate == "Module")dd($ListOfDatas);
                                                            }
                                                            else //1st SELECT, TIDAK PERLU BUAT OBJECT OPSI DGN KEY
                                                            {
                                                                $Helper = new \app\TDEs\KendoComboBoxHelper();
                                                                $Helper->addDatas($selectTemplate, $ListOfDatas);
                                                                $Helper->convertData($selectTemplate, [$valueColumnNames,"Name"], $showOptionAll);
                                                                $ListOfDatas = $Helper->getSavedData($selectTemplate);
                                                            }

                                                            if($index)$html .= " ";//spacer
                                                            $html .= "<{$elementType}
                                                                id='{$inputElementId}'
                                                                name='{$inputElementName}'
                                                                style='{$inputStyle}'";
                                                                if($inputClass) $html .= " class='{$inputClass}'";
                                                                if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                                $html .= " onkeydown='if(event.keyCode == 13){
                                                                    setTimeout(function() {
                                                                        {$this->submitFunctionName}";
                                                                        if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                        $html .= "();";
                                                                        if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                                    $html .= "}, {$this->submitDelayTimeOut});
                                                                };'";
                                                                if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                            $html .= "></{$elementType}>";

                                                            $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').{$inputType}({
                                                                dataTextField:'{$selectTextField}'
                                                                ,dataValueField:'{$selectValueField}'
                                                                ,height:{$selectListHeight}
                                                                ,filter:'{$selectFilter}'
                                                                ,value:'{$inputValue}'";
                                                                if(in_array($inputType,["kendoComboBox","kendoMultiSelect"]))$js .= ",placeholder: '{$inputPlaceHolder}'";
                                                                if($inputDisable)$js .= ",enable:false";
                                                                if(in_array($inputType,["kendoComboBox"]))
                                                                {
                                                                    $inputSuggest = $params["inputSuggest"] ?? true;
                                                                    if($inputSuggest)$js .= ",suggest:true";
                                                                }
                                                            $js .= "}).data('{$inputType}');";

                                                            $js .= "TDE.{$inputElementId}.populate = function(datas){
                                                                TDE.{$inputElementId}.reset();
                                                                TDE.{$inputElementId}.setDataSource(new kendo.data.{$dataSourceType}({data:datas}));
                                                            };";

                                                            $js .= "TDE.{$inputElementId}.reset = function(datas){
                                                                TDE.{$inputElementId}.setDataSource(new kendo.data.{$dataSourceType}({data:[]}));
                                                                TDE.{$inputElementId}.value('');
                                                                TDE.{$inputElementId}.select(-1);
                                                            };";

                                                            if($inputReadOnly)$js .= "TDE.{$inputElementId}.readonly();";

                                                            $js .= "TDE.{$inputElementId}.datas = ".json_encode($ListOfDatas).";";

                                                            //1st index = Data auto populate;
                                                            if(!$index)$js .= "TDE.{$inputElementId}.populate(TDE.{$inputElementId}.datas);";

                                                            /*
                                                            if($firstTemplate != $selectTemplate)
                                                            {
                                                                $js .="$(document).ready(function(){
                                                                            if(TDE.{$inputElementId}.datas.length == 1){
                                                                                TDE.{$inputElementId}.select(0);
                                                                                if (typeof {$inputElementId}DefaultChange === 'function') {
                                                                                    {$inputElementId}DefaultChange();
                                                                                }
                                                                            }
                                                                            else{
                                                                                TDE.{$inputElementId}.open();
                                                                            }
                                                                            TDE.{$inputElementId}.select(0);
                                                                            if (typeof {$inputElementId}DefaultChange === 'function') {
                                                                                {$inputElementId}DefaultChange();
                                                                            }
                                                                        });";
                                                            }
                                                            */

                                                            //Check if there's next step
                                                            if(isset($selectTemplates[($index + 1)]))
                                                            {
                                                                //There is
                                                                $js .= "function {$inputElementId}DefaultChange(e){";
                                                                    for($indexLoop = $index + 1 ; $indexLoop < count($selectTemplates) ; $indexLoop++)
                                                                    {
                                                                        //select setelah2nya di reset dulu
                                                                        $nextSelectId = $this->generateInputId($inputId.ucfirst($selectTemplates[$indexLoop])."Id", $groupName, $inputArray);
                                                                        $js .= "TDE.{$nextSelectId}.select(-1);TDE.{$nextSelectId}.populate([]);";
                                                                    }
                                                                    $nextSelectId = $this->generateInputId($inputId.ucfirst($selectTemplates[$index + 1])."Id", $groupName, $inputArray);

                                                                    $js .= "if(TDE.{$inputElementId}.select() != -1){
                                                                        let thisValue = TDE.{$inputElementId}.value();
                                                                        if(thisValue != '*'){
                                                                            if(thisValue in TDE.{$nextSelectId}.datas){
                                                                                TDE.{$nextSelectId}.populate(TDE.{$nextSelectId}.datas[thisValue]);
                                                                                if(TDE.{$nextSelectId}.datas[thisValue].length > 1)
                                                                                    TDE.{$nextSelectId}.open();
                                                                                else {
                                                                                    TDE.{$nextSelectId}.select(0);
                                                                                    if (typeof {$nextSelectId}DefaultChange === 'function') {
                                                                                        {$nextSelectId}DefaultChange();
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }";

                                                                    if($onChangeArrayFunctions[$selectTemplate])$js .= "{$onChangeArrayFunctions[$selectTemplate]}();";

                                                                $js .="}
                                                                TDE.{$inputElementId}.bind('change',{$inputElementId}DefaultChange);";
                                                            }
                                                            else
                                                            {
                                                                //This is the last one
                                                                if($onChangeArrayFunctions[$selectTemplate])
                                                                {
                                                                    $js .="TDE.{$inputElementId}.bind('change',{$onChangeArrayFunctions[$selectTemplate]});";
                                                                }
                                                            }

                                                            if($selectTemplate == "Page" && $onChangeArrayFunctions["Page"])
                                                            {
                                                                $js .= "TDE.{$inputElementId}.bind('change',{$onChangeArrayFunctions["Page"]});";
                                                            }

                                                            $loopCounter++;
                                                        }

                                                        $inputElementId = $this->generateInputName($inputId."AmpTemplate", $groupName, $inputArray);
                                                        $inputElementName = $this->generateInputName($inputName."AmpTemplate", $groupName, $inputArray);

                                                        if(count($filterApplicationIds))
                                                        {
                                                            $inputElementId = $this->generateInputName($inputId."AmpFilterApplicationIds", $groupName, $inputArray);
                                                            $inputElementName = $this->generateInputName($inputName."AmpFilterApplicationIds", $groupName, $inputArray);
                                                            foreach($filterApplicationIds AS $index => $Id)
                                                            {
                                                                $this->html .= "<input id='{$inputElementId}' name='{$inputElementName}[]' type='hidden' form='{$this->elementId}' value='{$Id}'/>";
                                                            }
                                                        }
                                                        if(count($filterModuleIds))
                                                        {
                                                            $inputElementId = $this->generateInputName($inputId."AmpFilterModuleIds", $groupName, $inputArray);
                                                            $inputElementName = $this->generateInputName($inputName."AmpFilterModuleIds", $groupName, $inputArray);
                                                            foreach($filterModuleIds AS $index => $Id)
                                                            {
                                                                $this->html .= "<input id='{$inputElementId}' name='{$inputElementName}[]' type='hidden' form='{$this->elementId}' value='{$Id}'/>";
                                                            }
                                                        }
                                                        if(count($filterPageIds))
                                                        {
                                                            $inputElementId = $this->generateInputName($inputId."AmpFilterPageIds", $groupName, $inputArray);
                                                            $inputElementName = $this->generateInputName($inputName."AmpFilterPageIds", $groupName, $inputArray);
                                                            foreach($filterPageIds AS $index => $Id)
                                                            {
                                                                $this->html .= "<input id='{$inputElementId}' name='{$inputElementName}[]' type='hidden' form='{$this->elementId}' value='{$Id}'/>";
                                                            }
                                                        }
                                                    }

                                                    else
                                                    {
                                                        if($inputType == "kendoMultiSelect")$inputElementName .= "[]";
                                                        $selectFilter = $params["selectFilter"] ?? "contains";
                                                        $selectOptions = $params["selectOptions"] ?? [];
                                                        $selectHeaderTemplate = $params["selectHeaderTemplate"] ?? "";
                                                        $selectFooterTemplate= $params["selectFooterTemplate"] ?? "";
                                                        $selectTemplate = $params["selectTemplate"] ?? "";

                                                        $html .= "<{$elementType}
                                                                id='{$inputElementId}'
                                                                name='{$inputElementName}'
                                                                style='{$inputStyle}'";
                                                                if($inputClass) $html .= " class='{$inputClass}'";
                                                                if(count($inputDataCustom)) $html .= " data-tde-{$inputDataCustom[0]}='{$inputDataCustom[1]}'";
                                                                $html .= " onkeydown='if(event.keyCode == 13){
                                                                    setTimeout(function() {
                                                                        {$this->submitFunctionName}";
                                                                        if($this->confirmationMessageIsShow)$html .= "ConfirmationMessage";
                                                                        $html .= "();";
                                                                        if($onKeyDownFunction)$html .= "{$onKeyDownFunction}();";
                                                                    $html .= "}, {$this->submitDelayTimeOut});
                                                                };'";
                                                            if($onPasteFunction)$html .= " onpaste='{$onPasteFunction}();'";
                                                        $html .= ">";
                                                        $html .= "</{$elementType}>";

                                                        $js .= "TDE.{$inputElementId} = $('#{$inputElementId}').{$inputType}({
                                                            dataTextField:'{$selectTextField}'
                                                            ,dataValueField:'{$selectValueField}'
                                                            ,height:{$selectListHeight}
                                                            ,value:'{$inputValue}'";
                                                            if(in_array($inputType,["kendoComboBox","kendoMultiSelect"]))$js .= ",placeholder: '{$inputPlaceHolder}'";
                                                            if($selectFilter)$js .= ",filter:'{$selectFilter}'";
                                                            if($selectHeaderTemplate)$js .= ",headerTemplate: '{$selectHeaderTemplate}'";
                                                            if($selectFooterTemplate)$js .= ",footerTemplate: '{$selectFooterTemplate}'";
                                                            if($selectTemplate)$js .= ",template: '{$selectTemplate}'";
                                                            if(in_array($inputType,["kendoComboBox"]))
                                                            {
                                                                $inputSuggest = $params["inputSuggest"] ?? true;
                                                                if($inputSuggest)$js .= ",suggest:true";
                                                            }
                                                        $js .= "}).data('{$inputType}');";

                                                        if($inputReadOnly)$js .= "TDE.{$inputElementId}.readonly();";

                                                        $js .= "TDE.{$inputElementId}.reset = function(datas){
                                                            TDE.{$inputElementId}.setDataSource(new kendo.data.{$dataSourceType}({data:[]}));
                                                            TDE.{$inputElementId}.value('');
                                                            //TDE.{$inputElementId}.select(-1);
                                                        };";

                                                        $js .= "TDE.{$inputElementId}.populate = function(datas){
                                                            TDE.{$inputElementId}.reset();

                                                            let options = [];
                                                            let selected = '';

                                                            //console.table(datas);
                                                            for (let data of datas){
                                                                if(data instanceof Array){
                                                                    //array
                                                                    options.push({Value: data[0], Text: data[1]});
                                                                    if(data.length == 3 && data[2]){
                                                                        selected = data[0];
                                                                    }
                                                                }
                                                                else if(data instanceof Object){
                                                                    //associative array = object
                                                                    if('Value' in data && 'Text' in data){
                                                                        options.push(data);
                                                                        if('Selected' in data){
                                                                            selected = data.Value;
                                                                        }
                                                                    }
                                                                }
                                                                else{
                                                                    //it's a string
                                                                    options.push({Value: data, Text: data});
                                                                }
                                                            }
                                                            TDE.{$inputElementId}.setDataSource(new kendo.data.{$dataSourceType}({data:options}));
                                                            if(selected){
                                                                TDE.{$inputElementId}.value(selected);
                                                            }
                                                        };";

                                                        if(count($selectOptions))
                                                        {
                                                            $js .= "TDE.{$inputElementId}.populate(".json_encode($selectOptions).");";
                                                        }
                                                    }

                                                    $onFilteringFunction = "";
                                                    if($selectFiltering)
                                                    {
                                                        if(is_string($selectFiltering))$onFilteringFunction = $selectFiltering;
                                                        else $onFilteringFunction =  $inputId."Filtering";

                                                        $js .= "TDE.{$inputElementId}.bind('filtering', {$onFilteringFunction});";
                                                    }

                                                    $onSelectFunction = "";
                                                    if($selectSelect)
                                                    {
                                                        if(is_string($selectSelect))$onSelectFunction = $selectSelect;
                                                        else $onSelectFunction =  $inputId."Select";

                                                        $js .= "TDE.{$inputElementId}.bind('select', {$onSelectFunction});";
                                                    }
                                                }
                                                else $this->setStatusCode(411);//Form error input type

                                                if($inputInfo){
                                                    $inputInfoElementId = "{$inputElementId}Info";
                                                    $html .= "<span id='{$inputInfoElementId}' class='ms-2'>{$inputInfo}</span>";
                                                    $js .= "TDE.{$inputInfoElementId} = $('#{$inputInfoElementId}');";
                                                }
                                                //INPUT INVALID FEEDBACK
                                                if($this->invalidFeedbackIsShow)$html .= "<div id='{$this->group}{$this->id}InvalidFeedback{$inputElementName}' class='invalid-feedback'></div>";
                                            $html .= "</div>";
                                        }
                                    $html .= "</div>";
                                $html .= "</div>";

                                if($onChangeFunction)
                                {
                                    //dd($inputElementIds,$inputElementId);
                                    if(count($inputElementIds) > 1)
                                    {
                                        foreach($inputElementIds AS $inputElementId)
                                        {
                                            $js .= "TDE.{$inputElementId}.bind('change', {$onChangeFunction});";
                                        }
                                    }
                                    else $js .= "TDE.{$inputElementId}.bind('change', {$onChangeFunction});";
                                }
                            $html .= "</div>";
                        }
                        else
                        {
                            $FieldSet = new FieldSet($params);
                            if($inputType != $stillSelectTesting && $selectTypeDetail != $stillSelectTypeTesting)
                            {
                                //if($selectTypeDetail == "cbpPicker")dd($FieldSet->getHtml());
                                $html .= $FieldSet->getHtml();
                                $js .= $FieldSet->getJs(true);
                            }
                        }

                        if(!$isTesting)
                        {
                            //dd($html,$FieldSet->getHtml());
                            //dd($js, $FieldSet->getJs(true));
                        }
                    }
                }

                //if($inputName == "NotificationSound") dd($html);
                $this->html .= $html;
                $this->js .= $js;
            }
                protected function generateInputId(string $inputId, string $groupName, string|array $arrayName)
                {
                    $Id = $inputId;

                    if($groupName && $groupName != "BLANK")
                    {
                        $Id .= "_{$groupName}";
                    }
                    if($arrayName)
                    {
                        if(is_string($arrayName))
                        {
                            $Id .= "_{$arrayName}";
                        }
                        if(is_array($arrayName))
                        {
                            $Id .= "_".implode("_",$arrayName);
                        }
                    }

                    return $Id;
                }
                protected function generateInputName(string $inputName, string $groupName, string|array $arrayName)
                {
                    $Name = $inputName;

                    if($groupName && $groupName != "BLANK")
                    {
                        $Name .= "[{$groupName}]";
                    }
                    if($arrayName)
                    {
                        if(is_string($arrayName))
                        {
                            $Name .= "[{$arrayName}]";
                        }
                        if(is_array($arrayName))
                        {
                            $Name .= "[".implode("][",$arrayName)."]";
                        }
                    }

                    return $Name;
                }
        #endregion field generator

        protected function generateButtons()
        {
            if($this->getStatusCode() != 100){return false;}
            if(!$this->isBegin){$this->setStatusCode(402);return false;}//Page is not yet begin
            if(!$this->isEnd){$this->setStatusCode(404);return false;}//Page is not yet ended

            if($this->cancelButtonIsShow)//RESET FORM
            {
                $this->html .= "<div class='{$this->cancelButtonClass}' onClick='setTimeout(function() {TDE.{$this->elementId}.trigger(&quot;reset&quot;);";
                    if($this->isStep)$this->html .= "{$this->stepFunctionName}(0);";//BACK TO STEP 1
                    foreach($this->cancelFunctions AS $index => $cancelButtonFunction)$this->html .= $cancelButtonFunction."();";
                $this->html .= "}, {$this->cancelDelayTimeOut});'><i class='{$this->cancelFontAwesomeIcon}'></i> {$this->cancelText}</div>";
            }
            if($this->submitButtonIsShow)
            {
                $this->html .= "<div class='{$this->submitButtonClass}' onClick='setTimeout(function() {";
                    foreach($this->submitFunctions AS $index => $submitButtonFunction)
                        $this->html .= $submitButtonFunction."();";
                    if($this->submitDefaultIsExecute)
                    {
                        $this->html .= "{$this->submitFunctionName}";
                        if($this->confirmationMessageIsShow)$this->html .= "ConfirmationMessage";
                        $this->html .= "();";
                    }
                $this->html .= "}, {$this->submitDelayTimeOut});'>";
                    $this->html .= "<i class='{$this->submitFontAwesomeIcon}'></i> {$this->submitText}
                </div>";
            }
            if(count($this->additionalButtons))
            {
                foreach($this->additionalButtons AS $index => $button)
                {
                    $this->cancelButtonColor = $this->buttonColorPrefix.($this->cancelButtonColor ?? "secondary");
                    $this->cancelButtonClass = $this->buttonClass." ".$this->cancelButtonColor;

                    $color = $this->buttonColorPrefix.($button["color"] ?? "primary");
                    $class = $this->buttonClass." ".$color;
                    $fontAwsomeIcon = $button["fontAwsomeIcon"] ?? "";
                    $text = $button["text"] ?? "OTHER BUTTON";
                    $functionName = $button["functionName"] ?? "";

                    $this->html .= "<div
                        class='{$class}'
                        onClick='{$functionName}();'>
                        <i class='{$fontAwsomeIcon}'></i> {$text}</div>";
                }
            }
        }
        protected function generateJSStepFunction()
        {
            if($this->getStatusCode() != 100){return false;}
            if(!$this->isBegin){$this->setStatusCode(402);return false;}//Page is not yet begin
            if(!$this->isEnd){$this->setStatusCode(404);return false;}//Page is not yet ended

            if($this->isStep)
            {
                //MAIN STEP SHOW AND HIDE FUNCTION
                $this->globalJS .= "function {$this->stepFunctionName}(stepId,backOrNext){
                    let thisStep = stepId;
                    if(backOrNext == 'b')thisStep++;
                    else if(backOrNext == 'n')thisStep--;
                    let validateFunctionName = '{$this->stepClass}Validate_'+thisStep;
                    if(backOrNext == 'b' || (backOrNext == 'n' && window[validateFunctionName]())){
                        $('.{$this->stepClass}').addClass('d-none');
                        $('#{$this->stepClass}_'+stepId).removeClass('d-none');
                    }
                }";
                foreach($this->stepValidations AS $stepCounter => $validations)
                {
                    $this->globalJS .= "function {$this->stepClass}Validate_{$stepCounter}(){
                        let IsValid = true;
                        let InvalidLabelText = '';";

                        if(count($validations))
                        {
                            foreach($validations AS $index => $params)
                            {
                                $labelText = $params["labelText"] ?? $params["inputName"] ?? "";
                                $inputName = $this->dynamicForm.($params["inputName"] ?? "");

                                $inputId = $this->group.$this->id.(str_replace("[]","",$inputName));
                                $inputGroup = $params["inputGroup"] ?? [""];
                                $inputArray = $params["inputArray"] ?? "";

                                $inputType = $this->isHidden ? "hidden" : ($params["inputType"] ?? "text");

                                foreach($inputGroup AS $index => $groupName)
                                {
                                    $inputElementId = $this->generateInputId($inputId, $groupName, $inputArray);
                                    $inputElementName = $this->generateInputName($inputName, $groupName, $inputArray);
                                    $invalidFeedbackId = $this->group.$this->id."InvalidFeedback".$inputElementName;

                                    if($inputType == "text" || $inputType == "email" || $inputType == "password")
                                    {
                                        $this->globalJS .= "if(IsValid && !$('#{$inputElementId}').data('kendoTextBox').value()){IsValid = false;InvalidLabelText = '{$labelText}';}";
                                    }
                                    else if($inputType == "checkbox")
                                    {
                                        $this->globalJS .= "if(IsValid && !$('#{$inputElementId}').data('kendoCheckBox').value()){IsValid = false;InvalidLabelText = '{$labelText}';}";
                                    }
                                    else if($inputType == "textarea")
                                    {
                                        $this->globalJS .= "if(IsValid && !$('#{$inputElementId}').data('kendoTextArea').value()){IsValid = false;InvalidLabelText = '{$labelText}';}";
                                    }
                                    else if($inputType == "kendoNumericTextBox")
                                    {
                                        $this->globalJS .= "if(IsValid && !$('#{$inputElementId}').data('{$inputType}').value()){IsValid = false;InvalidLabelText = '{$labelText}';}";
                                    }
                                    else if($inputType == "kendoDatePicker")
                                    {
                                        $this->globalJS .= "if(IsValid && !$('#{$inputElementId}').data('{$inputType}').value()){IsValid = false;InvalidLabelText = '{$labelText}';}";
                                    }
                                    else if($inputType == "kendoTimePicker")
                                    {
                                        $this->globalJS .= "if(IsValid && !$('#{$inputElementId}').data('{$inputType}').value()){IsValid = false;InvalidLabelText = '{$labelText}';}";
                                    }
                                    else if($inputType == "kendoDateTimePicker")
                                    {
                                        $this->globalJS .= "if(IsValid && !$('#{$inputElementId}').data('{$inputType}').value()){IsValid = false;InvalidLabelText = '{$labelText}';}";
                                    }
                                    else if($inputType == "kendoDatePicker_range")
                                    {
                                        $this->globalJS .= "if(IsValid && !$('#{$inputElementId}Start').data('kendoDatePicker').value()){IsValid = false;InvalidLabelText = '{$labelText}';}
                                            if(IsValid && !$('#{$inputElementId}End').data('kendoDatePicker').value()){IsValid = false;InvalidLabelText = '{$labelText}';}
                                            if(IsValid && $('#{$inputElementId}Start').data('kendoDatePicker').value() > $('#{$inputElementId}End').data('kendoDatePicker').value()){IsValid = false;InvalidLabelText = '{$labelText}';}";
                                    }
                                    else if(in_array($inputType,["kendoDropDownList","kendoComboBox","kendoMultiSelect"]))
                                    {
                                        $selectTypeDetail = $params["selectTypeDetail"] ?? "";
                                        if($selectTypeDetail == "monthYearPicker")
                                        {
                                            $selectTemplates =  $params["selectTemplates"] ?? ["month","year"];
                                            foreach($selectTemplates AS $index => $template)
                                            {
                                                if($template == "year")
                                                {
                                                    $inputElementId = $this->generateInputId($inputId."Year", $groupName, $inputArray);
                                                    $inputElementName = $this->generateInputName($inputName."Year", $groupName, $inputArray);
                                                    $invalidFeedbackId = $this->group.$this->id."InvalidFeedback".$inputElementName;

                                                }
                                                if($template == "month")
                                                {
                                                    $inputElementId = $this->generateInputId($inputId."Month", $groupName, $inputArray);
                                                    $inputElementName = $this->generateInputName($inputName."Month", $groupName, $inputArray);
                                                    $invalidFeedbackId = $this->group.$this->id."InvalidFeedback".$inputElementName;
                                                }
                                                $this->globalJS .= "if(IsValid && $('#{$inputElementId}').data('{$inputType}').select() == -1){IsValid = false;InvalidLabelText = '{$template}';}";
                                            }
                                        }
                                        else if($selectTypeDetail == "cbpPicker")
                                        {
                                            $selectTemplates =  $params["selectTemplates"] ?? ["brand","company","branch","pos"];
                                            foreach($selectTemplates AS $index => $selectTemplate)
                                            {
                                                $selectTemplate = ucfirst(strtolower($selectTemplate));
                                                $inputElementId = $this->generateInputId($inputId.$selectTemplate."Id", $groupName, $inputArray);
                                                $inputElementName = $this->generateInputName($inputName.$selectTemplate."Id", $groupName, $inputArray);
                                                $invalidFeedbackId = $this->group.$this->id."InvalidFeedback".$inputElementName;

                                                $this->globalJS .= "if(IsValid && $('#{$inputElementId}').data('{$inputType}').select() == -1){IsValid = false;InvalidLabelText = '{$selectTemplate}';}";
                                            }
                                        }
                                        else if($selectTypeDetail == "ampPicker")
                                        {
                                            $selectTemplates =  $params["selectTemplates"] ?? ["application","module","page"];
                                            foreach($selectTemplates AS $index => $selectTemplate)
                                            {
                                                $selectTemplate = ucfirst(strtolower($selectTemplate));
                                                $inputElementId = $this->generateInputId($inputId.$selectTemplate."Id", $groupName, $inputArray);
                                                $inputElementName = $this->generateInputName($inputName.$selectTemplate."Id", $groupName, $inputArray);
                                                $invalidFeedbackId = $this->group.$this->id."InvalidFeedback".$inputElementName;

                                                $this->globalJS .= "if(IsValid && $('#{$inputElementId}').data('{$inputType}').select() == -1){IsValid = false;InvalidLabelText = '{$selectTemplate}';}";
                                            }
                                        }
                                        else
                                        {
                                            $this->globalJS .= "if(IsValid && $('#{$inputElementId}').data('{$inputType}').select() == -1){IsValid = false;InvalidLabelText = '{$labelText}';}";
                                        }
                                    }
                                    else if($inputType == "kendoCheckBox")
                                    {
                                        $this->globalJS .= "if(IsValid && !$('#{$inputElementId}').data('{$inputType}').value()){IsValid = false;InvalidLabelText = '{$labelText}';}";
                                    }
                                    else if($inputType == "switch")
                                    {
                                        $this->globalJS .= "if(IsValid && !$('#{$inputElementId}').data('kendoSwitch').value()){IsValid = false;InvalidLabelText = '{$labelText}';}";
                                    }
                                    else if($inputType == "kendoUpload")
                                    {
                                        $this->globalJS .= "if(IsValid && !$('#{$inputElementId}').data('{$inputType}').value()){IsValid = false;InvalidLabelText = '{$labelText}';}";
                                    }
                                }
                            }
                        }

                        $this->globalJS .= "if(!IsValid)TDE.commonModal.Display({body:InvalidLabelText+' is required!'});
                        return IsValid;
                    }";
                }
            }
        }

        public function generateApprovalTable($params = null)
        {
            $divId = "{$this->group}{$this->id}DivKendoGridApprovals";
            $kendoGridId = "{$this->group}{$this->id}KendoGridApprovals";
            $this->addHtml("<div id='{$divId}' class=''><h6>PROFIL APPROVAL</h6>");
                $gridParams = [
                    "page" => $this->page,
                    "group" => $this->group.$this->id,
                    "id" => "Approvals",
                    "height" => 0,
                    "columnMenu" => false,
                    "filterable" => false,
                    "sortable" => false,
                    "resizable" => false,
                    "pageable" => false,
                    "columns" => [
                        ["formatType" => "rowNumber"],
                        //["field" => "Action","title" => " ","formatType" => "action"],
                        ["field" => "ApprovalTypeItemName","title" => "Jenjang","width" => 150],
                        ["field" => "StatusCode","title" => "Status","width" => 70, "attributes" => ["class" => "text-center"]],
                        ["field" => "ApproveDisapproveEmployeeName","title" => "Oleh","width" => 250],
                        ["field" => "ApproveDisapproveDateTime","title" => "Waktu", "formatType" => "dateTime"],
                        ["field" => "ApproveDisapproveGeneralNotes","title" => "Catatan"],
                    ],
                ];
                $grid = new KendoGrid($gridParams);
                $grid->begin();
                $grid->end();
            $this->addHtml($grid->getHtml());
            $this->addHtml("<br/></div>");

            $TDEId = "{$this->group}{$this->id}ApprovalTable";
            $js = "TDE.{$TDEId} = {};";
            $js .= "TDE.{$TDEId}.populate = function(datas){
                $('#{$divId}').addClass('d-none');
                TDE.{$kendoGridId}.populate([]);
                if(datas.length){
                    $('#{$divId}').removeClass('d-none');
                    TDE.{$kendoGridId}.populate(datas);
                }
            };";

            $this->js .= $js;
        }
    #endregion data process
}
