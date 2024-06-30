<?php
//LOG OUT
$formParams = array(
    "page" => "login",
    "group" => "loginBranch",
    "id" => "Logout",
    "buttonsIsShow" => false,
    "ajaxJSUrl" => "linkDefaultAjax+'defaultLogout",
    "submitButtonColor" => "danger",
    "submitFontAwesomeIcon" => "fa-solid fa-arrow-right-from-bracket",
    "ajaxJSUrl" => "'/".CORE_AJAX."default/defaultLogout",
    "submitText" => "LOGOUT"
);
$form = new \app\pages\Form($formParams);
$form->begin();
$form->addField(array("inputType" => "hidden", "inputName" => "UserId", "inputValue" => $user->Id));
$form->end();
$form->render();
$logoutFunctionName = $form->getSubmitDefaultFunctionName();
//LOG OUT
?>

<div id="login">
    <div class="row h-100">
        <div class="col-lg-4 col-12">
            <div id="login-left">
                <div class="login-logo">
                    <a href="/<?php echo DIR;?>">
                        <img src="/<?php echo CORE_IMAGE;?>Logo_<?php echo strtoupper(APP_NAME);?>_100.png" alt="Logo">
                    </a>
                    <span class="login-title"><?php echo APP_NAME;?></span>
                </div>
                <div class="loginBranch-subtitle">Welcome back,</div>
                <div class="loginBranch-employeeName text-center text-primary fw-bold"><?php echo "{$user->Name}";?></div>
                <div class="text-center text-primary"><?php echo "- {$user->PositionName} -";?></div>
                <div class="text-end pb-5 fst-italic"><span class="font-bold text-decoration-underline text-primary" role="button" onClick="<?php echo "{$logoutFunctionName}();";?>">Click here</span> to Logout</div>
                <div class="text-center pt-5 text-danger">
                    Your user account hasn't been granted to access any of the Branches
                    <br/>Please contact <span class="fw-bold">Branch PIC </span>to request the access.
                </div>
            </div>
        </div>
        <div class="col-lg-8 d-none d-lg-block">
            <div id="login-right">

            </div>
        </div>
    </div>
</div>
