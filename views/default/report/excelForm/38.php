<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
        $form->addField(["inputName" => "DateApplyYear"]);
        $form->addField(["inputName" => "DateApplyMonth"]);
        $form->addField(["inputName" => "StatusCode"]);
        $form->addField(["inputName" => "DocumentNumber"]);

?>