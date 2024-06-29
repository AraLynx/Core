<?php
$month = $ajax->getPost("DateApplyMonth");
$monthName = date("F",strtotime('00-'.$month.'-01'));

$headerInfos["Period"] = "{$monthName} {$ajax->getPost("DateApplyYear")}";
$tryHeaderInfos["StatusCode"] = "Status";
$tryHeaderInfos["DocumentNumber"] = "Document Number";

foreach($tryHeaderInfos AS $inputName => $description)
{
    if($ajax->getPost($inputName))
        $headerInfos[$description] = $ajax->getPost($inputName);
}

$headerParams = [
    "columnIndex" => 0,
    "rowIndex" => 1,
    "titleText" => $reportDescription,
    "mergeCellCount" => 5,
    "infos" => $headerInfos,
];
$spreadSheet->generateHeader($headerParams);
//$datas["post"] = $ajax->getPost();

$datas["FileLink"] = $spreadSheet
    ->map(["CompanyName","Company"])
    ->map(["BranchName","Branch"])
    ->map(["POSName","POS"])
    ->map(["DocumentNumber","Document Number"])
    ->map(["StatusName","Status"])
    ->map(["Period","Period"])
    ->map(["BranchManagerEmployeeName","Branch Manager"])
    ->map(["PICEmployeeId","NIP PIC"],["formatCell" => "numeric"])
    ->map(["PICEmployeeName","Name PIC"])
    ->map(["PICEmployeePosition","Position PIC"])
    ->map(["PICPhoneNumber","Phone Number PIC"])
    ->map(["StartDate","Start Date"],["formatCell" => "date"])
    ->map(["EndDate","End Date"],["formatCell" => "date"])
    ->map(["TotalDays","Total Days"],["formatCell" => "numeric"])
    ->map(["SPKPlanQty","SPK Target"],["formatCell" => "numeric"])
    ->map(["TypeName","Activity Type"])
    ->map(["AktivitasName","Name Event"])
    ->map(["LokasiName","Location Type"])
    ->map(["LocationName","Location Name"])
    ->map(["Alamat","Address (Offline)"])
    ->map(["GoogleMapURL","URL Location (Offline)"])
    ->map(["SocialMediaAccountName","Account Name (Online)"])
    ->map(["PromotionalURL","URL Promotion (Online)"])
    ->map(["VenueRentalCost","Venue Rental Cost"],["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["AccommodationCost","Accomodation Cost"],["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["FuelCost","Fuel Cost"],["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["BeverageCost","Beverage Cost"],["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["PromotionalMediaCost","Media Promotional Cost"],["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["PPh","PPh"],["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["PPN","PPN"],["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["BudgetPerDays","Budget Per Days"],["formatCell" => "currency"])
    ->map(["BudgetPerUnits","Cost Per Unit"],["formatCell" => "currency"])
    ->map(["TotalBudget","Subtotal Budget"],["formatCell" => "currency", "aggregate" => "sum"])    
    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();