<?php
?>
<script>
    $(document).ready(function(){

    });
</script>
<main id="pageName">
    <div id="contentName_content" class="tde-box-3">
        <?php
            #region SEARCH
                #region FORM
                    $formParams = [
                        "page" => "pageName"
                        ,"group" => "contentName"
                        ,"id" => "GetContents"
                        ,"invalidFeedbackIsShow" => false
                        ,"cancelButtonIsShow" => false
                        ,"submitFontAwesomeIcon" => "fa-solid fa-search"
                        ,"submitText" => "SEARCH"
                        ,"submitButtonColor" => "search"
                        ,"additionalButtons" => [
                            [
                                "color" => "add"
                                ,"fontAwsomeIcon" => "fa-solid fa-plus"
                                ,"text" => "ADD"
                                ,"functionName" => "contentNameAddContentPrepare"
                            ]
                        ]
                    ];
                    $form = new \app\components\Form($formParams);
                    $form->begin();
                    $form->addField(["labelText" => "POS", "inputType" => "kendoDropDownList", "selectTypeDetail" => "cbpPicker", "selectTemplates" => ["pos"], "selectCBPIsAddAll" => true,"required" => true]);
                    $form->addField(["labelText" => "Periode", "inputType" => "kendoDatePicker_range","required" => true]);
                    $form->addField(["labelText" => "No TDE","inputName" => "NumberText"]);
                    $form->end();
                    $form->render();
                #endregion FORM

                #region GRID
                    $subGridParams = [
                        "page" => "pageName",
                        "group" => "contentName",
                        "id" => "ContentItems",
                        "isDetailInit" => true,
                        "columns" => [
                            ["formatType" => "action"],
                            ["field" => "FieldName","title" => "Field", "width" => 200],
                            ["field" => "NumberText","title" => "TDE Number", "formatType" => "numberText"],
                            ["field" => "Date","title" => "Date", "formatType" => "date"],
                            ["field" => "DateTime","title" => "Date  & Time", "formatType" => "dateTime"],
                            ["field" => "Price","title" => "Price", "formatType" => "currency"],
                            ["field" => "DiscountPercentage","title" => "Discount (%)", "formatType" => "percentage"],
                            ["field" => "Quantyt","title" => "Quantity", "formatType" => "numeric"],
                            ["field" => "Index","title" => "Index", "formatType" => "dec"],
                        ],
                    ];
                    $subGrid = new \app\components\KendoGrid($subGridParams);
                    $subGrid->begin();
                    $subGridDetailInitFunctionName = $subGrid->end();
                    $subGrid->render();

                    $gridParams = [
                        "page" => "pageName",
                        "group" => "contentName",
                        "id" => "Contents",
                        "columns" => [
                            ["formatType" => "action"],
                            ["field" => "FieldName","title" => "Field", "width" => 200],
                            ["field" => "NumberText","title" => "TDE Number", "formatType" => "numberText"],
                            ["field" => "Date","title" => "Date", "formatType" => "date"],
                            ["field" => "DateTime","title" => "Date  & Time", "formatType" => "dateTime"],
                            ["field" => "Price","title" => "Price", "formatType" => "currency"],
                            ["field" => "DiscountPercentage","title" => "Discount (%)", "formatType" => "percentage"],
                            ["field" => "Quantyt","title" => "Quantity", "formatType" => "numeric"],
                            ["field" => "Index","title" => "Index", "formatType" => "dec"],
                        ],
                        "detailInit" => $subGridDetailInitFunctionName,
                    ];
                    $grid = new \app\components\KendoGrid($gridParams);
                    $grid->begin();
                    $grid->end();
                    $grid->render();
                #endregion GRID
            #endregion SEARCH

            #region ADD
                $formParams = [
                    "page" => "pageName"
                    ,"group" => "contentName"
                    ,"id" => "AddContent"
                    ,"invalidFeedbackIsShow" => false
                    ,"cancelFunctions" => ["TDE.contentNameKendoWindowAddContent.close"]
                    ,"submitFontAwesomeIcon" => "fa-solid fa-plus"
                    ,"submitText" => "ADD"
                    ,"submitButtonColor" => "add"
                ];
                $form = new \app\components\Form($formParams);
                $form->begin();
                $form->addField(["labelText" => "POS", "inputType" => "kendoDropDownList", "selectTypeDetail" => "cbpPicker", "selectTemplates" => ["pos"], "required" => true]);
                $form->addField(["labelText" => "Date", "inputType" => "kendoDatePicker","required" => true]);
                $form->end();

                $windowParams = array(
                    "page" => "pageName"
                    ,"group" => "contentName"
                    ,"id" => "AddContent"
                    ,"title" => "ADD"
                    ,"body" => $form->getHtml()
                );
                $window = new \app\components\KendoWindow($windowParams);
                $window->begin();
                $window->end();
                $window->render();
            #endregion ADD

            #region EDIT
                $formParams = [
                    "page" => "pageName"
                    ,"group" => "contentName"
                    ,"id" => "GetContent"
                    ,"isHidden" => true
                ];
                $form = new \app\components\Form($formParams);
                $form->begin();
                $form->addField(["inputName" => "Id"]);
                $form->end();
                $form->render();

                $formParams = [
                    "page" => "pageName"
                    ,"group" => "contentName"
                    ,"id" => "EditContent"
                    ,"invalidFeedbackIsShow" => false
                    ,"cancelFunctions" => ["TDE.contentNameKendoWindowEditContent.close"]
                    ,"submitFontAwesomeIcon" => "fa-solid fa-pencil"
                    ,"submitText" => "EDIT"
                    ,"submitButtonColor" => "edit"
                ];
                $form = new \app\components\Form($formParams);
                $form->begin();
                $form->addField(["inputName" => "Id", "inputType" => "hidden"]);
                $form->addField(["labelText" => "POS", "inputName" => "POS", "inputReadOnly" => true]);
                $form->addField(["labelText" => "Date", "inputType" => "kendoDatePicker","required" => true]);
                $form->end();

                $windowParams = array(
                    "page" => "pageName"
                    ,"group" => "contentName"
                    ,"id" => "EditContent"
                    ,"title" => "EDIT"
                    ,"body" => $form->getHtml()
                );
                $window = new \app\components\KendoWindow($windowParams);
                $window->begin();
                $window->end();
                $window->render();
            #endregion EDIT

            #region DELETE
                $formParams = [
                    "page" => "pageName"
                    ,"group" => "contentName"
                    ,"id" => "SetDeleteContent"
                    ,"isHidden" => true
                ];
                $form = new \app\components\Form($formParams);
                $form->begin();
                $form->addField(["inputName" => "Id"]);
                $form->end();
                $form->render();
            #endregion DELETE

            #region RELEASE
                $formParams = [
                    "page" => "pageName"
                    ,"group" => "contentName"
                    ,"id" => "SetReleaseContent"
                    ,"isHidden" => true
                ];
                $form = new \app\components\Form($formParams);
                $form->begin();
                $form->addField(["inputName" => "Id"]);
                $form->end();
                $form->render();
            #endregion RELEASE

            #region UNRELEASE
                $formParams = [
                    "page" => "pageName"
                    ,"group" => "contentName"
                    ,"id" => "SetUnReleaseContent"
                    ,"isHidden" => true
                ];
                $form = new \app\components\Form($formParams);
                $form->begin();
                $form->addField(["inputName" => "Id"]);
                $form->end();
                $form->render();
            #endregion UNRELEASE

            #region COMPLETE
                $formParams = [
                    "page" => "pageName"
                    ,"group" => "contentName"
                    ,"id" => "SetCompleteContent"
                    ,"isHidden" => true
                ];
                $form = new \app\components\Form($formParams);
                $form->begin();
                $form->addField(["inputName" => "Id"]);
                $form->end();
                $form->render();
            #endregion COMPLETE

            #region CANCEL
                $formParams = [
                    "page" => "pageName"
                    ,"group" => "contentName"
                    ,"id" => "SetCancelContent"
                    ,"isHidden" => true
                ];
                $form = new \app\components\Form($formParams);
                $form->begin();
                $form->addField(["inputName" => "Id"]);
                $form->end();
                $form->render();
            #endregion CANCEL
        ?>
    </div>
</main>
