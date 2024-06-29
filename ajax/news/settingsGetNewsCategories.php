<?php
use app\core\Application;
use app\core\Ajax;

require_once __DIR__.'/../../init.php';
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../../configs/ajax.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__,2));
$dotenv->load();
require_once dirname(__DIR__,2).'/params.php';
$app = new Application(dirname(__DIR__), PARAMS);

//-------------------------------- INIT
$PageId = $_POST["PageId"];
unset($_POST["PageId"]);
$ajax = new Ajax(pageId:$PageId);
//FORM VALIDATION
$ajax->addValidation("post","GaiaModuleId",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","GaiaModuleId",["int"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    $model =new \app\modelDims\UranusNewsCategory();
    $model->addParameters(["GaiaModuleId" => $ajax->post["GaiaModuleId"]]);
    $model->setAdditionalField("TEMP_Get",["concatenate", "",["<i class='fa-regular fa-eye' role='button' title='Edit News Category' onClick='settingsEditNewsCategoryPrepareData(","Id",",&apos;","Name","&apos;,","IsEnable",")'></i>"]]);
    $model->setAdditionalField("TEMP_Action",["concatenate", "",["TEMP_Get"]]);
    $model->setAdditionalField("NameProfile",["concatenate", "  ",["TEMP_Action", "Name"]]);
    $datas = $model->f5();
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
