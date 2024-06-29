<?php
$dateType = $ajax->getPost("DateType");
switch($dateType){
    case "REGISTER" : $dateType = "Register Date"; break;
    case "DISTRIBUTION" : $dateType = "Distribution Date"; break;
    case "TTUM" : $dateType = "SPK Date"; break;
    case "INVOICE" : $dateType = "Invoice Date"; break;
}
$headerInfos[$dateType] = "{$ajax->getPost("DateValueStart")} s/d {$ajax->getPost("DateValueEnd")}";

$tryHeaderInfos["VehicleGroupName"] = "Vehicle Group";
$tryHeaderInfos["VehicleTypeName"] = "Vehicle Type";
$tryHeaderInfos["ColorDescription"] = "Color";
$tryHeaderInfos["StatusName"] = "Status";

if($ajax->getPost("DocumentNumberType") == "SPKNumber"){$documentNumberType = "SPK Number"; }
else {$documentNumberType = "Invoice Number"; }
$tryHeaderInfos["DocumentNumberValue"] = $documentNumberType;

if($ajax->getPost("EmployeeType") == "TeamLeaderName"){$employeeType = "Team Leader Name"; }
else {$employeeType = "Sales Name"; }
$tryHeaderInfos["EmployeeValue"] = $employeeType;

if($ajax->getPost("CustomerType") == "CustomerName"){$customerType = "Customer Name"; }
else {$customerType = "STNK Name"; }
$tryHeaderInfos["CustomerValue"] = $customerType;

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

if($ajax->getPost("ReportVersion") == "summary")
{
    $spreadSheet->map(["SPKNo","No SPK"],["formatCell" => "numeric"])
        ->map(["RegisterDate","Tgl Register"],["formatCell" => "date"])
        ->map(["DistributionDate","Tgl Distribusi"],["formatCell" => "date"])
        ->map(["SPKDate","Tgl SPK"], ["formatCell" => "date"])
        ->map(["Status","Status"])
        ->map(["POSName","POS"])
        ->map([["PelangganPanggilan","PelangganNama"],"Nama Konsumen"])
        ->map([["VehicleGroup","VehicleType"],"Tipe Unit"])
        ->map(["TeamLeaderName","Nama Team Leader"])
        ->map(["SalesName","Nama Sales"]);
}

if($ajax->getPost("ReportVersion") == "detail")
{
    $spreadSheet
    ->startHeaderGroup("SPK")
        ->map(["SPKNo","No SPK"],["formatCell" => "numeric"])
        ->map(["RegisterDate","Tgl Register"],["formatCell" => "date"])
        ->map(["DistributionDate","Tgl Distribusi"],["formatCell" => "date"])
        ->map(["LostDate","Tgl Hilang"],["formatCell" => "date"])
        ->map(["SPKDate","Tgl SPK"], ["formatCell" => "date"])
        ->map(["InvoiceDate","Tgl Invoice"], ["formatCell" => "date"])
        ->map(["Status","Status"])
        ->map(["InvoiceNoText","No Invoice"])
        ->map(["POSName","POS"])

    ->startHeaderGroup("Team Leader & Sales")
        ->map(["TeamLeaderNIK","NIK Team Leader"])
        ->map(["TeamLeaderName","Nama Team Leader"])
        ->map(["SalesNIK","NIK Sales"])
        ->map(["SalesName","Nama Sales"])

    ->startHeaderGroup("Approval")
        ->map(["ApprovalKacab","KACAB / SM"])
        ->map(["ApprovalADH","ADH"])
        ->map(["ApprovalOM","OM"])
        ->map(["ApprovalDeputy","Deputi"])

    ->startHeaderGroup("Oportuniti")
        ->map(["OportunitiNo","Nomor"])
        ->map(["OportunitiTgl","Tgl Oportuniti"], ["formatCell" => "date"])

    ->startHeaderGroup("Data Pelanggan")
        ->map(["PelangganNo","No Pelanggan"])
        ->map([["PelangganPanggilan","PelangganNama"],"Nama Pelanggan"])
        ->map([["PelangganAlamat1","PelangganAlamat2","PelangganAlamatRT","PelangganAlamatRW"],"Alamat"])
        ->map(["PelangganAlamatKelurahan","Kelurahan"])
        ->map(["PelangganAlamatKecamatan","Kecamatan"])
        ->map(["PelangganAlamatKabupaten","Kabupaten"])
        ->map(["PelangganAlamatPropinsi","Propinsi"])

    ->startHeaderGroup("Data Unit")
        ->map(["MaterialCode","Kode Material"])
        ->map([["VehicleGroup","VehicleType"],"Tipe Unit"])
        ->map(["UnitColor","Warna"])
        ->map(["NilaiJual","Harga Nota"], ["formatCell" => "currency", "aggregate" => "sum"])

    ->startHeaderGroup("Data STNK")
        ->map([["STNKPanggilan","STNKNama"],"Nama STNK"])
        ->map([["STNKAlamat1","STNKAlamat2","STNKAlamatRT","STNKAlamatRW"],"Alamat STNK"])
        ->map(["STNKAlamatKelurahan","Kelurahan STNK"])
        ->map(["STNKAlamatKecamatan","Kecamatan STNK"])
        ->map(["STNKAlamatKabupaten","Kabupaten STNK"])
        ->map(["STNKAlamatPropinsi","Propinsi STNK"])
    ->endHeaderGroup();
}

$datas["FileLink"] = $spreadSheet->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
