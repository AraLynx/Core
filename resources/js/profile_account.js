function accountGetUserSuccess(result){
    $("#accountEditUserUsername").val(result.data.UserName);
    $("#accountEditUserEmailAddress").val(result.data.EmailAddress);
}
function accountEditAvatarSuccess(result){
    TDE.commonModal.Display({title:"SUCCESS", "body":"Your avatar successfuly updated"});
    profileGetData();
}
function accountEditUserSuccess(result){
    TDE.commonModal.Display({title:"SUCCESS", "body":"Your profile successfuly updated"});
    profileGetData();
}
function accountKendoWindowEditPasswordOpen(){
    TDE.accountKendoWindowEditPassword.center().open();
    TDE.accountFormEditPassword.trigger('reset');
}
function accountKendoWindowEditPasswordClose(){
    TDE.accountKendoWindowEditPassword.close();
}
function accountEditPasswordSuccess(result){
    TDE.accountKendoWindowEditPassword.close();
}

function accountEditSettingNotificationSoundChange(e){
    console.log('change');
    accountEditSettingTestSound();
}
function accountEditSettingTestSound(){
    if(TDE.accountEditSettingNotificationSound.select() != -1){
        let audioFile = TDE.accountEditSettingNotificationSound.value();
        //let audioObj = new Audio("/"+COMMON_AUDIO+"notifications/"+audioFile);
        //audioObj.play();
        document.getElementById("audio_"+audioFile).play();
    }
}
function accountEditSettingTestVibrate(){
    if(TDE.accountEditSettingNotificationVibrate.select() != -1){
        let vibrate = TDE.accountEditSettingNotificationVibrate.value();
        if('vibrate' in navigator){
            navigator.vibrate(vibrate);
        }
    }
}
function accountEditSettingSuccess(result){
    if(!result.data.IsError){
        TDE.accountKendoWindowEditSetting.close();
        /*
        TDE.commonModal.Display({
            body: "Settings saved, reloading the page..."
        });
        location.reload();
        */
        defaultGetUserSettings();
    }
}
