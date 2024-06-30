<?php
namespace app\core;

class Request
{
    public array $getVariables = [];
    public array $postVariables = [];

    public function __construct()
    {
        $this->generatePostVariable();
    }

    #region init
    #endregion init

    #region set status
    #endregion

    #region setting variable
        public function isGet()
        {
            return $this->getMethod() === 'get';
        }
        public function isPost()
        {
            return $this->getMethod() === 'post';
        }
        public function setGetVariable(string $key, $value)
        {
            $this->getVariables[$key] = $value;
        }
        public function setPostVariable(string $key, $value)
        {
            $this->postVariables[$key] = $value;
        }
    #endregion setting variable

    #region getting / returning variable
        public function getPath()
        {
            $path = str_replace(strtolower(APP_ROOT),"",strtolower($_SERVER['REQUEST_URI'])) ?? '/';
            //echo "<pre>";var_dump(APP_ROOT);echo "</pre>";

            if(str_contains($path,"?"))
            {
                $explodes = explode("?",$path);

                $path = $explodes[0];

                $vars = explode("&",$explodes[1]);

                foreach($vars AS $index => $var)
                {
                    $varExplode = explode("=",$var);
                    $this->getVariables[$varExplode[0]] = $varExplode[1];
                }
            }
            return $path;
        }
        public function getMethod()
        {
            return strtolower($_SERVER['REQUEST_METHOD']);
        }
        public function getBody()
        {
            $body = [];
            if($this->isGet())
            {
                foreach($_GET as $key => $value)
                {
                    $body[$key] = filter_input(INPUT_GET, $key, FILER_SANITIZE_SPECIAL_CHARS);
                }
            }

            if($this->isPost())
            {
                foreach($_POST as $key => $value)
                {
                    $body[$key] = filter_input(INPUT_POST, $key, FILER_SANITIZE_SPECIAL_CHARS);
                }
            }
            return $body;
        }
        public function getGetVariable(string $key)
        {
            return $this->getVariables[$key];
        }
        public function getGetVariables()
        {
            return $this->getVariables;
        }
        public function getPostVariable(string $key)
        {
            return $this->postVariables[$key];
        }
        public function getPostVariables()
        {
            return $this->postVariables;
        }
    #endregion  getting / returning variable

    #region data process
        protected function generatePostVariable()
        {
            if(isset($_POST))
            {
                foreach($_POST as $key => $value)
                {
                    $this->setPostVariable($key,$value);
                }
            }
        }
    #endregion data process
}
