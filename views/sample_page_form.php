<?php
#region FORM GET DATA
$formParams = array(
    "page" => "page_name"
    ,"group" => "group_name"
    ,"id" => "do_something"

    ,"isAuth" => false //DEFAULT true
    ,"isHidden" => true //DEFAULT false
    ,"theme" => "bootstrap" //DEFAULT 'kendo'
    ,"defaultLabelCol" => 2 //DEFAULT 1
    ,"invalidFeedbackIsShow" => false //DEFAULT true
    ,"submitFunctionName" => "someFunctionName" //DEFAULT group+id
    ,"confirmationMessageIsShow" => true //DEFAULT false

    ,"buttonsIsShow" => false //DEFAULT true
        ,"buttonClass" => "buttonClass" //DEFAULT ''
        ,"buttonJustify" => "start" //DEFAULT 'end'
        ,"cancelButtonIsShow" => false //DEFAULT true
            ,"cancelButtonColor" => "some bootstrap color" //DEFAULT 'secondary'
            ,"cancelFontAwesomeIcon" => "some fa icon class" //DEFAULT 'fa-solid fa-xmark'
            ,"cancelText" => "someCancelText" //DEFAULT 'CANCEL'
            ,"cancelFunctions" => ["someJSFunctionName"] //DEFAULT []

        ,"submitButtonIsShow" => false //DEFAULT true
            ,"submitButtonColor" => "some bootstrap color" //DEFAULT 'primary'
            ,"submitFontAwesomeIcon" => "some fa icon class" //DEFAULT 'fa-solid fa-check'
            ,"submitText" => "someSubmitText" //DEFAULT 'SUBMIT'
            ,"submitFunctions" => ["someJSFunctionName"] //DEFAULT []

        ,"additionalButtons" => [ //DEFAULT []
                [ //BUTTON 1
                    "color" => "warning" //DEFAULT 'secondary'
                    ,"fontAwsomeIcon" => "fa-solid fa-key" //DEFAULT ''
                    ,"text" => "BUTTON 1" //DEFAULT 'OTHER BUTTON'
                    ,"functionName" => "someJSFunctionName" //DEFAULT ''
                ]
                ,[ //BUTTON 2
                    "color" => "danger" //DEFAULT 'secondary'
                    ,"fontAwsomeIcon" => "fa-solid fa-key" //DEFAULT ''
                    ,"text" => "BUTTON 2" //DEFAULT 'OTHER BUTTON'
                    ,"functionName" => "someJSFunctionName" //DEFAULT ''
                ]
            ]

    ,"ajaxJSIsRender" => false //DEFAULT true
        ,"ajaxJSUrl" => "some url" //DEFAULT 'linkAjax'+submitFunctionName
        ,"ajaxJSIsSuccess" => false //DEFAULT true
            ,"ajaxJSSuccessFunction" => "someJSFunctionName" //DEFAULT submitFunctionName+'Success'

        ,"ajaxJSIsDone" => true //DEFAULT false
            ,"ajaxJSDoneFunction" => "someJSFunctionName" //DEFAULT submitFunctionName+'Done'

        ,"ajaxJSIsFail" => true //DEFAULT false
            ,"ajaxJSFailFunction" => "someJSFunctionName" //DEFAULT submitFunctionName+'Fail'

        ,"ajaxJSIsAlways" => true //DEFAULT false
            ,"ajaxJSAlwaysFunction" => "someJSFunctionName" //DEFAULT submitFunctionName+'Always'
);
$form = new \app\components\Form($formParams);
$form->begin();

#region STEP
    $form->addStep("STEP TITLE");
 //OR
    $form->addStep(array(
        "isShowStepTitle" => false, //DEFAULT true
        "stepTitle" => "TITLE ONE" //DEFAULT 'STEP '.stepCounter
    ));

