<script src="/<?php echo COMMON_JS;?>default_worker.js" defer></script>
<?php
$formParams = array(
    "page" => "default",
    "group" => "default",
    "id" => "Worker",
    "isHidden" => true,
    "buttonsIsShow" => false,
    "ajaxJSUrl" =>  "linkDefaultAjax+'defaultWorker",
    "ajaxJSIsShowModal" => false,
    "ajaxJSIsFail" => true,
    "ajaxJSIsAlways" => true,
);
$form = new \app\pages\Form($formParams);
$form->begin();
if(APP_NAME == "Plutus")
{
    $form->addField(["inputName" => "BranchId", "inputValue" => $_BRANCH->Id]);
}
$form->addField(["inputName" => "EmployeeId", "inputValue" => $_EMPLOYEE["Id"]]);
$form->addField(["inputName" => "PositionId", "inputValue" => $_EMPLOYEE["PositionId"]]);
$form->addField(["inputName" => "StatusCode", "inputValue" => "WMAP"]);
$form->end();
$form->render();
