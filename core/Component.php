<?php
namespace app\core;

class Component
{
    public Application $app;
    protected $page;
    protected $group;
    protected $id;
    protected $elementId;

    protected int $isBegin = 0;
    protected int $isEnd = 0;

    protected string $html = ""; //FOR RENDERING HTML
    protected string $globalJS = ""; //FOR RENDERING GLOBAL SCRIPT
    protected string $js = ""; //FOR RENDERING WHEN DOCUMENT RFEADY

    public function __construct(string $page)
    {
        $this->app = Application::$app;
        $this->page = $page;
    }
    //REDIRECT TO APP
    public function setStatusParams(array $statusParams){$this->app->setStatusParams($statusParams);}
    public function setStatusCode(int $statusCode, array $statusParams = NULL){$this->app->setStatusCode($statusCode, $statusParams);}
    public function getStatusCode(){return $this->app->getStatusCode();}
    public function statusMessage(){return $this->app->statusMessage();}

    #region init
    #endregion init

    #region set status
    #endregion

    #region setting variable
        public function addHtml($html)
        {
            if($html)$this->html .= $html;
        }
        public function addJs($js)
        {
            if($js)$this->js .= $js;
        }
    #endregion setting variable

    #region getting / returning variable
        public function getHtml(bool $isHtmlOnly = false)
        {
            if($this->getStatusCode() != 100){return null;}
            if(!$this->isBegin){$this->setStatusCode(602);return null;}//Page is not yet begin
            if(!$this->isEnd){$this->setStatusCode(604);return null;}//Page is not yet ended

            if($isHtmlOnly)return $this->html;

            return $this->html.$this->getJs();
        }
        public function getJs()
        {
            if($this->getStatusCode() != 100){return null;}
            if(!$this->isBegin){$this->setStatusCode(602);return null;}//Page is not yet begin
            if(!$this->isEnd){$this->setStatusCode(604);return null;}//Page is not yet ended

            $return = "";
            if($this->globalJS || $this->js)
            {
                $return = "<script>";
                if($this->globalJS)$return.= $this->globalJS;
                if($this->js)$return.= "$(document).ready(function(){{$this->js}});";
                $return .= "</script>";
            }
            return $return;
        }
    #endregion  getting / returning variable

    #region data process
        public function render(bool $isHtmlOnly = false)
        {
            if($this->getStatusCode() != 100){return null;}
            if(!$this->isBegin){$this->setStatusCode(602);return null;}//Page is not yet begin
            if(!$this->isEnd){$this->setStatusCode(604);return null;}//Page is not yet ended

            echo $this->getHtml($isHtmlOnly);
        }
    #endregion data process

}

