<?php
namespace app\controllers;
//use app\helpers\controllers\ControllerHelper;
use app\core\Controller;
use app\core\Request;
use app\core\Token;
use app\modelAlls\UranusUser;
use app\modelAlls\UranusUserRecord;

class PrintOutController extends Controller
{
    protected int $userId;
    protected UranusUserRecord $User;

    public function __construct()
    {
        parent::__construct();
        $this->setIsContentCore(true);

        $this->setLayout('print');
        $this->setViewFolderName('print');

        $this->userId = $_SESSION[APP_NAME]["login"]["userId"];

        $model = new UranusUser();
        $model->addParameters(["Id" => $this->userId]);
        $this->User = $model->F5()[0];
    }

    protected function tokenIsValid(string $token)
    {
        $Token = new Token($this->userId);
        return $Token->checkToken($token);
    }

    protected function getCBPProfile(array $params)
    {
        $BrandId = $params["BrandId"] ?? 0;
        $CompanyId = $params["CompanyId"] ?? 0;
        $BranchId = $params["BranchId"] ?? 0;
        $POSId = $params["POSId"] ?? 0;

        $SP = new \app\core\StoredProcedure("uranus", "SP_Sys_Print_GetCBPProfile");
        if($POSId)$SP->addParameters(["POSId" => $POSId]);
        else if($BranchId)$SP->addParameters(["BranchId" => $BranchId]);
        else if($CompanyId)$SP->addParameters(["CompanyId" => $CompanyId]);
        else if($BrandId)$SP->addParameters(["BrandId" => $BrandId]);

        return $SP->F5()[0];
    }

    public function report(Request $request)
    {
        $this->setPageTitle('Print Out');

        if(!$this->tokenIsValid($request->getGetVariable("t")))return $this->tokenExpired();

        $postVariables = $request->getPostVariables();
        $report = $this->generateReport($postVariables);

        $params = [
            'post' => $request->getPostVariables(),
            "User" => $this->User,
            "CBPProfile" => $this->getCBPProfile(["POSId" => $postVariables["POSId"]]),
            "report" => $report
        ];

        return $this->render('reportPrint',$params);
    }
        protected function generateReport($postVariables)
        {
            $report = [];

            $ReportId = $postVariables["ReportId"];
            unset($postVariables["ReportId"]);
            $postVariables["loginUserId"] = $this->userId;

            $SP = new \app\core\StoredProcedure("uranus");
            $SP->initParameter($postVariables);
            $SP->removeParameters(["CompanyName","BranchName","POSName"]);

            $reportGenerateReportFilePath = dirname(__DIR__,2)."/Core/ajax/report/process/{$ReportId}.php";

            if(file_exists($reportGenerateReportFilePath))
                require_once $reportGenerateReportFilePath;

            $report = $this->generateReportItems($ReportId, $report);

            return $report;
        }
            protected function generateReportItems($ReportId, $report)
            {
                $items = [];
                if($ReportId == 44)//Laporan Harian Bank
                {
                    foreach($report AS $summary)
                    {
                        $summary["type"] = "summary";
                        $items[] = $summary;
                        $debit = 0;
                        $credit = 0;

                        foreach($summary["Items"] AS $transaction)
                        {
                            $transaction["type"] = "transaction";
                            $items[] = $transaction;

                            $debit += $transaction["Debit"];
                            $credit += $transaction["Credit"];
                        }

                        $Total = [
                            "type" => "total",
                            "Debit" => $debit,
                            "Credit" => $credit,
                        ];
                        $items[] = $Total;

                        $NewLine = ["type" => "newLine"];
                        $items[] = $NewLine;
                    }
                }
                else $items = $report;

                return $items;
            }
}
