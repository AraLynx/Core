<?php
$q = "EXEC [SP_Sys_Report_ReportGetReport_{$ReportId}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

$SP->setReturnColumns(["BranchAlias","POSName","CompleteDateTime","PKBNumberText","BookingNumberText","PrePKBNumberText","ReferenceNumber","Type"
    ,"CustomerTitle","CustomerName"
    ,"VehiclePoliceNumber","VehicleVIN","VehicleEngineNumber"
    ,"SrvNonOPLDPP","SrvOPLDPP","SpGenuineDPP","SpBahanDPP","SpCostHPP","SpLainDPP","SpOPLDPP"]);

//Sanitasi semua yang keluar di kendogrid
$SP->addSanitation("CompleteDateTime", ["date"]);

$SP->execute();
$report = $SP->getRow();
