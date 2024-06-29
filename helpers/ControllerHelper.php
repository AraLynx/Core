<?php
namespace app\helpers\controllers;
use app\core\Request;

class ControllerHelper
{
    protected Request $request;
    protected int $moduleId ;
    protected int $pageId ;
    protected string $methodName ;
    protected string $folderName ;
    protected string $pageTitle ;
    protected array $breadcrumbs;
    public function __construct(int $moduleId)
    {
        $this->setModuleId($moduleId);

        $this->init();
    }

#region init
    public function init(){
        if(APP_NAME == "Gaia")
        {
            //if($this->moduleId == 1){$this->breadcrumbs[] = ["General", "universal"];}
            if($this->moduleId == 2){$this->breadcrumbs[] = ["Accounting", "accounting"];}
            if($this->moduleId == 3){$this->breadcrumbs[] = ["IT", "it"];}
            if($this->moduleId == 4){$this->breadcrumbs[] = ["HRD", "hrd"];}
            if($this->moduleId == 5){$this->breadcrumbs[] = ["GA", "ga"];}
            if($this->moduleId == 6){$this->breadcrumbs[] = ["After Sales", "aftersales"];}
            if($this->moduleId == 7){$this->breadcrumbs[] = ["Finance", "finance"];}
            if($this->moduleId == 8){$this->breadcrumbs[] = ["Sales", "sales"];}
            if($this->moduleId == 9){$this->breadcrumbs[] = ["Legal", "legal"];}
            if($this->moduleId == 10){$this->breadcrumbs[] = ["Admin Operation", "admin"];}
            if($this->moduleId == 11){$this->breadcrumbs[] = ["Marketing Support", "msupport"];}
            if($this->moduleId == 12){$this->breadcrumbs[] = ["Tax", "tax"];}
            if($this->moduleId == 13){$this->breadcrumbs[] = ["Audit", "audit"];}
        }
        if(APP_NAME == "Selene")
        {
        }
        if(APP_NAME == "Plutus")
        {
            if($this->moduleId == 1){$this->breadcrumbs[] = ["Showroom", "showroom"];}
            if($this->moduleId == 2){$this->breadcrumbs[] = ["Workshop", "workshop"];}
            if($this->moduleId == 3){$this->breadcrumbs[] = ["Sparepart", "sparepart"];}
            if($this->moduleId == 4){$this->breadcrumbs[] = ["Finance", "finance"];}
        }
        if(APP_NAME == "Hephaestus")
        {
            if($this->moduleId == 2){$this->breadcrumbs[] = ["Accounting", "accounting"];}
            if($this->moduleId == 3){$this->breadcrumbs[] = ["IT", "it"];}
            if($this->moduleId == 4){$this->breadcrumbs[] = ["HRD", "hrd"];}
            if($this->moduleId == 5){$this->breadcrumbs[] = ["GA", "ga"];}
            if($this->moduleId == 6){$this->breadcrumbs[] = ["After Sales", "aftersales"];}
            if($this->moduleId == 7){$this->breadcrumbs[] = ["Finance", "finance"];}
            if($this->moduleId == 8){$this->breadcrumbs[] = ["Sales", "sales"];}
            if($this->moduleId == 9){$this->breadcrumbs[] = ["Legal", "legal"];}
            if($this->moduleId == 10){$this->breadcrumbs[] = ["Admin Operation", "admin"];}
            if($this->moduleId == 11){$this->breadcrumbs[] = ["Marketing Support", "msupport"];}
            if($this->moduleId == 12){$this->breadcrumbs[] = ["Tax", "tax"];}
            if($this->moduleId == 13){$this->breadcrumbs[] = ["Audit", "audit"];}
        }
    }
#endregion init

#region set status
#endregion

#region setting variable
    public function setModuleId(int $moduleId)
    {
        $this->moduleId = $moduleId;
    }
    public function setPageId(int $pageId)
    {
        $this->pageId = $pageId;
    }
    public function setMethodName(string $methodName)
    {
        $this->methodName = $methodName;
    }
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }
    public function setPageTitle(string $pageTitle)
    {
        $this->pageTitle = $pageTitle;
    }
    public function setViewFolderName(string $folderName)
    {
        $this->folderName = $folderName;
    }
#endregion setting variable

