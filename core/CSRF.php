<?php
namespace app\core;

class CSRF
{
    protected Application $app;

    protected string $key;
    protected string $salt;
    protected string $token;

    public function __construct(array $params)
    {
        $this->app = Application::$app;

        $this->key = $params["key"];
        $this->salt = $params["salt"] ?? "general";

        if(in_array($this->app->app_name,["Hephaestus"]))$this->salt = "token untuk {$this->salt}";
        else $this->salt = "token untuk {$this->salt} tanggal ".date("Y m d");

        $this->generateToken();
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
    #endregion setting variable

    #region getting / returning variable
        public function getToken()
        {
            if($this->getStatusCode() == 100)
            {
                return $this->token;
            }
        }
    #endregion  getting / returning variable

    #region data process
        protected function generateToken()
        {
            if($this->getStatusCode() == 100)
            {
                $this->token = hash_hmac("sha256",$this->salt,$this->key);
            }
            else $this->setStatusCode(502);//Form token is not valid
        }
        public function compareToken($token)
        {
            if($this->getStatusCode() == 100)
            {
                if(!hash_equals($this->token, $token))$this->setStatusCode(502);//Form token is not valid
            }
        }
    #endregion data process

}
