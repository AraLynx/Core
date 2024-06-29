<?php
$headerInfos["Periode Nota"] = $ajax->getPost("InvoiceDateStart")." s/d ".$ajax->getPost("InvoiceDateEnd");

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
$datas["FileLink"] = $spreadSheet->map(["BranchAlias","Cabang"])
    ->map(["POSName","POS"])
    ->startHeaderGroup("NOTA")
        ->map(["InvoiceDate","Tanggal"], ["formatCell" => "date"])
        ->map(["CreatedDate","Cetak"], ["formatCell" => "date"])
        ->map(["InvoiceNumber","Nomor Dokumen"])

    ->startHeaderGroup("KONSUMEN")
        ->map(["CustomerKTPNumber","KTP"])
        ->map(["CustomerNPWPNumber","NPWP"])
        ->map(["CustomerName","Nama"])
        ->map(["CustomerAddress","Alamat"])

    ->startHeaderGroup("UNIT")
        ->map(["UnitVIN","Rangka"])
        ->map(["UnitEngineNumber","Mesin"])
        ->map(["OrderNumberText","No Order"])
        ->map(["VehicleGroup","Model"])
        ->map(["VehicleType","Tipe"])
        //->map(["Caroserie","Karoseri"])
    ->endHeaderGroup()

    ->map("Qty", ["formatCell" => "numeric", "aggregate" => "sum"])
    ->map(["LeasingDP","DP / TDP"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map("OTR", ["formatCell" => "currency", "aggregate" => "sum"])
    ->map("Pelunasan", ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["CadBBNNotice","Notice"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["OffTheRoad","Off The Road"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["TotalDiscount","Diskon"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["ARPrice","Harga Jual"], ["formatCell" => "currency", "aggregate" => "sum"])

    ->startHeaderGroup("PPN KELUAR")
        ->map(["PPNOutLeasingDP","DP / TDP"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["PPNOutPelunasan","Pelunasan"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["PPNOutBBNNoticePrice","Notice"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["PPNOutDiscount","Diskon"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["PPNOutTotal","TOTAL"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->endHeaderGroup()

    ->map(["DPP","DPP Jual"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["HPP","HPP Beli"], ["formatCell" => "currency", "aggregate" => "sum"])

    ->startHeaderGroup("INVESTASI")
        ->map(["CadInvestasi","Cadangan"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CadInvestasiTambahan","Tambahan"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->endHeaderGroup()

    ->map(["GPBeforeProgram","GP sblm program"], ["formatCell" => "currency", "aggregate" => "sum"])

    ->startHeaderGroup("PROGRAM ASTRA")
        ->map(["AstraClaimFakpol","Fakpol"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["AstraCashBack","Cash Back"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["AstraOther","Lain"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["AstraTotal","TOTAL"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->endHeaderGroup()
    ->map(["GPAfterProgram","GP stlh program"], ["formatCell" => "currency", "aggregate" => "sum"])

    ->map(["LeasingARInsuranceRefund","Refund Asuransi"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["GPAfterRefund","GP stlh refund"], ["formatCell" => "currency", "aggregate" => "sum"])

    ->startHeaderGroup("CADANGAN")
        ->map(["CadAksesoris","Aksesoris"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CadBBNUnNotice","UnNotice"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CadFeeCabang","Fee Cabang"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CadInsentifTotal","Insentif"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CadPDI","PDI"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CadMediator","Mediator"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CadOngkirMainDealer","Ongkir MD"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CadOngkirKonsumen","Ongkir Konsumen"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CadBungaDO","Bunga DO"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CadDeco","Perbaikan"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CadanganLain","Lain"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CadanganTotal","TOTAL"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->endHeaderGroup()
    ->map(["GPAfterCadangan","GP stlh cadangan"], ["formatCell" => "currency", "aggregate" => "sum"])

    ->startHeaderGroup("BIAYA REAL")
        ->map(["CostAksesoris","Aksesoris"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CostBBNUnNotice","Un Notice"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CostFeeCabang","Fee Cabang"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CostInsentif","Insentif"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CostPDI","PDI"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CostMediator","Mediator"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CostOngkirMainDealer","Ongkir MD"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CostOngkirKonsumen","Ongkir Konsumen"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CostOngkirLain","Ongkir Lain"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CostBungaDO","Bunga DO"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CostDeco","Perbaikan"], ["formatCell" => "currency", "aggregate" => "sum"])
        ->map(["CostTotal","Total"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->endHeaderGroup()
    ->startHeaderGroup("OTHER INCOME")
        ->map(["DiffTotal","TOTAL"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->endHeaderGroup()
    ->map(["GPAfterDiff","GP stlh OI"], ["formatCell" => "currency", "aggregate" => "sum"])

    ->map(["PPNIn","PPN Masuk"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["DiffPPNOutIn","Selisih PPN"], ["formatCell" => "currency", "aggregate" => "sum"])
    ->map(["SalesMethod","Tipe Penjualan"])
    ->startHeaderGroup("KREDIT")
        ->map(["LeasingName","Vendor Leasing"])
        ->map(["LeasingTenor","Tenor"], ["formatCell" => "numeric"])
    ->startHeaderGroup("TIPE ASURANSI (Thn)")
        ->map(["LeasingInsuranceAllRisk","All Risk"], ["formatCell" => "numeric"])
        ->map(["LeasingInsuranceTLO","TLO"], ["formatCell" => "numeric"])
        ->map(["LeasingInsuranceMix","Mix"], ["formatCell" => "numeric"])

    ->startHeaderGroup("SALES FORCE")
        ->map(["SalesmanEmployeeId","NIK"], ["formatCell" => "numeric"])
        ->map(["SalesmanEmployeeName","Nama"])
        ->map(["SalesmanEmployeePosition","Grade"])

    ->startHeaderGroup("TEAM LEADER")
        ->map(["TeamLeaderEmployeeId","NIK"], ["formatCell" => "numeric"])
        ->map(["TeamLeaderEmployeeName","Nama"])
        ->map(["TeamLeaderEmployeePosition","Grade"])

    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
