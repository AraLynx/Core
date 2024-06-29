<?php
namespace app\core;

require_once dirname(__DIR__,3)."/functions/numeric.php";

$SP = new StoredProcedure("uranus");
$SP->addParameters(["RId1" => $RId1]);
$q = "EXEC [SP_Sys_Approval_{$subSPName}]";
$q .= $SP->SPGenerateParameters();
//$data = $q;
$SP->SPPrepare($q);

$SP->addSanitation("InvoiceDate",["date"]);
$SP->addSanitation("POSName",["string"]);
$SP->addSanitation("SPKNumberText",["string"]);
$SP->addSanitation("RefundAsuransi",["int"]);
$SP->addSanitation("LeasingName",["string"]);

$SP->addSanitation("DateTime",["dateTime"]);
$SP->addSanitation("NumberText",["string"]);
$SP->addSanitation("Nominal",["int"]);
$SP->addSanitation("Method",["string"]);

$SP->addSanitation("Description",["string"]);
$SP->execute();
$datas["RefundAsuransi"] = $SP->getRow()[0];
