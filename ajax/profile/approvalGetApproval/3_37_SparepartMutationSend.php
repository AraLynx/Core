<?php
namespace app\core;

//require_once dirname(__DIR__,3)."/functions/numeric.php";

$SP = new StoredProcedure("uranus", "SP_Sys_Approval_{$subSPName}");
$SP->addParameters(["RId1" => $RId1, "RId2" => $RId2, "RId3" => $RId3]);
$tables = $SP->f5();
$datas["SparepartMutation"] = $tables;
foreach($tables[0] AS $index => $row)
{
    $datas["SparepartMutation"] = $row;
}

foreach($tables[1] AS $index => $row)
{
    $datas["SparepartMutationItems"][] = $row;
}
