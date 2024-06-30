const linkAjax = "/"+CORE_AJAX+"login/";

//alert("JS LOADED");
$(document).ready(function(){

});
function loginLoginSuccess(result){
    if(result["datas"]["PasswordIsDefault"]){
        $("#loginNewPasswordUserId").val(result["datas"]["UserId"]);
        TDE.loginKendoWindowNewPassword.center().open();
    }
    else{
        location.reload();
    }
}
function loginNewPasswordSuccess(result){
    TDE.loginKendoWindowNewPassword.close();
    TDE.ajaxModal.Reset();
    TDE.ajaxModal.Body.html("Password updated, please try to log in with your new password");
    TDE.ajaxModal.Body.addClass("text-primary");
    TDE.ajaxModal.show();
}

function loginForgotPasswordSuccess(result){
    TDE.loginKendoWindowForgotPassword.close();

    TDE.ajaxModal.Reset();
    TDE.ajaxModal.Body.html("We've send you a link to reset your password to your email. Please follow the instruction in the email.");
    TDE.ajaxModal.Body.addClass("text-primary");
    TDE.ajaxModal.show();
}
