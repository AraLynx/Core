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
$ajax->addValidation("post","Name",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","GaiaModuleId",["int"]);
$ajax->addValidation("post","Name",["string"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    $SP =new StoredProcedure("uranus");
    $SP->tranStart();
    $SP->tranTry("SP_News_settingsAddNewsCategory", ["GaiaModuleId" => $ajax->post["GaiaModuleId"], "Name" => $ajax->post["Name"], "CreatedByUserId" => $ajax->post["loginUserId"]]);
    $SP->tranEnd();
    $data = $SP->tranF5();
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
