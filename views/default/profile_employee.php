
<div class="h6">SEARCH EMPLOYEE</div>
<?php
    #region FORM GET EMPLOYEES
    $formParams = array(
        "page" => "profile",
        "group" => "employee",
        "id" => "GetEmployees",
        "invalidFeedbackIsShow" => false,
        "cancelButtonIsShow" => false,
        "submitFontAwesomeIcon" => "fa-solid fa-search",
        "submitText" => "SEACH EMPLOYEE",
    );
    $form = new \app\components\Form($formParams);
    $form->begin();
    $form->addField(array("labelText" => "NIP", "inputType" => "kendoNumericTextBox", "inputName" => "Id"));
    $form->addField(array("labelText" => "Name", "inputName" => "Name"));
    $form->collapsable();
    $form->addField(array("labelText" => "Area", "inputType" => "kendoDropDownList", "selectTypeDetail" => "cbpPicker", "selectTemplates" => ["company","branch","pos"], "selectCBPIsAddAll" => true));
    $form->addField(array("labelText" => "Position", "inputName" => "PositionName"));
    $form->addField(array("labelText" => "Status", "inputName" => "EmployeeIsActive", "inputType" => "kendoDropDownList", "selectOptions" => [[1, "Still Working Only"], [0, "Resigned Only"], ["*", "All Records"]], "inputCol" => 3));

    $form->end();
    $form->render();
    echo "<hr/>";
    $gridParams = array(
        "page" => "profile",
        "group" => "employee",
        "id" => "Employees",
        "columns" => array(
            array("field" => "Avatar", "title" => " ", "width" => 100),
            array("field" => "NameProfile", "title" => "Employee", "width" => 350),
            array("field" => "PositionProfile", "title" => "Position"),
            array("field" => "POSProfile", "title" => "Placement"),
        ),
    );

    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
?>
