
<script src="/<?php echo CORE_JS;?>default_changeLog.js" defer></script>
<?php
$title = "Change Log";
$body = "Information goes here";
$params = array(
    "page" => "default",
    "group" => "default",
    "id" => "ChangeLog",
    "width" => "750px",
    "height" => "500px",
    "pinned" => true,
    "title" => $title,
    "body" => $body,
);
$changeLogKendoWindow = new \app\components\KendoWindow($params);
$changeLogKendoWindow->begin();
$changeLogKendoWindow->end();
$changeLogKendoWindow->render();

$formParams = array(
    "page" => "default",
    "group" => "defaultChangeLog",
    "id" => "GetChangeLogsFromSidebar",
    "isHidden" => true,
    "buttonsIsShow" => false,
    "ajaxJSUrl" =>  "linkDefaultAjax+'defaultChangeLogGetChangeLogsFromSidebar",
);
$form = new \app\components\Form($formParams);
$form->begin();
$form->end();
$form->render();

$formParams = array(
    "page" => "default",
    "group" => "defaultChangeLog",
    "id" => "GetChangeLogs",
    "isHidden" => true,
    "buttonsIsShow" => false,
    "ajaxJSUrl" =>  "linkDefaultAjax+'defaultChangeLogGetChangeLogs",
);
$form = new \app\components\Form($formParams);
$form->begin();
$form->addField(["inputName" => "ModuleId"]);
$form->addField(["inputName" => "PageId"]);
$form->end();
$form->render();

$formParams = array(
    "page" => "default",
    "group" => "defaultChangeLog",
    "id" => "GetChangeLog",
    "isHidden" => true,
    "buttonsIsShow" => false,
    "ajaxJSUrl" =>  "linkDefaultAjax+'defaultChangeLogGetChangeLog",
);
$form = new \app\components\Form($formParams);
$form->begin();
$form->addField(["inputName" => "Id"]);
$form->end();
$form->render();



//FOR TESTING ONLY
/*
echo "<div id='defaultChangeLogContent' class='d-none'>";
require_once 'ChangeLog/tester.php';
echo "</div>";

echo "<script>
    $(document).ready(function(){
        TDE.defaultKendoWindowChangeLog.body($('#defaultChangeLogContent').html());
    });
</script>";
*/
