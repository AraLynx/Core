<?php
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__,2));
$dotenv->load();
require_once __DIR__.'/../../params.php';
?>
<script>
    $(document).ready(function(){

    });
</script>
<main id="approval">
    <div id="approval_content" class="tde-box-3">
        <?php
        $formParams = array(
            "page" => "approval"
            ,"group" => "approval"
            ,"id" => "GetApprovals"
            ,"invalidFeedbackIsShow" => false //DEFAULT true
            ,"cancelButtonIsShow" => false //DEFAULT true
            ,"submitFontAwesomeIcon" => "fa-solid fa-search" //DEFAULT 'fa-solid fa-check'
            ,"submitText" => "SEARCH" //DEFAULT 'SUBMIT'
        );
        $form = new \app\components\Form($formParams);
        $form->begin();
        $form->addField(["labelText" => "POS", "inputType" => "kendoDropDownList", "selectTypeDetail" => "cbpPicker", "selectTemplates" => ["pos"], "selectCBPFilters" => ["posIds" => $_READPOSES[76]], "required" => true, "inputOnChangeArray" => ["pos" => true]]);
        $form->addField(["labelText" => "Request Type", "inputName" => "RequestType", "inputType" => "kendoDropDownList", "selectOptions" => $approvalRequestTypes, "required" => true]);
        $form->collapsable();
        $form->addColumn(3);
            $form->addField(["labelText" => "Request at", "inputName" => "CreatedDateTime", "inputType" => "kendoDatePicker_range", "required" => true]);
        $form->nextColumn();
            $form->addField(["labelCol" => "3", "labelText" => "Ref. Number", "inputName" => "ReferenceNumber"]);
        $form->nextColumn();
            $form->addField(["labelCol" => "3", "labelText" => "Req. Status", "inputName" => "StatusCode", "inputType" => "kendoDropDownList", "selectOptions" => $approvalGetApprovalsStatusCodeOptions, "required" => true]);
        $form->endColumn();
        $form->addField(["labelText" => "Area", "inputName" => "Area", "inputType" => "kendoDropDownList", "selectTypeDetail" => "cbpPicker", "selectTemplates" => ["company","branch","pos"], "selectCBPIsAddAll" => true]);
        $form->end();
        $form->render();

        echo "<hr/>";

        $gridParams = array(
            "page" => "approval",
            "group" => "approval",
            "id" => "Approvals",
            "columns" => array(
                array("field" => "ReferenceNumber", "title" => "Reference Number", "width" => 150),
                array("field" => "ApprovalTypeName", "title" => "Approval Type", "width" => 200),
                array("field" => "Area", "title" => "Area", "width" => 150),
                array("field" => "StatusCode", "title" => "StatusCode", "width" => 100),
                array("field" => "CreatedDateTime", "title" => "Request at","formatType" => "dateTime"),
                array("field" => "CreatedByEmployeeName", "title" => "Request by", "width" => 200),
                array("field" => "noWorkOrder", "title" => "Disapprove info", "width" => 400),
            ),
        );

        $grid = new \app\components\KendoGrid($gridParams);
        $grid->begin();
        $grid->end();
        $grid->render();
        ?>
    </div>
</main>