#endregion STEP
//
$form->addField(array(
    "labelIsShow" => false,//DEFAULT true
        "labelCol" => "3",//DEFAULT defaultLabelCol
        "labelText" => "Label 1",//DEFAULT ''
        "labelClass" => "",//DEFAULT ''

    "inputType" => "password",//DEFAULT text
    /*
        option :
            text, email, password, textarea, switch, checbox

            ===KHUSUS KENDO UI===
            kendoNumericTextBox
            kendoDatePicker
            kendoTimePicker
            kendoDateTimePicker
            kendoDatePicker_range
            kendoDropDownList
            kendoComboBox
            kendoMultiSelect
            ===KHUSUS KENDO UI===
    */
    "inputName" => "Label1",//DEFAULT ''
    "inputValue" => "some_value",//DEFAULT ''
    "inputCol" => "9",//DEFAULT 12 - labelCol
    "inputPlaceHolder" => false,//DEFAULT labelText
    "inputStyle" => "",//DEFAULT ''
    "inputSize" => "80px",//DEFAULT '100%'
    "required" => true,//DEFAULT false
    "inputReadOnly" => true,//DEFAULT false

        //KHUSUS checkbox THEME kendo
        "checkboxLabel" => "tulisan di sebelah kiri checkbox", //DEFAULT ''

        //KHUSUS textarea THEME kendo
        "textareaRow" => "2", //DEFAULT 5
        "textareaMaxLength" => "200", //DEFAULT 500
        "textareaShowCounter" => false, //DEFAULT true

        //KHUSUS kendoNumericTextBox
        "numericTypeDetail" => "currency",//DEFAULT [BLANK] ; option : currency, percentage, dec1, dec2, dec3, dec4
        "numericIsNegaitve" => true, //DEFAULT false
        "numericMin" => 10, //DEFAULT 0
        "numericMax" => 100, //DEFAULT x
        "numericDecimals" => 2, //DEFAULT x
        "numericStep" => 1, //DEFAULT x
        "numericFormat" => "# pcs", //DEFAULT #

        //KHUSUS kendoDatePicker, kendoTimePicker, kendoDateTimePicker, kendoDatePicker_range
        "dateTimeFormat" => "yyyy-MM-dd", //DEFAULT kendoDatePicker & kendoDatePicker_range: "yyyy-MM-dd" ; kendoTimePicker: "HH:mm:ss" ; kendoDateTimePicker: "yyyy-MM-dd HH:mm:ss"
        "dateTimeMin" => "x", //DEFAULT "this month"
        "dateTimeMax" => "x", //DEFAULT "today"
        //dateTimeMin & dateTimeMax tidak berguna untuk input type kendoDatePicker_range

        //KHUSUS UNTUK kendoDropDownList, kendoComboBox, kendoMultiSelect
        "selectTextField" => "TextColumnName", //DEFAULT "Text"
        "selectValueField" => "ValueColumnName", //DEFAULT "Value"
        "selectFilter" => "startswith", //DEFAULT "contains" ; option : startswith, endswith, contains
        "selectOptions" => [["Text" => "Some Text1", "Value" => "Some Value1"], ["Text" => "Some Text2", "Value" => "Some Value2"]],//DEFAULT []
        "selectTypeDetail" => "monthYearPicker", //DEFAULT "" ; option : monthYearPicker, cbpPicker
            //KHUSUS UNTUK select monthYearPicker
            //selectFilter & selectOptions tidak berguna
            "selectTemplates" => ["year","month"],//DEFAULT ["month","year"]
            "selectYearMin" => 2020,//DEFAULT 2015
            "selectYearMax" => 2021,//DEFAULT date("Y")

            //KHUSUS UNTUK select cbpPicker
            //selectOptions tidak berguna
            "selectTemplates" => ["company","branch","pos"], //DEFAULT ["brand","company","branch","pos"], bisa ditukar2 dan dibuang
            "selectCBPIsAddAll" => true, //DEFAULT false
            "selectCBPCabangPOSes" => '0,1,2,3', //DEFAULT '1,2,3'

        //KHUSUS UNTUK switch THEME kendo
        "switchChecked" => true, //DEFAULT false
        "switchSize" => "medium", //DEFAULT "small"; option : small, medium, large, none
        "switchTrackRounded" => "medium", //DEFAULT "small"; option : small, medium, large, none
        "switchThumbRounded" => "medium", //DEFAULT "small"; option : small, medium, large, none
        "switchMessagesChecked" => "OK", //DEFAULT "YES"
        "switchMessagesUnchecked" => "NOT OK", //DEFAULT "NO"
));
$form->end();
$form->render();
#endregion
