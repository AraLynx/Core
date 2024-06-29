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
$ajax->addValidation("post","Id",["required"]);
$ajax->addValidation("post","Name",["required"]);
$ajax->addValidation("post","IsEnable",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","Id",["int"]);
$ajax->addSanitation("post","Name",["string"]);
$ajax->addSanitation("post","IsEnable",["int"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    $SP =new StoredProcedure("uranus");
    $SP->tranStart();
    $SP->tranTry("SP_News_settingsEditNewsCategory", ["Id" => $ajax->post["Id"], "Name" => $ajax->post["Name"], "IsEnable" => $ajax->post["IsEnable"], "EditedByUserId" => $ajax->post["loginUserId"]]);
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
