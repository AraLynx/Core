<?php
#region LOG OUT
    $formParams = array(
        "page" => "login",
        "group" => "loginBranch",
        "id" => "Logout",
        "isHidden" => true,
        "buttonsIsShow" => false,
        "submitButtonColor" => "danger",
        "submitFontAwesomeIcon" => "fa-solid fa-arrow-right-from-bracket",
        "ajaxJSUrl" => "'/".CORE_AJAX."default/defaultLogout",
        "submitText" => "LOGOUT"
    );
    $form = new \app\components\Form($formParams);
    $form->begin();
    $form->addField(array("inputName" => "UserId", "inputValue" => $user->Id));
    $form->end();
    $form->render();
    $logoutFunctionName = $form->getSubmitDefaultFunctionName();
#endregion LOG OUT
?>

<div id="login">
    <div class="row h-100">
        <div class="col-lg-4 col-12">
            <div id="login-left">
                <div class="login-logo">
                    <a href="/<?php echo ROOT;?>">
                        <img src="/<?php echo CORE_IMAGE;?>Logo_<?php echo strtoupper(APP_NAME);?>_100.png" alt="Logo">
                    </a>
                    <span class="login-title"><?php echo APP_NAME;?></span>
                </div>

                <div class="loginBranch-subtitle">Welcome back,</div>
                <div class="loginBranch-employeeName text-center text-primary fw-bold"><?php echo "{$user->Name}";?></div>
                <div class="text-center text-primary"><?php echo "- {$user->PositionName} -";?></div>
                <div class="text-end mb-5 fst-italic"><span class="font-bold text-decoration-underline text-primary" role="button" onClick="<?php echo "{$logoutFunctionName}();";?>">Click here</span> to Logout</div>
                <div class="loginBranch-subtitle">Please choose <span class="fw-bold">Branch</span> to complete your login</div>
                <?php
                $formParams = array(
                    "page" => "login"
                    ,"group" => "loginBranch"
                    ,"id" => "Login"
                    ,"defaultLabelIsShow" => false
                    ,"buttonsIsShow" => false
                );
                $form = new \app\components\Form($formParams);
                $form->begin();
                $form->addField(array("inputType" => "kendoDropDownList", "inputName"=>"BranchId", "required" => true, "inputOnChange" => true));
                $form->end();
                $form->render();
                ?>
                <script>
                    $(document).ready(function(){
                        let branches = <?php echo json_encode($branches);?>;
                        TDE.loginBranchLoginBranchId.populate(branches);
                        if(branches.length == 1){
                            TDE.loginBranchLoginBranchId.select(0);
                            loginBranchLogin();
                        }
                        else{
                            //TDE.loginBranchLoginBranchId.open();
                        }
                    });
                </script>
            </div>
        </div>
        <div class="col-lg-8 d-none d-lg-block bg-chronos bg-<?php echo strtolower(APP_NAME);?>">
            <div id="login-right">

            </div>
        </div>
    </div>
</div>
