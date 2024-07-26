<div class="h6">APPROVAL</div>
<?php
//dd($_READPOSES[76]) ;
//dd($_BRANCH) ;
//echo($_BRANCH->BrandId) ;
//echo($_BRANCH->CompanyId) ;
//echo($_BRANCH->Id) ;
?>
<?php
#region FORM GET APPROVALS
    $formParams = [
        "page" => "profile"
        ,"group" => "approval"
        ,"id" => "GetApprovals"
        ,"invalidFeedbackIsShow" => false
        ,"cancelButtonIsShow" => false
        ,"submitFontAwesomeIcon" => "fa-solid fa-search"
        ,"submitText" => "SEARCH"
    ];
    $form = new \app\components\Form($formParams);

    $form->begin();
        //if(APP_NAME == "Plutus")$form->addField(["labelText" => "POS", "inputType" => "kendoDropDownList", "selectTypeDetail" => "cbpPicker", "selectTemplates" => ["pos"], "selectCBPFilters" => ["posIds" => $_READPOSES[76]], "required" => true]);
        $form->addField(["labelText" => "Req. Date", "inputName" => "Date", "inputType" => "kendoDatePicker_range", "required" => true]);
        $form->addField(["labelText" => "Status", "inputName" => "StatusCode", "inputType" => "kendoDropDownList", "selectOptions" => $approvalApprovalStatuses, "required" => true]);
        $form->collapsable();
        $form->addField(["labelText" => "Req. Number", "inputName" => "ReferenceNumber"]);
        $form->addField(["inputType" => "hidden", "inputName" => "PositionId", "inputValue" => $_EMPLOYEE["PositionId"]]);

        $CBPFilters = [];
        if(APP_NAME == "Plutus")
        {
            $CBPFilters["brandIds"] = [$_BRANCH->BrandId];
            $CBPFilters["companyIds"] = [$_BRANCH->CompanyId];
            $CBPFilters["branchIds"] = [$_BRANCH->Id];
        }

        $form->addField(["labelText" => "Area", "inputType" => "kendoDropDownList", "selectTypeDetail" => "cbpPicker", "selectTemplates" => ["brand","branch"], "selectCBPIsAddAll" => true, "selectCBPFilters" => $CBPFilters ]);
        $form->addField(["labelText" => "Application", "inputName" => "ApplicationId", "inputType" => "kendoDropDownList", "selectOptions" => $approvalApprovalTypes["Applications"], "inputOnChange" => true]);
        $form->addField(["labelText" => "Module", "inputName" => "PageId", "inputType" => "kendoDropDownList", "inputOnChange" => true]);
        $form->addField(["labelText" => "Req. Type", "inputName" => "ApprovalTypeId", "inputType" => "kendoDropDownList", "inputOnChange" => true]);
        $form->addField(["labelText" => "Req. Step", "inputName" => "ApprovalTypeItemId", "inputType" => "kendoDropDownList"]);
    $form->end();
    $form->render();
    echo "<hr/>";
        $gridParams = [
            "page" => "profile",
            "group" => "approval",
            "id" => "Approvals",
            "columns" => [
                ["title" => "No", "formatType" => "rowNumber", "locked" => true],
                ["title" => " ", "field" => "Action", "formatType" => "action", "locked" => true],
                ["field" => "ApprovalProfile","title" => "Approval", "width" => 320],
                ["field" => "AdditionalData","title" => "Remarks", "width" => 600],
                //["field" => "CreatedDateTime","title" => "Req. Date", "formatType" => "date"],
                //["field" => "ApprovalTypeName","title" => "Approval Type", "width" => 200],
                //["field" => "Status","title" => "Status", "width" => 100],
                //["field" => "ApprovalTypeItemName","title" => "Approval Step", "width" => 200],
            ]
        ];
        $grid = new \app\components\KendoGrid($gridParams);
        $grid->begin();
        $grid->end();
        $grid->render();

    $formParams = [
        "page" => "profile"
        ,"group" => "approval"
        ,"id" => "GetApproval"
        ,"isHidden" => true
    ];
    $form = new \app\components\Form($formParams);
    $form->begin();
        $form->addField(["inputName" => "DBName"]);
        $form->addField(["inputName" => "ApprovalId"]);
    $form->end();
    $form->render();
#endregion FORM GET APPROVALS

