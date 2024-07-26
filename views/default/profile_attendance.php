
<div class="d-flex justify-content-between">
    <div class="h6">MY ATTENDANCE</div>
    <div id="profile_teamsAttendance_btn" class="d-none btn btn-primary" role="button" onClick="profileShowSubContent('teamAttendance');"><i class="fa-solid fa-users"></i> TEAM'S ATTENDANCE</div>
</div>
<?php
#region FORM GET DATA
    $formParams = array(
        "page" => "profile",
        "group" => "attendance",
        "id" => "GetData",
        "isHidden" => true,
    );
    $form = new \app\components\Form($formParams);
    $form->begin();
    $form->addField(array("inputName" => "EmployeeId", "inputValue" => $_EMPLOYEE["Id"]));
    $form->end();
    $form->render();
#endregion FORM GET DATA

#region FORM GET ATTENDANCE
    $formParams = array(
        "page" => "profile"
        ,"group" => "attendance"
        ,"id" => "GetAttendances"
        ,"invalidFeedbackIsShow" => false //DEFAULT true
        ,"cancelButtonIsShow" => false
        ,"submitFontAwesomeIcon" => "fa-solid fa-search" //DEFAULT 'fa-solid fa-check'
        ,"submitText" => "SEARCH" //DEFAULT 'SUBMIT'
    );
    $form = new \app\components\Form($formParams);
    $form->begin();

    $form->addField(array("labelText" => "Periode","inputType" => "kendoDatePicker_range","inputName" => "Periode","dateTimeMin" => "x","required" => true));
    $form->end();
    $form->render();
    echo "<hr/>";
    $gridParams = array(
        "page" => "profile",
        "group" => "attendance",
        "id" => "Attendances",
        "excelFileName" => "Attendance",
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
    $grid->end();
    $grid->render();
#endregion FORM GET ATTENDANCE
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
