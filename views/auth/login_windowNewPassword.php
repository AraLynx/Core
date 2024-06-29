<div class="container">
    <p class="text-center">
        You are currently using <span class="text-danger">System Default Password</span> as your current login password.
        Please type in a <span class="text-primary">New Unique password</span>.
    </p>

    <?php
    $formParams = array(
        "page" => "login"
        ,"group" => "login"
        ,"id" => "NewPassword"
        ,"isAuth" => false //krn blon login
        //,"theme" => "bootstrap"
        ,"buttonClass" => "btn-dark btn-lg shadow-lg"
        ,"buttonJustify" =>  "center"
        ,"cancelButtonIsShow" => false
        ,"submitFontAwesomeIcon" => ""
        ,"submitText" => "Save New Password"
    );

    $form = new \app\pages\Form($formParams);
    $form->begin();
    $form->addField(array("inputType" => "hidden", "inputName" => "UserId"));
    $form->addField(array("labelText" => "Password", "labelIsShow" => false, "inputType" => "password", "inputName" => "Password", "required" => true));
    $form->addField(array("labelText" => "Retype Password", "labelIsShow" => false, "inputType" => "password", "inputName" => "RetypePassword", "required" => true));
    $form->end();
    $form->render();
    ?>
</div>
