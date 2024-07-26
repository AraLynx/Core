<?php
?>
<div id='reportDiv_<?php echo $reportId;?>' class='reportDiv d-none'>
    <?php
    $gridParams = [
        "page" => "report",
        "group" => "report",
        "id" => "_{$reportId}",
        "toolbarString" => "<div class=\'btn btn-secondary align-middle\' onclick=\'reportGenerateExcelPrepareData({$reportId})\'>Export to Excel</div>",
        "columns" => [
            ["title" => "No", "formatType" => "rowNumber"],
            ["title" => "POS / Outlet", "width" => 250, "template" => "#= BranchAlias #, #= POSName #"],
            ["field" => "InvoiceDate", "title" => "Nota", "formatType" => "date"],
            ["field" => "PKBDate", "title" => "UE", "formatType" => "date"],
            ["field" => "PKBNumberText", "title" => "No Order", "formatType" => "numberText"],

            ["field" => "VehiclePoliceNumber", "title" => "No Polisi", "width" => 100],
            ["field" => "VehicleBrandType", "title" => "Tipe Kendaraan", "width" => 250],
            ["field" => "VehicleVIN", "title" => "No Rangka", "width" => 150],
            ["field" => "VehicleEngineNumber", "title" => "No Mesin", "width" => 100],
            ["field" => "VehicleYear", "title" => "Tahun", "formatType" => "numeric"],
            ["field" => "Kilometer", "title" => "KM", "formatType" => "numeric"],
            ["field" => "CustomerName", "title" => "Pemilik", "width" => 300],

            ["field" => "PKBSparepartCostCounter", "title" => "No", "formatType" => "numeric"],
            ["field" => "ChargeTo", "title" => "Charge To", "width" => 100],
            ["field" => "SparepartCode", "title" => "Kode", "width" => 200],
            ["field" => "SparepartName", "title" => "Produk", "width" => 300],
            ["field" => "SparepartCostQuantity", "title" => "Qty", "formatType" => "numeric"],
            ["field" => "SparepartUnitName", "title" => "Unit", "width" => 100],

            ["field" => "WarehouseName", "title" => "Gudang", "width" => 200],
            ["field" => "WarehouseRackName", "title" => "Rak", "width" => 200],
            ["field" => "PartRequisitionItemValueEach", "title" => "Satuan", "formatType" => "currency"],
            ["field" => "PartRequisitionItemValue", "title" => "Retail", "formatType" => "currency"],
        ],
    ];
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