#region getting / returning variable
    public function getFirstBreadcrumbs()
    {
        return $this->breadcrumbs[0];
    }
    public function getControllerSettings()
    {
        $callBack = "getControllerSettings_{$this->methodName}";
        return $this->$callBack();
    }
    #region reportAccess
    protected function getControllerSettings_reportAccess()
    {
        $callbacks = [];
        $callbacks[] = ["setViewFolderName","all"];
        $callbacks[] = ["setPageTitle","Report Access"];
        $callbacks[] = ["setJS",["reportAccess_20240105"]];

        $this->breadcrumbs[] = ["Report Access","{$this->getFirstBreadcrumbs()[1]}/reportaccess"];

        $params = [
            "breadcrumbs" => $this->breadcrumbs,
            "subContent" => "userReportAccess",
            "moduleId" => $this->moduleId,
            "pageId"=> $this->pageId,
            "CBPs" => $this->reportAccessGetCBPs(),
            "reports" => $this->reportAccessGetReports(),
        ];

        return [
            "controllerCallbacks" => $callbacks,
            "renderParams" => $params,
        ];
    }
        protected function reportAccessGetCBPs()
        {
            $userId = $_SESSION[APP_NAME]["login"]["userId"];
            $SP = new \app\core\StoredProcedure(APP_NAME, "SP_1_7_getCBPs");
            if(in_array($this->pageId,[196,195]))
            {
                $SP->addParameters(["UserId" => $userId]);
            }
            $result = $SP->f5();
            $CBPs = [];
            foreach($result AS $CBP)
            {
                $CompanyId = $CBP["CompanyId"];
                $CompanyAlias = $CBP["CompanyAlias"];
                $BranchId = $CBP["BranchId"];
                $BranchName = $CBP["BranchName"];
                $POSId = $CBP["POSId"];
                $POSName = $CBP["POSName"];

                if(!isset($CBPs[$CompanyId]))
                {
                    $CBPs[$CompanyId] = [
                        "Id" => $CompanyId,
                        "Name" => $CompanyAlias,
                        "Branches" => [],
                    ];
                }
                if(!isset($CBPs[$CompanyId]["Branches"][$BranchId]))
                {
                    $CBPs[$CompanyId]["Branches"][$BranchId] = [
                        "Id" => $BranchId,
                        "Name" => $BranchName,
                        "POSes" => [],
                    ];
                }
                $CBPs[$CompanyId]["Branches"][$BranchId]["POSes"][$POSId] = [
                    "Id" => $POSId,
                    "Name" => $POSName,
                ];
            }

            return $CBPs;
        }
        protected function reportAccessGetReports()
        {
            $SP = new \app\core\StoredProcedure(APP_NAME, "SP_1_7_getReports");
            $SP->addParameters(["ModuleId" => $this->moduleId]);
            $result = $SP->f5();
            $Reports = [];
            foreach($result AS $report)
            {
                $SP = new \app\core\StoredProcedure(APP_NAME, "SP_1_7_getReports");
                $SP->addParameters(["ModuleId" => $this->moduleId]);
                $result = $SP->f5();
                $Reports = [];
                foreach($result AS $report)
                {
                    $Id = $report["Id"];
                    $Group = $report["Group"];
                    $ReportName = $report["Name"];
                    if(!isset($Reports[$Group]))
                    {
                        $Reports[$Group] = [];
                    }
                    $Reports[$Group][$Id] = $ReportName;
                }

                return $Reports;
            }

            return $Reports;
        }
    #endregion reportAccess

    #region gaiaUser
        protected function getControllerSettings_gaiaUser()
        {
            $callbacks = [];
            $callbacks[] = ["setViewFolderName","all"];
            $callbacks[] = ["setPageTitle","Gaia User"];
            $callbacks[] = ["setJS",["gaiaUser"]];

            $this->breadcrumbs[] = ["Gaia User","{$this->getFirstBreadcrumbs()[1]}/gaiauser"];

            $params = [
                'subContent' => $this->request->getVariables["subContent"] ?? "user",
                'moduleId' => $this->moduleId,
            ];

            return [
                "controllerCallbacks" => $callbacks,
                "renderParams" => $params,
            ];
        }
    #endregion gaiaUser

    #region seleneUser
        protected function getControllerSettings_seleneUser()
        {
            $callbacks = [];
            $callbacks[] = ["setViewFolderName","all"];
            $callbacks[] = ["setPageTitle","Selene User"];
            $callbacks[] = ["setJS",["seleneUser"]];

            $this->breadcrumbs[] = ["Selene User","{$this->getFirstBreadcrumbs()[1]}/seleneuser"];

            $params = [
                'subContent' => $this->request->getVariables["subContent"] ?? "user",
                'moduleId' => $this->moduleId,
                'seleneModuleIds' => [7],
                "isBrand" => true,
            ];

            return [
                "controllerCallbacks" => $callbacks,
                "renderParams" => $params,
            ];
        }
    #endregion seleneUser

    #region plutusUser
        protected function getControllerSettings_plutusUser()
        {
            $callbacks = [];
            $callbacks[] = ["setViewFolderName","all"];
            $callbacks[] = ["setPageTitle","Plutus User"];
            $callbacks[] = ["setJS",["plutusUser"]];

            $this->breadcrumbs[] = ["Plutus User","{$this->getFirstBreadcrumbs()[1]}/plutususer"];

            $params = [
                'subContent' => $this->request->getVariables["subContent"] ?? "user",
                'moduleId' => $this->moduleId,
                'plutusModuleIds' => [2,3],
                'selectCBPIsWSIsSH' => "selectCBPIsWS",
                "isBrand" => true,
            ];

            return [
                "controllerCallbacks" => $callbacks,
                "renderParams" => $params,
            ];
        }
    #endregion plutusUser
#endregion  getting / returning variable

#region data process
#endregion data process
}
