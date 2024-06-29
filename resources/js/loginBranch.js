const linkAjax = "/"+COMMON_AJAX+"login/";

$(document).ready(function(){
    //alert("JS LOADED");
});
function loginBranchLoginBranchIdChange(e){
    if(TDE.loginBranchLoginBranchId.select() != -1){
        loginBranchLogin();
    }
}
function loginBranchLoginSuccess(result){
    location.reload();
}
function loginBranchLogoutSuccess(result){
    location.reload();
}
