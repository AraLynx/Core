<?php
$tryHeaderInfos["VehicleGroupName"] = "Group";
$tryHeaderInfos["VehicleTypeName"] = "Type";
$tryHeaderInfos["UnitColorDescription"] = "Warna";
$tryHeaderInfos["UnitVIN"] = "# Rangka";
$tryHeaderInfos["UnitEngineNumber"] = "# Mesin";
$tryHeaderInfos["UnitYear"] = "Tahun Rangka";
$tryHeaderInfos["AgeMinimum"] = "Umur";
$tryHeaderInfos["StatusName"] = "Status";

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

    $datas["FileLink"] = $spreadSheet
        ->map(["VehicleGroupType","Tipe"])
        ->map(["UnitColorDescription","Warna"])
        ->map(["UnitVIN","No Mesin"])
        ->map(["UnitEngineNumber","No Mesin"])
        ->map(["UnitYear","Tahun Mesin"])
        ->map("Status")
        ->map(["Location","Lokasi"])
        ->map(["InvoiceDate","Tanggal DO"], ["formatCell" => "date"])
        ->map(["Age","Umur (Hari)"])
        ->map("Free")
        ->map("Booked")
        ->map(["Sold","Terjual"])
        ->map(["Return","Retur"])
        ->renderData()
        ->autoSize()
        ->end()
        ->getFileLink();