#region REQUEST DATA
    $windowBody = "";

    #region APPROVAL TABLE LIST
        $windowBody .= "<h5 id='approvalApproveDisapproveApprovalTypeName'>APPROVAL TYPE NAME</h5>";
        $gridParams = [
            "page" => "profile",
            "group" => "approvalApproveDisapprove",
            "id" => "Approvals",
            "columnMenu" => false,
            "filterable" => false,
            "sortable" => false,
            "resizable" => false,
            "pageable" => false,
            "height" => false,
            "columns" => [
                //["title" => "No", "formatType" => "rowNumber"],
                ["title" => "Status", "field" => "Action", "width" => 120],
                //["title" => "Status", "field" => "StatusCode", "formatType" => "action"],
                ["title" => "Employee", "field" => "EmployeeName", "width" => 250],
                ["title" => "Role", "field" => "ApprovalTypeItemName", "width" => 300],
                ["title" => "Date", "field" => "DateTime", "width" => 170],
                ["title" => " "],
            ]
        ];
        $grid = new \app\components\KendoGrid($gridParams);
        $grid->begin();
        $grid->end();
        $windowBody .= $grid->getHtml();
    #endregion

    $windowBody .= "<hr/>";

    #region DETAIL REQUEST DATA
        ob_start();
        require __DIR__."/profile_approval/1_96_ReleasePO.php";
        require __DIR__."/profile_approval/1_156_ReleasePO.php";

        require __DIR__."/profile_approval/2_29_ReleaseMAP.php";

        require __DIR__."/profile_approval/3_6_ReleasePKB.php";
        require __DIR__."/profile_approval/3_17_RefundAsuransi.php";
        require __DIR__."/profile_approval/3_24_RefundAsuransi.php";
        require __DIR__."/profile_approval/3_30_ReleasePS_AdditionalPlafond.php";
        require __DIR__."/profile_approval/3_44_ReleaseSPK.php";
        require __DIR__."/profile_approval/3_76_ReturPOSparepart.php";
        require __DIR__."/profile_approval/3_37_SparepartMutationSend.php";
        $windowBody .= ob_get_clean();
    #endregion

    $windowParams = array(
        "page" => "profile"
        ,"group" => "approval"
        ,"id" => "ApproveDisapprove"
        ,"title" => "VIEW REQUEST"
        ,"body" => $windowBody
    );
    $window = new \app\components\KendoWindow($windowParams);
    $window->begin();
    $window->end();
    $window->render();
#endregion

#region SET APPROVE
    $formParams = [
        "page" => "profile"
        ,"group" => "approval"
        ,"id" => "SetApprove"
        ,"submitFontAwesomeIcon" => "fa-regular fa-thumbs-up"
        ,"submitButtonColor" => "success"
        ,"submitText" => "APPROVE"
        ,"cancelFunctions" =>  array("TDE.approvalKendoWindowSetApprove.close")
    ];
    $form = new \app\components\Form($formParams);
    $form->begin();
    $form->addField(["inputName" => "DBName", "inputType" => "hidden"]);
    $form->addField(["inputName" => "ApprovalId", "inputType" => "hidden"]);
    $form->addField(["labelText" => "Remarks", "inputName" => "GeneralNotes", "labelIsShow" => false]);
    $form->end();
    $body = $form->getHtml();

    $windowParams = array(
        "page" => "profile"
        ,"group" => "approval"
        ,"id" => "SetApprove"
        ,"title" => "GIVE APPROVAL"
        ,"body" => $body
        ,"width" => "375px"
    );
    $window = new \app\components\KendoWindow($windowParams);
    $window->begin();
    $window->end();
    $window->render();
#endregion SET APPROVE

#region SET DISAPPROVE
    $formParams = [
        "page" => "profile"
        ,"group" => "approval"
        ,"id" => "SetDisapprove"
        ,"submitFontAwesomeIcon" => "fa-regular fa-thumbs-down"
        ,"submitButtonColor" => "danger"
        ,"submitText" => "DISAPPROVE"
        ,"cancelFunctions" =>  array("TDE.approvalKendoWindowSetDisapprove.close")
    ];
    $form = new \app\components\Form($formParams);
    $form->begin();
    $form->addField(["inputName" => "DBName", "inputType" => "hidden"]);
    $form->addField(["inputName" => "ApprovalId", "inputType" => "hidden"]);
    $form->addField(["labelText" => "Remarks", "inputName" => "GeneralNotes", "required" => true, "labelIsShow" => false]);
    $form->end();
    $body = $form->getHtml();

    $windowParams = array(
        "page" => "profile"
        ,"group" => "approval"
        ,"id" => "SetDisapprove"
        ,"title" => "DECLINE APPROVAL"
        ,"body" => $body
        ,"width" => "375px"
    );
    $window = new \app\components\KendoWindow($windowParams);
    $window->begin();
    $window->end();
    $window->render();
#endregion SET DISAPPROVE
?>
