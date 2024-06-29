<?php
?>
<div id='reportDiv_<?php echo $reportId;?>' class='reportDiv d-none'>
    <?php
    $gridParams = array(
        "page" => "report",
        "group" => "report",
        "id" => "_{$reportId}",
        "toolbarString" => "<div class=\'btn btn-secondary align-middle\' onclick=\'reportGenerateExcelPrepareData({$reportId})\'>Export to Excel</div>",
        "columns" => array(
            array("title" => "No", "formatType" => "rowNumber"),
            array("title" => "POS / Outlet", "width" => 250, "template" => "#= BranchAlias #, #= POSName #"),
            array("field" => "CompleteDateTime", "title" => "Nota", "formatType" => "date"),
            array("field" => "CreatedDateTime", "title" => "Cetak", "formatType" => "date"),
            array("field" => "InvoiceNumberText", "title" => "No Transaksi", "formatType" => "invoiceNumberText"),
            array("field" => "PKBNumberText", "title" => "No Order", "formatType" => "numberText"),
            array("field" => "PKBType", "title" => "Tipe (WalkIn/DMS/BIB)", "width" => 120),
            array("field" => "Mechanics", "title" => "Mekanik", "width" => 250),

            array("field" => "VehiclePoliceNumber", "title" => "No Polisi", "width" => 120),
            array("title" => "Tipe Kendaraan", "width" => 150, "template" => "#= VehicleBrand #, #= VehicleType #"),
            array("field" => "VehicleVIN", "title" => "No Rangka", "width" => 150),
            array("field" => "VehicleEngineNumber", "title" => "No Mesin", "width" => 100),
            array("field" => "VehicleYear", "title" => "Tahun", "formatType" => "right"),
            array("field" => "Kilometer", "title" => "KM", "formatType" => "numeric"),

            array("title" => "Pemilik", "width" => 250, "template" => "#= CustomerTitle # #= CustomerName #"),
            array("field" => "CustomerNPWPNumber", "title" => "NPWP", "width" => 150),
            array("field" => "CustomerKTPNumber", "title" => "KTP", "width" => 150),
            array("title" => "Telp", "width" => 150, "template" => "#= CustomerMobilePhone1 #, #= CustomerMobilePhone2 #"),
            array("title" => "Alamat", "width" => 350, "template" => "#= CustomerAddressLine1 #, #= CustomerAddressLine2 #"),
            array("field" => "CustomerAddressKabupaten", "title" => "Kota", "width" => 250),

            array("field" => "ItemNumber", "title" => "No", "width" => 80, "attributes" => ["class" => "text-end"]),
            array("field" => "ChargeTo", "title" => "Charge To", "width" => 150),
            array("field" => "Product", "title" => "Grup", "width" => 100),
            array("field" => "Type", "title" => "Tipe", "width" => 100),
            array("field" => "ProductCode", "title" => "Kode", "width" => 150),
            array("field" => "ProductName", "title" => "Produk", "width" => 250),
            array("field" => "Qty", "title" => "Qty", "formatType" => "dec"),
            array("field" => "Unit", "title" => "Unit", "width" => 150),
            array("field" => "Storage", "title" => "Rak", "width" => 250),

            array("field" => "Each", "title" => "Satuan","formatType" => "currency"),
            array("field" => "Retail", "title" => "Retail","formatType" => "currency"),
            array("field" => "DiscountPercentage", "title" => "Diskon %","formatType" => "percentage"),
            array("field" => "DiscountNominal", "title" => "Diskon Rp","formatType" => "currency"),
            array("field" => "DPP", "title" => "DPP","formatType" => "currency"),
        ),
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
