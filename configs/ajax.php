<?php
$appName = $_POST["appName"] ?? $_GET["a"];
unset($_POST["appName"]);

require_once dirname(__DIR__,2)."/{$appName}/init.php";
require_once dirname(__DIR__,2)."/{$appName}/vendor/autoload.php";

$isError = false;
$message = "";

$data = "";
$datas = [];

/*
$scriptName = $_SERVER['SCRIPT_NAME'];
$link = str_replace("/tde/","tde/",strtolower($scriptName));
$link = str_replace("/ajax/","/cache/ajax/",strtolower($scriptName));
*/
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__,2)."/{$appName}");
$dotenv->load();
require_once dirname(__DIR__,2)."/{$appName}/params.php";
$app = new \app\core\Application(dirname(__DIR__), PARAMS);
