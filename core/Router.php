<?php
namespace app\core;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];
    protected array $renderParams = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    #region init
    #endregion init

    #region set status
    #endregion

    #region setting variable
        public function get(string $path,$callback)
        {
            $path = strtolower($path);
            $this->routes['get'][$path] = $callback;
        }
        public function post(string $path,$callback)
        {
            $path = strtolower($path);
            $this->routes['post'][$path] = $callback;
        }
        public function setAuth(Auth $auth)
        {
            $this->renderParams["_ENVIRONMENT"] = Application::$app->env;
            $this->renderParams["_EMPLOYEE"] = $auth->getEmployee();
            $this->renderParams["_MODULE_PAGES"] = $auth->getModulePages();
            if(APP_NAME == "Plutus")
            {
                $this->renderParams["_BRANCH"] = $auth->getBranch();
                $this->renderParams["_CREATEPOSES"] = $auth->getCreatePOSes();
                $this->renderParams["_READPOSES"] = $auth->getReadPOSes();
                $this->renderParams["_UPDATEPOSES"] = $auth->getUpdatePOSes();
                $this->renderParams["_DELETEPOSES"] = $auth->getDeletePOSes();
                $this->renderParams["_OTHER_BRANCHES"] = $auth->getOtherBranches();
                //$this->renderParams["_ISBACKDATE"] = $auth->getIsBackDate();
            }
            if(APP_NAME == "Selene")
            {
                $this->renderParams["_CREATEBRANCHES"] = $auth->getCreateBranches();
                $this->renderParams["_READBRANCHES"] = $auth->getReadBranches();
                $this->renderParams["_UPDATEBRANCHES"] = $auth->getUpdateBranches();
                $this->renderParams["_DELETEBRANCHES"] = $auth->getDeleteBranches();
            }
            $this->renderParams["_IS_REPORT_ACCESS"] = $auth->getIsReportAccess();
        }
    #endregion setting variable

    #region getting / returning variable
        protected function getLayout(array $params)
        {
            $layout = Application::$app->controller->layout;
            foreach($params as $key => $value)
            {
                $$key = $value;
            }

            ob_start();
            if(Application::$app->controller->getIsLayoutChronos())
            {
                include_once Application::$ROOT_DIR."/../Chronos/views/layout/{$layout}.php";
            }
            else
            {
                include_once Application::$ROOT_DIR."/views/layout/{$layout}.php";
            }
            return ob_get_clean();
        }
        protected function getPageTitle()
        {
            return Application::$app->controller->getPageTitle();
        }
        protected function getContent(string $content, array $params)
        {
            $viewFolderName = Application::$app->controller->viewFolderName;
            foreach($params as $key => $value)
            {
                $$key = $value;
            }

            ob_start();
            if(Application::$app->controller->getIsContentChronos())
            {
                include_once Application::$ROOT_DIR."/../Chronos/views/{$viewFolderName}/{$content}.php";
            }
            else
            {
                include_once Application::$ROOT_DIR."/views/{$viewFolderName}/{$content}.php";
            }
            return ob_get_clean();
        }
        protected function getVer(string $url){
            if(empty($url)) return $url;
            else if(!file_exists($_SERVER['DOCUMENT_ROOT'] . $url)) return NULL;

            $ver = '-'.filemtime($_SERVER['DOCUMENT_ROOT'].$url).'.';
            $path = pathinfo($url);
            clearstatcache(); //Refresh file cache using by filemtime()

            return $path['dirname'].'/'.str_replace('.', $ver, $path['basename']);
        }
        protected function getJS()
        {
            $js = Application::$app->controller->getJS();
            $jsText = "";

            foreach($js as $value)
            {
                if(substr($value,0,4) == "http")
                {
                    $jsText .="<script src='".$value."'></script>";
                }
                else
                {
                    if(Application::$app->controller->getIsContentChronos())
                    {
                        $filePath = "/".COMMON_JS."".$value.".js";
                    }
                    else
                    {
                        $filePath = "/".JS_ROOT."".$value.".js";
                    }

                    $jsText .="<script src='".$this->getVer($filePath)."'></script>";
                }
            }

            return $jsText;
        }
        protected function getChronosJS()
        {
            $js = Application::$app->controller->getChronosJS();
            $jsText = "";

            foreach($js as $value)
            {
                if(substr($value,0,4) == "http")
                {
                    $jsText .="<script src='".$value."'></script>";
                }
                else
                {
                    $filePath = "/".COMMON_JS."".$value.".js";
                    $jsText .="<script src='".$this->getVer($filePath)."'></script>";
                }
            }

            return $jsText;
        }
        protected function getCSS()
        {
            $css = Application::$app->controller->getCSS();
            $cssText = "";

            foreach($css as $value)
            {
                if(substr($value,0,4) == "http")
                {
                    $cssText .="<link rel='stylesheet' type='text/css' href='".$value."'>";
                }
                else
                {
                    if(Application::$app->controller->getIsContentChronos())
                    {
                        $filePath = "/".COMMON_CSS."".$value.".css";
                    }
                    else
                    {
                        $filePath = "/".CSS_ROOT."".$value.".css";
                    }

                    $cssText .="<link rel='stylesheet' type='text/css' href='".$this->getVer($filePath)."'>";
                }
            }

            return $cssText;
        }
        protected function getChronosCSS()
        {
            $css = Application::$app->controller->getChronosCSS();
            $cssText = "";
            foreach($css as $key => $value)
            {
                if(substr($value,0,4) == "http")
                    $cssText .="<link rel='stylesheet' type='text/css' href='".$value."'>";
                else
                {
                    $filePath = "/".COMMON_CSS."".$value.".css";
                    $cssText .="<link rel='stylesheet' type='text/css' href='".$this->getVer($filePath)."'>";
                }
            }
            return $cssText;
        }
        public function getEmployee(string $key = null)
        {
            if(isset($key))$return = $this->renderParams["_EMPLOYEE"][$key];
            else $return = $this->renderParams["_EMPLOYEE"];

            return $return;
        }
    #endregion  getting / returning variable

    #region data process
        public function resolve()
        {
            $path = $this->request->getPath();
            $method = $this->request->getMethod();
            //echo $path;

            $callback = $this->routes[$method][$path] ?? false;
            //dd($callback);
            if($callback === false)
            {
                $this->response->setStatusCode(404);
                Application::$app->controller = new Controller();
                Application::$app->controller->setIsLayoutChronos(true);
                Application::$app->controller->setIsContentChronos(true);
                Application::$app->controller->setLayout("auth");
                Application::$app->controller->setPageTitle("Ooops!");
                //Application::$app->controller->setJS(["_404"]);
                //Application::$app->controller->setCSS(["_404"]);
                return $this->renderView("_404");
            }
            if(is_string($callback))
            {
                return $this->renderView($callback);
            }

            if(is_array($callback))
            {
                Application::$app->controller = new $callback[0]();
                $callback[0] = Application::$app->controller;
            }

            //dd($callback[0]);
            return call_user_func($callback, $this->request);
        }
        public function renderView(string $content, array $params = [])
        {
            //$this->renderParams = $params;
            $this->renderParams = array_merge($this->renderParams, $params);

            $layout = $this->getLayout($this->renderParams);

            $content = $this->getContent($content, $this->renderParams);
            $renderedView = str_replace('{{content}}',$content,$layout);

            $pageTitle = $this->getPageTitle();
            if($pageTitle)$renderedView = str_replace('{{page_title}}',$pageTitle,$renderedView);
            else $renderedView = str_replace('{{page_title}}',"",$renderedView);

            /*
            $js = $this->getJS();
            if($js)$renderedView = str_replace('{{dynamic_js}}',$js,$renderedView);
            else $renderedView = str_replace('{{dynamic_js}}',"",$renderedView);
            */
            $renderedView = str_replace('{{dynamic_js}}',$this->getChronosJS().$this->getJS(),$renderedView);

            /*
            $css = $this->getCSS();
            $chronosCss = $this->getChronosCSS();
            if($css)$renderedView = str_replace('{{dynamic_css}}',$css,$renderedView);
            else $renderedView = str_replace('{{dynamic_css}}',"",$renderedView);
            */
            $renderedView = str_replace('{{dynamic_css}}',$this->getChronosCSS().$this->getCSS(),$renderedView);

            return $renderedView;
        }
    #endregion data process
}
