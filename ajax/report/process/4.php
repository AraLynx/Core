<?php
$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

$SP->addSanitation("SPKId",["int"]);
$SP->addSanitation("BranchAlias",["string"]);
$SP->addSanitation("POSName",["string"]);
$SP->addSanitation("InvoiceDate",["date"]);
$SP->addSanitation("CreatedDate",["date"]);
$SP->addSanitation("InvoiceNumber",["string"]);

$SP->addSanitation("CustomerKTPNumber",["string"]);
$SP->addSanitation("CustomerNPWPNumber",["string"]);
$SP->addSanitation("CustomerName",["string"]);
$SP->addSanitation("CustomerAddressLine1",["string"]);
$SP->addSanitation("CustomerAddressLine2",["string"]);
$SP->addSanitation("CustomerAddressRT",["string"]);
$SP->addSanitation("CustomerAddressRW",["string"]);
$SP->addSanitation("CustomerAddressPropinsi",["string"]);
$SP->addSanitation("CustomerAddressKabupaten",["string"]);
$SP->addSanitation("CustomerAddressKecamatan",["string"]);
$SP->addSanitation("CustomerAddressKelurahan",["string"]);

$SP->addSanitation("UnitVIN",["string"]);
$SP->addSanitation("UnitEngineNumber",["string"]);
$SP->addSanitation("OrderNumberText",["string"]);
$SP->addSanitation("VehicleGroup",["string"]);
$SP->addSanitation("VehicleType",["string"]);
$SP->addSanitation("Qty",["int"]);

$SP->addSanitation("UnitPOSHPP",["int"]);
$SP->addSanitation("UnitPOSPPNIn",["int"]);
$SP->addSanitation("CaroseriePOSHPP",["int"]);
$SP->addSanitation("CaroseriePOSPPNIn",["int"]);
$SP->addSanitation("UnitPrice",["int"]);
$SP->addSanitation("CaroseriePrice",["int"]);

$SP->addSanitation("LeasingDP",["int"]);

$SP->addSanitation("Discount",["int"]);
$SP->addSanitation("SubsidyDP",["int"]);
$SP->addSanitation("CadBBNNotice",["int"]);
$SP->addSanitation("CadBBNUnNotice",["int"]);
$SP->addSanitation("CadAksesoris",["int"]);
$SP->addSanitation("CadInvestasi",["int"]);
$SP->addSanitation("CadInvestasiTambahan",["int"]);
$SP->addSanitation("CadInsentif",["int"]);
$SP->addSanitation("CadMediator",["int"]);
$SP->addSanitation("CadOngkirKonsumen",["int"]);
$SP->addSanitation("OngkirKonsumen",["int"]);
$SP->addSanitation("CadBungaDO",["int"]);
$SP->addSanitation("CadFakpol",["int"]);
$SP->addSanitation("CadFeeCabang",["int"]);
$SP->addSanitation("CadPDI",["int"]);
$SP->addSanitation("CadDeco",["int"]);
$SP->addSanitation("CadCuci",["int"]);
$SP->addSanitation("CadPilihNopol",["int"]);
$SP->addSanitation("CadGarwil",["int"]);
$SP->addSanitation("CadOtherCost",["int"]);

$SP->addSanitation("ClaimFakpol",["int"]);
$SP->addSanitation("ClaimCashBack",["int"]);
$SP->addSanitation("ClaimSCP",["int"]);

$SP->addSanitation("SalesMethod",["string"]);
$SP->addSanitation("LeasingName",["string"]);
$SP->addSanitation("LeasingTenor",["int"]);
$SP->addSanitation("LeasingInsuranceAllRisk",["int"]);
$SP->addSanitation("LeasingInsuranceTLO",["int"]);
$SP->addSanitation("LeasingInsuranceMix",["int"]);
$SP->addSanitation("LeasingARInsuranceRefund",["int"]);

$SP->addSanitation("TeamLeaderEmployeeId",["int"]);
$SP->addSanitation("TeamLeaderEmployeeName",["string"]);
$SP->addSanitation("TeamLeaderEmployeePositionName",["string"]);
$SP->addSanitation("TeamLeaderEmployeeGroupName",["string"]);

$SP->addSanitation("SalesmanEmployeeId",["int"]);
$SP->addSanitation("SalesmanEmployeeName",["string"]);
$SP->addSanitation("SalesmanEmployeePositionName",["string"]);
$SP->addSanitation("SalesmanEmployeeGroupName",["string"]);

$SP->setAdditionalField("TEMP_RT",["implode", " ", ["RT", "CustomerAddressRT"]]);
$SP->setAdditionalField("TEMP_RW",["implode", " ", ["RW", "CustomerAddressRT"]]);
    $SP->setAdditionalField("TEMP_RTRW",["implode", " / ", ["TEMP_RT", "TEMP_RW"]]);
    $SP->setAdditionalField("TEMP_Wilayah",["implode", ", ", ["CustomerAddressKelurahan", "CustomerAddressKecamatan", "CustomerAddressKabupaten", "CustomerAddressPropinsi"]]);
        $SP->setAdditionalField("CustomerAddress",["implode", ", ", ["CustomerAddressLine1", "CustomerAddressLine2", "TEMP_RTRW", "TEMP_Wilayah"]]);

