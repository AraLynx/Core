<?php
namespace app\core;

//require_once dirname(__DIR__,3)."/functions/numeric.php";

$SP = new StoredProcedure("uranus", "SP_Sys_Approval_{$subSPName}");
$SP->addParameters(["RId1" => $RId1, "RId2" => $RId2, "RId3" => $RId3]);
$tables = $SP->f5();
foreach($tables[1] AS $index => $row)
{
    $POGRReturnId = $row["PurchaseOrderGoodReceiveReturnId"] * 1;
    if(!isset($POGRReturnItem[$POGRReturnId]))
    {
        $POGRReturnDPP[$POGRReturnId] = 0;
        $POGRReturnQuantity[$POGRReturnId] = 0;
    }

    $POGRReturnDPP[$POGRReturnId] += $row["DPPNominal"];
    $POGRReturnQuantity[$POGRReturnId] += $row["Quantity"];
    $datas["POGRReturnItems"][] = $row;
}
foreach($tables[0] AS $index => $row)
{
    $DPP = $POGRReturnDPP[$row["Id"]];
    $row["DPP"] = $DPP;
    $row["Total"] = $DPP;
    $row["PPNPercentage"] = 0;
    if($row["PPNNominal"])
    {
        $PPNNominal = $row["PPNNominal"];
        $row["PPNPercentage"] = round($PPNNominal * 100 / $DPP);
        $row["Total"] += $PPNNominal;
    }
    $datas["POGRReturn"]= $row;
}
