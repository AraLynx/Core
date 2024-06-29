<?php
namespace app\core;

//require_once __DIR__.'/../functions/encrypt.php';

class Token
{
    protected Application $app;
    protected int $userId;
    public function __construct(int $userId)
    {
        $this->app = Application::$app;
        $this->userId = $userId;
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
    public function getToken(int $durationSecond = 60)
    {
        if($this->getStatusCode() != 100) return null;

        $token = $this->userId."|".base_convert(time()+$durationSecond,10,36);
        return $token;
    }
    public function checkToken(string $token)
    {
        $isValid = 1;

        $token_explode = explode("|",$token);
        if($token_explode[0] != $this->userId)$isValid = 0;

        $expired = base_convert($token_explode[1],36,10);
        $now = time();
        if($expired < $now)$isValid = 0;

        return $isValid;
    }
#endregion  getting / returning variable

#region data process
#endregion data process
}
