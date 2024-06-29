<?php
$headerInfos["Tanggal SPK"] = $ajax->getPost("DepositDateStart")." s/d ".$ajax->getPost("DepositDateEnd");
$tryHeaderInfos["VINNumber"] = "No Rangka";
$tryHeaderInfos["EngineNumber"] = "No Mesin";
$tryHeaderInfos["SPKNumber"] = "No SPK";
$tryHeaderInfos["CustomerName"] = "Nama Konsumen";
$tryHeaderInfos["STNKName"] = "Nama STNK";
foreach($tryHeaderInfos AS $inputName => $description)
{
    if($ajax->getPost($inputName))
        $headerInfos[$description] = $ajax->getPost($inputName);
}

$datas["FileLink"] = $spreadSheet
    // ->map(["Cabang","POS / Outlet"])
    ->map(["SPKNumberText","No SPK"])
    ->map(["TanggalSPK","Tanggal SPK"])
    ->map(["TanggalNota","Tanggal Nota"])
    ->map(["NoDocument","No Dokumen"])

    ->startHeaderGroup("Konsumen")
        ->map(["NamaPemesan","Nama Konsumen"])
        ->map(["NamaSTNK","Nama STNK"])
        ->map(["Alamat","Alamat"])
        ->map(["NoHandphone","No Handphone"])
    ->endHeaderGroup()

    ->startHeaderGroup("Unit")
        ->map(["NoRangka","No Rangka"])
        ->map(["NoMesin","No Mesin"])
        ->map(["UnitType","Tipe Unit"])
    ->endHeaderGroup()

    ->startHeaderGroup("Leasing")
        ->map(["TipePenjualan","Tipe Penjualan"])
        ->map(["VendorLeasing","Vendor Leasing"])
    ->endHeaderGroup()

    ->startHeaderGroup("Salesman")
        ->map(["NamaSalesman","Nama Sales"])
        ->map(["GradeSalesman","Grade Sales"])
        ->map(["LeaderName","Leader"])
        ->map(["GradeLeader","Grade Leader"])
    ->endHeaderGroup()

    ->startHeaderGroup("Titipan 1")
        ->map(["CD1Date","Tanggal"])
        ->map(["CD1Type","Tipe"])
        ->map(["CD1NoPlutus","No Plutus"])
        ->map(["CD1Nominal","Nominal"],["formatCell" => "currency"])
        ->map(["CD1Metode","Metode"])
    ->endHeaderGroup()

    ->startHeaderGroup("Titipan 2")
        ->map(["CD2Date","Tanggal"])
        ->map(["CD2Type","Tipe"])
        ->map(["CD2NoPlutus","No Plutus"])
        ->map(["CD2Nominal","Nominal"],["formatCell" => "currency"])
        ->map(["CD2Metode","Metode"])
    ->endHeaderGroup()

    ->startHeaderGroup("Titipan 3")
        ->map(["CD3Date","Tanggal"])
        ->map(["CD3Type","Tipe"])
        ->map(["CD3NoPlutus","No Plutus"])
        ->map(["CD3Nominal","Nominal"],["formatCell" => "currency"])
        ->map(["CD3Metode","Metode"])
    ->endHeaderGroup()

    ->renderData()
    ->autoSize()
    ->end()
    ->getFileLink();
