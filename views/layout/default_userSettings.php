<script src="/<?php echo CORE_JS;?>default_userSettings.js" defer></script>
<?php
$formParams = array(
    "page" => "default",
    "group" => "default",
    "id" => "GetUserSettings",
    "isHidden" => true,
    "buttonsIsShow" => false,
    "ajaxJSUrl" =>  "linkDefaultAjax+'defaultGetUserSettings",
    "ajaxJSIsShowModal" => false,
);
$form = new \app\pages\Form($formParams);
$form->begin();
$form->end();
$form->render();
