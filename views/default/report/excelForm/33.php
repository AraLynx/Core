<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
            $form->addField(["inputName" => "DateMonth"]);      $form->addField(["inputName" => "DateYear"]);
            $form->addField(["inputName" => "StatusPDIId"]);          $form->addField(["inputName" => "StatusPDIName"]);

?>
