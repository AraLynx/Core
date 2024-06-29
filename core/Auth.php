<?php
namespace app\core;

require_once __DIR__.'/../functions/browser.php';

class Auth
{
    public Application $app;

    protected int $userId;
    protected int $branchId;
    protected string $loginTokenHash;
    protected StoredProcedure $SPUranus;
    protected StoredProcedure $SPApp;
    public static Auth $auth;

    protected array $browser;
    protected string $deviceTypeName;

    protected string $salt;
    protected array $employee;
    protected array $modulePages;
    protected array $pages;

    public function __construct(int $userId, string $loginTokenHash = null)
    {
        $this->app = Application::$app;
        $this->userId = $userId;
        $this->employee["UserId"] = $this->userId;

        if(in_array($this->app->app_name,["Hephaestus"]))$this->salt = "token untuk login {$this->app->app_name} user id {$this->userId}";
        else $this->salt = "token untuk login user id {$this->userId} tanggal ".date("Y m d");

        if(isset($loginTokenHash))$this->loginTokenHash = $loginTokenHash;

        $this->generateBrowser();
        $this->checkEmployee();
    }
    //REDIRECT TO APP
    public function setStatusParams(array $statusParams){$this->app->setStatusParams($statusParams);}
    public function setStatusCode(int $statusCode, array $statusParams = NULL){$this->app->setStatusCode($statusCode, $statusParams);}
    public function getStatusCode(){return $this->app->getStatusCode();}
    public function statusMessage(){return $this->app->statusMessage();}

    #region init
        protected function generateBrowser()
        {
            $browser = browser($_SERVER['HTTP_USER_AGENT']);
            $this->browser["deviceTypeName"] = "";
            if($browser->isDesktop())$this->browser["deviceTypeName"] = "desktop";
            else if($browser->isTablet())$this->browser["deviceTypeName"] = "tablet";
            else if($browser->isMobile())$this->browser["deviceTypeName"] = "mobile";
            //else if($browser->isRobot())$this->browser["deviceTypeName"] = "robot";

            $this->browser["deviceName"] = $browser->getDevice();
            $this->browser["browserName"] = $browser->getBrowser();
            $this->browser["platformName"] = $browser->getPlatform();
        }
        protected function checkEmployee()
        {
            if($this->getStatusCode() == 100)

            $SP = new StoredProcedure("uranus", "SP_Sys_Auth_GetEmployeeStatusPositionByUserId");
            $SP->addParameters(["UserId" => $this->userId]);
            $SP->f5();

            if($this->getStatusCode() == 100)
            {
                foreach($SP->getRow() AS $index => $row)
                {
                    if($row["Data"] == "Username")$this->employee["Username"] = $row["Value"];
                    if($row["Data"] == "AvatarFileName")$this->employee["AvatarFileName"] = $row["Value"];
                    //if($row["Data"] == "EmailAddress")$this->employee["EmailAddress"] = $row["Value"];

                    if($row["Data"] == "Id")$this->employee["Id"] = $row["Value"];
                    if($row["Data"] == "Name")$this->employee["Name"] = $row["Value"];

                    if($row["Data"] == "GenderId")$this->employee["GenderId"] = $row["Value"];
                    //if($row["Data"] == "Gender")$this->employee["Gender"] = $row["Value"];

                    //if($row["Data"] == "EmployeeStatusId")$this->employee["EmployeeStatusId"] = $row["Value"];
                    if($row["Data"] == "EmployeeStatusTypeId")$this->employee["EmployeeStatusTypeId"] = $row["Value"];
                    //if($row["Data"] == "EmployeeStatusTypeName")$this->employee["EmployeeStatusTypeName"] = $row["Value"];
                    if($row["Data"] == "EmployeeStatusEndDate")$this->employee["EmployeeStatusEndDate"] = $row["Value"];

                    //if($row["Data"] == "EmployeeStatusPositionId")$this->employee["EmployeeStatusPositionId"] = $row["Value"];
                    if($row["Data"] == "PositionId")$this->employee["PositionId"] = $row["Value"];
                    if($row["Data"] == "PositionName")$this->employee["PositionName"] = $row["Value"];

                    if($row["Data"] == "IsHeadOffice")$this->employee["IsHeadOffice"] = $row["Value"];
                    if($row["Data"] == "IsBranch")$this->employee["IsBranch"] = $row["Value"];
                    if($row["Data"] == "IsPayrollSales")$this->employee["IsPayrollSales"] = $row["Value"];
                }
            }

            if($this->getStatusCode() == 100)
                if(
                    !in_array($this->employee["EmployeeStatusTypeId"],array(1,2,3))
                    || (
                        in_array($this->employee["EmployeeStatusTypeId"],array(2,3))
                        && $this->employee["EmployeeStatusEndDate"] < date("Y-m-d")
                    )
                )
                    $this->setStatusCode(811);
        }
    #endregion init

