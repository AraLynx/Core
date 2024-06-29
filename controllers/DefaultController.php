<?php
namespace app\controllers;
use app\core\Controller;
use app\core\Request;

class DefaultController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setIsContentChronos(true);
    }

    public function blank()
    {
        $this->setPageTitle("Tri Mandiri Group");
        $this->setJS(["chronos"]);
        $this->setCSS(["chronos"]);
        $this->setLayout("blank");
        $this->setViewFolderName('default');
        return $this->render('home');
    }

    public function home()
    {
        $this->setPageTitle(APP_NAME);
        $this->setJS(["moduleList02"]);
        $this->setCSS(["moduleList02"]);
        return $this->render('moduleList02');
    }

    public function profile(Request $request)
    {
        $this->setPageTitle($request->getVariables["pageTitle"] ?? "Profile Page");
        $this->setJS([
            "profile_account",
            "profile_chat",
            "profile_message",
            "profile_approval",
            "profile_attendance",
            "profile_teamAttendance",
            "profile_employee",
            "profile_news_feed",
            "profile"
        ]);
        $this->setCSS(["profile"]);

        $params = [
            'breadcrumbs' => array(
                array("Profile", "profile")
            ),
            'subContent' => $request->getVariables["subContent"] ?? "account",

            //account
            'accountSettings' => $this->getAccountSettings(),

            //approval
            'approvalApprovalTypes' => $this->approvalGenerateApprovalTypes(),
            'approvalApprovalStatuses' => [
                ["*", "ALL"]
                ,["NU","NOT USED / CANCELED"]
                ,["AP","APPROVED"]
                ,["DAP","DISAPPROVED"]
                ,["ODAP","OTHER DISAPPROVED"]
                ,["WAP","WAITING APPROVAL"]
                ,["WMAP","WAITING MY APPROVAL", true]
                ,["WOAP","WAITING OTHER APPROVALS"]
            ],
        ];

        return $this->render('profile',$params);
    }
            protected function getAccountSettings()
            {
                $userId = $this->app->router->getEmployee("UserId");
                $model = new \app\modelFacts\UranusUserSetting();
                $model->addParameters(["UserId" => $userId]);
                $model->f5();
                $userSettings = $model->getUserSettings();

                $accountSettings = [];

                $audios_notifications_path = dirname(__DIR__)."/resources/audios/notifications";
                $accountSettings["notificationSound"]["selectOptions"] = [];
                //$accountSettings["notificationSound"]["selectOptions"][] = ["silent", "== silent / mute =="];
                foreach(scandir($audios_notifications_path) AS $file)
                {
                    if($file && $file != "." && $file != "..")
                    {
                        $selected = false;
                        if($userSettings["NotificationSound"] == $file)$selected = true;
                        $accountSettings["notificationSound"]["selectOptions"][] = [$file,$file,$selected];
                    }
                }

                $accountSettings["notificationVibrate"]["selectOptions"] = [];
                //$accountSettings["notificationVibrate"]["selectOptions"][] = ["0"];
                for($milisecond = 0 ; $milisecond < 1001 ; $milisecond = $milisecond+100)
                {
                    $selected = false;
                    if($userSettings["NotificationVibrate"] == $milisecond)$selected = true;
                    $accountSettings["notificationVibrate"]["selectOptions"][] = [$milisecond,$milisecond." ms",$selected];
                }

                return $accountSettings;
            }
        public function notification()
        {
            $Request = new Request();
            $Request->getVariables["subContent"] = "account";
            return $this->profile($Request);
        }
        public function chat()
        {
            $Request = new Request();
            $Request->getVariables["pageTitle"] = "Chat";
            $Request->getVariables["subContent"] = "chat";
            return $this->profile($Request);
        }
        public function message()
        {
            $Request = new Request();
            $Request->getVariables["pageTitle"] = "Message";
            $Request->getVariables["subContent"] = "message";
            return $this->profile($Request);
        }
        public function approval()
        {
            $Request = new Request();
            $Request->getVariables["pageTitle"] = "Approval";
            $Request->getVariables["subContent"] = "approval";
            return $this->profile($Request);
        }
            protected function approvalGenerateApprovalTypes()
            {
                $userId = $_SESSION[APP_NAME]["login"]["userId"];

                $model = new \app\modelAlls\UranusUser_Detail();
                $model->addParameters(["Id" => $userId]);
                $users = $model->f5();
                $user = $users[0];

                $SP = new \app\core\StoredProcedure("uranus", "SP_Sys_Approval_GetApprovalTypes");
                $SP->addParameters(["PositionId" => $user->PositionId]);
                $SP->addParameters(["UserId" => $user->Id]);
                $approvalTypes = $SP->f5();

                $Applications = [];
                $return["Applications"] = [];

                $Pages = [];
                $return["Pages"] = [];

                $ApprovalTypes = [];
                $return["ApprovalTypes"] = [];

                $ApprovalTypeSteps = [];
                $return["ApprovalTypeSteps"] = [];
                foreach($approvalTypes AS $approvalType)
                {
                    $dbName = $approvalType["DB"];
                    $pageId = $approvalType["PageId"];
                    $approvalTypeId = $approvalType["ApprovalTypeId"];
                    $approvalTypeStepId = $approvalType["ApprovalTypeStepId"];

                    $appId = $approvalType["ApplicationId"];
                    $appName = $approvalType["ApplicationName"];
                    $pageName = $approvalType["PageName"];
                    $approvalTypeName = $approvalType["ApprovalTypeName"];
                    $approvalTypeStepName = $approvalType["ApprovalTypeStepName"];

                    //APPLICATIONS
                    if(!in_array($appId, $Applications))
                    {
                        $Applications[] = $appId;
                        $Pages[$appId] = [];

                        $return["Applications"][] = ["Value" => $appId, "Text" => $appName];
                        $return["Pages"][$appId] = [];
                    }

                    //PAGES
                    $page_id = "{$dbName}_{$pageId}";
                    if(!in_array($page_id, $Pages[$appId]))
                    {
                        $Pages[$appId][] = $page_id;
                        $ApprovalTypes[$page_id] = [];

                        $return["Pages"][$appId][] = ["Value" => $page_id, "Text" => $pageName];
                        $return["ApprovalTypes"][$page_id] = [];
                    }

                    //APPROVAL TYPES
                    $approvalType_id = "{$dbName}_{$approvalTypeId}";
                    if(!in_array($approvalType_id, $ApprovalTypes[$page_id]))
                    {
                        $ApprovalTypes[$page_id][] = $approvalType_id;
                        $ApprovalTypeSteps[$approvalType_id] = [];

                        $return["ApprovalTypes"][$page_id][] = ["Value" => $approvalType_id, "Text" => $approvalTypeName];
                        $return["ApprovalTypeSteps"][$approvalType_id] = [];
                    }

                    //APPROVAL TYPE STEPS
                    $approvalTypeStep_id = "{$dbName}_{$approvalTypeStepId}";
                    if(!in_array($approvalTypeStep_id, $ApprovalTypeSteps[$approvalType_id]))
                    {
                        $ApprovalTypeSteps[$approvalType_id][] = $approvalTypeStep_id;

                        $return["ApprovalTypeSteps"][$approvalType_id][] = ["Value" => $approvalTypeStep_id, "Text" => $approvalTypeStepName];
                    }
                }

                if(count($return["Applications"]) > 1)
                    array_unshift($return["Applications"], ["*", "ALL", true]);

                foreach($return["Pages"] AS $key => $page)
                {
                    if(count($return["Pages"][$key]) > 1)
                        array_unshift($return["Pages"][$key], ["*", "ALL", true]);
                }
                foreach($return["ApprovalTypes"] AS $key => $approvalTypes)
                {
                    if(count($return["ApprovalTypes"][$key]) > 1)
                        array_unshift($return["ApprovalTypes"][$key], ["*", "ALL", true]);
                }
                foreach($return["ApprovalTypeSteps"] AS $key => $approvalTypeSteps)
                {
                    if(count($return["ApprovalTypeSteps"][$key]) > 1)
                        array_unshift($return["ApprovalTypeSteps"][$key], ["*", "ALL", true]);
                }

                return $return;
            }
        public function attendance()
        {
            $Request = new Request();
            $Request->getVariables["pageTitle"] = "Attendace";
            $Request->getVariables["subContent"] = "attendance";
            return $this->profile($Request);
        }
        public function employee()
        {
            $Request = new Request();
            $Request->getVariables["pageTitle"] = "Employee";
            $Request->getVariables["subContent"] = "employee";
            return $this->profile($Request);
        }
        public function news()
        {
            $Request = new Request();
            $Request->getVariables["pageTitle"] = "news";
            $Request->getVariables["subContent"] = "news";
            return $this->profile($Request);
        }

    public function appAccess(Request $request)
    {
        $this->setPageTitle('Access');
        $this->setJS(["appAccess"]);
        //$this->setCSS(["appAccess"]);

        //ALL MODULE LIST
        $model = new \payroll\modelAlls\PayrollModulePage();
        $model->addParameters(["ModuleIsEnable" => 1, "PageIsEnable" => 1]);
        //echo $model->getQuery();
        $modulePages = $model->f5();

        $params = [
            'breadcrumbs' => array(
                array("Configuration", "config"),
                array("Access", "config/access")
            ),
            'subContent' => $request->getVariables["subContent"] ?? "access",
            "modulePages" => $modulePages,
        ];

        return $this->render('appAccess',$params);
    }

    public function report(Request $request)
    {
        $this->setPageTitle('Report');
        $this->setJS(["report"]);

        $params = [
            'breadcrumbs' => array(
                array("Report", "report")
            ),
            'selectOptions' => $this->reportGetSelectOptions(),
        ];

        return $this->render('report',$params);
    }
        protected function reportGetSelectOptions()
        {
            $userId = $this->app->router->getEmployee("UserId");

            $SP = new \app\core\StoredProcedure("uranus", "SP_Sys_Report_GetReports");
            $SP->addParameters(["UserId" => $userId]);
            if(APP_NAME == "Plutus")$SP->addParameters(["BranchId" => $_SESSION[APP_NAME]["login"]["branchId"]]);
            $results = $SP->f5();

            $reportIds = [];

            $departments = [];
            $reportGroups = [];
            $repots = [];
            $companies = [];
            $branches = [];
            $poses = [];

            $branchBrandIds = [];

            $vehicleGroups = [];
            $vehicleTypes = [];

            foreach($results[0] AS $result)//DEPARTMENT
            {
                $departments[] = [$result["DepartmentId"], $result["DepartmentName"]];
            }

            foreach($results[1] AS $result)//REPORT GROUP
            {
                $key = $result["DepartmentId"];
                if(!isset($reportGroups[$key]))$reportGroups[$key] = [];
                $reportGroups[$key][] = $result["GroupName"];
            }

            foreach($results[2] AS $result)//REPORT
            {
                $key = "{$result["DepartmentId"]}_{$result["GroupName"]}";
                if(!isset($repots[$key]))$repots[$key] = [];
                $repots[$key][] = [$result["ReportId"], $result["ReportName"]];

                $reportIds[] = $result["ReportId"];
            }

            foreach($results[3] AS $result)//COMPANY
            {
                $key = $result["ReportId"];
                if(!isset($companies[$key]))$companies[$key] = [/*["*","ALL"]*/];
                $companies[$key][] = [$result["CompanyId"], $result["CompanyName"]];
            }
            //foreach($companies AS $key => $list)if(count($list) == 2)array_shift($companies[$key]);//REMOVE ALL KALAU LIST CUMA 1 COMPANY

            foreach($results[4] AS $result)//BRANCH
            {
                //$branches["*"] = [["*","ALL"]];

                $key = "{$result["ReportId"]}_{$result["CompanyId"]}";
                if(!isset($branches[$key]))$branches[$key] = [["*","ALL"]];
                $branches[$key][] = [$result["BranchId"], $result["BranchName"]];

                $branchBrandIds[$result["BranchId"]] = $result["BrandId"];
            }
            foreach($branches AS $key => $list)if(count($list) == 2)array_shift($branches[$key]);//REMOVE ALL KALAU LIST CUMA 1 BRANCH

            foreach($results[5] AS $result)//POS
            {
                $poses["*"] = [["*","ALL"]];

                $key = "{$result["ReportId"]}_{$result["CompanyId"]}_{$result["BranchId"]}";
                if(!isset($poses[$key]))$poses[$key] = [["*","ALL"]];
                $poses[$key][] = [$result["POSId"], $result["POSName"]];
            }
            foreach($poses AS $key => $list)if(count($list) == 2)array_shift($poses[$key]);//REMOVE ALL KALAU LIST CUMA 1 POS

            $GroupIds = [];
            foreach($results[6] AS $result)//VEHICLE GROUP & TYPES
            {
                $BrandId = $result["BrandId"];
                $GroupId = $result["GroupId"];
                $GroupName = $result["GroupName"];
                $TypeId = $result["TypeId"];
                $TypeName = $result["TypeName"];

                if(!isset($vehicleGroups[$BrandId]))$vehicleGroups[$BrandId] = [["*","ALL"]];
                if(!in_array($GroupId,$GroupIds))
                {
                    $GroupIds[] = $GroupId;
                    $vehicleGroups[$BrandId][] = [$GroupId,$GroupName];
                }

                if(!isset($vehicleTypes[$GroupId]))$vehicleTypes[$GroupId] = [["*","ALL"]];
                $vehicleTypes[$GroupId][] = [$TypeId,$TypeName];
            }
            foreach($branches AS $key => $list)if(count($list) == 2)array_shift($branches[$key]);//REMOVE ALL KALAU LIST CUMA 1 BRANCH

            $return["ReportIds"] = $reportIds;

            $return["Departments"] = $departments;
            $return["ReportGroups"] = $reportGroups;
            $return["Reports"] = $repots;
            $return["Companies"] = $companies;
            $return["Branches"] = $branches;
            $return["POSes"] = $poses;

            $return["BranchBrandIds"] = $branchBrandIds;

            $return["VehicleGroups"] = $vehicleGroups;
            $return["VehicleTypes"] = $vehicleTypes;

            if(in_array(10,$reportIds))$return["_10_Statuses"] = $this->reportGetSelectHardCodeOptions(10);
            if(in_array(21,$reportIds))$return["_21_ReferenceTypeIds"] = $this->reportGetSelectHardCodeOptions(21);
            if(in_array(22,$reportIds)){
                $return["_22_DivisionIds"] = $this->reportGetSelectHardCodeOptions(22, "DivisionIds");
                $return["_22_Statuses"] = $this->reportGetSelectHardCodeOptions(22, "Statuses");
            }
            if(in_array(23,$reportIds)){
                $return["_23_Types"] = $this->reportGetSelectHardCodeOptions(23, "Types");
                $return["_23_Statuses"] = $this->reportGetSelectHardCodeOptions(23, "Statuses");
            }
            if(in_array(24,$reportIds)){
                $return["_24_DateTypes"] = $this->reportGetSelectHardCodeOptions(24, "DateTypes");
                $return["_24_NumberTypes"] = $this->reportGetSelectHardCodeOptions(24, "NumberTypes");
                $return["_24_FromTypes"] = $this->reportGetSelectHardCodeOptions(24, "romTypes");
                $return["_24_ReferenceTypeIds"] = $this->reportGetSelectHardCodeOptions(24, "ReferenceTypeIds");
                $return["_24_MethodIds"] = $this->reportGetSelectHardCodeOptions(24, "MethodIds");
            }
            if(in_array(25,$reportIds)){
                $return["_25_LocationPartnerTypeIds"] = $this->reportGetSelectHardCodeOptions(25, "LocationPartnerTypeIds");
                $return["_25_Statuses"] = $this->reportGetSelectHardCodeOptions(25, "Statuses");
            }
            if(in_array(26,$reportIds))$return["_26_Statuses"] = $this->reportGetSelectHardCodeOptions(26);
            if(in_array(27,$reportIds)){
                $return["_27_UnitYears"] = $this->reportGetSelectHardCodeOptions(27, "UnitYears");
                $return["_27_SalesMethods"] = $this->reportGetSelectHardCodeOptions(27, "SalesMethods");
            }
            if(in_array(28,$reportIds)){
                $return["_28_Statuses"] = $this->reportGetSelectHardCodeOptions(28, "Statuses");
                $return["_28_DateTypes"] = $this->reportGetSelectHardCodeOptions(28, "DateTypes");
                $return["_28_NumberTypes"] = $this->reportGetSelectHardCodeOptions(28, "NumberTypes");
                $return["_28_EmployeeTypes"] = $this->reportGetSelectHardCodeOptions(28, "EmployeeTypes");
                $return["_28_CustomerTypes"] = $this->reportGetSelectHardCodeOptions(28, "CustomerTypes");
            }
            if(in_array(29,$reportIds)){
                $return["_29_UnitYears"] = $this->reportGetSelectHardCodeOptions(29, "UnitYears");
                $return["_29_Statuses"] = $this->reportGetSelectHardCodeOptions(29, "Statuses");
            }
            if(in_array(30,$reportIds))$return["_30_Fields"] = $this->reportGetSelectHardCodeOptions(30);
            if(in_array(36,$reportIds))$return["_36_UnitFilter"] = $this->reportGetSelectHardCodeOptions(36);
            if(in_array(38,$reportIds))$return["_38_Statuses"] = $this->reportGetSelectHardCodeOptions(38);
            if(in_array(42,$reportIds))$return["_42_DateTypes"] = $this->reportGetSelectHardCodeOptions(42);

            return $return;
        }
        protected function reportGetSelectHardCodeOptions(int $reportId, string $type = NULL)
        {
            $options = [];
            if($reportId == 10)
            {
                $options = [
                    ["*","Semua"]
                    ,["stock", "Stok"]
                        ,["do", "- Stok (Upload DO)"]
                        ,["intransit", "- Stok (Intransit)"]
                        ,["onhand", "- Stok (On Hand)", true]

                    ,["free", "Free"]

                    ,["booked", "Booked"]
                        ,["bookedspk", "- Booked (SPK)"]
                        ,["bookedac", "- Booked (Antar Cabang)"]
                        ,["bookeduac", "-- Booked (Antar Cabang - UAC)"]
                        ,["bookedukac", "-- Booked (Antar Cabang - UKAC)"]

                    ,["sold", "Terjual"]
                    ,["soldspk", "- Terjual (SPK)"]
                        ,["soldac", "- Terjual (Antar Cabang)"]
                        ,["solduac", "-- Terjual (Antar Cabang - UAC)"]
                        ,["soldukac", "-- Terjual (Antar Cabang- UKAC)"]
                        ,["soldaccurate", "- Terjual (Accurate)"]
                ];
            }
            if($reportId == 21)
            {
                $options = [
                    ["*", "ALL", true],
                    ["6", "PKB"],
                    ["7", "DS"],
                    ["30", "PS"],
                ];
            }
            if($reportId == 22)
            {
                if($type == "DivisionIds")
                {
                    $options = [
                        ["*", "ALL", true]
                        ,["SH", "SHOWROOM"]
                        ,["WS", "WORKSHOP"]
                        ,["PKB", "> WS PKB"]
                        ,["DS", "> WS DS"]
                        ,["PS", "> WS PS"]
                    ];
                }
                if($type == "Statuses")
                {
                    $options = [
                        ["*", "ALL", true]
                        ,["BS", "BELUM SETOR"]
                        ,["SS", "SUDAH SETOR"]
                    ];
                }
            }
            if($reportId == 23)
            {
                if($type == "Types")
                {
                    $options = [
                        ['CLAIM', 'Claim Date', true],
                        ['NOTA', 'Nota Date'],
                    ];
                }
                if($type == "Statuses")
                {
                    $options = [
                        ['*', 'ALL', true],
                        [1, 'SUDAH LUNAS'],
                        [2, 'BELUM LUNAS'],
                    ];
                }
            }
            if($reportId == 24)
            {
                if($type == "DateTypes")
                {
                    $options = [
                        ["1" , "Document Date", true],
                        ["2" , "Journal Date"],
                    ];
                }
                if($type == "NumberTypes")
                {
                    $options = [
                        ["1" , "Print Number", true],
                        ["2" , "Document Number"],
                        ["3" , "Reference Number"],
                    ];
                }
                if($type == "FromTypes")
                {
                    $options = [
                        ["1" , "Customer Name", true],
                        ["2" , "Depositor"],
                    ];
                }
                if($type == "ReferenceTypeIds")
                {
                    $options = [
                        ["*" , "ALL", true],
                        ["44" , "SHOWROOM"],
                        ["6" , "BENGKEL"],
                        ["7" , "DIRECT SALES"],
                        ["30" , "PART SHOP"],
                    ];
                }
                if($type == "MethodIds")
                {
                    $options = [
                        ["*" , "ALL", true],
                        ["CSH" , "CASH"],
                        ["TRF" , "TRANSFER"],
                    ];
                }
            }
            if($reportId == 25)
            {
                if($type == "LocationPartnerTypeIds")
                {
                    $options = [
                        ["*", "ALL",true],
                        ["3", "SHOWROOM"],
                        ["4", "WAREHOUSE"]
                    ];
                }
                if($type == "Statuses")
                {
                    $options = [
                        ["*", "ALL",true],
                        ["0", "STOCK"],
                        ["1", "SOLD"],
                    ];
                }
            }
            if($reportId == 26)
            {
                $options = [
                    ["*" , "ALL", true],
                    ["0" , "STOCK"],
                    ["1" , "SOLD"]
                ];
            }
            if($reportId == 27)
            {
                if($type == "UnitYears")
                {
                    $options = ["*", "ALL"];
                    for($year = date("Y") ; $year >= 2000 ; $year--)
                    {
                        $options[] = $year;
                    };
                }
                if($type == "SalesMethods")
                {
                    $options = [
                        ["*", "ALL"],
                        ["IsCash", "CASH"],
                        ["IsCredit", "CREDIT"],
                    ];
                }
            }
            if($reportId == 28)
            {
                if($type == "Statuses")
                {
                    $options = [
                        ["*","ALL",true],
                        ["INVOICE","INVOICE"],
                        ["CLOSE","CLOSE"],
                        ["PROCESS","PROCESS"],
                        ["MISSING TTUM","MISSING TTUM"],
                        ["BLANK","BLANK"],
                        ["CANCEL","CANCEL"],
                        ["RETUR","RETUR SPK"],
                        ["NOT USED","NOT USED"],
                        ["EPC", "MISSING TTUM + PROCESS + CLOSE"],
                    ];
                }
                if($type == "DateTypes")
                {
                    $options = [
                        ["REGISTER", "Register Date",true],
                        ["DISTRIBUTION", "Distribution Date"],
                        ["TTUM", "SPK Date"],
                        ["INVOICE", "Invoice Date"],
                    ];
                }
                if($type == "NumberTypes")
                {
                    $options = [
                        ["SPKNumber","SPK Number",true],
                        ["InvoiceNumber","Invoice Number"],
                    ];
                }
                if($type == "EmployeeTypes")
                {
                    $options = [
                        ["TeamLeaderName","Team Leader Name",true],
                        ["SalesName", "Sales Name"],
                    ];
                }
                if($type == "CustomerTypes")
                {
                    $options = [
                        ["CustomerName", "Customer Name",true],
                        ["STNKName","STNK Name"],
                    ];
                }
            }
            if($reportId == 29)
            {
                if($type == "UnitYears")
                {
                    $options[] = ["*", "ALL", true];
                    for($year = date("Y"); $year >= 2000 ; $year--)
                    {
                        $options[] = $year;
                    }
                }
                if($type == "Statuses")
                {
                    $options = [
                        ["*", "ALL", true],
                        ["ONHAND", "ON HAND"],
                        ["INTRANSIT", "INTRANSIT"],
                        ["UPLOADDO", "UPLOAD DO"],
                        ["BOOKED_SPK", "BOOKED SPK"],
                        ["BOOKED_UAC", "BOOKED UAC"],
                        ["BOOKED_UKAC", "BOOKED UKAC"],
                    ];
                }
            }
            if($reportId == 30)
            {
                $options = [
                    ["InvoiceNumber", "No DO / No Invoice"],
                    ["EngineNumber", "No Mesin"],
                    ["VIN", "No Rangka / No Chasis"],
                ];
            }
            if($reportId == 36)
            {
                $options = [
                    ["EngineNumber", "Engine Number", TRUE],
                    ["VIN", "VIN"],
                ];
            }
            if($reportId == 38)
            {
                $options = [
                    ['*', 'ALL'],
                    ['ACTIVE', '-ACTIVE', TRUE],
                    ['OS', '---OUTSTANDING'],
                    ['RL', '---RELEASE'],
                        ['RL AP/AAP','------RELEASE APPROVED / AUTO APPROVED'],
                        ['RL DAP', '------RELEASE DISAPPROVE'],
                        ['RL WAP', '------RELEASE WAITING APPROVE'],
                    ['CO', '---COMPLETE'],
                    ['NU', '-NOT ACTIVE/ NOT USED'],
                ];
            }
            if($reportId == 42)
            {
                $options = [
                    ["SPKCompleteDate", "Tgl. Nota", true],
                    ["LoanPaymentDate", "Tgl. Pelunasan"],
                ];
            }
            return $options;
        }
}
