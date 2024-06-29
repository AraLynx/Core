
<?php
$SP->removeParameters(["VehicleGroupName","VehicleTypeName"]);

$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

$SP->setAdditionalField("Cabang", ["implode", " ", ["CompanyAlias", "BranchName"]]);
$SP->setAdditionalField("VehicleTypeAll", ["implode", " - ", ["VehicleType", "VehicleTypeAlias"]]);

$SP->execute();
$report = $SP->getRow();
