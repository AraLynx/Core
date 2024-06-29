<?php
namespace app\core;

require_once dirname(__DIR__,3)."/functions/numeric.php";

$SP = new StoredProcedure("uranus");
$SP->addParameters(["RId1" => $RId1]);
$q = "EXEC [SP_Sys_Approval_{$subSPName}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

//$SP->addSanitation("ReferenceId1",["int"]);
$SP->execute();
$row = $SP->getRow()[0];
$PKB["PKBDate"] = $row["PKBDate"];

$PKB["VehicleGroup"] = "{$row["VehicleBrand"]} {$row["VehicleGroup"]}";
$PKB["VehicleID"] = "{$row["VehicleVIN"]} / {$row["VehicleEngineNumber"]}";
$PKB["VehiclePoliceNumber"] = $row["VehiclePoliceNumber"];

$PKB["Customer"] = "{$row["CustomerTitle"]} {$row["CustomerName"]}";
    $CustomerIDs = [];
    if($row["CustomerKTPNumber"])$CustomerIDs[] = $row["CustomerKTPNumber"];
    if($row["CustomerNPWPNumber"])$CustomerIDs[] = $row["CustomerNPWPNumber"];
$PKB["CustomerID"] = implode(" / ",$CustomerIDs);
$PKB["Complaint"] = $row["Complaint"];

//$SP->addSanitation("ReferenceId1",["int"]);
$SP->nextRowset();
$NT = $SP->getRow()[0];
$PKB["BrandName"] = $NT["BrandName"];
$PKB["CompanyAlias"] = $NT["CompanyAlias"];
$PKB["BranchAlias"] = $NT["BranchAlias"];
$PKB["POSName"] = $NT["POSName"];
$PKB["CBPName"] = "{$PKB["CompanyAlias"]} {$PKB["BranchAlias"]} {$PKB["POSName"]}";
$PKB["NumberText"] = $NT["NumberText"];

//$SP->addSanitation("Description",["string"]);
$SP->nextRowset();
$PKBSrvs = [];
foreach($SP->getRow() AS $row)
{
    $PKBSrvId = $row["Id"];
    $PKBSrvs[$PKBSrvId] = $row;
    $PKBSrvs[$PKBSrvId]["Spareparts"] = [];
}

//$SP->addSanitation("ReferenceId1",["int"]);
$SP->nextRowset();
foreach($SP->getRow() AS $row)
{
    $PKBSrvId = $row["PKBServiceId"];

    $PKBSrvs[$PKBSrvId]["Spareparts"][] = $row;
}

$Items = [];
$Retail = 0;
$Discount = 0;
foreach($PKBSrvs AS $PKBSrv)
{
    $Item = $PKBSrv;
    $Items[] = [
        "ChargeTo" => $PKBSrv["ChargeTo"],
        "Code" => $PKBSrv["ServiceCode"],
        "Name" => $PKBSrv["ServiceName"],
        "Qty" => "{$PKBSrv["ServiceDuration"]} jam",
        "Retail" => $PKBSrv["SubTotal"],
        "Discount" => $PKBSrv["DiscountNominal"],
        "SubTotal" => $PKBSrv["SubTotal"] - $PKBSrv["DiscountNominal"],
    ];
    $Retail += $PKBSrv["SubTotal"];
    $Discount += $PKBSrv["DiscountNominal"];

    foreach($PKBSrv["Spareparts"] AS $PKBSrvSp)
    {
        $Item = $PKBSrvSp;
        $Items[] = [
            "ChargeTo" => $PKBSrvSp["ChargeTo"],
            "Code" => $PKBSrvSp["SparepartCode"],
            "Name" => $PKBSrvSp["SparepartName"],
            "Qty" => "{$PKBSrvSp["Quantity"]} {$PKBSrvSp["Unit"]}",
            "Retail" => $PKBSrvSp["SubTotal"],
            "Discount" => $PKBSrvSp["DiscountNominal"],
            "SubTotal" => $PKBSrvSp["SubTotal"] - $PKBSrvSp["DiscountNominal"],
        ];
        $Retail += $PKBSrvSp["SubTotal"];
        $Discount += $PKBSrvSp["DiscountNominal"];
    }
}
$PKB["TotalRetail"] = $Retail;
$PKB["TotalDiscount"] = $Discount;
$PKB["TotalDPP"] = $Retail - $Discount;

$datas["PKB"] = $PKB;
$datas["Items"] = $Items;

