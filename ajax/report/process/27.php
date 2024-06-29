<?php
$models = new \app\modelAlls\PlutusSPK();

$models->initParameter($ajax->getPost());
$models->removeParameters(["loginUserId"]);

$models->removeParameters(["DepartmentId","ReportGroup","CompanyName","BranchName","POSName"]);
$models->removeParameters(["VehicleGroupName","VehicleTypeName","SalesMethod"]);

if($ajax->getPost("SalesMethod") && $ajax->getPost("SalesMethod") != "*")
{
    $SalesMethod = $ajax->getPost("SalesMethod");
    $models->addParameter($SalesMethod, 1);
}
$models->addParameter("IsEnable", 1);
$models->addParameter("IsRelease", 1);
$models->addParameter("IsComplete", 1);
$models->addParameter("IsCancel", 0);
$models->addParameter("IsInvoice", 1);

$models->addSanitation("CompleteDateTime", ["date"]);
$models->setNoClassRecord(true);

$models->setReturnColumns([
    "CompleteDateTime","POSName","NumberText"
    ,"SalesMethod"
    ,"LeasingVendorName"
    ,"CustomerName"
    ,"VehicleGroupName","VehicleTypeName","UnitEngineNumber"
    ,"VehiclePoliceNumber","VehicleVIN","VehicleEngineNumber"
    ,"OTRPrice"
    ,"TeamLeaderEmployeeId", "TeamLeaderEmployeeName","TeamLeaderEmployeeGroupName"
]);

//$data = $models->getQuery();
$report = $models->f5();