$SP->setAdditionalField("TEMP_Pelunasan01",["add", ["UnitPrice", "CaroseriePrice", "CadBBNNotice", "CadBBNUnNotice"]]);
    $SP->setAdditionalField("Pelunasan",["substract", ["TEMP_Pelunasan01", "LeasingDP"]]);

$SP->setAdditionalField("OTR",["add", ["LeasingDP", "Pelunasan"]]);
$SP->setAdditionalField("OffTheRoad",["substract", ["OTR", "CadBBNNotice"]]);
$SP->setAdditionalField("TotalDiscount",["add", ["Discount", "SubsidyDP"]]);
$SP->setAdditionalField("ARPrice",["substract", ["OffTheRoad", "TotalDiscount"]]);

    $SP->setAdditionalField("TEMP_TAX",["divide_10", [0.11, 1.11]]);
$SP->setAdditionalField("PPNOutLeasingDP",["times", ["LeasingDP", "TEMP_TAX"]]);
$SP->setAdditionalField("PPNOutPelunasan",["times", ["Pelunasan", "TEMP_TAX"]]);
$SP->setAdditionalField("PPNOutBBNNoticePrice",["times", ["CadBBNNotice", "TEMP_TAX", -1]]);
$SP->setAdditionalField("PPNOutDiscount",["times", ["TotalDiscount", "TEMP_TAX", -1]]);
$SP->setAdditionalField("PPNOutTotal",["add", ["PPNOutLeasingDP", "PPNOutPelunasan", "PPNOutBBNNoticePrice", "PPNOutDiscount"]]);

$SP->setAdditionalField("DPP",["substract", ["ARPrice", "PPNOutTotal"]]);
$SP->setAdditionalField("HPP",["add", ["UnitPOSHPP", "CaroseriePOSHPP", "CadFakpol"]]);
$SP->setAdditionalField("GPBeforeProgram",["substract", ["DPP", "HPP", "CadInvestasi", "CadInvestasiTambahan"]]);

$SP->setAdditionalField("AstraClaimFakpol",["add", ["ClaimFakpol"]]);
$SP->setAdditionalField("AstraCashBack",["add", ["ClaimCashBack", "ClaimSCP"]]);
$SP->setAdditionalField("AstraOther",["add", ["ClaimOther"]]);
$SP->setAdditionalField("AstraTotal",["add", ["AstraClaimFakpol", "AstraCashBack", "AstraOther"]]);
$SP->setAdditionalField("GPAfterProgram",["add", ["GPBeforeProgram", "AstraTotal"]]);

$SP->setAdditionalField("GPAfterRefund",["add", ["GPAfterProgram", "LeasingARInsuranceRefund"]]);

$SP->setAdditionalField("CadInsentifTotal",["add", ["CadInsentif", "CadInsentifTambahan"]]);
$SP->setAdditionalField("CadanganLain",["add", ["CadOtherCost", "CadCuci", "CadPilihNopol", "CadGarwil"]]);
$SP->setAdditionalField("CadanganTotal",["add", ["CadAksesoris", "CadBBNUnNotice", "CadFeeCabang", "CadInsentifTotal", "CadPDI", "CadMediator", "CadOngkirMainDealer", "CadOngkirKonsumen", "CadBungaDO", "CadDeco", "CadanganLain"]]);
$SP->setAdditionalField("GPAfterCadangan",["substract", ["GPAfterRefund", "CadanganTotal"]]);

$SP->setAdditionalField("CostTotal",["add", ["CostAksesoris", "CostBBNUnNotice", "CostFeeCabang", "CostInsentif", "CostPDI", "CostMediator", "CostOngkirTotal", "CostBungaDO", "CostDeco"]]);

$SP->setAdditionalField("DiffTotal",["substract", ["CadanganTotal", "CostTotal"]]);

$SP->setAdditionalField("GPAfterDiff",["add", ["GPAfterCadangan", "DiffTotal"]]);

$SP->setAdditionalField("PPNIn",["add", ["UnitPOSPPNIn", "CaroseriePOSPPNIn"]]);
$SP->setAdditionalField("DiffPPNOutIn",["substract", ["PPNOutTotal", "PPNIn"]]);
$SP->setAdditionalField("SalesmanEmployeePosition",["implode", " ", ["SalesmanEmployeePositionName", "SalesmanEmployeeGroupName"]]);
$SP->setAdditionalField("TeamLeaderEmployeePosition",["implode", " ", ["TeamLeaderEmployeePositionName", "TeamLeaderEmployeeGroupName"]]);

$SP->execute();
$report = $SP->getRow();
