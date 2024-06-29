<?php
$field = $ajax->getPost("Field");
$dateStart = $ajax->getPost("ValueStart");
$dateEnd = $ajax->getPost("ValueEnd");

if($field === 'CLAIM') {
    $SP->addParameter('ClaimDateStart', $dateStart);
    $SP->addParameter('ClaimDateEnd', $dateEnd);
}
else if($field === 'NOTA') {
    $SP->addParameter('CompleteDateStart', $dateStart);
    $SP->addParameter('CompleteDateEnd', $dateEnd);
}

$SP->removeParameters(['Field', 'ValueStart', 'ValueEnd', 'ProgramTypeName', 'StatusName']);

$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

$SP->execute();
$report = $SP->getRow();
