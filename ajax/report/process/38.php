<?php
$Year = $ajax->getPost('DateApplyYear');
$Month = $ajax->getPost('DateApplyMonth');

$IdMonth = strlen($Month);
    if ($IdMonth === 1)
    {
        $Month = "0".$Month;
    }
    $DateApply = $Year."-".$Month."-01";

$SP->removeParameters(["DateApplyYear","DateApplyMonth"]);
$SP->addParameter('DateApply', $DateApply);

$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
$data = $q;
$SP->SPPrepare($q);
$SP->execute();
$report = $SP->getRow();