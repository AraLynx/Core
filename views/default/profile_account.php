<?php

#region FORM GET USER
    $formParams = array(
        "page" => "profile",
        "group" => "account",
        "id" => "GetUser",
        "buttonsIsShow" => false,
    );
    $form = new \app\pages\Form($formParams);
    $form->begin();
    $form->end();
    $form->render();
#endregion
?>
<div class="row">
    <div class="col-lg-4">
        <div class="h6">MY AVATAR</div>
        <?php
        #region FORM UPDATE USER AVATAR
            $formParams = array(
                "page" => "profile",
                "group" => "account",
                "id" => "EditAvatar",
                "invalidFeedbackIsShow" => false,
                "defaultLabelIsShow" => false,
                "cancelButtonIsShow" => false,
                "submitFontAwesomeIcon" => "fa-solid fa-pencil",
                "submitText" => "CHANGE AVATAR",
            );
            $form = new \app\pages\Form($formParams);
            $form->begin();
            $form->addField(array("inputType" => "kendoUpload", "uploadFileTypes" => ["jpg","jpeg","png"], "inputName" => "Avatar"));
            $form->addHtml("<div class='fst-italic text-muted'>*we recomend using a square sized picture (ex 200 by 200 px)</div>");

            $form->end();
            $form->render();
        #endregion FORM UPDATE USER AVATAR
        ?>
        <hr class="d-lg-none"/>
        <?php
        #region SETTING
            $formParams = array(
                "page" => "profile",
                "group" => "account",
                "id" => "EditSetting",
                "invalidFeedbackIsShow" => false,
                "defaultLabelCol" => 2,
                "submitFontAwesomeIcon" => "fa-solid fa-save",
                "submitText" => "SAVE SETTING",
                "cancelFunctions" => ["TDE.accountKendoWindowEditSetting.close"]
            );
            $form = new \app\pages\Form($formParams);
            $form->begin();
                $form->addHtml("<h6>Notification</h6>");
                $form->addField(["labelText" => "Sound", "inputName" => "NotificationSound", "inputType" => "kendoDropDownList", "selectOptions" => $accountSettings["notificationSound"]["selectOptions"], "inputOnChange" => true]);
                $form->addHtml("<div class='d-flex'><div class='btn btn-sm' onClick='accountEditSettingTestSound();'><i class='fa-solid fa-play'></i> Test sound</div></div>");
                $form->addField(["labelText" => "Vibrate", "inputName" => "NotificationVibrate", "inputType" => "kendoDropDownList", "selectOptions" => $accountSettings["notificationVibrate"]["selectOptions"]]);
                $form->addHtml("<div class='d-flex'><div class='btn btn-sm' onClick='accountEditSettingTestVibrate();'><i class='fa-solid fa-play'></i> Test vibrate</div></div>");
            $form->end();

            $windowParams = array(
                "page" => "profile"
                ,"group" => "account"
                ,"id" => "EditSetting"
                ,"title" => "SETTING"
                ,"width" => "400px"
                ,"body" => $form->getHtml()
            );
            $window = new \app\pages\KendoWindow($windowParams);
            $window->begin();
            $window->end();
            $window->render();
        #endregion SETTING
        ?>
        <div class="d-flex justify-content-end">
            <div class="btn btn-primary" onClick="TDE.accountKendoWindowEditSetting.center().open();"><i class="fa-solid fa-gears"></i> OTHER SETTINGS</div>
        </div>
        <hr class="d-lg-none"/>
    </div>
    <div class="col-lg">
        <div class="h6">MY EMPLOYEE & LOGIN ACCOUNT</div>
        <?php
        #region FORM UPDATE USER PROFILE
            $formParams = array(
                "page" => "profile",
                "group" => "account",
                "id" => "EditUser",
                "defaultLabelCol" => 2,
                "invalidFeedbackIsShow" => false,
                "cancelButtonIsShow" => false,
                "submitFontAwesomeIcon" => "fa-solid fa-pencil",
                "submitText" => "CHANGE PROFILE",
                "additionalButtons" => array(
                    array(
                        "color" => "danger"
                        ,"fontAwsomeIcon" => "fa-solid fa-key"
                        ,"text" => "CHANGE PASSWORD"
                        ,"functionName" => "accountKendoWindowEditPasswordOpen"
                    )
                )
            );
            $form = new \app\pages\Form($formParams);
            $form->begin();

            $form->addField(array("labelText" => "Name", "inputName" => "EmployeeName", "inputReadOnly" => true, "inputValue" => $_EMPLOYEE["Name"]));
            $form->addField(array("labelText" => "Position", "inputName" => "PositionName", "inputReadOnly" => true, "inputValue" => $_EMPLOYEE["PositionName"]));
            $form->addField(array("labelText" => "NIP", "inputName" => "EmployeeId", "inputReadOnly" => true, "inputValue" => $_EMPLOYEE["Id"], "inputSize" => "80px"));

            $form->addField(array("labelText" => "User Login", "inputName" => "Username", "inputValue" => $_EMPLOYEE["Username"], "required" => true));
            $form->addField(array("labelText" => "Email", "inputType" => "email", "inputName" => "EmailAddress", "required" => true));
            $form->end();
            $form->render();
        #endregion

        #region FORM CHANGE PASSWORD
            $formParams = array(
                "page" => "profile",
                "group" =>  "account",
                "id" =>  "EditPassword",
                "defaultLabelCol" =>  3,
                "submitButtonColor" =>  "danger",
                "submitFontAwesomeIcon" =>  "fa-solid fa-key",
                "submitText" =>  "CHANGE PASSWORD",
                "cancelFunctions" => array("accountKendoWindowEditPasswordClose"),
            );
            $form = new \app\pages\Form($formParams);
            $form->begin();

            $form->addField(array("inputType" => "hidden", "inputName" => "UserId", "inputValue" => $_EMPLOYEE["UserId"]));
            $form->addField(array("labelText" => "Exsiting Password", "inputType" => "password", "inputName" => "OldPassword", "required" => true));
            $form->addField(array("labelText" => "New Password", "inputType" => "password", "inputName" => "Password1", "required" => true));
            $form->addField(array("labelText" => "Re-type Password", "inputType" => "password", "inputName" => "Password2", "required" => true));

            $form->end();
            $html = $form->getHTML();

            $windowParams = array(
                "page" => "account",
                "group" => "account",
                "id" => "EditPassword",
                "title" => "CHANGE PASSWORD",
                "body" => $form->getHTML(),
            );
            $window = new \app\pages\KendoWindow($windowParams);
            $window->begin();
            $window->end();
            $window->render();
        #endregion
        ?>
    </div>
</div>
