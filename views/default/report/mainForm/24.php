<?php
    $dynamicForm = "_{$reportId}_";
    $form->addDynamicForm($dynamicForm);
        $form->addColumn([2,4,4]);
            $form->addField(["labelIsShow" => FALSE, "inputCol" => " mb-1", "inputType" => "kendoDropDownList", "inputName" => "DateType", "selectOptions"=> $selectOptions["_24_DateTypes"]]);
            $form->addField(["labelIsShow" => FALSE, "inputCol" => " mb-1", "inputType" => "kendoDropDownList", "inputName" => "NumberType", "selectOptions"=> $selectOptions["_24_NumberTypes"]]);
            $form->addField(["labelIsShow" => FALSE, "inputCol" => " mb-1", "inputType" => "kendoDropDownList", "inputName" => "FromType" ,"selectOptions"=> $selectOptions["_24_FromTypes"]]);
        $form->nextColumn();
            $form->addField(["labelIsShow" => FALSE, "inputCol" => " mb-1", "inputType" => "kendoDatePicker_range", "inputName" => "Date", "required" => true]);
            $form->addField(["labelIsShow" => FALSE, "inputPlaceHolder" => "", "inputCol" => " mb-1", "inputName" => "NumberValue"]);
            $form->addField(["labelIsShow" => FALSE, "inputPlaceHolder" => "", "inputCol" => " mb-1", "inputName" => "FromValue"]);
        $form->nextColumn();
            $form->addField(["labelText" => "Division", "inputType" => "kendoDropDownList", "inputName" => "ReferenceTypeId", "selectOptions"=> $selectOptions["_24_ReferenceTypeIds"]]);
            $form->addField(["labelText" => "Method", "inputType" => "kendoDropDownList", "inputName" => "MethodId", "selectOptions"=> $selectOptions["_24_MethodIds"]]);
            $form->addField(["labelText" => "Vehicle Group", "inputType" => "kendoDropDownList", "inputName" => "VehicleGroupId", "inputOnChange" => "reportGetReport_VehicleGroupIdChange"]);
            $form->addField(["labelText" => "Vehicle Type", "inputType" => "kendoDropDownList", "inputName" => "VehicleTypeId"]);
            $form->addField(["labelText" => "PIC Sales","inputPlaceHolder" => "", "inputName" => "PICSales"]);
        $form->endColumn();
?>
