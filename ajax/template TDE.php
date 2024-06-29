<?php
if($app->getStatusCode() == 100)
{
    //-------------------------- TDE KENDO GRID HELPER
    $Helper = new \app\TDEs\KendoGridHelper();
    $Helper->addDatas("dataName1", $datas1);
    $Helper->addDatas("dataName2", $datas2);
    //$Helper->addDatas(["dataName1" => $datas1,"dataName2" => $datas2]);



    $Helper->saveParentData("output");
    $datas = $Helper->getSavedData("output");
}
