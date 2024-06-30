<?php
namespace app\core;

class Controller
{
    protected Application $app;
    protected bool $isLayoutCore = true;
    protected bool $isContentCore = false;
    public string $layout;
    public string $viewFolderName;
    public array $js = [];
    public array $css = [];
    public array $coreJs = [];
    public array $coreCss = [];
    public string $pageTitle = 'Welcome to TDE 2.0';
    protected int $pageId = 0;
    protected array $breadcrumbs = [];

    public function __construct()
    {
        $this->app = Application::$app;
        $this->setIsLayoutCore(true);
        $this->setIsContentCore(false);
        $this->setLayout('default');
    }

    #region init
    #endregion init

    #region set status
    #endregion

    #region setting variable
        public function setIsLayoutCore(bool $isCore)
        {
            $this->isLayoutCore = $isCore;
        }
        public function setIsContentCore(bool $isCore)
        {
            $this->isContentCore = $isCore;
        }
        public function setLayout(string $layout)
        {
            $this->layout = $layout;
            $this->setViewFolderName($layout);
        }
        public function setViewFolderName(string $viewFolderName)
        {
            $this->viewFolderName = $viewFolderName;
        }
        public function setPageTitle(string $pageTitle)
        {
            $this->pageTitle = $pageTitle;
        }
        public function setJS(array $js)
        {
            $this->js = $js;
        }
        public function setCSS(array $css)
        {
            $this->css = $css;
        }
        public function setCoreJS(array $js)
        {
            $this->coreJs = $js;
        }
        public function setCoreCSS(array $css)
        {
            $this->coreCss = $css;
        }
    #endregion setting variable

    #region getting / returning variable
        public function getIsLayoutCore()
        {
            return $this->isLayoutCore;
        }
        public function getIsContentCore()
        {
            return $this->isContentCore;
        }
        protected function generateNewsImagePositionOptions()
        {
            return [
                ["Text" => "LEFT", "Value" => "left"],
                ["Text" => "CENTER", "Value" => "center"],
                ["Text" => "RIGHT", "Value" => "right"],
            ];
        }
        public function getPageTitle()
        {
            return $this->pageTitle;
        }
        public function getJS()
        {
            return $this->js;
        }
        public function getCSS()
        {
            return $this->css;
        }
        public function getCoreJS()
        {
            return $this->coreJs;
        }
        public function getCoreCSS()
        {
            return $this->coreCss;
        }
    #endregion  getting / returning variable

    #region data process
        protected function addBreadCrumb(string $text, string $link)
        {
            $indexOfLastBreadCrumbs = count($this->breadcrumbs) - 1;
            $lastLink = $this->breadcrumbs[$indexOfLastBreadCrumbs][1];

            $this->breadcrumbs[] = [$text, "{$lastLink}/{$link}"];
        }
        protected function runCallbacks(array $callbacks)
        {
            foreach($callbacks AS $callback)
            {
                $method = $callback[0];
                $params = $callback[1];

                $this->$method($params);
            }
        }
        protected function render(string $content, array $params = [])
        {
            //echo "<pre>";var_dump($params);echo "</pre>";
            if(!isset($params["breadcrumbs"]))$params["breadcrumbs"] = $this->breadcrumbs;
            return Application::$app->router->renderView($content, $params);
        }
        protected function tokenExpired()
        {
            $this->setIsContentCore(true);
            $this->setPageTitle('SESSION EXPIRED');
            $this->setLayout('print');
            $this->setViewFolderName('auth');

            return $this->render('tokenExpired');
        }
    #endregion data process
}
