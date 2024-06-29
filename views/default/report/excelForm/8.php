<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
        $form->addField(["inputName" => "DepositDateStart"]);       $form->addField(["inputName" => "DepositDateEnd"]);
        $form->addField(["inputName" => "VINNumber"]);
        $form->addField(["inputName" => "EngineNumber"]);
        $form->addField(["inputName" => "SPKNumber"]);
        $form->addField(["inputName" => "CustomerName"]);
        $form->addField(["inputName" => "STNKName"]);
?>
