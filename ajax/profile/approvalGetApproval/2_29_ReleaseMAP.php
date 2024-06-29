<?php
namespace app\core;

require_once dirname(__DIR__,3)."/functions/numeric.php";

$SP = new StoredProcedure("uranus", "SP_Sys_Approval_{$subSPName}");
$SP->addParameters(["RId1" => $RId1, "RId2" => $RId2, "RId3" => $RId3]);
$tables = $SP->f5();

$datas["MarketingActivity"] = $tables;
foreach($tables[0] AS $index => $item)
{
    $Branch = "{$item["CompanyAlias"]} - {$item["BranchAlias"]} - {$item["POSName"]}";

    $datas["MarketingActivity"] = [
        "Branch" => $Branch,
        "DocumentNumber" => $item["DocumentNumber"],
        "DateApply" => $item["DateApply"],
        "BranchManagerName" => $item["BranchManagerName"],
        "Subtotal" => $item["GrandTotal"]
    ];
}

foreach($tables[1] AS $index => $item)
{
    $RT = "";
    $RW = "";
    $KodePOS = "";

    if ($item['AddressRT'] != ""){$RT = " RT ".$item['AddressRT'];}
    if ($item['AddressRW'] != ""){$RW = " RW ".$item['AddressRW'];}
    if ($item['AddressPostalCode'] != ""){$KodePOS = " ".$item['AddressPostalCode'];}

    $StartDate = date_create($item['StartDate']);
    $EndDate = date_create($item['EndDate']);
    $CalculateDays = date_diff($StartDate,$EndDate);
    $JumlahHari = $CalculateDays->format('%a')+1;

    $TotalBudget = 0;
    $BudgetPerHari = 0;
    $CostPerUnit = 0;

    if ($item['VenueRentalCost'] > 0 || $item['AccommodationCost'] > 0 || $item['FuelCost'] > 0 || $item['BeverageCost'] > 0 || $item['PromotionalMediaCost'] > 0)
    {
        $TotalBudget = ($item['VenueRentalCost']+$item['AccommodationCost']+$item['FuelCost']+$item['BeverageCost']+$item['PromotionalMediaCost']+$item['PPh']+$item['PPN']);
    }

    if ($TotalBudget > 0)
    {
        $BudgetPerHari = round($TotalBudget / $JumlahHari);
        $CostPerUnit = round($TotalBudget / $item['TargetSPK']);
    }

    $PICProfile = "<p>";
        $PICProfile .= "Nama: {$item["PICEmployeeName"]}";
        $PICProfile .= "<br/>NIP: {$item['PICEmployeeId']}";
        $PICProfile .= "<br/>Jabatan: {$item['PICEmployeePosition']}";
        $PICProfile .= "<br/>No. HP: 0{$item['PICPhoneNumber']}";
    $PICProfile .= "</p>";

    $ActivityDateTime = "<p>";
        $ActivityDateTime .= "Mulai: {$item["StartDate"]}";
        $ActivityDateTime .= "<br/>Sampai: {$item["EndDate"]}";
        $ActivityDateTime .= "<br/>Lama Event: {$JumlahHari} Hari";
        $ActivityDateTime .= "<br/>Target SPK: {$item["TargetSPK"]}";
    $ActivityDateTime .= "</p>";

    $DetailActivity = "<p>";
        $DetailActivity .= "{$item["TypeName"]} - {$item["EventName"]} - {$item["VenueName"]}";
        if ($item["TypeName"] == "OFFLINE"){
            $DetailActivity .= "<br/>Nama Lokasi: {$item["LocationName"]}";
            $DetailActivity .= "<br/>Alamat: {$item["AddressLine"]} {$RT} {$RW} {$item["KelurahanName"]}, {$item["KecamatanName"]}, {$item["KabupatenName"]}, {$item["ProvinsiName"]} {$KodePOS}";
            $DetailActivity .= "<br/>URL Lokasi: <a href={$item["GoogleMapURL"]} target='_blank'> {$item["GoogleMapURL"]} </a>";
        } else if ($item["TypeName"] == "ONLINE"){
            $DetailActivity .= "<br/>Nama Akun: {$item["SocialMediaAccountName"]}";
            $DetailActivity .= "<br/>URL Akun: <a href={$item["PromotionalURL"]} target='_blank'> {$item["PromotionalURL"]} </a>";
        }
    $DetailActivity .= "</p>";

    $DetailBudget = "<p>";
        if ($item["VenueRentalCost"] > 0){$DetailBudget .= "Sewa Tempat: ".generatePrice($item["VenueRentalCost"])."<br/>";}
        if ($item["AccommodationCost"] > 0 ){$DetailBudget .= "Akomodasi: ".generatePrice($item["AccommodationCost"])."<br/>";}
        if ($item["FuelCost"] > 0 ){$DetailBudget .= "Bahan Bakar (BBM): ".generatePrice($item["FuelCost"])."<br/>";}
        if ($item["BeverageCost"] > 0 ){$DetailBudget .= "Konsumsi: ".generatePrice($item["BeverageCost"])."<br/>";}
        if ($item["PromotionalMediaCost"] > 0 ){$DetailBudget .= "Media Promosi: ".generatePrice($item["PromotionalMediaCost"])."<br/>";}
        $DetailBudget .= "PPh (10%): ".generatePrice($item["PPh"])."<br/>";
        $DetailBudget .= "PPN (11%): ".generatePrice($item["PPN"]);
    $DetailBudget .="</p>";

    $CalculateBudget = "<p>";
        $CalculateBudget .= "Biaya Per Hari: ".generatePrice($BudgetPerHari)."<br/>";
        $CalculateBudget .= "Biaya Per Unit: ".generatePrice($CostPerUnit)."<br/>";
        $CalculateBudget .= "Subtotal: ".generatePrice($TotalBudget)."<br/>";
    $CalculateBudget .= "</p>";

    $datas["MarketingActivityItems"][] = [
        "PICProfile" => $PICProfile,
        'ActivityDateTime' => $ActivityDateTime,
        'DetailActivity' => $DetailActivity,
        'DetailBudget' => $DetailBudget,
        'CalculateBudget' => $CalculateBudget,
    ];
}