    #region set status
    #endregion

    #region setting variable
        public function setLoginToken(bool $IsDebug)
        {
            if($this->getStatusCode() == 100)

            $token = hash_hmac("sha256",$this->salt, $_SESSION["key"]);

            if($this->browser["deviceTypeName"])
            {
                if(!$IsDebug)
                {
                    $SP = new StoredProcedure("uranus", "SP_Sys_Auth_UpdateFUser_TokenByUserId");
                    $SP->addParameters(["UserId" => $this->userId]);
                    $SP->addParameters(["DeviceTypeName" => $this->browser["deviceTypeName"]]);
                    $SP->addParameters(["Token" => $token]);
                    $SP->f5();
                }
                if($this->getStatusCode() == 100)
                {
                    $_SESSION[APP_NAME]["login"]["userId"] = $this->userId;
                    $_SESSION[APP_NAME]["login"]["token"] = $token;
                    $_SESSION[APP_NAME]["login"]["date"] = date("Ymd");
                    if(APP_NAME == "Plutus")$_SESSION[APP_NAME]["login"]["branchId"] = 0;
                    if($IsDebug)$_SESSION[APP_NAME]["login"]["debug"] = $IsDebug;
                }
            }
        }
        public function setBranchId(int $branchId)
        {
            if($this->getStatusCode() != 100) return null;

            if(APP_NAME == "Plutus")
            {
                $this->branchId = $branchId;
                $this->app->setBackDate($this->getBackDate());
            }
        }
        public function setLogout()
        {
            if($this->getStatusCode() != 100) return null;

            $SP = new StoredProcedure("uranus", "SP_Sys_Auth_UpdateFUser_TokenByUserId");
            $SP->addParameters(["UserId" => $this->userId]);
            $SP->addParameters(["Token" => "LOG OUT ".date("Y-m-d H:i:s")]);
            $SP->f5();

            unset($_SESSION[APP_NAME]);
        }
    #endregion setting variable

