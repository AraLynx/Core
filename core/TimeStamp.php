<?php
namespace app\core;

class TimeStamp
{
    protected Application $app;

    protected float $timestamp = 0;
    protected array $timestamps = [];

    public function __construct()
    {
        $this->app = Application::$app;

        $this->timestamp = microtime(true);
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
    public function addTimeStamp(string $description)
    {
        $now = microtime(true);
        $diff = $now - $this->timestamp;
        $this->timestamps[] = "{$description} : {$diff} second(s)";
        $this->timestamp = $now;
    }
#endregion setting variable

#region getting / returning variable
    public function getTimeStamps()
    {
        return $this->timestamps;
    }
#endregion  getting / returning variable

#region data process
#endregion data process
}
