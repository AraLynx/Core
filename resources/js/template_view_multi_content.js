/*FIND + REPLACE page -> actual_page_name*/
alert("JS LOADED");
const linkAjax = "/"+ROOT+"ajax/page_name/";

$(document).ready(function(){
});

function page_nameShowSubContent(subContent){
    $(".page_content").addClass("d-none");
    $("#page_name_"+subContent).removeClass("d-none");
    if(subContent == "dashboard")
    {
    }
    else if(subContent == "subContent")
    {
    }
}

//#region SEARCH DATAS
function contentNameGetContentsSuccess(result){
    TDE.contentNameKendoGridContents.populate(result.datas);
}
//#endregion SEARCH DATAS

//#region ADD DATA
function contentNameAddContentPrepare(){
    TDE.contentNameKendoWindowAddContent.center().open();
}
function contentNameAddContentSuccess(result){
    TDE.contentNameKendoWindowAddContent.close();
    contentNameGetContents();
}
//#endregion ADD DATA

//#region EDIT DATA
    function contentNameGetContentPrepare(Id){
        TDE.contentNameGetContentId.value(Id);
        contentNameGetContent();
    }
    function contentNameGetContentSuccess(result){
        let Content = result.data;
        TDE.contentEditContentId.value(Content.Id);

        TDE.contentKendoWindowEditConten.center().open();
    }
    function contentNameEditContentSuccess(result){
        TDE.contentNameKendoWindowEditContent.close();
        contentNameGetContents();
    }
//#endregion EDIT DATA

//#region DELETE DATAS
function contentNameSetDeleteContentPrepare(contentId){
    TDE.contentNameSetDeleteContentId.value(contentId);
    contentNameSetDeleteContent();
}
function contentNameSetDeleteOpnameSuccess(result){
    contentNameGetContents();
}
//#endregion DELETE DATAS

//#region RELEASE DATAS
function contentNameSetReleaseContentPrepare(contentId){
    TDE.contentNameSetReleaseContentId.value(contentId);
    contentNameSetReleaseContent();
}
function contentNameSetReleaseOpnameSuccess(result){
    contentNameGetContents();
}
//#endregion RELEASE DATAS

//#region UNRELEASE DATAS
function contentNameSetUnReleaseContentPrepare(contentId){
    TDE.contentNameSetUnReleaseContentId.value(contentId);
    contentNameSetUnReleaseContent();
}
function contentNameSetUnReleaseOpnameSuccess(result){
    contentNameGetContents();
}
//#endregion UNRELEASE DATAS

//#region COMPLETE DATAS
function contentNameSetCompleteContentPrepare(contentId){
    TDE.contentNameSetCompleteContentId.value(contentId);
    contentNameSetCompleteContent();
}
function contentNameSetCompleteOpnameSuccess(result){
    contentNameGetContents();
}
//#endregion COMPLETE DATAS

//#region CANCEL DATAS
function contentNameSetCancelContentPrepare(contentId){
    TDE.contentNameSetCancelContentId.value(contentId);
    contentNameSetCancelContent();
}
function contentNameSetCancelOpnameSuccess(result){
    contentNameGetContents();
}
//#endregion CANCEL DATAS
