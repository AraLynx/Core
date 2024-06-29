<?php
$gridDetailInit = [
    "page" => "page_name",
    "group" => "group_name",
    "id" => "kendoGridId_DetailInitId",
    "toolbarString" => "<div class=\'btn btn-secondary\' onClick=\'someFunction();\'><i class=\'fa-solid fa-search\'></i> SOME TEXT</div>",//DEFAULT ""
    "toolbars" => ["some button", "other button"],//DEFAULT []
    "excelFileName" => "SOME EXCEL FILE NAME",//DEFAULT ""
    "columnMenu" => false,//DEFAULT true
    "filterable" => false,//DEFAULT true
    "sortable" => false,//DEFAULT true
    "resizable" => false,//DEFAULT true
    "groupable" => true,//DEFAULT false
    "height" => "300",//DEFAULT 500 : TIDAK BERFUNGSI UNTUK "isDetailInit" => true

    "pageable" => false,//DEFAULT true
    "pageRefresh" => true,//DEFAULT false
    "pageSizes" => true,//DEFAULT false
    "pageButtonCount" => 5,//DEFAULT 0
    "pageSize" => 25,//DEFAULT 50

    "rowClass" => "DataClass",//DEFAULT RowClass
    "rowExpand" => "all",//DEFAULT persist ; option : all, first, persist

    "isDetailInit" => true,//DEFAULT false
    "detailInit" => "",//DEFAULT ""

    "columns" => [
        [
            "field" => "Some_Column_Name",
            "template" => "", //DEFAULT false
            "title" => "Some Column Name", //DEFAULT str_replace("_"," ",$field);
            "locked" => true, //DEFAULT false
            "formatType" => "currency", //DEFAULT false ; option : currency, percentage, numeric, date, time, dateTime, faIcon, action
            "formatManual" => "", //DEFAULT ""
            "width" => 150, //DEFAULT false
            "attributes" => ["class" => "retro_red, h6"], //DEFAULT []
            "encoded" => true, //DEFAULT false

            "groupable" => false, //DEFAULT true
                "aggregates" => ["min", "max", "count", "sum", "average"], //DEFAULT []
                "headerTemplate" => "Total: #= sum #", //DEFAULT ""
                "groupHeaderTemplate" => "Total: #= sum #", //DEFAULT ""
                "footerTemplate" => "Average: #= average #", //DEFAULT ""
                "groupFooterTemplate" => "Average: #= average #", //DEFAULT ""
        ],
    ],
];
$gridDetailInit = new \app\pages\KendoGrid($gridDetailInit);
$gridDetailInit->begin();
$gridDetailInitFunctionName = $gridDetailInit->end();
$gridDetailInit->render();

$gridParams = [
    "page" => "page_name",
    "group" => "group_name",
    "id" => "kendoGridId",
    "toolbarString" => "<div class=\'btn btn-secondary\' onClick=\'someFunction();\'><i class=\'fa-solid fa-search\'></i> SOME TEXT</div>",//DEFAULT ""
    "toolbars" => ["some button", "other button"],//DEFAULT []
    "excelFileName" => "SOME EXCEL FILE NAME",//DEFAULT ""
    "columnMenu" => false,//DEFAULT true
    "filterable" => false,//DEFAULT true
    "sortable" => false,//DEFAULT true
    "resizable" => false,//DEFAULT true
    "groupable" => true,//DEFAULT false
    "height" => "300",//DEFAULT 500 : TIDAK BERFUNGSI UNTUK "isDetailInit" => true

    "pageable" => false,//DEFAULT true
    "pageRefresh" => true,//DEFAULT false
    "pageSizes" => true,//DEFAULT false
    "pageButtonCount" => 5,//DEFAULT 0
    "pageSize" => 25,//DEFAULT 50

    "rowClass" => "DataClass",//DEFAULT RowClass
    "rowExpand" => "all",//DEFAULT persist ; option : all, first, persist

    "isDetailInit" => true,//DEFAULT false
    "detailInit" => $gridDetailInitFunctionName,//DEFAULT ""

    "columns" => [
        ["formatType" => "rowNumber"],//NO URUT
        ["field" => "Action", "formatType" => "action"],//TOMBOL ACTION
        [
            "field" => "Some_Column_Name",
            "template" => "", //DEFAULT false
            "title" => "Some Column Name", //DEFAULT str_replace("_"," ",$field);
            "locked" => true, //DEFAULT false
            "formatType" => "currency", //DEFAULT false ; option : currency, percentage, numeric, date, time, dateTime, faIcon, action
            "formatManual" => "", //DEFAULT ""
            "width" => 150, //DEFAULT false
            "attributes" => ["class" => "retro_red, h6"], //DEFAULT []
            "encoded" => true, //DEFAULT false

            "groupable" => false, //DEFAULT true
                "aggregates" => ["min", "max", "count", "sum", "average"], //DEFAULT []
                "headerTemplate" => "Total: #= sum #", //DEFAULT ""
                "groupHeaderTemplate" => "Total: #= sum #", //DEFAULT ""
                "footerTemplate" => "Average: #= average #", //DEFAULT ""
                "groupFooterTemplate" => "Average: #= average #", //DEFAULT ""
        ],
    ],
    "detailInit" => $gridDetailInitFunctionName,
];

$grid = new \app\pages\KendoGrid($gridParams);
$grid->begin();
$grid->end();
$grid->render();
