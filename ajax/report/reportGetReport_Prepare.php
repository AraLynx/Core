<?php
if($app->getStatusCode() == 100)
{
    $ReportId = $ajax->getPost("ReportId");
    //FORM VALIDATION
    $ajax->isDynamicForm("post");

    $ajax->addValidation("post","ReportId",["required"]);
    $ajax->addValidation("post","CompanyId",["required"]);

    $ajax->setDynamicForm("_{$ReportId}_");
    require_once __DIR__."/validation/{$ReportId}.php";
    $ajax->validate('post');
}
if($app->getStatusCode() == 100)
{
    //FORM SANITATION
    $ajax->addSanitation("post","ReportId",["string"]);
    $ajax->addSanitation("post","CompanyId",["int"]);
    $ajax->addSanitation("post","BranchId",["int"]);
    $ajax->addSanitation("post","POSId",["int"]);
    require_once __DIR__."/sanitation/{$ReportId}.php";
    $ajax->sanitize('post');

    $ajax->unsetVariable('post',"ReportId");
}
