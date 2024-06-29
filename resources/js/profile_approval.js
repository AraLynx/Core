function approvalGetApprovalsApplicationIdChange(e){
    TDE.approvalGetApprovalsPageId.reset();
    TDE.approvalGetApprovalsApprovalTypeId.reset();
    TDE.approvalGetApprovalsApprovalTypeItemId.reset();

    if(TDE.approvalGetApprovalsApplicationId.select() != -1 && TDE.approvalGetApprovalsApplicationId.value() != "*"){
        let value = TDE.approvalGetApprovalsApplicationId.value();
        TDE.approvalGetApprovalsPageId.populate(approvalGetApprovalsSelectOptionsPages[value]);
        if(approvalGetApprovalsSelectOptionsPages[value].length == 1){
            TDE.approvalGetApprovalsPageId.select(0);
            approvalGetApprovalsPageIdChange();
        }
        else{
            TDE.approvalGetApprovalsPageId.open();
        }
    }
}
function approvalGetApprovalsPageIdChange(e){
    TDE.approvalGetApprovalsApprovalTypeId.reset();
    TDE.approvalGetApprovalsApprovalTypeItemId.reset();

    if(TDE.approvalGetApprovalsPageId.select() != -1 && TDE.approvalGetApprovalsPageId.value() != "*"){
        let value = TDE.approvalGetApprovalsPageId.value();
        TDE.approvalGetApprovalsApprovalTypeId.populate(approvalGetApprovalsSelectOptionsApprovalTypes[value]);
        if(approvalGetApprovalsSelectOptionsApprovalTypes[value].length == 1){
            TDE.approvalGetApprovalsApprovalTypeId.select(0);
            approvalGetApprovalsApprovalTypeIdChange();
        }
        else{
            TDE.approvalGetApprovalsApprovalTypeId.open();
        }
    }
}
function approvalGetApprovalsApprovalTypeIdChange(e){
    TDE.approvalGetApprovalsApprovalTypeItemId.reset();

    if(TDE.approvalGetApprovalsApprovalTypeId.select() != -1 && TDE.approvalGetApprovalsApprovalTypeId.value() != "*"){
        let value = TDE.approvalGetApprovalsApprovalTypeId.value();
        TDE.approvalGetApprovalsApprovalTypeItemId.populate(approvalGetApprovalsSelectOptionsApprovalTypeSteps[value]);
        if(approvalGetApprovalsSelectOptionsApprovalTypeSteps[value].length == 1){
            TDE.approvalGetApprovalsApprovalTypeItemId.select(0);
        }
        else{
            TDE.approvalGetApprovalsApprovalTypeItemId.open();
        }
    }
}
function approvalGetApprovalsSuccess(result){
    TDE.approvalKendoGridApprovals.populate(result.datas);
}
function approvalGetApprovalPrepareData(dbName, approvalId){
    $("#approvalGetApprovalDBName").val(dbName);
    $("#approvalGetApprovalApprovalId").val(approvalId);
    approvalGetApproval();
}
function approvalGetApprovalSuccess(result){
    $("#approvalApproveDisapprove").addClass("d-none");
    if(result.data){
        TDE.approvalKendoWindowApproveDisapprove.center().maximize().open();

        $("#approvalApproveDisapproveApprovalTypeName").html(result.datas.approval.ApprovalTypeName);
        TDE.approvalApproveDisapproveKendoGridApprovals.populate(result.datas.approvals);

        $(".approvalApproveDisapprove").addClass("d-none");
        let approvalName = result.data;
        $("#approvalApproveDisapprove_"+approvalName).removeClass("d-none");

        if(approvalName == "1_96_ReleasePO"){
            let applicationId = 1;
            let pageId = 96;
            approvalGetApproval_Gaia_ReleasePOAsset(applicationId, pageId, result.datas.PO, result.datas.Items);
        }
        if(approvalName == "1_156_ReleasePO"){
            let applicationId = 1;
            let pageId = 156;
            approvalGetApproval_Gaia_ReleasePOAsset(applicationId, pageId, result.datas.PO, result.datas.Items);
        }
        if(approvalName == "3_6_ReleasePKB"){
            approvalGetApproval_3_6_ReleasePKB(result.datas.PKB, result.datas.Items);
        }
        if(approvalName == "3_30_ReleasePS_AdditionalPlafond"){
            approvalGetApproval_3_30_ReleasePS_AdditionalPlafond(result.datas.PS, result.datas.Items);
        }
        if(approvalName == "3_44_ReleaseSPK"){
            approvalGetApproval_3_44_ReleaseSPK(result.datas.SPK);
        }
        if(approvalName == "3_76_ReturPOSparepart"){
            approvalGetApproval_3_76_ReturPOSparepart(result.datas.POGRReturn, result.datas.POGRReturnItems);
        }
        if(approvalName == "3_37_SparepartMutationSend"){
            approvalGetApproval_3_37_SparepartMutationSend(result.datas.SparepartMutation, result.datas.SparepartMutationItems);
        }
        if(approvalName == "3_17_RefundAsuransi"){
            approvalGetApproval_3_17_RefundAsuransi(result.datas.RefundAsuransi);
        }
        if(approvalName == "3_24_RefundAsuransi"){
            approvalGetApproval_3_24_RefundAsuransi(result.datas.RefundAsuransi);
        }
        if(approvalName == "2_29_ReleaseMAP"){
            approvalGetApproval_2_29_ReleaseMAP(result.datas.MarketingActivity, result.datas.MarketingActivityItems);
        }
    }
    else{
        TDE.commonModal.Display({
            body: "This approval is not ready in this version, please go to <a href='https://vibi.trimandirigroup.com:5431/'>legacy application</a>"
        });
    }
}
    function approvalGetApproval_renderData(datas, formIds){
        //console.log(datas, formIds);
        for (const [key, value] of Object.entries(datas)) {
            for(const formId of formIds){
                let elementId = "approval"+formId+key;
                if((elementId in TDE)){
                    TDE[elementId].value(value);
                }
            }
        }
    }
    function approvalGetApproval_Gaia_ReleasePOAsset(applicationId, pageId, PO, Items){//PO ASET IT DR GAIA
        approvalGetApproval_renderData(PO, ["ApproveDisapprove_"+applicationId+"_"+pageId+"_ReleasePO","ApproveDisapprove_"+applicationId+"_"+pageId+"_ReleasePOMobile"]);
        TDE["approvalKendoGridApproveDisapprove_"+applicationId+"_"+pageId+"_ReleasePO"].populate(Items);
        TDE["approvalKendoGridApproveDisapprove_"+applicationId+"_"+pageId+"_ReleasePOMobile"].populate(Items);
    }
    function approvalGetApproval_3_6_ReleasePKB(PKB, Items){//RELEASE UNTUK NOTA PKB
        approvalGetApproval_renderData(PKB, ["ApproveDisapprove_3_6_ReleasePKB"]);
        TDE.approvalKendoGridApproveDisapprove_3_6_ReleasePKBItems.populate(Items);
    }
    function approvalGetApproval_3_30_ReleasePS_AdditionalPlafond(PS, Items){//RELEASE ADDITIONAL PLAFOND PS
        approvalGetApproval_renderData(PS, ["ApproveDisapprove_3_30_ReleasePS_AdditionalPlafond","ApproveDisapprove_3_30_ReleasePS_AdditionalPlafondMobile"]);
        TDE.approvalKendoGridApproveDisapprove_3_30_ReleasePS_AdditionalPlafondItems.populate(Items);
    }
    function approvalGetApproval_3_44_ReleaseSPK(SPK){//RELEASE UNTUK NOTA SPK
        approvalGetApproval_renderData(SPK, ["ApproveDisapprove_3_44_ReleaseSPK","ApproveDisapprove_3_44_ReleaseSPKMobile"]);
    }
    function approvalGetApproval_3_76_ReturPOSparepart(POGRReturn, POGRReturnItems){
        approvalGetApproval_renderData(POGRReturn, ["ApproveDisapprove_3_76_ReturPOSparepart"]);

        let returnEditReturnKendoGridSparepartsData = [];
        $.each(POGRReturnItems, function(POItemIDNId,Sparepart){
            returnEditReturnKendoGridSparepartsData.push({
                PurchaseOrderProfile : "No "+Sparepart.PONumberText+"<br/>Tgl "+Sparepart.PODate+"<br/>Vendor "+Sparepart.PartnerName,
                SparepartProfile : Sparepart.POItemCode+"<br/>"+Sparepart.POItemName,
                GRProfile : "No "+Sparepart.POGRDeliveryNumber+"<br/>Tgl "+Sparepart.POGRDate+"<br/>Jumlah "+Sparepart.POGRQuantity,//+" "+Sparepart.SparepartUnit,

                ReturnQuantity : Sparepart.Quantity,
                ReturnValue : Sparepart.DPPNominal,
            });
        });

        TDE.approvalKendoGridApproveDisapprove_3_76_ReturPOSparepartItems.populate(returnEditReturnKendoGridSparepartsData);
    }
    function approvalGetApproval_3_37_SparepartMutationSend(SparepartMutation, SparepartMutationItems){
        approvalGetApproval_renderData(SparepartMutation, ["ApproveDisapprove_3_37_SparepartMutationSend"]);

        let sendEditSparepartMutationKendoGridSparepartsData = [];
        $.each(SparepartMutationItems, function(Index,Sparepart){
            sendEditSparepartMutationKendoGridSparepartsData.push({
                SparepartGroupProfile : `<p class='text-decoration-underline text-center' title='${Sparepart.SparepartGroupName}'>${Sparepart.SparepartGroupCode}</p>`,
                SparepartGroup2Profile : `<p class='text-decoration-underline text-center' title='${Sparepart.SparepartGroup2Name}'>${Sparepart.SparepartGroup2Code}</p>`,
                SparepartGroup3Profile : `<p class='text-decoration-underline text-center' title='${Sparepart.SparepartGroup3Name}'>${Sparepart.SparepartGroup3Code}</p>`,

                SparepartCode : Sparepart.SparepartCode,
                SparepartName : Sparepart.SparepartName,
                OriginQuantity : Sparepart.OriginQuantity,
                OriginRackName : Sparepart.OriginRackName,
            });
        });

        TDE.approvalKendoGridApproveDisapprove_3_37_SparepartMutationSendItems.populate(sendEditSparepartMutationKendoGridSparepartsData);
    }
    function approvalGetApproval_3_17_RefundAsuransi(RefundAsuransi){
        approvalGetApproval_renderData(RefundAsuransi, ["ApproveDisapprove_3_17_RefundAsuransi"]);
    }
    function approvalGetApproval_3_24_RefundAsuransi(RefundAsuransi){
        approvalGetApproval_renderData(RefundAsuransi, ["ApproveDisapprove_3_24_RefundAsuransi"]);
    }
    function approvalGetApproval_2_29_ReleaseMAP(MarketingActivity,MarketingActivityItems){
        approvalGetApproval_renderData(MarketingActivity, ["ApproveDisapprove_2_29_ReleaseMAP"]);
        let datas = [];
        $.each(MarketingActivityItems, function(Index,Item){
            datas.push({
                PICProfile : Item.PICProfile,
                ActivityDateTime : Item.ActivityDateTime,
                DetailActivity : Item.DetailActivity,
                DetailBudget : Item.DetailBudget,
                CalculateBudget : Item.CalculateBudget
            });
        });
        TDE.approvalKendoGridApproveDisapprove_2_29_ReleaseMAPItems.populate(datas);
    }

function approvalSetApproveConfirmation(dbName, approvalId){
    $("#approvalSetApproveDBName").val(dbName);
    $("#approvalSetApproveApprovalId").val(approvalId);
    TDE.approvalKendoWindowSetApprove.center().open();
}
function approvalSetApproveSuccess(result){
    if(!result.data.IsError){
        TDE.approvalKendoWindowSetApprove.close();
        TDE.approvalKendoWindowApproveDisapprove.close();
        approvalGetApprovals();
    }
}
function approvalSetDisapproveConfirmation(dbName, approvalId){
    $("#approvalSetDisapproveDBName").val(dbName);
    $("#approvalSetDisapproveApprovalId").val(approvalId);
    TDE.approvalKendoWindowSetDisapprove.center().open();
}
function approvalSetDisapproveSuccess(result){
    if(!result.data.IsError){
        TDE.approvalKendoWindowSetDisapprove.close();
        TDE.approvalKendoWindowApproveDisapprove.close();
        approvalGetApprovals();
    }
}
