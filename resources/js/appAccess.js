/*FIND + REPLACE page -> actual_appAccess*/
//alert("JS LOADED");
const linkAjax = "/"+COMMON_AJAX+"appAccess/";

$(document).ready(function(){
});

function appAccessShowSubContent(subContent){
    $(".page_content").addClass("d-none");
    $("#appAccess_"+subContent).removeClass("d-none");
    if(subContent == "access")
    {
    }
    else if(subContent == "superUser")
    {
    }
}

//#region access
function accessGetUsersSuccess(result){
    TDE.accessKendoGridUsers.populate(result.datas);
}
//#region ADD NEW USER
    function accessAddUserSetUserId(UserId){
        $("#accessCreateUserGetUserId").val(UserId);
        accessCreateUserGetUser();
    }
    function accessCreateUserGetUserSuccess(result){
        let User = result.data;
        TDE.accessCreateUserId.value(User.Id);
        TDE.accessCreateUserName.value(User.Name);
        TDE.accessCreateUserUsername.value(User.Username);
        TDE.accessKendoWindowCreateUser.center().open();
    }
    function accessCreateUserSuccess(result){
        let output = result.data.Output;
        if(output == "OK"){
            TDE.accessKendoWindowCreateUser.close();
            accessGetUsers();
        }
        else{
            TDE.commonModal.Display({"body":output, "title":"CREATE NEW USER FAILED"});
        }
    }
//#endregion ADD NEW USER
//#region EDIT ACCESS
    //#region ACTIVATE USER
        function accessEnableUserSetUserId(UserId){
            $("#accessEnableUserId").val(UserId);
            accessEnableUserConfirmationMessage();
        }
        function accessEnableUserSuccess(result){
            accessGetUsers();
        }
    //#endregion

    //#region DISABLE USER
        function accessDisableUserSetUserId(UserId){
            $("#accessDisableUserId").val(UserId);
            accessDisableUserConfirmationMessage();
        }
        function accessDisableUserSuccess(result){
            accessGetUsers();
        }
    //#endregion

    //#region EDIT APPLICATION ACCESS
        function accessEditAccessSetData(UserId){
            $("#accessEditAccessGetAccessesUserId").val(UserId);
            $("#accessEditAccessUserId").val(UserId);
            accessEditAccessGetAccesses();
        }
        function accessEditAccessGetAccessesSuccess(result){
            let Auths = result.datas;
            for(let Auth of Auths)
            {
                let PageId = Auth.PageId;

                let PageC = Auth.PageC;
                let PageR = Auth.PageR;
                let PageU = Auth.PageU;
                let PageD = Auth.PageD;

                let AuthC = Auth.AuthC;
                let AuthR = Auth.AuthR;
                let AuthU = Auth.AuthU;
                let AuthD = Auth.AuthD;

                let checkBoxCId = "accessEditAccessAuth_C_"+PageId;
                let checkBoxRId = "accessEditAccessAuth_R_"+PageId;
                let checkBoxUId = "accessEditAccessAuth_U_"+PageId;
                let checkBoxDId = "accessEditAccessAuth_D_"+PageId;

                //CREATE
                TDE[checkBoxCId].enable(false);
                TDE[checkBoxCId].check(false);
                if(PageC){
                    TDE[checkBoxCId].enable(true);
                    if(AuthC)
                        TDE[checkBoxCId].check(true);
                }

                //READ
                TDE[checkBoxRId].enable(false);
                TDE[checkBoxRId].check(false);
                if(PageR){
                    TDE[checkBoxRId].enable(true);
                    if(AuthR)
                        TDE[checkBoxRId].check(true);
                }

                //UPDATE
                TDE[checkBoxUId].enable(false);
                TDE[checkBoxUId].check(false);
                if(PageU){
                    TDE[checkBoxUId].enable(true);
                    if(AuthU)
                        TDE[checkBoxUId].check(true);
                }

                //DELETE
                TDE[checkBoxDId].enable(false);
                TDE[checkBoxDId].check(false);
                if(PageD){
                    TDE[checkBoxDId].enable(true);
                    if(AuthD)
                        TDE[checkBoxDId].check(true);
                }
            }
            TDE.accessKendoWindowEditAccess.center().open();
        }
        function accessEditAccessSuccess(result){
            TDE.accessKendoWindowEditAccess.close();
            //accessGetUsers();
        }
    //#endregion
//#endregion EDIT ACCESS

//#region superUser
function superUserGetUsersSuccess(result){
    TDE.superUserKendoGridUsers.populate(result.datas);
}

function superUserManageSuperUserSetUserId(app, userId)
{
    if(app == "gaia")
    {
        $("#superUserManageGaiaSuperUserPrepareId").val(userId);
        superUserManageGaiaSuperUserPrepare();
    }
    if(app == "selene")
    {

    }
    if(app == "plutus")
    {

    }
}

function superUserManageGaiaSuperUserPrepareSuccess(result)
{
    $("#superUserManageGaiaSuperUserId").val(result.data.Id);
    TDE.superUserManageGaiaSuperUserUserId.value(result.data.UserId);
    TDE.superUserManageGaiaSuperUserName.value(result.data.Name);

    for(let moduleId in result.datas.access)
    {
        let check = false;
        if(result.datas.access[moduleId])check = true;
        TDE["superUserManageGaiaSuperUserModuleIds_"+moduleId].check(check);
    }
    TDE.superUserKendoWindowManageGaiaSuperUser.center().open();
}
function superUserManageGaiaSuperUserSuccess(result){
    if(!result.data.IsError){
        TDE.superUserKendoWindowManageGaiaSuperUser.close();
    }
}
//#endregion superUser

