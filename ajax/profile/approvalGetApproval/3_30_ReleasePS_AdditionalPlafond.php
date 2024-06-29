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
$PS = $row;

//$SP->addSanitation("ReferenceId1",["int"]);
$SP->nextRowset();
$NT = $SP->getRow()[0];
$PS["BrandName"] = $NT["BrandName"];
$PS["CompanyAlias"] = $NT["CompanyAlias"];
$PS["BranchAlias"] = $NT["BranchAlias"];
$PS["POSName"] = $NT["POSName"];
$PS["CBPName"] = "{$PS["CompanyAlias"]} {$PS["BranchAlias"]} {$PS["POSName"]}";
$PS["NumberText"] = $NT["NumberText"];

$SP->nextRowset();
$Spareparts = [];
foreach($SP->getRow() AS $row)
{
    $Spareparts[] = [
        "Code" => $row["SparepartCode"],
        "Name" => $row["SparepartName"],
        "Qty" => "{$row["Quantity"]} {$row["Unit"]}",
        "Retail" => $row["SubTotal"],
        "Discount" => $row["SellingDiscountNominal"],
        "SubTotal" => $row["SubTotal"] - $row["SellingDiscountNominal"],
    ];
}
$datas["PS"] = $PS;
$datas["Items"] = $Spareparts;

