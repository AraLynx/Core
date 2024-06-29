<?php
use app\core\StoredProcedure;

if($app->getStatusCode() == 100)
{
    //-------------------------------- STORED PROCEDURE
    $SP = new StoredProcedure(APP_NAME, "SP_spName");
    $SP->initParameter($ajax->getPost());
    $SP->removeParameters(["loginUserId"]);//buang index post loginUserId
    //$SP->addParameters(["ExecutedByUserId" => $ExecutedByUserId,"OtherKey" => "OtherValue"]);//tambah parameter
    //$SP->renameParameter("loginUserId","UserId");
    //$data = $SP->SPGenerateQuery();
    //$data = $SP->f5()[0];
    //$datas = $SP->f5();
}
