<?php

$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

$SP->addSanitation("PKBServiceId",["int"]);
$SP->addSanitation("Mechanic",["string"]);
$SP->execute();
$PKBServiceMechanics = [];
foreach($SP->getRow() AS $index => $row)
{
    $PKBSrvId = $row["PKBServiceId"];
    $Mechanic = $row["Mechanic"];
    if(!isset($PKBServiceMechanic[$PKBSrvId]))
        $PKBServiceMechanic[$PKBSrvId] = [];

    $PKBServiceMechanic[$PKBSrvId][] = $Mechanic;
}

//-------------------------- Sanitize output PKB + SRV + SP + PR
$SP->addSanitation("PKBId",["int"]);
$SP->addSanitation("SrvId",["int"]);
$SP->addSanitation("SpId",["int"]);
$SP->addSanitation("PRSpId",["int"]);

$SP->addSanitation("PKBNumberText",["string"]);
$SP->addSanitation("InvoiceNumberText",["string"]);
$SP->addSanitation("CreatedDateTime",["date"]);
$SP->addSanitation("CompanyAlias",["string"]);
$SP->addSanitation("BranchAlias",["string"]);
$SP->addSanitation("POSName",["string"]);

$SP->addSanitation("CompleteDateTime",["date"]);
$SP->addSanitation("PKBType",["string"]);
$SP->addSanitation("SAEmployeeName",["string"]);
$SP->addSanitation("KepalaReguEmployeeName",["string"]);

$SP->addSanitation("VehicleBrand",["string"]);
$SP->addSanitation("VehicleGroup",["string"]);
$SP->addSanitation("VehicleType",["string"]);
$SP->addSanitation("VehicleVIN",["string"]);
$SP->addSanitation("VehicleEngineNumber",["string"]);
$SP->addSanitation("VehiclePoliceNumber",["string"]);
$SP->addSanitation("VehicleYear",["int"]);
$SP->addSanitation("Kilometer",["int"]);

$SP->addSanitation("CustomerTitle",["string"]);
$SP->addSanitation("CustomerName",["string"]);
$SP->addSanitation("CustomerKTPNumber",["string"]);
$SP->addSanitation("CustomerNPWPNumber",["string"]);
$SP->addSanitation("CustomerMobilePhone1",["string"]);
$SP->addSanitation("CustomerMobilePhone2",["string"]);
$SP->addSanitation("CustomerAddressLine1",["string"]);
$SP->addSanitation("CustomerAddressLine2",["string"]);
$SP->addSanitation("CustomerAddressKabupaten",["string"]);

$SP->addSanitation("ChargeTo",["string"]);
$SP->addSanitation("Product",["string"]);
$SP->addSanitation("Type",["string"]);
$SP->addSanitation("ProductCode",["string"]);
$SP->addSanitation("ProductName",["string"]);
$SP->addSanitation("Qty",["dec"]);
$SP->addSanitation("Unit",["string"]);
$SP->addSanitation("Storage",["string"]);

$SP->addSanitation("Each",["int"]);
$SP->addSanitation("Retail",["int"]);
$SP->addSanitation("DiscountPercentage",["dec"]);
$SP->addSanitation("DiscountNominal",["int"]);
$SP->addSanitation("DPP",["int"]);
$SP->nextRowset();
//$secondData = $SP->getRow();
$PKBId = 0;
$PKBSrvId = 0;
$PKBSrvSpId = 0;
$PKBSrvSpPRId = 0;
$ItemNumber = 1;
foreach($SP->getRow() AS $index => $row)
{
    if($PKBId != $row["PKBId"])$ItemNumber = 1;

    $PKBId = $row["PKBId"];
    $PKBSrvId = $row["SrvId"];
    $PKBSrvSpId = $row["SpId"];
    $PKBSrvSpPRId = $row["PRSpId"];
    $row["ItemNumber"] = $ItemNumber;

    $row["VehiclePoliceNumber"] = str_replace([" ","_"],"",$row["VehiclePoliceNumber"]);
    $row["CustomerMobilePhone1"] = str_replace(["-_","_"],"",$row["CustomerMobilePhone1"]);
    $row["CustomerMobilePhone2"] = str_replace(["-_","_"],"",$row["CustomerMobilePhone2"]);

    $row["Mechanics"] = "";
    if(isset($PKBServiceMechanic[$PKBSrvId]))
        $row["Mechanics"] = implode(", ",$PKBServiceMechanic[$PKBSrvId]);

        $report[] = $row;

    $ItemNumber++;
}
