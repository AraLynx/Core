<?php
namespace app\core;

require_once dirname(__DIR__,3)."/functions/numeric.php";

$SP = new StoredProcedure("uranus");
$SP->addParameters(["RId1" => $RId1, "RId2" => $RId2, "RId3" => $RId3]);
$q = "EXEC [SP_Sys_Approval_{$subSPName}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);
$SP->addSanitation("Date",["Date"]);
$SP->addSanitation("DiscountReguler",["int"]);
$SP->addSanitation("DiscountReguler",["int"]);
$SP->addSanitation("DiscountReguler",["int"]);
$SP->addSanitation("DiscountReguler",["int"]);
$SP->addSanitation("DiscountReguler",["int"]);
$SP->execute();
$PO = $SP->getRow()[0];

$PO["CBP"] = "{$PO["CompanyAlias"]} {$PO["BranchAlias"]} - {$PO["POSName"]}";
$PO["Partner"] = "{$PO["PartnerName"]} cb. {$PO["PartnerBranchName"]}";

$PO["PartnerNPWPPKPNumber"] = "NO NPWP";
if($PO["PartnerBranchNPWPNumber"])$PO["PartnerNPWPPKPNumber"] = "{$PO["PartnerBranchNPWPNumber"]}";
if($PO["PartnerBranchPKPNumber"]  && $PO["PartnerBranchNPWPNumber"] != $PO["PartnerBranchPKPNumber"])$PO["PartnerNPWPPKPNumber"] = " (PKP {$PO["PartnerBranchPKPNumber"]})";

$PO["PartnerAddress"] = "";
if($PO["PartnerBranchAddressLine"])$PO["PartnerAddress"] = "{$PO["PartnerBranchAddressLine"]}";

$PO["PartnerPIC"] = "";
if($PO["PartnerBranchPICName"])$PO["PartnerPIC"] = "{$PO["PartnerBranchPICTypeName"]} : {$PO["PartnerBranchPICName"]}";
if($PO["PartnerBranchPICPhone1"])$PO["PartnerPIC"] .= " ({$PO["PartnerBranchPICPhone1"]})";

//MOBILE EXCLUSIVE
$PO["PO"] = "{$PO["NumberText"]} | {$PO["CompanyAlias"]} {$PO["BranchAlias"]} - {$PO["POSName"]}";

$datas["PO"] = $PO;

//========================================================================================================================================
$datas["POItems"] = [];
$SP->addSanitation("ReferenceId1",["int"]);
$SP->addSanitation("ReferenceId2",["int"]);
$SP->addSanitation("ReferenceId3",["int"]);

$SP->addSanitation("Quantity",["int"]);
$SP->addSanitation("BuyingPrice",["int"]);
$SP->addSanitation("DiscountAdditionalNominal",["int"]);
$SP->addSanitation("DiscountRegulerNominal",["int"]);
$SP->addSanitation("QuantityBuyingPrice",["int"]);
$SP->addSanitation("SubTotalPrice",["int"]);
$SP->nextRowset();
$POItems = $SP->getRow();
$datas["POItems"] = $POItems;
$Items = [];
$TotalPrice = 0;
foreach($POItems AS $POItem)
{
    $POItemId = $POItem["Id"];

    if($POItem["ReferenceId1"] && $POItem["ReferenceId2"])
    {
        //ADDITIONAL ITEMS
        $parentPOId = $POItem["ReferenceId1"];
        $parentPOItemId = $POItem["ReferenceId2"];
        $Items[$parentPOItemId]["POItemProfile"] .= "<br/><span class='text-small text-secondary ms-2'>*inc. {$POItem["ItemName"]}</span>";
    }
    else
    {
        //POItemProfile
        $Items[$POItemId]["POItemProfile"] = "{$POItem["Quantity"]} x {$POItem["ItemType1Name"]} {$POItem["ItemType2Name"]} {$POItem["ItemName"]}";

        //POItemPrice
        $Items[$POItemId]["POItemPrice"] = "";
        if($POItem["Quantity"]>1)$Items[$POItemId]["POItemPrice"] .= "@ ";
        $Items[$POItemId]["POItemPrice"] .= generatePrice($POItem["BuyingPrice"]);
        if($POItem["Quantity"]>1)$Items[$POItemId]["POItemPrice"] .= "<br/>retail ".generatePrice($POItem["QuantityBuyingPrice"]);
        if($POItem["DiscountRegulerNominal"])
        {
            $Items[$POItemId]["POItemPrice"] .= "<br/>Disc. -".generatePrice($POItem["DiscountRegulerNominal"]);
            $Items[$POItemId]["POItemPrice"] .= "<br/><span class='fw-bold'>Total ".generatePrice($POItem["SubTotalPrice"])."</span>";
        }
        $TotalPrice += $POItem["SubTotalPrice"];

        //PPProfile
        $PPProfiles = [];
        if($POItem["ProcurementPlanItemId"])
        {
            $PPProfiles[] = "<span class='fw-bold'>{$POItem["PPNumberText"]}</span> ({$POItem["PPDate"]})";
            if($POItem["PPGeneralNotes"])$PPProfiles[] = $POItem["PPGeneralNotes"];
            if($POItem["PPInternalNotes"])$PPProfiles[] = $POItem["PPInternalNotes"];

            if($POItem["PPPICEmployeeName"])$PPProfiles[] = "<span class='fw-bold'>Doc. PIC ({$POItem["PPPICEmployeeId"]}) {$POItem["PPPICEmployeeName"]}</span>";
            if($POItem["PPUserEmployeeName"])$PPProfiles[] = "User ({$POItem["PPUserEmployeeId"]}) {$POItem["PPUserEmployeeName"]}";

            if($POItem["PPItemGeneralNotes"])$PPProfiles[] = "<span class='fst-italic'>{$POItem["PPItemGeneralNotes"]}</span>";
            if($POItem["PPItemInternalNotes"])$PPProfiles[] = "<span class='fst-italic'>{$POItem["PPItemInternalNotes"]}</span>";
        }
        $Items[$POItemId]["PPProfile"] = implode("<br/>", $PPProfiles);
    }
}
foreach($Items AS $Item)
{
    $datas["Items"][] = $Item;
}
if($PO["DiscountReguler"])
{
    $datas["Items"][] = [
        "POItemPrice" => "<p class='text-end fw-bold'>Subtotal ".generatePrice($TotalPrice)."</p>",
    ];
    $datas["Items"][] = [
        "POItemPrice" => "<p class='text-end fw-bold'>Disc. -".generatePrice($PO["DiscountReguler"])."</p>",
    ];
}
$TotalPrice = $TotalPrice - $PO["DiscountReguler"];
$datas["Items"][] = [
    "POItemPrice" => "<p class='text-end fw-bold'>Total ".generatePrice($TotalPrice)."</p>",
];
$datas["PO"]["TotalPrice"] = generatePrice($TotalPrice);


