<?php
?>

<main id="news" class="d-lg-flex w-100">
    <div id="page_name_menu" class="tde-box me-3" style="min-width:150px">
        <nav class="p-2">
            <ul class="d-flex flex-lg-column list-unstyled mb-0 mb-lg-3">
                <li class="py-2 px-3 p-lg-0">
                    <div class="d-flex align-items-center" role="button" onClick="page_nameShowSubContent('subContent1');">
                        <!--MENGGUNAKAN ICON FONT AWESOME-->
                        <i class="fa-solid fa-fw fa-display" title="SUB CONTENT 1"></i>
                        <div class="d-lg-block d-none ms-lg-2"> SUB CONTENT 1</div>
                    </div>
                </li>
                <li class="py-2 px-3 p-lg-0">
                    <div class="d-flex align-items-center" role="button" onClick="page_nameShowSubContent('subContent2');">
                        <!--MENGGUNAKAN IMAGE DI FOLDER IMAGES/SUBPAGE-->
                        <img class="subpage_menu_icon" src="/<?php echo IMAGE_ROOT?>subpage/subContent2.png"></img>
                        <div class="d-lg-block d-none ms-lg-2"> SUB CONTENT 2</div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    <div id="spacer" class="mb-3 me-lg-3 mb-lg-0"></div>
    <div id="page_name_content" class="tde-box-3 overflow-auto flex-fill">
        <div id="page_name_subContent1" class="page_content d-none">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-fw fa-display" title="SUB CONTENT 1"></i>
                <div class="h4"> SUB CONTENT 1</div>
            </div>
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

        <div id="page_name_subContent2" class="page_content d-none">
            <div class="d-flex align-items-center">
                <img class="subpage_content_icon" src="/<?php echo IMAGE_ROOT?>subpage/subContent2.png"></img>
                <div class="h4">SUB CONTENT 2</div>
            </div>
            <?php
            ?>
        </div>
    </div>
</main>
<script>
    $(document).ready(function(){
        page_nameShowSubContent('<?php echo $subContent;?>');
    });
</script>
