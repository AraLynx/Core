<div class="d-flex justify-content-between">
    <div class="h6">TEAM'S ATTENDANCE</div>
    <div class="btn btn-primary" role="button" onClick="profileShowSubContent('attendance')"><i class="fa-solid fa-user"></i> MY ATTENDANCE</div>
</div>
<?php
#region FORM GET DATA
    $formParams = array(
        "page" => "profile",
        "group" => "teamAttendance",
        "id" => "GetData",
        "isHidden" => true,
    );
    $form = new \app\components\Form($formParams);
    $form->begin();
    $form->addField(array("inputName" => "EmployeeId", "inputValue" => $_EMPLOYEE["Id"]));
    $form->end();
    $form->render();
#endregion FORM GET DATA

#region FORM GET TEAM ATTENDANCE
    $formParams = array(
        "page" => "profile"
        ,"group" => "teamAttendance"
        ,"id" => "GetAttendances"
        ,"invalidFeedbackIsShow" => false //DEFAULT true
        ,"cancelButtonIsShow" => false
        ,"submitFontAwesomeIcon" => "fa-solid fa-search" //DEFAULT 'fa-solid fa-check'
        ,"submitText" => "SEARCH" //DEFAULT 'SUBMIT'

        ,"additionalButtons" => array(
            array(
                "color" => "success"
                ,"fontAwsomeIcon" => "fa-solid fa-plus"
                ,"text" => "ADD ATTENDANCE REQUEST"
                ,"functionName" => "teamAttendanceAddRequestPrepare"
            )
        )
    );
    $form = new \app\components\Form($formParams);
    $form->begin();

    $form->addField(array("inputType" => "hidden", "inputName" => "EmployeeId", "inputValue" => $_EMPLOYEE["Id"]));
    $form->addField(array("labelText" => "Periode","inputType" => "kendoDatePicker_range","inputName" => "Periode","dateTimeMin" => "x","required" => true));
    $form->collapsable();
    $form->addField(array("labelText" => "Position","inputType" => "kendoMultiSelect","inputName" => "PositionIds[]", "inputOnChange" => true));
        $selectTemplate = "<div class=\'d-flex align-items-center\'>";
            $selectTemplate .= "<div class=\'me-2\'><img src=\'#:data.AvatarFileLink#\' class=\'avatar avatar-30\'/></div>";
            $selectTemplate .= "<div class=\'\'>";
                $selectTemplate .= "<div><span class=\'fw-bold\'>#: data.Name #</span> (#: data.Id #)</div>";
                $selectTemplate .= "<div><span class=\'fst-italic\'>#: data.PositionName #</span></div>";
            $selectTemplate .= "</div>";
        $selectTemplate .= "</div>";
    $form->addField(array("labelText" => "Employee","inputType" => "kendoMultiSelect","inputName" => "EmployeeIds[]", "selectTemplate" => $selectTemplate));
    $form->end();
    $form->render();
    echo "<hr/>";
    $gridParams = array(
        "page" => "profile",
        "group" => "teamAttendance",
        "id" => "Attendances_Attendances",
        //"excelFileName" => "Attendance",
        "isDetailInit" => true,
        "columns" => array(
            array("field" => "Date","formatType" => "date"),
            array("field" => "Day", "width" => 80),
            array("field" => "TimeIn", "formatType" => "time"),
            array("field" => "TimeOut", "formatType" => "time"),

            array("field" => "Status", "width" => 80),
            array("field" => "IHKIn", "title" => "IN","formatType" => "faIcon"),
            array("field" => "IHKOut", "title" => "OUT","formatType" => "faIcon"),
            array("field" => "Description"),
        ),
    );

    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $gridDetailInitFunctionName = $grid->end();
    $grid->render();
    $gridParams = array(
        "page" => "profile",
        "group" => "teamAttendance",
        "id" => "Attendances",
        //"excelFileName" => "Attendance",
        "columns" => array(
            //array("title" => "Employee", "width" => 400, "template" => $employeeTemplate),
            array("field" => "EmployeeProfile", "title" => "Employee","width" => 400),
            array("field" => "SummaryProfile", "title" => "Summary"),
        ),
        "detailInit" => $gridDetailInitFunctionName,
    );

    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
