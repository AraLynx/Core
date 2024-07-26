<?php
#region FORM GET DATA
$formParams = array(
    "page" => "page_name"
    ,"group" => "group_name"
    ,"id" => "form_id"
    ,"isHidden" => true
);
$form = new \app\components\Form($formParams);
$form->begin();
$form->addField(array("inputType" => "password","inputValue" => "some_value"));
$form->end();
$form->render();
#endregion
