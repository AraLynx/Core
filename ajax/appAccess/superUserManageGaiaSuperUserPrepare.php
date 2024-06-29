<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax("crud");

//FORM SANITATION
$ajax->addSanitation("post","Id",["int"]);
$ajax->sanitize('post');

//-------------------------- MODEL
//*GET USER
$model = new \app\modelAlls\UranusUser();
$model->initParameter($ajax->post);
$model->removeParameters(["loginUserId"]);//buang index post loginUserId
//$data = $model->getQuery();
$records = $model->f5();
$data = $records[0];

//*GENERATE DEPT LIST
$datas["access"] = [];
$model = new \app\modelDims\GaiaModule();
$model->addParameters(["IsEnable" => 1, "NotId" => 1]);
//echo $model->getQuery();
$modules = $model->f5();
foreach($modules AS $index => $module)
{
    $datas["access"][$module->Id] = 0;
}

//*SET ACCESS
$model = new \app\modelRels\GaiaSuperUser();
$model->addParameters(["UserId" => $ajax->post["Id"]]);
//$data = $model->getQuery();
$records = $model->f5();
foreach($records AS $index => $rel)
{
    if(isset($datas["access"][$rel->ModuleId]))
        $datas["access"][$rel->ModuleId] = 1;
}

if(!is_null(error_get_last()))
{
    $ajax->setStatusCode(500);
}
else
{
    if($ajax->getStatusCode() == 100)
    {
        $ajax->setData($data);
        $ajax->setDatas($datas);
        $ajax->setError($message);
    }
}
$ajax->end();
