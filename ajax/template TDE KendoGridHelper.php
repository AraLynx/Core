<?php
if($app->getStatusCode() == 100)
{
    //-------------------------- TDE KENDO GRID HELPER
    $Helper = new \app\TDEs\KendoGridHelper();
    $Helper->addDatas("dataName1", $datas1);
    $Helper->addDatas("dataName2", $datas2);
    //$Helper->addDatas(["dataName1" => $datas1,"dataName2" => $datas2]);

    /*SETTING PARENT DATA*/
    $Helper->setParentData("dataName1"/*, "columnId"*/);//columnId default = "Id"
    //$Helper->setParentData("dataName1", ["columnId1","columnId2"]);//bila parent Id gabungan dari 2 atau lebih colom, hasil akhir akan di implode dengan glue "_"

    /*SETTING CHILD DATA, AKAN MASUK KE DALAM ARRAY Items*/
    $Helper->setChildData("dataName2","columnForeignId"/*, "Items"*/);
    //$Helper->setChildData("dataName2",["columnForeignId1","columnForeignId2"]);//bila parent Id gabungan dari 2 atau lebih colom, hasil akhir akan di implode dengan glue "_"

    //otomatis menambahkan RowClass dengan test warna sesuai data IsEnable, IsRelease, IsComplete dan IsCancel
    $Helper->addRowClass("dataName1");
    $Helper->generateAdditionalFields();

    //Buat kolom action by class methode
    $Helper->addActions("dataName1",[
        ["faIcon" => "fa-solid fa-eye", "title" => "Lihat", "functions" => [["name" => "contentNameGetData", "args" => ["Id"]]]],

        /*OS*/
        ["ifs" => ["args" => [["IsEnable",1], ["IsRelease",0], ["IsComplete",0], ["IsCancel",0]]],
            "faIcon" => "fa-solid fa-share", "title" => "Release", "functions" => [["name" => "contentNameSetReleaseDataPrepare", "args" => ["Id"]]]],
        ["ifs" => ["args" => [["IsEnable",1], ["IsRelease",0], ["IsComplete",0], ["IsCancel",0]]],
            "faIcon" => "fa-solid fa-trash", "title" => "Hapus", "functions" => [["name" => "contentNameSetDeleteDataPrepare", "args" => ["Id"]]]],

        /*RL*/
        ["ifs" => ["args" => [["IsEnable",1], ["IsRelease",1], ["IsComplete",0], ["IsCancel",0], ["StatusCode", ["RL AP", "RL AAP"]]]],
            "faIcon" => "fa-solid fa-lock", "title" => "Kunci", "functions" => [["name" => "contentNameSetCompleteDataPrepare", "args" => ["Id"]]]],
        ["ifs" => ["args" => [["IsEnable",1], ["IsRelease",1], ["IsComplete",0], ["IsCancel",0]]],
            "faIcon" => "fa-solid fa-reply", "title" => "UnRelease", "functions" => [["name" => "contentNameSetUnReleaseDataPrepare", "args" => ["Id"]]]],

        /*CO*/
        ["ifs" => ["args" => [["IsEnable",1], ["IsRelease",1], ["IsComplete",1], ["IsCancel",0]]],
            "faIcon" => "fa-solid fa-lock-open", "title" => "Batal", "functions" => [["name" => "contentNameSetCancelDataPrepare", "args" => ["Id"]]]],
    ]);
    $Helper->generateAction();

    //OUTPUT
    $Helper->saveParentData("output");
    $datas = $Helper->getSavedData("output");
}
