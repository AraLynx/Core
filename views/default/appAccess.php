<?php
//dd($modulePages);
?>

<main id="news" class="d-lg-flex w-100">
    <div id="appAccess_menu" class="tde-box me-lg-3 mb-lg-0 mb-3" style="min-width:150px">
        <nav class="p-2">
            <ul class="d-flex flex-lg-column list-unstyled mb-0 mb-lg-3">
                <li class="py-2 px-3 p-lg-0">
                    <div class="d-flex align-items-center" role="button" onClick="appAccessShowSubContent('access');">
                        <i class="fa-solid fa-fw fa-users" title="SUB CONTENT 1"></i>
                        <div class="d-lg-block d-none ms-lg-2"> PAYROLL ACCESS</div>
                    </div>
                </li>
                <li class="py-2 px-3 p-lg-0">
                    <div class="d-flex align-items-center" role="button" onClick="appAccessShowSubContent('superUser');">
                        <i class="fa-solid fa-fw fa-star" title="SUB CONTENT 2"></i>
                        <div class="d-lg-block d-none ms-lg-2"> SUPER USER</div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    <div id="appAccess_content" class="tde-box-3 overflow-auto flex-fill">
        <div id="appAccess_access" class="page_content d-none">
            <div class="h4"><i class="fa-solid fa-fw fa-users"></i> PAYROLL ACCESS</div>
            <?php
            #region GET USERS
                $formParams = array(
                    "page" => "appAccess",
                    "group" => "access",
                    "id" => "GetUsers",
                    //"defaultLabelCol" => 2,
                    "invalidFeedbackIsShow" => false,
                    "cancelButtonIsShow" => false,
                    "submitFontAwesomeIcon" => "fa-solid fa-search",
                    "submitText" => "SEARCH USER",
                );
                $form = new \app\components\Form($formParams);
                $form->begin();
                $form->addField(array("inputType" => "hidden", "inputName" => "EmployeeIsActive", "inputValue" => 1));
                $form->addField(array("labelText" => "NIP", "inputType" => "kendoNumericTextBox", "inputName" => "EmployeeId"));
                $form->addField(array("labelText" => "Name", "inputName" => "EmployeeName"));
                $form->collapsable();
                $form->addField(array("labelText" => "Branch", "inputType" => "kendoDropDownList", "selectTypeDetail" => "cbpPicker"));
                $form->addField(array("labelText" => "Position", "inputName" => "PositionName"));
                $form->end();
                $form->render();
                echo "<hr/>";
                $kendoGridParams = array(
                    "page" => "appAccess",
                    "group" => "access",
                    "id" => "Users",
                    "rowExpand" => "first",
                    "columns" => array(
                        array("field" => "Avatar", "title" => " ", "width" => 100),
                        array("field" => "NameProfile", "title" => "Employee"),
                        array("field" => "PositionProfile", "title" => "Position", "width" => 250),
                        array("field" => "POSProfile", "title" => "Placement", "width" => 200),
                    ),
                );
                $kendoGrid = new \app\components\KendoGrid($kendoGridParams);
                $kendoGrid->begin();
                $kendoGrid->end();
                $kendoGrid->render();
            #endregion GET USERS

            #region ENABLE USER
                $formParams = array(
                    "page" => "sys",
                    "group" => "access",
                    "id" => "EnableUser",
                    "isHidden" => true,
                    "confirmationMessageIsShow" => true

                    ,"submitText" => "ACTIVATE"
                );
                $form = new \app\components\Form($formParams);
                $form->begin();
                $form->addField(array("inputName" => "Id"));
                $form->end();
                $form->render();
            #endregion DISABLE USER

            #region DISABLE USER
                $formParams = array(
                    "page" => "sys",
                    "group" => "access",
                    "id" => "DisableUser",
                    "isHidden" => true,
                    "confirmationMessageIsShow" => true

                    ,"submitButtonColor" => "danger"
                    ,"submitFontAwesomeIcon" => "fa-solid fa-ban"
                    ,"submitText" => "DEACTIVATE"
                );
                $form = new \app\components\Form($formParams);
                $form->begin();
                $form->addField(array("inputName" => "Id"));
                $form->end();
                $form->render();
            #endregion DISABLE USER

            #region EDIT ACCESS
                $formParams = array(
                    "page" => "sys",
                    "group" => "access",
                    "id" => "EditAccessGetAccesses",
                    "isHidden" => true
                );
                $form = new \app\components\Form($formParams);
                $form->begin();
                $form->addField(array("inputName" => "UserId"));
                $form->end();
                $form->render();

                $formParams = array(
                    "page" => "sys",
                    "group" => "access",
                    "id" => "EditAccess",
                    "invalidFeedbackIsShow" => false,
                    "defaultLabelCol" => 3,
                    "cancelFunctions" =>  array("TDE.accessKendoWindowEditAccess.close"),
                );
                $form = new \app\components\Form($formParams);
                $form->begin();
                $form->addField(array("inputType" => "hidden", "inputName" => "UserId"));
                    $ModuleId = 0;
                    foreach($modulePages AS $index => $modulePage)
                    {
                        if($modulePage->ModuleId != $ModuleId)
                        {
                            if($ModuleId)$form->addHtml("<hr/>");
                            $ModuleId = $modulePage->ModuleId;
                            $form->collapsable(["text" => "<i class='fa-solid fa-angle-down'></i> ".$modulePage->ModuleName]);
                        }

                        $form->addField(array("labelText" => $modulePage->PageName, "inputType" => "kendoCheckBox", "inputName" => "Auth", "inputCol" => 4, "inputGroup" => ["C","R","U","D"], "inputArray" => $modulePage->Id));
                    }
                $form->end();

                $footer = "<div><small class='text-muted'>* Legend
                    <br/>C = Create
                    <br/>R = Read
                    <br/>U = Update
                    <br/>D = Delete
                </small></div>";

                $windowParams = array(
                    "page" => "sys"
                    ,"group" => "access"
                    ,"id" => "EditAccess"
                    ,"title" => "MANAGE PAYROLL ACCESS"
                    ,"width" => "800px"
                    ,"body" => $form->getHtml().$footer

                );
                $window = new \app\components\KendoWindow($windowParams);
                $window->begin();
                $window->end();
                $window->render();
            #endregion
            ?>
        </div>

        <div id="appAccess_superUser" class="page_content d-none">
            <div class="h4"><i class="fa-solid fa-fw fa-star"></i> SUPER USER</div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function(){
        appAccessShowSubContent('<?php echo $subContent;?>');
    });
</script>
