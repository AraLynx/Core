<?php

?>
<script>
    $(document).ready(function(){
        newsShowSubContent('<?php echo $subContent;?>');
    });
    pkw
</script>
<main id="news" class="d-flex w-100">
    <div id="news_menu" class="tde-box me-3" style="min-width:150px">
        <p><a role="button" onClick="newsShowSubContent('settings');"><i class="fa-solid fa-fw fa-cogs"></i> SETTINGS</a></p>
        <hr class="text-secondary"/>
        <p><a role="button" onClick="newsShowSubContent('news');"><i class="fa-regular fa-fw fa-newspaper"></i> NEWS</a></p>
    </div>
    <div id="news_content" class="tde-box-3 overflow-auto flex-fill">
        <div id="news_settings" class="page_content d-none">
            <h5><i class="fa-solid fa-fw fa-cogs"></i> SETTINGS</a></h5>
            <div class="d-flex justify-content-between">
                <h6>NEWS CATEGORY</h6>
                <div class="btn btn-primary" onClick="TDE.settingsAddNewsCategoryName.value('');TDE.settingsKendoWindowAddNewsCategory.center().open();">
                    <i class="fa-reguler fa-plus"></i>
                    ADD CATEGORY
                </div>
            </div>
            <?php
                //SETINGS - GET NEWS CATEGORIES
                    $formParams = array(
                        "page" => "news"
                        ,"group" => "settings"
                        ,"id" => "GetNewsCategories"
                        ,"isHidden" => true
                    );
                    $form = new \app\components\Form($formParams);
                    $form->begin();
                    $form->addField(["inputName" => "PageId", "inputValue" => $pageId]);
                    $form->addField(["inputName" => "GaiaModuleId", "inputValue" => $moduleId]);
                    $form->end();
                    $form->render();
                //SETINGS - GET NEWS CATEGORIES

                //SETINGS - ADD NEWS CATEGORY
                    $formParams = array(
                        "page" => "news"
                        ,"group" => "settings"
                        ,"id" => "AddNewsCategory"
                        ,"cancelFunctions"=> ["TDE.settingsKendoWindowAddNewsCategory.close"]
                    );
                    $form = new \app\components\Form($formParams);
                    $form->begin();
                    $form->addField(["inputType" => "hidden", "inputName" => "PageId", "inputValue" => $pageId]);
                    $form->addField(["inputType" => "hidden", "inputName" => "GaiaModuleId", "inputValue" => $moduleId]);
                    $form->addField(["inputName" => "Name", "required" => true]);
                    $form->end();
                    //$form->render();

                    $windowParams = array(
                        "page" => "news"
                        ,"group" => "settings"
                        ,"id" => "AddNewsCategory"
                        ,"title" => "ADD NEWS CATEGORY"
                        ,"body" => $form->getHtml()
                    );
                    $window = new \app\components\KendoWindow($windowParams);
                    $window->begin();
                    $window->end();
                    $window->render();
                //SETINGS - ADD NEWS CATEGORIES

                //SETINGS - EDIT NEWS CATEGORY
                    $formParams = array(
                        "page" => "news"
                        ,"group" => "settings"
                        ,"id" => "EditNewsCategory"
                        ,"cancelFunctions"=> ["TDE.settingsKendoWindowEditNewsCategory.close"]
                    );
                    $form = new \app\components\Form($formParams);
                    $form->begin();
                    $form->addField(["inputType" => "hidden", "inputName" => "PageId", "inputValue" => $pageId]);
                    $form->addField(["inputType" => "hidden", "inputName" => "Id"]);
                    $form->addField(["inputName" => "Name", "required" => true]);
                    $form->addField(["labelText" => "Active", "inputName" => "IsEnable", "inputType" => "switch", "required" => true]);
                    $form->end();
                    //$form->render();

                    $windowParams = array(
                        "page" => "news"
                        ,"group" => "settings"
                        ,"id" => "EditNewsCategory"
                        ,"title" => "EDIT NEWS CATEGORY"
                        ,"body" => $form->getHtml()
                    );
                    $window = new \app\components\KendoWindow($windowParams);
                    $window->begin();
                    $window->end();
                    $window->render();
                //SETINGS - EDIT NEWS CATEGORIES

                $gridParams = [
                    "page" => "news"
                    ,"group" => "settings"
                    ,"id" => "NewsCategories"
                    ,"columns" => [
                        //["field" => "Action", "formatType" => "action"],
                        ["field" => "NameProfile", "title" => "News Category"],
                        ["field" => "NewsCount", "title" => "Article Count", "formatType" => "numeric", "width"=> 150],
                    ]
                ];

                $grid = new \app\components\KendoGrid($gridParams);
                $grid->begin();
                $grid->end();
                $grid->render();
            ?>
        </div>

        <div id="news_news" class="page_content d-none">
            <h5><i class="fa-regular fa-fw fa-newspaper"></i> NEWS</h5>
            <?php
                //NEWS - GET NEWSES
                    $formParams = array(
                        "page" => "news"
                        ,"group" => "news"
                        ,"id" => "GetNewses"
                        ,"cancelButtonIsShow" => false
                        ,"submitFontAwesomeIcon" => "fa-solid fa-search"
                        ,"submitText" => "SEARCH"
                        ,"additionalButtons" => array(
                            array(
                                "color" => "primary"
                                ,"fontAwsomeIcon" => "fa-solid fa-newspaper"
                                ,"text" => "CREATE NEWS"
                                ,"functionName" => "TDE.newsKendoWindowAddNews.maximize().open"
                            )
                        )
                    );
                    $form = new \app\components\Form($formParams);
                    $form->begin();
                    $form->addField(["inputName" => "PageId", "inputType" => "hidden", "inputValue" => $pageId]);
                    $form->addField(["inputName" => "GaiaModuleId", "inputType" => "hidden", "inputValue" => $moduleId]);
                    $form->addField(["labelText" => "Publish Date", "inputName" => "Date", "inputType" => "kendoDatePicker_range", "required" => true]);
                    $form->addField(["labelText" => "Content", "inputName" => "Content"]);
                    $form->end();
                    $form->render();
                //NEWS - GET NEWSES

                //NEWS - ADD NEWS
                    $formParams = array(
                        "page" => "news"
                        ,"group" => "news"
                        ,"id" => "AddNews"
                        ,"invalidFeedbackIsShow" => false
                        //,"defaultLabelCol" => 2
                        ,"cancelFunctions"=> ["TDE.newsKendoWindowAddNews.close"]
                        ,"submitFontAwesomeIcon" => "fa-solid fa-newspaper"
                        ,"submitText" => "ADD NEWS"
                    );
                    $form = new \app\components\Form($formParams);
                    $form->begin();
                    $form->addField(["inputType" => "hidden", "inputName" => "PageId", "inputValue" => $pageId]);
                    $form->addField(["inputType" => "hidden", "inputName" => "GaiaModuleId", "inputValue" => $moduleId]);
                    $form->addField(["inputName" => "Title", "required" => true]);
                    $form->addField(["labelText" => "Sub Title", "inputName" => "SubTitle"]);
                    $form->addField(["labelText" => "Publish Date", "inputName" => "PublishDate", "inputType" => "kendoDatePicker", "required" => true]);
                    $form->addField(["inputName" => "Summary", "inputType" => "textarea", "textareaMaxLength" => 1000, "textareaRow" => 3,  "required" => true]);
                    $form->end();

                    $gridParams = array(
                        "page" => "news",
                        "group" => "newsAddNews",
                        "columns" => [
                            ["field" => "Section","title" => "Section", "width" => 250],
                        ],
                    );
                    $grid = new \app\components\KendoGrid($gridParams);
                    $grid->begin();
                    $grid->end();

                    $body = $form->getHtml();
                    $body .= "<br/>";
                    $body .= "<div class='btn btn-primary' onClick='TDE.newsAddNewsKendoWindowAddNewsSection.center().open();'><i class='fa-regular fa-file-lines'></i> ADD SECTION</div>";
                    $body .= $grid->getHtml();


                    $windowParams = array(
                        "page" => "news"
                        ,"group" => "news"
                        ,"id" => "AddNews"
                        ,"title" => "ADD NEWS"
                        ,"width" => "700px"
                        ,"body" => $body
                    );
                    $window = new \app\components\KendoWindow($windowParams);
                    $window->begin();
                    $window->end();
                    $window->render();

                    //NEWS - ADD NEWS ADD SECTION
                        $formParams = array(
                            "page" => "news"
                            ,"group" => "newsAddNews"
                            ,"id" => "AddNewsSection"
                            ,"invalidFeedbackIsShow" => false
                            //,"defaultLabelCol" => 2
                            ,"cancelFunctions"=> ["TDE.newsAddNewsKendoWindowAddNewsSection.close"]
                            ,"submitFontAwesomeIcon" => "fa-regular fa-file-lines"
                            ,"submitText" => "ADD SECTION"
                        );
                        $form = new \app\components\Form($formParams);
                        $form->begin();
                        $form->addField(["inputType" => "hidden", "inputName" => "PageId", "inputValue" => $pageId]);
                        $form->addField(["inputType" => "hidden", "inputName" => "GaiaModuleId", "inputValue" => $moduleId]);
                        $form->addField(["inputName" => "Content", "inputType" => "textarea", "textareaMaxLength" => 5000, "required" => true]);
                        $form->addField(["labelText" => "Source", "inputName" => "Source", "inputPlaceHolder" => "https://www.someLink.com/someArticle"]);
                        $form->addColumn(2);
                            $form->addField(["inputName" => "Image", "inputType" => "kendoUpload", "uploadFileTypes" => ["jpg", "jpeg", "png"]]);
                        $form->nextColumn();
                            $form->addField(["labelText" => "Position", "inputName" => "ImagePosition", "inputType" => "kendoDropDownList", "selectOptions" => $imagePositionOptions],);
                        $form->end();

                        $windowParams = array(
                            "page" => "news"
                            ,"group" => "newsAddNews"
                            ,"id" => "AddNewsSection"
                            ,"title" => "ADD SECTION"
                            ,"width" => "700px"
                            ,"body" => $form->getHtml()
                        );
                        $window = new \app\components\KendoWindow($windowParams);
                        $window->begin();
                        $window->end();
                        $window->render();
                    //NEWS - ADD NEWS ADD SECTION
                //NEWS - ADD NEWS
            ?>
        </div>
    </div>
</div>