    #region getting / returning variable
        public function getEmployee()
        {
            if($this->getStatusCode() != 100) return null;
            return $this->employee;
        }
        public function getModulePages()
        {
            if($this->getStatusCode() != 100) return null;

            $this->generateModulePages();
            return $this->modulePages;
        }
        public function getIsReportAccess()
        {
            if($this->getStatusCode() != 100) return null;

            $SP = new StoredProcedure("uranus", "SP_Sys_Auth_getReportAccess");
            $SP->addParameters(["UserId" => $this->userId]);
            if(APP_NAME == "Plutus")$SP->addParameters(["BranchId" => $this->branchId]);

            $return = $SP->f5();
            $isAccess = $return[0]["Count"] ? true : false;

            return $isAccess;
        }
        public function getModuleIds()
        {
            if($this->getStatusCode() != 100) return null;

            $ModuleIds = [];
            if(!isset($this->modulePages))$this->getModulePages();

            foreach($this->modulePages AS $index => $modulePage)
            {
                if(!in_array($modulePage["ModuleId"],$ModuleIds))$ModuleIds[] = $modulePage["ModuleId"];
            }
            return $ModuleIds;
        }
        public function getPageIds()
        {
            if($this->getStatusCode() != 100) return null;

            $PageIds = [];
            if(!isset($this->modulePages))$this->getModulePages();

            foreach($this->modulePages AS $index => $modulePage)
            {
                if(!in_array($modulePage["PageId"],$PageIds))$PageIds[] = $modulePage["PageId"];
            }
            return $PageIds;
        }
        /* PLUTUS SPECIFIC */
            public function getBranch()
            {
                if($this->getStatusCode() != 100) return null;
                if(APP_NAME != "Plutus")return [];

                $all = new \app\modelAlls\UranusCompanyBranch_Detail();
                $all->addParameters(["Id" => $this->branchId]);
                $branches = $all->f5();

                return $branches[0];
            }
            public function getCreatePOSes()
            {
                if($this->getStatusCode() != 100) return null;
                if(APP_NAME != "Plutus")return [];
                if(!$this->branchId)return [];

                $SP = new StoredProcedure(APP_NAME, "SP_Sys_Auth_getAccessPOSes");
                $SP->addParameters(["UserId" => $this->userId]);
                $SP->addParameters(["BranchId" => $this->branchId]);
                $SP->addParameters(["AuthType" => 'c']);

                $POSes = [];
                foreach($SP->f5() AS $index => $row)
                {
                    $POSId = $row["POSId"];
                    $PageId = $row["PageId"];
                    $Auth = $row["Auth"];
                    if($Auth)
                    {
                        if(!isset($POSes[$PageId]))
                            $POSes[$PageId] = [];

                        $POSes[$PageId][] = $POSId;
                    }
                }
                return $POSes;
            }
            public function getReadPOSes()
            {
                if($this->getStatusCode() != 100) return null;
                if(APP_NAME != "Plutus")return [];
                if(!$this->branchId)return [];

                $SP = new StoredProcedure(APP_NAME, "SP_Sys_Auth_getAccessPOSes");
                $SP->addParameters(["UserId" => $this->userId]);
                $SP->addParameters(["BranchId" => $this->branchId]);
                $SP->addParameters(["AuthType" => 'r']);

                $POSes = [];
                foreach($SP->f5() AS $index => $row)
                {
                    $POSId = $row["POSId"];
                    $PageId = $row["PageId"];
                    $Auth = $row["Auth"];
                    if($Auth)
                    {
                        if(!isset($POSes[$PageId]))
                            $POSes[$PageId] = [];

                        $POSes[$PageId][] = $POSId;
                    }
                }
                return $POSes;
            }
            public function getUpdatePOSes()
            {
                if($this->getStatusCode() != 100) return null;
                if(APP_NAME != "Plutus")return [];
                if(!$this->branchId)return [];

                $SP = new StoredProcedure(APP_NAME, "SP_Sys_Auth_getAccessPOSes");
                $SP->addParameters(["UserId" => $this->userId]);
                $SP->addParameters(["BranchId" => $this->branchId]);
                $SP->addParameters(["AuthType" => 'u']);

                $POSes = [];
                foreach($SP->f5() AS $index => $row)
                {
                    $POSId = $row["POSId"];
                    $PageId = $row["PageId"];
                    $Auth = $row["Auth"];
                    if($Auth)
                    {
                        if(!isset($POSes[$PageId]))
                            $POSes[$PageId] = [];

                        $POSes[$PageId][] = $POSId;
                    }
                }
                return $POSes;
            }
            public function getDeletePOSes()
            {
                if($this->getStatusCode() != 100) return null;
                if(APP_NAME != "Plutus")return [];
                if(!$this->branchId)return [];

                $SP = new StoredProcedure(APP_NAME, "SP_Sys_Auth_getAccessPOSes");
                $SP->addParameters(["UserId" => $this->userId]);
                $SP->addParameters(["BranchId" => $this->branchId]);
                $SP->addParameters(["AuthType" => 'd']);

                $POSes = [];
                foreach($SP->f5() AS $index => $row)
                {
                    $POSId = $row["POSId"];
                    $PageId = $row["PageId"];
                    $Auth = $row["Auth"];
                    if($Auth)
                    {
                        if(!isset($POSes[$PageId]))
                            $POSes[$PageId] = [];

                        $POSes[$PageId][] = $POSId;
                    }
                }
                return $POSes;
            }
            public function getOtherBranches()
            {
                if($this->getStatusCode() != 100) return null;

                if(APP_NAME != "Plutus")return null;

                $SP = new \app\core\StoredProcedure(APP_NAME, "SP_Sys_Auth_getCompanyBranches");
                $SP->addParameters(["UserId" => $this->userId]);
                $SP->addParameters(["NotBranchId" => $this->branchId]);
                $rows = $SP->f5();
                $branches = [];
                foreach($rows AS $index => $row)
                {
                    //$companyId = $row["CompanyId"];
                    //$companyName = $row["CompanyName"];
                    $companyAlias = $row["CompanyAlias"];

                    $branchId = $row["BranchId"];
                    $branchName = $row["BranchName"];

                    $branches[] = ["Value" => $branchId, "Text" => "{$companyAlias} - {$branchName}"];
                }
                return $branches;
            }
            public function getBackDate()
            {
                if($this->getStatusCode() != 100) return null;

                if(APP_NAME != "Plutus")return null;

                $backDate = [];

                $SP = new StoredProcedure("uranus", "SP_Sys_Auth_getBackDate");
                $SP->addParameters(["UserId" => $this->userId]);
                $SP->addParameters(["BranchId" => $this->branchId]);
                //dd($SP->f5());

                foreach($SP->f5() AS $row)
                {
                    $backDate[$row["PageId"]][$row["POSId"]] = $row["MonthBackDate"] * 1;
                }
                return $backDate;
            }
        /* PLUTUS SPECIFIC */

