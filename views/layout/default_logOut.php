<script src="/<?php echo CORE_JS;?>default_logOut.js" defer></script>
<?php
$formParams = array(
    "page" => "default",
    "group" => "default",
    "id" => "Logout",
    "isHidden" => true,
    "confirmationMessageIsShow" => true,
    "ajaxJSUrl" => "linkDefaultAjax+'defaultLogout",
    "submitButtonColor" => "danger",
    "submitFontAwesomeIcon" => "fa-solid fa-arrow-right-from-bracket",
    "submitText" => "LOGOUT"
);
$form = new \app\components\Form($formParams);
$form->begin();
$form->end();
$form->render();
