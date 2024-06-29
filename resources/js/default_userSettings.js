let notifSound = "software interface start.wav";
let notifVibrate = 500;

$(document).ready(function(){
    defaultGetUserSettings();
});

function defaultGetUserSettingsSuccess(result){
    notifSound = result.datas.NotificationSound;
    notifVibrate = result.datas.NotificationVibrate;
}