        /* SELENE SPECIFIC */
            public function getCreateBranches()
            {
                if($this->getStatusCode() != 100) return null;
                if(APP_NAME != "Selene") return [];

                $SP = new StoredProcedure(APP_NAME, "SP_Sys_Auth_getAccessBranches");
                $SP->addParameters(["UserId" => $this->userId]);
                $SP->addParameters(["AuthType" => 'c']);

                $Branches = [];
                foreach($SP->f5() AS $index => $row)
                {
                    $BranchId = $row["BranchId"];
                    $PageId = $row["PageId"];
                    $Auth = $row["Auth"];

                    if($Auth) {
                        if(!isset($Branches[$PageId])) {
                            $Branches[$PageId] = [];
                        }

                        $Branches[$PageId][] = $BranchId;
                    }
                }

                return $Branches;
            }
            public function getReadBranches()
            {
                if($this->getStatusCode() != 100) return null;
                if(APP_NAME != "Selene") return [];

                $SP = new StoredProcedure(APP_NAME, "SP_Sys_Auth_getAccessBranches");
                $SP->addParameters(["UserId" => $this->userId]);
                $SP->addParameters(["AuthType" => 'r']);

                $Branches = [];
                foreach($SP->f5() AS $index => $row)
                {
                    $BranchId = $row["BranchId"];
                    $PageId = $row["PageId"];
                    $Auth = $row["Auth"];

                    if($Auth) {
                        if(!isset($Branches[$PageId])) {
                            $Branches[$PageId] = [];
                        }

                        $Branches[$PageId][] = $BranchId;
                    }
                }

                return $Branches;
            }
            public function getUpdateBranches()
            {
                if($this->getStatusCode() != 100) return null;
                if(APP_NAME != "Selene") return [];

                $SP = new StoredProcedure(APP_NAME, "SP_Sys_Auth_getAccessBranches");
                $SP->addParameters(["UserId" => $this->userId]);
                $SP->addParameters(["AuthType" => 'u']);

                $Branches = [];
                foreach($SP->f5() AS $index => $row)
                {
                    $BranchId = $row["BranchId"];
                    $PageId = $row["PageId"];
                    $Auth = $row["Auth"];

                    if($Auth) {
                        if(!isset($Branches[$PageId])) {
                            $Branches[$PageId] = [];
                        }

                        $Branches[$PageId][] = $BranchId;
                    }
                }

                return $Branches;
            }
            public function getDeleteBranches()
            {
                if($this->getStatusCode() != 100) return null;
                if(APP_NAME != "Selene") return [];

                $SP = new StoredProcedure(APP_NAME, "SP_Sys_Auth_getAccessBranches");
                $SP->addParameters(["UserId" => $this->userId]);
                $SP->addParameters(["AuthType" => 'd']);

                $Branches = [];
                foreach($SP->f5() AS $index => $row)
                {
                    $BranchId = $row["BranchId"];
                    $PageId = $row["PageId"];
                    $Auth = $row["Auth"];

                    if($Auth) {
                        if(!isset($Branches[$PageId])) {
                            $Branches[$PageId] = [];
                        }

                        $Branches[$PageId][] = $BranchId;
                    }
                }

                return $Branches;
            }
        /* SELENE SPECIFIC */
    #endregion  getting / returning variable

