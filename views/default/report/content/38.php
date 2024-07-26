<?php
?>
<div id='reportDiv_<?php echo $reportId;?>' class='reportDiv d-none'>
    <?php
    $gridParams = [
        "page" => "report",
        "group" => "report",
        "id" => "_{$reportId}",
        "isAutoFitColumn" => true,
        "toolbarString" => "<div class=\'btn btn-secondary align-middle\' onclick=\'reportGenerateExcelPrepareData({$reportId})\'>Export to Excel</div>",
        "columns" => [
            ["formatType" => "rowNumber"],
            ["field" => "CompanyName","title" => "Company"],
            ["field" => "BranchName","title" => "Branch"],
            ["field" => "POSName","title" => "POS"],

            ["field" => "DocumentNumber","title" => "Document Number"],
            ["field" => "StatusName","title" => "Status"],
            ["field" => "Period","title" => "Period"],
            ["field" => "BranchManagerEmployeeName","title" => "Branch Manager"],
            ["field" => "PICEmployeeId","title" => "NIP PIC"],
            ["field" => "PICEmployeeName","title" => "Name PIC"],
            ["field" => "PICEmployeePosition","title" => "Position PIC"],
            ["field" => "PICPhoneNumber","title" => "Phone PIC"],
            ["field" => "StartDate","title" => "Start Date"],
            ["field" => "EndDate","title" => "End Date"],
            ["field" => "TotalDays","title" => "Total Days"],
            ["field" => "SPKPlanQty","title" => "SPK Target"],

            ["field" => "TypeName","title" => "Type"],
            ["field" => "AktivitasName","title" => "Name Event"],
            ["field" => "LokasiName","title" => "Location Type"],
            ["field" => "LocationName","title" => "Location Name"],

            ["field" => "Alamat","title" => "Address"],
            ["field" => "GoogleMapURL","title" => "Map Location"],
            ["field" => "SocialMediaAccountName","title" => "Account Name"],
            ["field" => "PromotionalURL","title" => "Promotion Url"],

            ["field" => "VenueRentalCost","title" => "Venue Rental Cost", "formatType" => "currency"],
            ["field" => "AccommodationCost","title" => "Accommodation Cost", "formatType" => "currency"],
            ["field" => "FuelCost","title" => "Fuel Cost", "formatType" => "currency"],
            ["field" => "BeverageCost","title" => "Beverage Cost", "formatType" => "currency"],
            ["field" => "PromotionalMediaCost","title" => "Promotional Media Cost", "formatType" => "currency"],
            ["field" => "PPh","title" => "PPh", "formatType" => "currency"],
            ["field" => "PPN","title" => "PPN", "formatType" => "currency"],

            ["field" => "BudgetPerDays","title" => "Budget / Days", "formatType" => "currency"],
            ["field" => "BudgetPerUnits","title" => "Cost / Unit", "formatType" => "currency"],
            ["field" => "TotalBudget","title" => "Budget Total", "formatType" => "currency"],

            ["field" => ""],
        ],
    ];
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
