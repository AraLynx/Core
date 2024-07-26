
<script>
    let otherBranches = <?php echo json_encode($_OTHER_BRANCHES);?>;
</script>
<script src="/<?php echo CORE_JS;?>default_switchBranch.js" defer></script>
<?php
$formParams = array(
    "page"  => "default",
    "group" => "default",
    "id" => "SwitchBranch",
    "defaultLabelCol" => 2,
    "submitButtonColor" => "warning",
    "submitFontAwesomeIcon" => "fa-solid fa-repeat",
    "submitText" => "SWITCH BRANCH",
    "ajaxJSUrl" => "'/".CORE_AJAX."login/loginBranchLogin",
);
$form = new \app\components\Form($formParams);
$form->begin();
$form->addField(["labelText" => "Branch", "inputType" => "kendoDropDownList", "inputName"=>"BranchId", "required" => true]);
$form->end();
$windowParams = array(
    "page" => "default"
    ,"group" => "default"
    ,"id" => "SwitchBranch"
    ,"title" => "Switch Branch"
    ,"body" => $form->getHtml()
);
$window = new \app\components\KendoWindow($windowParams);
$window->begin();
$window->end();
$window->render();
