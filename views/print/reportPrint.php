<?php
$linkToReportFolder = "../../Chronos/views/print/";

$ReportId = $post["ReportId"];
$CompanyId = $post["CompanyId"];
$CompanyName = $post["CompanyName"];
$BranchId = $post["BranchId"];
$BranchName = $post["BranchName"];
$POSId = $post["POSId"];
$POSName = $post["POSName"];

$filePath = "report/{$ReportId}.php";
if(file_exists("{$linkToReportFolder}{$filePath}")) require_once $filePath;
