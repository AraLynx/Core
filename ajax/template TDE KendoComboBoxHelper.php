<?php
if($app->getStatusCode() == 100)
{
    //-------------------------- TDE KENDO COMBOBOX HELPER
    $Helper = new \app\TDEs\KendoComboBoxHelper();
    $Helper->addDatas("dataName1", $datas1);
    //$Helper->convertData("output", "Value & TextColumnName");// If Value column name = Text column name
    //$Helper->convertData("output", ["ValueColumnName", "TextColumName"]);
    //$Helper->convertData("output", ["ValueColumnName", "TextColumnName"], true);//3rd param : true : add "SEMUA"

    //IF DATA MANIPULATION IS NEEDED
        $Helper->addField("dataName1", "newValueColumnName", "concat", ["columnName1","someText1","columnName2", "someText2"]);
        $Helper->addField("dataName1", "newTextColumnName", "implode", ["glue", ["columnName1","someText1","columnName2", "someText2"]]);
        $Helper->generateAdditionalFields();
    $Helper->convertData("output", ["newValueColumnName", "newTextColumnName"]);

    $datas = $Helper->getSavedData("output");
}
