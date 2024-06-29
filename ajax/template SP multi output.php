<?php
use app\core\StoredProcedure;

if($app->getStatusCode() == 100)
{
    $SP = new StoredProcedure(APP_NAME);
    $SP->initParameter($ajax->getPost());
    $SP->removeParameters(["loginUserId"]);//buang index post loginUserId
    //$SP->addParameters(["ExecutedByUserId" => $ExecutedByUserId,"OtherKey" => "OtherValue"]);//tambah parameter
    //$SP->renameParameter("loginUserId","UserId");

    $q = "EXEC [SP_XX_AjaxName]";
    $q .= $SP->SPGenerateParameters();
    //$data = $q;
    $SP->SPPrepare($q);
    //-------------------------- Sanitize output
    $SP->addSanitation("outputColumn",["string"]);
    /*
    string      : ada sanitasi addslashes
    upper       : tulisan menjadi auto kapital
    date        : tulisan 10 char
    time        : tulisan 8 char
    dateTime    : tulisan 19 char
    bool        : ada isi = 1, kosong = 0
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
    $SP->execute();
    $firstData = $SP->getRow();
    //$datas["firstData"] = $firstData;

    //-------------------------- Sanitize 2nd output
    $SP->addSanitation("outputColumn",["string"]);
    $SP->nextRowset();
    $secondData = $SP->getRow();
    //$datas["secondData"] = $secondData;
}
