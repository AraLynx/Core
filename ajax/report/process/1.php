<?php
$Year = $ajax->getPost("DateYear");
$Month = $ajax->getPost("DateMonth");
$SP->addParameter("Date", date("{$Year}-{$Month}-t", strtotime("{$Year}-{$Month}-01")));

$SP->removeParameters(["DateYear", "DateMonth"]);

$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);
$SP->execute();
$report = $SP->getRow();
