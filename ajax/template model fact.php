<?php
use app\modelFacts;
if($app->getStatusCode() == 100)
{
    $factParams = [
        "recursiveOrder" => 99// DEFAULT 0
        ,"isGenerateDim" => true //DEFAULT false
    ];
    $model = new SomeFactClass($factParams);
    $model->initParameter($ajax->post);
    $model->removeParameters(["loginUserId"]);//buang index post loginUserId
    $records = $employees->F5();
    $datas = $records;

    foreach($records AS $index => $record)
    {
        //IF RECORD HAS NO CLASS
        $datas[] = [
            "field1" => $record["field1"]
            ,"field2" => $record["field2"]
        ];

        //IF RECORD HAS CLASS
        $datas[] = [
            "field1" => $record->field1
            ,"field2" => $record->someFunction1()
            ,"field3" => $record->someFunction2()
        ];
    }
}

