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
            array("formatType" => "rowNumber"),
            array("field" => "CBPName", "title" => "POS / Outlet", "width" => 250),
            array("field" => "InvoiceDate", "title" => "Tanggal Nota", "formatType" => "date"),
            array("field" => "InvoiceHeaderDocumentNumber", "title" => "No. Transaksi", "formatType" => "invoiceNumberText"),
            array("field" => "PSPONumber", "title" => "No. PO", "width" => 150),
            array("field" => "PSPartSales", "title" => "Part Sales", "width" => 150),
            array("field" => "GIWarehouseName", "title" => "Gudang", "width" => 150),
            array("field" => "GIWarehouseRackName", "title" => "Rak", "width" => 150),
            array("field" => "PSCustomerName", "title" => "Customer", "width" => 200),
            array("field" => "Number", "title" => "No", "width" => 50),
            array("field" => "SpGroup1Name", "title" => "Grup", "width" => 70),
            array("field" => "SpGroup2Name", "title" => "Sub Grup", "width" => 100),
            array("field" => "SpCode", "title" => "Kode", "width" => 150),
            array("field" => "SpName", "title" => "Part", "width" => 200),
            array("field" => "GIQuantity", "title" => "Jumlah", "formatType" => "numeric"),
            array("field" => "SpUnit", "title" => "Satuan", "width" => 100),
            array("field" => "PSSpSellingPrice", "title" => "Harga @", "formatType" => "currency"),
            array("field" => "PSSpSubTotal", "title" => "Sub Total", "formatType" => "currency"),
            array("field" => "PSSpSellingDiscount", "title" => "Disc %", "formatType" => "percentage"),
            array("field" => "PSSpSellingDiscountNominal", "title" => "Disc Rp", "formatType" => "currency"),
            array("field" => "PSSpDPP", "title" => "DPP", "formatType" => "currency"),
            array("field" => "SpClassificationName", "title" => "Klasifikasi", "width" => 159),
        ),
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
