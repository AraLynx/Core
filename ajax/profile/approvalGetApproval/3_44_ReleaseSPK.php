<?php
namespace app\core;

require_once dirname(__DIR__,3)."/functions/numeric.php";

$SP = new StoredProcedure("uranus");
$SP->addParameters(["RId1" => $RId1, "RId2" => $RId2, "RId3" => $RId3]);
$q = "EXEC [SP_Sys_Approval_{$subSPName}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

$SP->addSanitation("IsCash",["int"]);
$SP->addSanitation("IsCredit",["int"]);
$SP->addSanitation("IsCashPO",["int"]);
$SP->addSanitation("IsLeasing",["int"]);

$SP->addSanitation("UnitPrice",["int"]);
$SP->addSanitation("CaroseriePrice",["int"]);
$SP->addSanitation("CostBBNNoticePrice",["int"]);
$SP->addSanitation("CostBBNUnNoticePrice",["int"]);
$SP->addSanitation("CostBBNPrice",["int"]);
$SP->addSanitation("CostDiscount",["int"]);
$SP->addSanitation("OTRPrice",["int"]);
$SP->addSanitation("CostDPSubsidy",["int"]);

$SP->addSanitation("LeasingTDP",["int"]);
$SP->addSanitation("TotalCash",["int"]);
$SP->addSanitation("TMSTDP",["int"]);

$SP->addSanitation("CustomerDeposit",["int"]);

$SP->execute();
$SPK = $SP->getRow()[0];
$SPK["SPK"] = "{$SPK["NumberText"]} | {$SPK["CompanyAlias"]} {$SPK["BranchAlias"]} - {$SPK["POSName"]}";
$SPK["Customer"] = "{$SPK["CustomerTitleName"]} {$SPK["CustomerName"]}".($SPK["CustomerName"] != $SPK["STNKCustomerName"] ? " A/N STNK {$SPK["STNKCustomerTitle"]} {$SPK["STNKCustomerName"]}" : "");
$SPK["Vehicle"] = "{$SPK["VehicleGroupName"]} {$SPK["VehicleTypeName"]}";
if($SPK["CaroserieId"]) $SPK["Vehicle"] .= " + {$SPK["CaroserieModel"]}";
$SPK["Unit"] = "{$SPK["UnitEngineNumber"]} | {$SPK["UnitVIN"]} | {$SPK["UnitColor"]} | {$SPK["UnitYear"]}";
$SalesNames = [];
    $Salesman = [];
    if($SPK["SalesmanEmployeeName"] != "OFFICE")$Salesman[] = "{$SPK["SalesmanEmployeeName"]}";
    if($SPK["SalesmanEmployeeGroupName"] && $SPK["SalesmanEmployeeGroupName"] != "-")$Salesman[] = "({$SPK["SalesmanEmployeeGroupName"]})";
if(count($Salesman))$SalesNames[] = implode(" ",$Salesman);
    $TeamLeader = [];
    if($SPK["TeamLeaderEmployeeName"] != "OFFICE")$TeamLeader[] = "{$SPK["TeamLeaderEmployeeName"]}";
    if($SPK["TeamLeaderEmployeeGroupName"] && $SPK["TeamLeaderEmployeeGroupName"] != "-")$TeamLeader[] = "({$SPK["TeamLeaderEmployeeGroupName"]})";
if(count($TeamLeader))$SalesNames[] = implode(" ",$TeamLeader);
$SPK["Sales"] = implode(" & ",$SalesNames);

$SPK["OTR"] = generatePrice($SPK["OTRPrice"]);
if($SPK["CostDiscount"])$SPK["OTR"] .= " (inc. disc. ".generatePrice($SPK["CostDiscount"]).")";

$SPK["Transaction"] = ($SPK["IsCashPO"] ? "CASH PO " : "").($SPK["IsCash"] ? "TUNAI" : "KREDIT");
if($SPK["IsCredit"])
{
    $SPK["Transaction"] .= " via {$SPK["LeasingVendorName"]}";
    $SPK["Transaction"] .= " ; TDP ".generatePrice($SPK["LeasingTDP"]);
}
if($SPK["CostDPSubsidy"])$SPK["Transaction"] .= " ; SUBSIDI DP ".generatePrice($SPK["CostDPSubsidy"]);

if($SPK["IsCash"])
{
    $SPK["AR"] = "KONSUMEN ".generatePrice($SPK["TotalCash"]);
    $PaymentPercentage = ($SPK["CustomerDeposit"] ? generatePercent($SPK["CustomerDeposit"], $SPK["TotalCash"]) : "0.00%");
}
if($SPK["IsCredit"])
{
    $ARLeasing = $SPK["OTRPrice"] - $SPK["LeasingTDP"];
    $SPK["AR"] = "KONSUMEN ".generatePrice($SPK["TMSTDP"])." ; LEASING ".generatePrice($ARLeasing);
    $PaymentPercentage = ($SPK["CustomerDeposit"] ? generatePercent($SPK["CustomerDeposit"], $SPK["TMSTDP"]) : "0.00%");
}
$SPK["Payment"] = generatePrice($SPK["CustomerDeposit"])." ({$PaymentPercentage})";
$datas["SPK"] = $SPK;

//========================================================================================================================================
$SP->addSanitation("Nominal",["int"]);
$SP->nextRowset();
$CustomerDeposits = $SP->getRow();
$datas["CustomerDeposits"] = [];
foreach($CustomerDeposits AS $CustomerDeposit)
{
    $CustomerDeposit["Code"] = "<p class='center underline' title='{$CustomerDeposit["Type"]}'>{$CustomerDeposit["Code"]}</p>";
    $CustomerDeposit["Nominal"] = "<p class='right'>{$CustomerDeposit["Nominal"]}</p>";
    $datas["customerDeposits"][] = $CustomerDeposit;
}

//========================================================================================================================================
//$SP->addSanitation("outputColumn",["string"]);
$SP->nextRowset();
$datas["SPKCosts"]= $SP->getRow();

//========================================================================================================================================
//$SP->addSanitation("outputColumn",["string"]);
$SP->nextRowset();
$datas["SPKAccessorys"]= $SP->getRow();