    #region data process
        public function validateLogin()
        {
            if($this->getStatusCode() != 100) return null;

            if(isset($_SESSION[APP_NAME]["login"]["debug"]) && $_SESSION[APP_NAME]["login"]["debug"]) return true;

            $isValid = false;

            $token = hash_hmac("sha256",$this->salt,$_SESSION["key"]);

            if($_SESSION[APP_NAME]["login"]["token"] != $token)
            {
                $this->setStatusCode(821);//Token is expired
                session_destroy();
            }
            if($this->getStatusCode() == 100)
            {
                if($this->getUserToken() == $_SESSION[APP_NAME]["login"]["token"])
                {
                    $isValid = true;
                    //$this->app->employee = $this->employee;
                }
            }
            return $isValid;
        }
        public function validateAjax()
        {
            if($this->getStatusCode() != 100) return null;

            $isValid = false;
            if(!isset($this->loginTokenHash))$this->setStatusCode(822);//Token hash is not provided
            else if(!$this->browser["deviceTypeName"])$this->setStatusCode(823);//Device Type is not recognize
            else
            {
                //dd($this->loginTokenHash);
                if(password_verify($this->getUserToken(),$this->loginTokenHash))
                    $isValid = true;
                //else $this->setStatusCode(821)//Token is expired

                return $isValid;
            }
        }
            protected function getUserToken()
            {
                if($this->getStatusCode() != 100) return null;

                $SP = new StoredProcedure("uranus", "SP_Sys_Auth_GetFUser_TokenByUserId");
                $SP->addParameters(["UserId" => $this->userId]);
                $SP->addParameters(["DeviceTypeName" => $this->browser["deviceTypeName"]]);
                $rows = $SP->f5();
                $row = $rows[0];
                return $row["Token"];
            }
        protected function generateModulePages()
        {
            if($this->getStatusCode() != 100) return null;

            $this->modulePages = [];
            $this->SPApp = new StoredProcedure(APP_NAME, "SP_Sys_Auth_generateModulePages");
            $this->SPApp->addParameters(["UserId" => $this->userId]);
            if(APP_NAME == "Plutus")$this->SPApp->addParameters(["BranchId" => $this->branchId]);
            $modulePages = $this->SPApp->f5();
            foreach($modulePages AS $index => $row)
            {
                $this->modulePages[] = $row;
            }
        }
    #endregion data process
}