#endregion FORM GET ATTENDANCE

    #region FORM ADD REQUEST TEAM ATTENDANCE
        #region FORM GET DATA
            $formParams = array(
                "page" => "profile",
                "group" => "teamAttendance",
                "id" => "AddRequestGetData",
                "isHidden" => true,
            );
            $form = new \app\components\Form($formParams);
            $form->begin();
            $form->end();
            $form->render();

            $formParams = array(
                "page" => "profile",
                "group" => "teamAttendance",
                "id" => "AddRequestGetAttendanceRequestType",
                "isHidden" => true,
            );
            $form = new \app\components\Form($formParams);
            $form->begin();
            $form->addField(["inputName" => "Id"]);
            $form->end();
            $form->render();
        #endregion FORM GET DATA

        $formParams = array(
            "page" => "profile"
            ,"group" => "teamAttendance"
            ,"id" => "AddRequest"
            ,"defaultLabelCol" => 2
            ,"invalidFeedbackIsShow" => false
            ,"submitFontAwesomeIcon" => "fa-solid fa-plus"
            ,"submitText" => "ADD REQUEST"
            ,"submitButtonColor" => "success"
            ,"cancelButtonFunction" => "TDE.teamAttendanceKendoWindowAddRequest.close"
        );
        $form = new \app\components\Form($formParams);
        $form->begin();
            $selectTemplate = "<div class=\'d-flex align-items-center\'>";
                $selectTemplate .= "<div class=\'me-2\'><img src=\'#:data.AvatarFileLink#\' class=\'avatar avatar-30\'/></div>";
                $selectTemplate .= "<div class=\'\'>";
                    $selectTemplate .= "<div><span class=\'fw-bold\'>#: data.Name #</span> (#: data.Id #)</div>";
                    $selectTemplate .= "<div><span class=\'fst-italic\'>#: data.PositionName #</span></div>";
                $selectTemplate .= "</div>";
            $selectTemplate .= "</div>";
        $form->addField(array("labelText" => "Employee","inputType" => "kendoDropDownList","inputName" => "EmployeeId", "selectTemplate" => $selectTemplate,"required" => true));
        $form->addField(array("labelText" => "Request","inputType" => "kendoDropDownList","inputName" => "AttendanceRequestTypeId","inputOnChange" => true,"required" => true));
        $form->addField(array("inputType" => "hidden","inputName" => "DateTypeId"));
        $form->addDynamicForm("DateTypeId1");
            $form->addField(array("labelText" => "Date", "inputType" => "kendoDatePicker","inputName" => "Date","dateTimeMin" => "last month","dateTimeMax"=>"next month","required" => true));
        $form->addDynamicForm("DateTypeId2");
            $form->addField(array("labelText" => "Date", "inputType" => "kendoDatePicker_range","inputName" => "Date","dateTimeMin" => "last month","dateTimeMax"=>"next month","required" => true));
        $form->endDynamicForm();
        $form->addField(array("labelText" => "Description","inputType" => "textarea","inputName" => "Description","required" => true));
        $form->addField(array("labelText" => "Attachment", "inputType" => "kendoUpload", "uploadFileTypes" => ["jpg","jpeg","png"], "inputName" => "Attachment"));
        $form->end();

        $windowParams = array(
            "page" => "profile"
            ,"group" => "teamAttendance"
            ,"id" => "AddRequest"
            ,"title" => "ADD REQUEST"
            ,"body" => $form->getHtml()
            ,"width" => "700px"
        );
        $window = new \app\components\KendoWindow($windowParams);
        $window->begin();
        $window->end();
        $window->render();

    #endregion FORM ADD REQUEST ATTENDANCE
?>
<div class="row">
    <div class="col">
        <?php
            $codes = ["REG","OFF","IDS","DMML","DMR","IPC","DAP"];
            $legends = [];
            foreach($codes AS $index => $code)
            {
                $legends[] = $code." : ".$attendaceLegends[$code];
            }
            echo implode("<br/>",$legends);
        ?>
    </div>
    <div class="col">
        <?php
            $codes = ["CT","CKIH","IU","CK","S","IBMC"];
            $legends = [];
            foreach($codes AS $index => $code)
            {
                $legends[] = $code." : ".$attendaceLegends[$code];
            }
            echo implode("<br/>",$legends);
        ?>
    </div>

    <div class="col">
        <?php
            $codes = ["IBA","IHP","IJP","PD","ST","TR", "ITK"];
            $legends = [];
            foreach($codes AS $index => $code)
            {
                $legends[] = $code." : ".$attendaceLegends[$code];
            }
            echo implode("<br/>",$legends);
        ?>
    </div>
</div>
