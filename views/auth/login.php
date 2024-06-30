<?php
?>

<main id="login">
    <div class="row h-100">
        <div class="col-lg-4 col-12">
            <div id="login-left">
                <div class="login-logo">
                    <a href="/<?php echo DIR;?>">
                        <img src="/<?php echo CORE_IMAGE;?>Logo_<?php echo strtoupper(APP_NAME);?>_100.png" alt="Logo">
                    </a>
                    <span class="login-title"><?php echo APP_NAME;?></span>
                </div>

                <h1 class="login-subtitle">Log in</h1>
                <?php
                $formParams = array(
                    "page" => "login"
                    ,"group" => "login"
                    ,"id" => "Login"
                    ,"isAuth" => false //krn blon login
                    ,"defaultLabelIsShow" => false
                    ,"buttonClass" => "btn-lg shadow-lg mt-5"
                    ,"buttonJustify" => "start"
                    ,"cancelButtonIsShow" => false
                    ,"submitFontAwesomeIcon" => ""
                    ,"submitText" => "Log in"
                );
                $form = new \app\pages\Form($formParams);
                $form->begin();
                $form->addField(array("labelText" => "User Login", "inputName" => "Username", "required" => true));
                $form->addField(array("labelText" => "Password", "inputType" => "password", "inputName" => "Password", "required" => true));
                $form->end();
                $form->render();
                ?>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class="text-primary fw-bold text-decoration-underline" role="button" onClick="TDE.loginKendoWindowForgotPassword.center().open();">Forgot password?</p>
                </div>
                <?php
                $formParams = array(
                    "page" => "login"
                    ,"group" => "login"
                    ,"id" => "ForgotPassword"
                    ,"isAuth" => false
                    //,"defaultLabelIsShow" => false
                    //,"defaultLabelCol" => 2
                    ,"cancelButtonIsShow" => false
                    ,"submitFontAwesomeIcon" => "fa-regular fa-envelope"
                    ,"submitText" => "Send new password to mail"
                );
                $form = new \app\pages\Form($formParams);
                $form->begin();
                $form->addField(array("labelText" => "NIK", "inputType" => "kendoNumericTextBox", "inputName" => "EmployeeId", "required" => true));
                $form->addField(array("labelText" => "Email", "inputType" => "email", "inputName" => "EmailAddress", "required" => true));
                $form->end();
                $kendoWindowParams = array(
                    "page" => "login",
                    "group" => "login",
                    "id" => "ForgotPassword",
                    "title" => "ForgotPassword",
                    "body" => $form->getHtml()
                );
                $kendoWindowNewPassword = new \app\pages\KendoWindow($kendoWindowParams);
                $kendoWindowNewPassword->begin();
                $kendoWindowNewPassword->end();
                $kendoWindowNewPassword->render();
                ?>
            </div>
        </div>
        <div class="col-lg-8 d-none d-lg-block bg-chronos bg-<?php echo strtolower(APP_NAME);?>">
            <div id="login-right">

            </div>
        </div>
    </div>
</main>
<?php
ob_start();
include_once __DIR__."/login_windowNewPassword.php";
$body = ob_get_clean();

$kendoWindowParams = array(
    "page" => "login",
    "group" => "login",
    "id" => "NewPassword",
    "title" => "NEW PASSWORD",
    "body" => $body
);
$kendoWindowNewPassword = new \app\pages\KendoWindow($kendoWindowParams);
$kendoWindowNewPassword->begin();
$kendoWindowNewPassword->end();
$kendoWindowNewPassword->render();
