<?php
namespace app\core;
use Intervention\Image\ImageManager;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();

//FORM VALIDATION
$ajax->addValidation("post","Avatar",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","Avatar",["file"]);
$ajax->sanitize('post');

$avatar = $ajax->moveFile("Avatar", "UserAvatar");

if($app->getStatusCode() == 100)
{
    $SP = new StoredProcedure("uranus", "SP_Sys_profile_accountEditAvatar");
    $SP->initParameter($ajax->post);
    $SP->renameParameter("loginUserId","UserId");
    $SP->addParameters([
        "AvatarFileDirectory" => $avatar["fileDirectory"],
        "AvatarFileName" => $avatar["fileName"]
    ]);
    $SP->f5();

    //CROP SQUARE & RESIZE IMAGE
    $manager = new ImageManager(['driver' => 'gd']);
    $image = $manager->make("../../..{$avatar["fileDirectory"]}/{$avatar["fileName"]}");
    //$image->orientate();

    $heigh = $image->height();
    $width = $image->width();

    if($heigh != 200 || $width != 200)
    {
        if($heigh <  $width)$dimesion = $heigh;
        else $dimesion = $width;

        $image->crop($dimesion, $dimesion)->resize(200,200);
        $image->save("../../..{$avatar["fileDirectory"]}/{$avatar["fileName"]}");
    }
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
