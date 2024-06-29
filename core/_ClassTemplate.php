<?php
namespace app\core;

class ClassTemplate
{
    protected Application $app;
    public function __construct()
    {
        $this->app = Application::$app;
    }
    //REDIRECT TO APP
    public function setStatusParams(array $statusParams){$this->app->setStatusParams($statusParams);}
    public function setStatusCode(int $statusCode, array $statusParams = NULL){$this->app->setStatusCode($statusCode, $statusParams);}
    public function getStatusCode(){return $this->app->getStatusCode();}
    public function statusMessage(){return $this->app->statusMessage();}

    public function methode1()
    {
        if($this->getStatusCode() != 100) return null;

        //DO SOMETHING
    }

    #region init
    #endregion init

    #region set status
    #endregion

    #region setting variable
    #endregion setting variable

    #region getting / returning variable
    #endregion  getting / returning variable

    #region data process
    #endregion data process
}
