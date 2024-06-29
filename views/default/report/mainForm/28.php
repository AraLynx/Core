<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
    $form->addColumn([6,2,4]);
        $form->addField(["labelText" => "Status SPK", "inputName" => "StatusId", "inputType" => "kendoDropDownList","selectOptions" => $selectOptions["_28_Statuses"], "inputCol" => 5,"labelCol" => 2]);
        $form->addField(["labelText" => "Vehicle Group", "inputType" => "kendoDropDownList", "inputName" => "VehicleGroupId", "inputOnChange" => "reportGetReport_VehicleGroupIdChange", "labelCol" => 2,"inputCol" => 5]);
        $form->addField(["labelText" => "Vehicle Type", "inputType" => "kendoDropDownList", "inputName" => "VehicleTypeId","labelCol" => 2,"inputCol" => 8]);
        $form->addField(["labelText" => "Vehicle Color", "inputName" => "UnitColor", "inputPlaceHolder" => "", "inputCol" => 8,"labelCol" => 2]);
    $form->nextColumn();
        $form->addField(["labelIsShow" => false, "inputType" => "kendoDropDownList", "selectOptions" => $selectOptions["_28_DateTypes"], "inputName" => "DateType", "required" => true,"inputCol" => " mb-1"]);
        $form->addField(["labelIsShow" => false, "inputType" => "kendoDropDownList", "selectOptions" => $selectOptions["_28_NumberTypes"], "inputName" => "DocumentNumberType","inputCol" => " mb-1"]);
        $form->addField(["labelIsShow" => false, "inputType" => "kendoDropDownList", "selectOptions" => $selectOptions["_28_EmployeeTypes"], "inputName" => "EmployeeType","inputCol" => " mb-1"]);
        $form->addField(["labelIsShow" => false, "inputType" => "kendoDropDownList", "selectOptions" => $selectOptions["_28_CustomerTypes"], "inputName" => "CustomerType","inputCol" => " mb-1"]);
    $form->nextColumn();
        $form->addField(["labelIsShow" => false, "inputName" => "DateValue", "inputType" => "kendoDatePicker_range","required" => true,"inputCol" => " mb-1"]);
        $form->addField(["labelIsShow" => false, "inputName" => "DocumentNumberValue", "inputPlaceHolder" => "","inputCol" => " mb-2"]);
        $form->addField(["labelIsShow" => false, "inputName" => "EmployeeValue", "inputPlaceHolder" => "","inputCol" => " mb-2"]);
        $form->addField(["labelIsShow" => false, "inputName" => "CustomerValue", "inputPlaceHolder" => "","inputCol" => " mb-1"]);
    $form->endColumn();
?>
