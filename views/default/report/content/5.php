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
            array("title" => "SPK", "columns" => [
                array("field" => "SPKDate", "title" => "Tgl SPK", "formatType" => "date"),
                array("field" => "SPKNumber", "title" => "No SPK", "width" => 170),
                array("field" => "SPKInvoiceDate", "title" => "Tgl Nota", "formatType" => "date"),
                array("field" => "SPKDiscountPrice", "title" => "Diskon", "formatType" => "currency"),
                array("field" => "SPKCustomerName", "title" => "Konsumen", "width" => 250),
                array("field" => "SPKSTNKName", "title" => "Nama STNK", "width" => 250),
                array("field" => "SPKMobilePhone", "title" => "No HP", "width" => 150),
                array("field" => "SPKUnitType", "title" => "Tipe Unit", "width" => 300),
                array("field" => "SPKVIN", "title" => "No Rangka", "width" => 150),
                array("field" => "SPKSellingType", "title" => "Tipe Penjualan", "width" => 150),
                array("field" => "SPKLeasingVendorName", "title" => "Vendor Leasing", "width" => 250),
            ]),

            array("title" => "Titipan", "columns" => [
                array("field" => "DepositCompleteDate", "title" => "Klik Posting", "formatType" => "date"),
                array("field" => "DepositDate", "title" => "Tgl Terima", "formatType" => "date"),
                array("field" => "DepositDocumentNumber", "title" => "No Dokumen", "width" => 150),
                array("field" => "DepositPaymentMenthod", "title" => "Metode Bayar", "width" => 150),
                array("field" => "DepositNominal", "title" => "Nominal", "formatType" => "currency"),
                array("field" => "SPKSalesName", "title" => "Nama Sales", "width" => 200),
                array("field" => "SPKLeaderName", "title" => "Nama Leader", "width" => 200),
            ]),

            array("title" => "Setoran", "columns" => [
                array("field" => "SetoranDate", "title" => "Tgl Setoran", "formatType" => "date"),
                array("field" => "SetoranReferenceNumber", "title" => "No Referensi", "width" => 200),
                array("field" => "SetoranAccount", "title" => "Akun", "width" => 150),
                array("field" => "SetoranAge", "title" => "Umur", "width" => 100),
                array("field" => "SetoranStatus", "title" => "Status", "width" => 100),
            ]),

            array("field" => "TotalCustomerDeposit", "title" => "Total Uang Masuk", "formatType" => "currency"),
        ),
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
