<?php
namespace app\TDEs;
use app\core\TDE;

class ChangeLogHelper extends TDE
{
    protected int $userId;
    protected string $path;
    protected array $explodedPaths;
    protected array $pathMatrix;

    public function __construct(int $userId)
    {
        parent::__construct();
        $this->prepare("ChangeLogHelper");

        $this->userId = $userId;

        $_HEADER_REQUEST = apache_request_headers();
        //$datas["header_req"] = $_HEADER_REQUEST;
        if($_HEADER_REQUEST["Sec-Fetch-Site"] == "same-origin")
        {
            $Origin = $_HEADER_REQUEST["Origin"];
            $FullPath = $_HEADER_REQUEST["Referer"];
            $TDE_Path = $Origin."/".TDE_ROOT."/".APP_NAME."/";

            if(substr($FullPath,0,strlen($TDE_Path)) == $TDE_Path)
            {
                $this->path = substr($FullPath,strlen($TDE_Path));
                $this->explodePath();
            }
            else $this->app->setStatusCode(562);
        }
        else $this->app->setStatusCode(561);

        $this->generatePathMatrixFromDB();
    }

#region init
#endregion init

#region set status
#endregion

#region setting variable
#endregion setting variable

#region getting / returning variable
    public function getApplicationId()
    {
        if($this->getStatusCode() != 100) return null;

        $applicationId = 0;
        if(APP_NAME == "Gaia") $applicationId = 1;
        if(APP_NAME == "Selene") $applicationId = 2;
        if(APP_NAME == "Plutus") $applicationId = 3;

        return $applicationId;
    }
    public function getPath()
    {
        if($this->getStatusCode() != 100) return null;

        return $this->path;
    }
    public function getPaths()
    {
        if($this->getStatusCode() != 100) return null;

        return $this->explodedPaths;
    }
    public function getPathMatrix()
    {
        if($this->getStatusCode() != 100) return null;

        return $this->pathMatrix;
    }
    public function getNewNotif()
    {
        if($this->getStatusCode() != 100) return null;

        if($this->getPageId())
        {
            $pageId = $this->getPageId();

            $SP = new \app\core\StoredProcedure("Uranus", "SP_Sys_ChangeLog_GetNewNotif");
            $SP->addParameters(["UserId" => $this->userId, "ApplicationId" => $this->getApplicationId(), "ApplicationVersion" => 2, "PageId" => $pageId]);
            return $SP->f5();
        }

        if($this->getModuleId())
        {
            $moduleId = $this->getModuleId();

            $SP = new \app\core\StoredProcedure("Uranus", "SP_Sys_ChangeLog_GetNewNotif");
            $SP->addParameters(["UserId" => $this->userId, "ApplicationId" => $this->getApplicationId(), "ApplicationVersion" => 2, "ModuleId" => $moduleId]);
            return $SP->f5();
        }

        $SP = new \app\core\StoredProcedure("Uranus", "SP_Sys_ChangeLog_GetNewNotif");
        $SP->addParameters(["UserId" => $this->userId, "ApplicationId" => $this->getApplicationId(), "ApplicationVersion" => 2]);
        return $SP->f5();
    }
        public function getModuleId()
        {
            if($this->getStatusCode() != 100) return null;

            $moduleId = 0;
            if(count($this->explodedPaths) == 1 || count($this->explodedPaths) == 2)
            {
                $ModuleRoute = $this->explodedPaths[0];

                foreach($this->pathMatrix AS $path)
                {
                    if(strtolower($ModuleRoute) == strtolower($path["ModuleRoute"]))
                    {
                        $moduleId = $path["ModuleId"];
                    }
                }
            }
            return $moduleId;
        }
        public function getPageId()
        {
            if($this->getStatusCode() != 100) return null;

            $pageId = 0;
            if(count($this->explodedPaths) == 2)
            {
                $ModuleRoute = $this->explodedPaths[0];
                $PageRoute = $this->explodedPaths[1];

                foreach($this->pathMatrix AS $path)
                {
                    if(strtolower($ModuleRoute) == strtolower($path["ModuleRoute"]) && strtolower($PageRoute) == strtolower($path["PageRoute"]))
                    {
                        $pageId = $path["PageId"];
                    }
                }
            }
            return $pageId;
        }
    function getChangeLogs(int $moduleId, int $pageId)
    {
        if($this->getStatusCode() != 100) return null;

        $SP = new \app\core\StoredProcedure("Uranus", "SP_Sys_ChangeLog_GetChangeLogs");
        $header = ["module" => ["Id" => 0, "Name" => "Test", "Route" => ""], "page" => ["Id" => 0, "Name" => "Test", "Route" => ""]];
        $SP->addParameters(["UserId" => $this->userId, "ApplicationId" => $this->getApplicationId(), "ApplicationVersion" => 2]);
        if($moduleId)
        {
            $SP->addParameters(["ModuleId" => $moduleId]);
            $header["module"]["Id"] = $moduleId;
        }
        if($pageId)
        {
            $SP->addParameters(["PageId" => $pageId]);
            $header["page"]["Id"] = $moduleId;
        }
        //return $SP->SPGenerateQuery();
        $changeLogs = $SP->f5();

        return ["header" => $header, "changeLogs" => $changeLogs];
    }
#endregion  getting / returning variable

#region data process
    protected function explodePath()
    {
        if($this->getStatusCode() != 100) return null;

        $this->explodedPaths = explode("/",$this->path);
    }
    protected function addPathMatrix()
    {
        if($this->getStatusCode() != 100) return null;
    }
    protected function generatePathMatrixFromDB()
    {
        if($this->getStatusCode() != 100) return null;

        $SP = new \app\core\StoredProcedure("Uranus", "SP_Sys_ChangeLog_GeneratePathMatrix");
        $SP->addParameters(["AppName" => APP_NAME, "UserId" => $this->userId]);
        $this->pathMatrix = $SP->f5();
        //dd($this->pathMatrix);
    }
#endregion data process
}
