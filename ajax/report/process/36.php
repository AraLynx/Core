<?php
$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
$data = $q;
// dd($data);
$SP->SPPrepare($q);
$SP->execute();
$report = $SP->getRow();
// dd($report);