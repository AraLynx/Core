<?php
    $linkToReportFolder = "../../Chronos/views/default/";
?>
<script>
    const selectOptions = <?php echo json_encode($selectOptions);?>;
    $(document).ready(function(){

    });
</script>
<main id="report" class="d-flex w-100">
    <div id="report_content" class="tde-box-3 overflow-auto flex-fill w-100">
        <?php
        #region GENERATE EXCEL
        $formParams = array(
            "page" => "report"
            ,"group" => "report"
            ,"id" => "GenerateExcel"
            ,"isHidden" => true
        );
        $form = new \app\pages\Form($formParams);
        $form->begin();
        $form->addField(["inputName" => "ReportId"]);
        $form->addField(["inputName" => "CompanyId"]);  $form->addField(["inputName" => "CompanyName"]);
        $form->addField(["inputName" => "BranchId"]);   $form->addField(["inputName" => "BranchName"]);
        $form->addField(["inputName" => "POSId"]);      $form->addField(["inputName" => "POSName"]);

        foreach($selectOptions["ReportIds"] AS $reportId)
        {
            $filePath = "report/excelForm/{$reportId}.php";
            if(file_exists("{$linkToReportFolder}{$filePath}")) require_once $filePath;
        }
        $form->end();
        $form->render();
        #endregion GENERATE EXCEL

        #region GENERATE PRINT OUT TOKEN
        $formParams = array(
            "page" => "report"
            ,"group" => "report"
            ,"id" => "GeneratePrintOutToken"
            ,"isHidden" => true
        );
        $form = new \app\pages\Form($formParams);
        $form->begin();
        $form->addField(["inputName" => "ReportId"]);
        $form->end();
        $form->render();
        #endregion GENERATE EXCEL

        #region FORM FILTER
        $formParams = array(
            "page" => "report"
            ,"group" => "report"
            ,"id" => "GetReport"
            ,"invalidFeedbackIsShow" => false
            ,"cancelButtonIsShow" => false
            ,"submitFontAwesomeIcon" => "fa-solid fa-search"
            ,"submitText" => "SEARCH"
        );
        $form = new \app\pages\Form($formParams);
        $form->begin();
            $form->addColumn(2);
                $form->addField(["labelText" => "Report Owner", "inputName" => "DepartmentId", "inputType" => "kendoDropDownList", "inputOnChange" => true, "required" => true]);
                $form->nextColumn();
                $form->addField(["labelText" => "Company", "inputName" => "CompanyId", "inputType" => "kendoDropDownList", "inputOnChange" => true, "required" => true]);
            $form->endColumn();
            $form->addColumn(2);
                $form->addField(["labelText" => "Report Group", "inputName" => "ReportGroup", "inputType" => "kendoDropDownList", "inputOnChange" => true, "required" => true]);
                $form->nextColumn();
                $form->addField(["labelText" => "Branch", "inputName" => "BranchId", "inputType" => "kendoDropDownList", "inputOnChange" => true]);
            $form->endColumn();
            $form->addColumn(2);
                $form->addField(["labelText" => "Report Type", "inputName" => "ReportId", "inputType" => "kendoDropDownList", "inputOnChange" => true, "required" => true]);
                $form->nextColumn();
                $form->addField(["labelText" => "POS", "inputName" => "POSId", "inputType" => "kendoDropDownList"]);
            $form->endColumn();
            $form->collapsable(["text" => "Additional filter", "isShow" => true]);

            foreach($selectOptions["ReportIds"] AS $reportId)
            {
                $filePath = "report/mainForm/{$reportId}.php";
                if(file_exists("{$linkToReportFolder}{$filePath}")) require_once $filePath;
            }
        $form->end();
        $form->render();

        echo "<hr>";
        #endregion FORM FILTER

        foreach($selectOptions["ReportIds"] AS $reportId)
        {
            $filePath = "report/content/{$reportId}.php";
            if(file_exists("{$linkToReportFolder}{$filePath}")) require_once $filePath;

        }
        #region UnderDev
        echo "<div id='reportDivUnderDevelopment' class='reportDiv d-none'>
            <div class='d-flex justify-content-center mt-5'>
                <div>
                    <div class='text-center h3 text-warning'><span id='reportUnderDevelopmentTitle'></span> IS UNDER CONSTRUCTION</div>
                    <img class='text-center' src='/".CORE_IMAGE."under_construction_001.jpg'/>
                </div>
            </div>
        </div>";
        #endregion UnderDev
        ?>
    </div>
</main>
