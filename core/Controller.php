<?php
namespace app\core;

class Controller
{
    protected Application $app;
    protected bool $isLayoutChronos = true;
    protected bool $isContentChronos = false;
    public string $layout;
    public string $viewFolderName;
    public array $js = [];
    public array $css = [];
    public array $chronosJs = [];
    public array $chronosCss = [];
    public string $pageTitle = 'Welcome to TDE 2.0';
    protected int $pageId = 0;
    protected array $breadcrumbs = [];

    public function __construct()
    {
        $this->app = Application::$app;
        $this->setIsLayoutChronos(true);
        $this->setIsContentChronos(false);
        $this->setLayout('default');
    }

    #region init
    #endregion init

    #region set status
    #endregion

    #region setting variable
        public function setIsLayoutChronos(bool $isChronos)
        {
            $this->isLayoutChronos = $isChronos;
        }
        public function setIsContentChronos(bool $isChronos)
        {
            $this->isContentChronos = $isChronos;
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
        public function setChronosJS(array $js)
        {
            $this->chronosJs = $js;
        }
        public function setChronosCSS(array $css)
        {
            $this->chronosCss = $css;
        }
    #endregion setting variable

    #region getting / returning variable
        public function getIsLayoutChronos()
        {
            return $this->isLayoutChronos;
        }
        public function getIsContentChronos()
        {
            return $this->isContentChronos;
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
        public function getChronosJS()
        {
            return $this->chronosJs;
        }
        public function getChronosCSS()
        {
            return $this->chronosCss;
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
            $this->setIsContentChronos(true);
            $this->setPageTitle('SESSION EXPIRED');
            $this->setLayout('print');
            $this->setViewFolderName('auth');

            return $this->render('tokenExpired');
        }
    #endregion data process
}
