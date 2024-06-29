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
            array("field" => "BranchAlias", "title" => "Cabang", "width" => 100),
            array("field" => "POSName", "title" => "POS", "width" => 150),

            array("title" => "NOTA", "columns" => [
                ["field" => "InvoiceDate", "title" => "Tanggal", "formatType" => "date"],
                ["field" => "CreatedDate", "title" => "Cetak", "formatType" => "date"],
                ["field" => "InvoiceNumber", "title" => "Nomor Dokumen", "formatType" => "invoiceNumberText"],
            ]),

            array("title" => "KONSUMEN", "columns" => [
                ["field" => "CustomerKTPNumber", "title" => "KTP", "width" => 160],
                ["field" => "CustomerNPWPNumber", "title" => "NPWP", "width" => 200],
                ["field" => "CustomerName", "title" => "Nama", "width" => 200],
                ["field" => "CustomerAddress", "title" => "Alamat", "width" => 400],
            ]),

            array("title" => "UNIT", "columns" => [
                ["field" => "UnitVIN", "title" => "Rangka", "width" => 160],
                ["field" => "UnitEngineNumber", "title" => "Mesin", "width" => 150],
                ["field" => "OrderNumberText", "title" => "No Order", "width" => 200],
                ["field" => "VehicleGroup", "title" => "Model", "width" => 150],
                ["field" => "VehicleType", "title" => "Tipe", "width" => 200],
                ["field" => "Caroserie", "title" => "Karoseri", "width" => 200],
            ]),

            array("field" => "Qty", "title" => "Qty", "formatType" => "numeric"),
            array("field" => "LeasingDP", "title" => "DP / TDP", "formatType" => "currency"),
            array("field" => "OTR", "title" => "OTR", "formatType" => "currency"),
            array("field" => "Pelunasan", "title" => "Pelunasan", "formatType" => "currency"),
            array("field" => "CadBBNNotice", "title" => "Notice", "formatType" => "currency"),
            array("field" => "OffTheRoad", "title" => "Off The Road", "formatType" => "currency"),
            array("field" => "TotalDiscount", "title" => "Diskon", "formatType" => "currency"),
            array("field" => "ARPrice", "title" => "Harga Jual", "formatType" => "currency"),

            array("title" => "PPN KELUAR", "columns" => [
                ["field" => "PPNOutLeasingDP", "title" => "DP / TDP", "formatType" => "currency"],
                ["field" => "PPNOutPelunasan", "title" => "Pelunasan", "formatType" => "currency"],
                ["field" => "PPNOutBBNNoticePrice", "title" => "Notice", "formatType" => "currency"],
                ["field" => "PPNOutDiscount", "title" => "Diskon", "formatType" => "currency"],
                ["field" => "PPNOutTotal", "title" => "Total", "formatType" => "currency"],
            ]),

            ["field" => "DPP", "title" => "DPP Jual", "formatType" => "currency"],
            ["field" => "HPP", "title" => "HPP Beli", "formatType" => "currency"],

            array("title" => "INVESTASI", "columns" => [
                ["field" => "CadInvestasi", "title" => "Cadangan", "formatType" => "currency"],
                ["field" => "CadInvestasiTambahan", "title" => "Tambahan", "formatType" => "currency"],
            ]),
            array("field" => "GPBeforeProgram", "title" => "GP sblm program", "formatType" => "currency"),

            array("title" => "PROGRAM ASTRA", "columns" => [
                ["field" => "AstraClaimFakpol", "title" => "Fakpol", "formatType" => "currency"],
                ["field" => "AstraCashBack", "title" => "Cash Back", "formatType" => "currency"],
                ["field" => "AstraOther", "title" => "Lain", "formatType" => "currency"],
                ["field" => "AstraTotal", "title" => "Total", "formatType" => "currency"],
            ]),
            array("field" => "GPAfterProgram", "title" => "GP stlh program", "formatType" => "currency"),

            array("field" => "LeasingARInsuranceRefund", "title" => "Refund Asuransi", "formatType" => "currency"),
            array("field" => "GPAfterRefund", "title" => "GP stlh refund", "formatType" => "currency"),

            array("title" => "CADANGAN", "columns" => [
                ["field" => "CadAksesoris", "title" => "Aksesoris", "formatType" => "currency"],
                ["field" => "CadBBNUnNotice", "title" => "Un Notice", "formatType" => "currency"],
                ["field" => "CadFeeCabang", "title" => "Fee Cabang", "formatType" => "currency"],
                ["field" => "CadInsentifTotal", "title" => "Insentif", "formatType" => "currency"],
                ["field" => "CadPDI", "title" => "PDI", "formatType" => "currency"],
                ["field" => "CadMediator", "title" => "Mediator", "formatType" => "currency"],
                ["field" => "CadOngkirMainDealer", "title" => "Ongkir MD", "formatType" => "currency"],
                ["field" => "CadOngkirKonsumen", "title" => "Ongkir Konsumen", "formatType" => "currency"],
                ["field" => "CadBungaDO", "title" => "Bunga DO", "formatType" => "currency"],
                ["field" => "CadDeco", "title" => "Perbaikan", "formatType" => "currency"],
                ["field" => "CadanganLain", "title" => "Lain", "formatType" => "currency"],
                ["field" => "CadanganTotal", "title" => "Total", "formatType" => "currency"],
            ]),
            array("field" => "GPAfterCadangan", "title" => "GP stlh cadangan", "formatType" => "currency"),

            array("field" => "PPNIn", "title" => "PPN Masuk", "formatType" => "currency"),
            array("field" => "DiffPPNOutIn", "title" => "Selisih PPN", "formatType" => "currency"),
            array("field" => "SalesMethod", "title" => "Tipe Penjualan", "width" => 100),
            array("title" => "KREDIT", "columns" => [
                ["field" => "LeasingName", "title" => "Vendor Leasing", "width" => 250],
                ["field" => "LeasingTenor", "title" => "Tenor", "formatType" => "numeric"],
            ]),
            array("title" => "TIPE ASURANSI (Thn)", "columns" => [
                ["field" => "LeasingInsuranceAllRisk", "title" => "All Risk", "formatType" => "numeric"],
                ["field" => "LeasingInsuranceTLO", "title" => "TLO", "formatType" => "numeric"],
                ["field" => "LeasingInsuranceMix", "title" => "Mix", "formatType" => "numeric"],
            ]),

            array("title" => "SALES FORCE", "columns" => [
                ["field" => "SalesmanEmployeeId", "title" => "NIK", "formatType" => "numeric"],
                ["field" => "SalesmanEmployeeName", "title" => "Nama", "width" => 200],
                ["field" => "SalesmanEmployeePosition", "title" => "Grade", "width" => 200],
            ]),

            array("title" => "TEAM LEADER", "columns" => [
                ["field" => "TeamLeaderEmployeeId", "title" => "NIK", "formatType" => "numeric"],
                ["field" => "TeamLeaderEmployeeName", "title" => "Nama", "width" => 200],
                ["field" => "TeamLeaderEmployeePosition", "title" => "Grade", "width" => 200],
            ]),
        ),
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
