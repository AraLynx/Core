<?php
namespace app\core;

class Record
{
    protected Application $app;
    protected int $objectId;
    protected array $columns;
    protected array $columnProperties;

    public string $action;

    protected bool $isGenerateSelectValueAndText;
    protected array $selectValueTemplates;
    protected string $selectValueGlue;

    protected array $selectTextTemplates;
    protected string $selectTextGlue;

    public array $selectValueAndText;

    //protected bool $isGenerateSelectTemplate;

    //public array $selectTemplate;

    public function __construct(array $params = null, array $record = null)
    {
        $this->app = Application::$app;
        $this->objectId = $params["objectId"];
        $this->columns = $params["columns"];
        $this->columnProperties = $params["columnProperties"];

        $this->isGenerateSelectValueAndText = $params["isGenerateSelectValueAndText"] ?? false;
        $this->selectValueTemplates = $params["selectValueTemplates"] ?? ["Id"];
        $this->selectValueGlue = $params["selectValueGlue"] ?? "_";

        $this->selectTextTemplates = $params["selectTextTemplates"] ?? ["Name"];
        $this->selectTextGlue = $params["selectTextGlue"] ?? " ";

        if(isset($record)) $this->setData($record);

        $this->init();


        if(isset($params["actionIf"]))
        {
            $this->action = "";
            $this->generateActionIf($params["actionIf"]);
        }
    }
    //REDIRECT TO APP
    public function setStatusParams(array $statusParams){$this->app->setStatusParams($statusParams);}
    public function setStatusCode(int $statusCode, array $statusParams = NULL){$this->app->setStatusCode($statusCode, $statusParams);}
    public function getStatusCode(){return $this->app->getStatusCode();}
    public function statusMessage(){return $this->app->statusMessage();}

    #region init
        protected function init()
        {
            if($this->getStatusCode() != 100) return null;

            if($this->isGenerateSelectValueAndText)$this->generateSelectValueAndText();
        }
    #endregion init

    #region set status
    #endregion

    #region setting variable
        public function setData($record)
        {
            if($this->getStatusCode() != 100) return null;
            foreach($record AS $field => $value)
            {
                $this->$field = $value;
            }
        }
    #endregion setting variable

    #region getting / returning variable
    #endregion  getting / returning variable

    #region data process
        protected function generateSelectValueAndText(array $params = NULL)
        {
            if($this->getStatusCode() != 100) return null;
            $this->selectValueAndText = [];

            $Values = array();
            foreach($this->selectValueTemplates AS $index => $field)
            {
                if(isset($this->$field) && $this->$field)$Values[] = $this->$field;
            }

            $Texts = array();
            foreach($this->selectTextTemplates AS $index => $field)
            {
                if(isset($this->$field) && $this->$field)$Texts[] = $this->$field;
            }

            $this->selectValueAndText = [
                "Value" => implode($this->selectValueGlue, $Values),
                "Text" => implode($this->selectTextGlue, $Texts),
            ];
        }

        protected function generateActionIf(array $params)
        {
            /*
            UNDER DEV
            */
            if($this->getStatusCode() != 100) return null;
            foreach($params AS $index => $param)
            {
                $string = $param[0];

                $isTrue = true;

                foreach($param AS $index => $rule)
                {
                    if($index > 0 && $isTrue)
                    {
                        $fieldName = $rule[0];
                        $statement = $rule[1];
                        $valueCheck = $rule[2] ?? NULL;

                        if($statement == "eq")
                        {
                            if($valueCheck == NULL)
                            {
                                if($this->$fieldName)$isTrue = false;
                            }
                            else
                            {
                                if($this->$fieldName != $valueCheck)$isTrue = false;
                            }
                        }

                        if($statement == "neq")
                        {
                            if($valueCheck == NULL)
                            {
                                if(!$this->$fieldName)$isTrue = false;
                            }
                            else
                            {
                                if($this->$fieldName == $valueCheck)$isTrue = false;
                            }
                        }
                    }
                }
                if($isTrue)
                {
                    $this->action .= $string;
                }
            }
        }
    #endregion data process

}
