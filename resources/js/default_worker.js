let userIsInteract = false;

let defaultWorkerInProgress = false;
let defaultWorkerInterval;

$(document).ready(function(){
    $(window).bind("scroll click", userSetInteract);
});
function userSetInteract(){
    if(!userIsInteract){
        userIsInteract = true;
        defaultWorkerRun();
        defaultWorkerInterval = setInterval(defaultWorkerRun, 30 * 1000);
    }
}

//#region worker
    function defaultWorkerRun(){
        //console.log("Try default worker...");
        if(!defaultWorkerInProgress){
            defaultWorkerInProgress = true;
            defaultWorker();
        }
    }
    function defaultWorkerSuccess(result){
        if(userIsInteract){
            defaultWorkerSuccess_notif(result.datas);
            if(result.datas.changeLog.length)defaultWorkerSuccess_changeLog(result.datas.changeLog[0]);
            else {
                defaultNewsNotif_ChangeLogId = 0;
                defaultNewsNotif({start:false});
            }
        }
    }
    function defaultWorkerFail(result){
        //console.log("Default worker failed...");
    }
    function defaultWorkerAlways(result){
        //console.log("Default worker reset...");
        defaultWorkerInProgress = false;
    }

        function defaultWorkerSuccess_notif(datas){
            //#region email counter
            let unreadEmailCounter = datas.unreadEmailCounter;
                if($("#unreadEmailCounter").length)
                {
                    $("#unreadEmailCounter").addClass("d-none");
                    if(unreadEmailCounter){
                        $("#unreadEmailCounter").removeClass("d-none");
                    }
                }
                $(".unreadEmailCounter").addClass("d-none");
                if(unreadEmailCounter){
                    $(".unreadEmailCounter").removeClass("d-none");
                    $(".unreadEmailCounter").html(unreadEmailCounter);
                }
            //#endregion email counter

            //#region waiting my approval
                let approvalWMAPCounter = datas.approvalWMAPCounter;
                if($("#approvalWMAPCounter").length)
                {
                    $("#approvalWMAPCounter").addClass("d-none");
                    if(approvalWMAPCounter){
                        $("#approvalWMAPCounter").removeClass("d-none");
                    }
                }
                $(".approvalWMAPCounter").addClass("d-none");
                if(approvalWMAPCounter){
                    $(".approvalWMAPCounter").removeClass("d-none");
                    $(".approvalWMAPCounter").html(approvalWMAPCounter);
                }
            //#endregion waiting my approval

            let beforeNotifCounter = $("#navbarWorkerNotification").html() * 1
            ;
            $(".workerNotification").html("");
            $(".workerNotification").addClass("d-none");
            let notificationCounter = unreadEmailCounter + approvalWMAPCounter;
            if(notificationCounter){
                $(".workerNotification").removeClass("d-none");
                $(".workerNotification").html(notificationCounter);

                if(beforeNotifCounter < notificationCounter){
                    document.getElementById("audio_"+notifSound).play();
                    if('vibrate' in navigator){
                        navigator.vibrate(notifVibrate);
                    }
                }
            }
        }
        function defaultWorkerSuccess_changeLog(changeLog){
            if(defaultNewsNotif_ChangeLogId != changeLog.Id){
                defaultNewsNotif_ChangeLogId = changeLog.Id;

                let BackgroundClass = "bg-warning";
                let NewsColor = "#dc3545";
                let NewsText = "* News update *";

                if(changeLog.IsPersist){
                    BackgroundClass = "bg-danger";
                    NewsColor = "#ffffff";
                    NewsText = "! Important news !";
                }

                let Content = "";
                Content += "<strong>";
                    Content += "<span style='color:" + NewsColor + "'>" + NewsText + "</span>";
                    Content += " Click <a class='cursor-pointer' title='read article' onClick='defaultChangeLogGetChangeLogPrepare(" + changeLog.Id + ");'>here</a> to read article.";
                Content += "</strong>";
                Content += " <em>" + changeLog.Date + " / Update <a class='cursor-pointer' title='read article' onClick='defaultChangeLogGetChangeLogPrepare(" + changeLog.Id + ")'>#" + changeLog.ShortNumberText + "</a></em>";
                Content += " " + changeLog.Summary;

                defaultNewsNotif({content:Content, backgroundClass:BackgroundClass});
            }
        }
//#endregion worker
