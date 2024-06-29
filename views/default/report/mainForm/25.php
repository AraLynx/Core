<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addColumn([5,5,2]);
        $form->addField(["labelText" => "Location Type", "inputName" => "LocationPartnerTypeId", "inputType" => "kendoDropDownList", "selectOptions" => $selectOptions["_25_LocationPartnerTypeIds"], "inputCol" => 8, "inputOnChange" => true]);
        $form->addField(["labelText" => "Location Name", "inputType" => "kendoDropDownList", "inputName" => "LocationPartnerId","inputCol" => 8]);
        $form->addField(["labelText" => "Status", "inputName" => "StatusId", "inputType" => "kendoDropDownList","selectOptions" => $selectOptions["_25_Statuses"], "inputCol" => 4]);
    $form->nextColumn();
        $form->addField(["labelText" => "Vehicle Group", "inputType" => "kendoDropDownList", "inputName" => "VehicleGroupId", "inputOnChange" => "reportGetReport_VehicleGroupIdChange", "inputCol" => 8]);
        $form->addField(["labelText" => "Vehicle Type", "inputType" => "kendoDropDownList", "inputName" => "VehicleTypeId","inputCol" => 8]);
    $form->endColumn();
?>
