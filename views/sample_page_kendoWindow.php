<?php
$windowParams = array(
    "page" => "page_name"
    ,"group" => "group_name"
    ,"id" => "kendoWindowId"
    ,"title" => "SOME TITLE"
    ,"body" => "SOME BODY"
);
$window = new \app\pages\KendoWindow($windowParams);
$window->begin();
$window->end();
$window->render();
