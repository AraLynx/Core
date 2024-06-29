<?php
session_start();
//echo "<pre>";var_dump($_SESSION);echo "</pre>";

require_once __DIR__.'/../const.php';
require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
require_once __DIR__.'/../params.php';

use app\core\Application;
$app = new Application(dirname(__DIR__), PARAMS);
//dd($app);

//GENERATE SESSION KEY
if(!isset($_SESSION["key"]))
    $_SESSION["key"] = bin2hex(random_bytes(32));
if(!isset($_SESSION[APP_NAME]))
    $_SESSION[APP_NAME] = array();

use app\controllers\DefaultController;

$app->router->get($app->request->getPath(), [DefaultController::class, 'blank']);
$app->run();
