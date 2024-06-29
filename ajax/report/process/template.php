
<?php
$SP->renameParameter("DivisionId","Division");
$SP->renameParameter("StatusId","Status");

$SP->removeParameters(["DivisionName","StatusName"]);

$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

$SP->setReturnColumns(["ReceivedDate","ReceiveNominal","DepositDate","Aging","BrandName","CompanyName","BranchName","POSName","ReferenceNumber",
"PartnerName","HariPenerimaan","ReceivedNumber","ReceivedFromName","ReceivedByEmployeeName","DepositReferenceNumber","COA6Name"]);

//Sanitasi semua yang keluar di kendogrid
$SP->addSanitation("ReceivedDate", ["date"]);
$SP->addSanitation("ReceiveNominal", ["int"]);
$SP->addSanitation("DepositDate", ["date"]);
$SP->addSanitation("Aging", ["int"]);
$SP->addSanitation("BrandName", ["String"]);
$SP->addSanitation("CompanyName", ["String"]);
$SP->addSanitation("BranchName", ["String"]);
$SP->addSanitation("POSName", ["String"]);
$SP->addSanitation("ReferenceNumber", ["String"]);
$SP->addSanitation("PartnerName", ["String"]);
$SP->addSanitation("HariPenerimaan", ["String"]);
$SP->addSanitation("ReceivedNumber", ["String"]);
$SP->addSanitation("ReceivedFromName", ["String"]);
$SP->addSanitation("ReceivedByEmployeeName", ["String"]);
$SP->addSanitation("DepositReferenceNumber", ["String"]);
$SP->addSanitation("COA6Name", ["string"]);

$SP->execute();
$report = $SP->getRow();
