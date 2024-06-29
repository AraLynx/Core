<?php
use app\core\StoredProcedure;

if($app->getStatusCode() == 100)
{
    //-------------------------------- STORED PROCEDURE
    $SP = new StoredProcedure(APP_NAME);
    $SP->tranStart();
    $SP->tranTry("SP_NAME_1", ["Param1" => $Value1, "Param2" => $Value2, "Param3" => $Value3]);
    $SP->tranTry("SP_NAME_2", ["Param4" => $Value4, "Param5" => $Value5, "Param6" => $Value6]);
    $SP->tranEnd();
    $data = $SP->tranF5();


    //-------------------------------- BILA BUTUH [inserted].[Id] UNTUK SP CHILD NYA
    $SP = new StoredProcedure(APP_NAME);
    $SP->tranStart();
    $SP->tranDeclare("InsertedId1", "INT");
    $SP->tranDeclare("InsertedId2", "INT");

    $SP->tranTry("SP_NAME_1", ["DBValidation" => "@DB_VALIDATION_MESSAGE","Param1" => $Value1, "Param2" => $Value2, "Param3" => $Value3, "OutputId" => "@InsertedId1"]);
    foreach($array1 AS $index1 => $data1)
    {
        $SP->tranTry("SP_NAME_2", ["DBValidation" => "@DB_VALIDATION_MESSAGE","ParentId" => "!InsertedId1", "Param4" => $data1["value4"], "Param5" => $data1["value5"], "Param6" => $data1["value6"], "OutputId" => "@InsertedId2"]);
        foreach($data1["children"] AS $index2 => $data2)
        {
            $SP->tranTry("SP_NAME_3", ["DBValidation" => "@DB_VALIDATION_MESSAGE","ParentId" => "!InsertedId2", "Param7" => $data2["value7"], "Param8" => $data2["value8"], "Param9" => $data2["value9"]]);
            //dan seterusnya
        }
    }

    $SP->tranEnd();
    $data = $SP->tranF5();

    /*
    OUTPUT $data
    BISA DI CEK DI JS

    KALAU SUKSES
    $data["IsError"] =  0

    KALAU ERROR = 1 (SP ERROR)
    $data["IsError"] =  1
    $data["ErrorNumber"]
    $data["ErrorSeverity"]
    $data["ErrorState"]
    $data["ErrorProcedure"]
    $data["ErrorLine"]
    $data["ErrorMessage"]

    KALAU ERROR = 2 (MANUAL DB VALIDATION ERROR)
    $data["IsError"] =  2
    $data["DBValidationMessage"]
    */
}
