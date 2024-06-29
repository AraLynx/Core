<?php
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax("crud");
//FORM VALIDATION
$ajax->addValidation("post","inputName",["required"]);
/*
required    : tidak boleh kosong
hidden      : tidak boleh kosong, sama seperti required
email       : untuk bentuk isian email, validasi by php dgn FILTER_VALIDATE_EMAIL
min         : untuk angka dengan minimum nilai tertentu (rule[1])
                usage [OTHER_RULE, ["min",3], OTHER_RULE]
max         : untuk angka dengan maksimal nilai tertentu (rule[1])
                usage [OTHER_RULE, ["max",3], OTHER_RULE]
match       : untuk cek pengisian sama atau tidak dengan input yg lain [rule[1]]
                usage [OTHER_RULE, ["match","password1"], OTHER_RULE]
*/
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","inputName",["string"]);
/*
string      : ada sanitasi addslashes
upper       : tulisan menjadi auto kapital
date        : tulisan 10 char
time        : tulisan 8 char
dateTime    : tulisan 19 char
bool        : ada isi = true, kosong = false
boolean     : sama dengan bool
int         : convert ke angka bilangan bulat
integer     : sama dengan int
dec         : convert ke angka bilangan pecahan
decimal     : sama dengan dec
                usage [OTHER_RULE, ["dec",$precision], OTHER_RULE]
                $precision DEFAULT = 2 ->[OTHER_RULE, "dec", OTHER_RULE]
ecrypt      : enkripsi input dengan password hash
                usage [OTHER_RULE, ["ecrypt",$algo], OTHER_RULE]
                opsi $algo    = hash      :PASSWORD_DEFAULT (default algo) -> [OTHER_RULE, "ecrypt", OTHER_RULE]
                            = bcrypt    :PASSWORD_BCRYPT
                            = argon2i   :PASSWORD_ARGON2I
                            = argon2id  :PASSWORD_ARGON2ID
*/
$ajax->sanitize('post');
$inputName = $ajax->post["inputName"];
$ExecutedByUserId = $ajax->post["loginUserId"];

$mailHelper = new \app\TDEs\PHPMailerHelper();
//$mailHelper = new \app\TDEs\PHPMailerHelper("debug");
try {
    $mail = $mailHelper->getMail();

    //DOCUMENTATION https://github.com/PHPMailer/PHPMailer

    $mail->addAddress('Email Address', 'Person Name [OPTIONAL]');

    //Content
    $mail->Subject = $Subject;
    $mail->Body = $Body;

    //$mail->addAttachment("/".TDE_ROOT."/".APP_NAME."/some_folder_name/some_file_name.xls", "new_file_name.xls");

    $mail->send();
}
catch (Exception $e) {
    $ajax->setError("Message could not be sent. Mailer Error: {$mail->ErrorInfo}") ;
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
