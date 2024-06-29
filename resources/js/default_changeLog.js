
let defaultNewsNotif_ChangeLogId = 0;
//let defaultNewsNotif_isMouseOver = false;


$(document).ready(function(){
    //let newsNotif_textIndent = "";
    $("#footer_news_notif").mouseover(function () {
        //newsNotif_textIndent = $("#footer_news_notif").css("text-indent");
        //$("#footer_news_notif").marquee({pause:true});
        //$("#footer_news_notif").css("text-indent", newsNotif_textIndent);
    });
    $("#footer_news_notif").mouseout(function () {
        //$("#footer_news_notif").marquee({pause:false});
    });
});

function defaultNewsNotif(params){
    let count = -1;
    let pxIncrement = 0.5;
    let speed = 10;
    let leftToRight = false;
    let start = true;
    let backgroundClass = "bg-warning";
    let content = params.content;

    if('count' in params)count = params.count;
    if('pxIncrement' in params)pxIncrement = params.pxIncrement;
    if('speed' in params)speed = params.speed;
    if('leftToRight' in params)leftToRight = params.leftToRight;
    if('start' in params)start = params.start;
    if('backgroundClass' in params)backgroundClass = params.backgroundClass;

    if(start){
        $("#footer_news").removeAttr("class");
        $("#footer_news").addClass("opacity-100");
        $("#footer_news").addClass(backgroundClass);

        $("#footer_news_notif").marquee({
            count:count,
            pxIncrement:pxIncrement,
            speed:speed,
            leftToRight:leftToRight,
            start:start,
            backgroundClass:backgroundClass,
            content:content
        });
    }
    else{
        $("#footer_news").removeAttr("class");
        $("#footer_news").addClass("opacity-0");
        $("#footer_news_notif").marquee({start:start});
    }
}

function defaultChangeLogGetChangeLogPrepare(ChangeLogId){
    TDE.defaultChangeLogGetChangeLogId.value(ChangeLogId);
    defaultChangeLogGetChangeLog();
}
function defaultChangeLogGetChangeLogSuccess(result){
    let element = "";

    let AppUpdate = result.data;
    let Contents = result.datas;

    let element_header = "";
    element_header += "<h5>"
        element_header +="<span class='cursor-pointer text-decoration-underline' onClick='defaultChangeLogGetChangeLogsPrepare(0,0);'><i class='fa-solid fa-book'></i> Change Log</span>";
        element_header += " <i class='fa-solid fa-angles-right'></i>";
        element_header += " <span class='cursor-pointer text-decoration-underline' onClick='defaultChangeLogGetChangeLogsPrepare("+AppUpdate.ModuleId+",0);'><i class='fa-solid fa-book'></i> "+AppUpdate.ModuleName+"</span>";
        element_header += " <i class='fa-solid fa-angles-right'></i>";
        element_header += " <span class='cursor-pointer text-decoration-underline' onClick='defaultChangeLogGetChangeLogsPrepare("+AppUpdate.ModuleId+","+AppUpdate.PageId+");'><i class='fa-solid fa-book'></i> "+AppUpdate.PageName+"</span>";
    element_header += "</h5>";
    element_header += "<hr/>";

    element_header += "<div class='d-flex justify-content-between'>";
        element_header += "<p class='fw-bold align-self-center'>Change Log<br/>#"+AppUpdate.NumberText+"</p>";
        element_header += "<h6 class=' text-center align-self-center'>"+AppUpdate.Summary+"</h6>";
        element_header += "<p class='fw-bold text-end align-self-center'>Date<br/>"+AppUpdate.Date+"</p>";
    element_header += "</div>";
    element_header += "<hr/>";
    element = element_header;

    let element_content = "";
    for(let Content of Contents){
        if(element_content != "")element_content += "<br/><br/>";
        element_content += "<h5 class=''>"+Content.Title.replace(/\\/g, '')+"</h5>";
        element_content += "<br/>"+Content.Content.replace(/\\/g, '');
    }
    element += element_content;

    element = element_header + element_content;
    TDE.defaultKendoWindowChangeLog.body(element);
}
function defaultChangeLogGetChangeLogsFromSidebarSuccess(result){
    let ModuleId = result.datas.ModuleId;
    let PageId = result.datas.PageId;
    defaultChangeLogGetChangeLogsPrepare(ModuleId,PageId);
}
function defaultChangeLogGetChangeLogsPrepare(ModuleId, PageId){
    TDE.defaultChangeLogGetChangeLogsModuleId.value(ModuleId);
    TDE.defaultChangeLogGetChangeLogsPageId.value(PageId);
    defaultChangeLogGetChangeLogs();
}
function defaultChangeLogGetChangeLogsSuccess(result){
    TDE.sidebar.hide();

    let ChangeLogs = result.datas.changeLogs;
    let Header = result.datas.header;

    let element = "";

    let header = "";
    header += "<h5>"
        header +="<span class='cursor-pointer text-decoration-underline' onClick='defaultChangeLogGetChangeLogsPrepare(0,0);'><i class='fa-solid fa-book'></i> Change Log</span>";
        if(Header.module.Id && ChangeLogs.length){
            header += " <i class='fa-solid fa-angles-right'></i>";
            header += " <span class='cursor-pointer text-decoration-underline' onClick='defaultChangeLogGetChangeLogsPrepare("+Header.module.Id+",0);'><i class='fa-solid fa-book'></i> "+ChangeLogs[0].ModuleName+"</span>";
        }
        if(Header.page.Id && ChangeLogs.length){
            header += " <i class='fa-solid fa-angles-right'></i>";
            header += " <span class='cursor-pointer text-decoration-underline' onClick='defaultChangeLogGetChangeLogsPrepare("+Header.module.Id+","+Header.page.Id+");'><i class='fa-solid fa-book'></i> "+ChangeLogs[0].PageName+"</span>";
        }
    header += "</h5>";
    header += "<hr/>";

    let content = "";
    for(ChangeLog of ChangeLogs)
    {
        let Id = ChangeLog.Id;
        let ModuleId = ChangeLog.ModuleId;
        let ModuleName = ChangeLog.ModuleName;
        let ModuleRoute = ChangeLog.ModuleRoute;
        let PageId = ChangeLog.PageId;
        let PageName = ChangeLog.PageName;
        let PageRoute = ChangeLog.PageRoute;
        let NumberText = ChangeLog.NumberText;
        let Summary = ChangeLog.Summary;
        let Date = ChangeLog.Date;
        let IsRead = ChangeLog.IsRead;

        content += "<div>";
            content += "<h5>"+Date+"</h5>";
            content += "<div class=''>";
                if(!IsRead)content += "<span class='align-top badge rounded-pill bg-danger'>NEW!</span>";
                content += " <a class='cursor-pointer' title='read article' onClick='defaultChangeLogGetChangeLogPrepare(" + Id + ")'><span class='h5'>Change log #"+NumberText+"</span></a>";
            content += "</div>";
            content += "<div class=''>";
                if(!Header.module.Id){
                    content += "<span class='cursor-pointer text-decoration-underline' onClick='defaultChangeLogGetChangeLogsPrepare("+ModuleId+",0);'><i class='fa-solid fa-book'></i> "+ModuleName+"</span> ";
                    content += "<i class='fa-solid fa-angles-right'></i> ";
                }
                if(!Header.page.Id){
                    content += "<span class='cursor-pointer text-decoration-underline' onClick='defaultChangeLogGetChangeLogsPrepare("+ModuleId+","+PageId+");'><i class='fa-solid fa-book'></i> "+PageName+"</span> ";
                    content += "<i class='fa-solid fa-angles-right'></i> ";
                }
                content += "[<a href='/"+ROOT+ModuleRoute+"/"+PageRoute+"'>Go to this page</a>]";
            content += "</div>";
            /*
            content += "<p>";
                content +="<span class='cursor-pointer text-decoration-underline' onClick='defaultChangeLogGetChangeLogsPrepare(0,0);'><i class='fa-solid fa-book'></i> Change Log</span>";
                content += " <i class='fa-solid fa-angles-right'></i>";
                content += " <span class='cursor-pointer text-decoration-underline' onClick='defaultChangeLogGetChangeLogsPrepare("+ModuleId+",0);'><i class='fa-solid fa-book'></i> "+ModuleName+"</span>";
                content += " <i class='fa-solid fa-angles-right'></i>";
                content += " <span class='cursor-pointer text-decoration-underline' onClick='defaultChangeLogGetChangeLogsPrepare("+ModuleId+","+PageId+");'><i class='fa-solid fa-book'></i> "+PageName+"</span>";
            content += "</p>";
            */
            content += "<div>";
                content += "<span class='h6'>"+Summary+"</span>";
                content += " [<a class='cursor-pointer' title='read article' onClick='defaultChangeLogGetChangeLogPrepare(" + Id + ")'>Baca artikel selengkapnya</a>]"
            content += "</div>";
        content += "</div>";

        if(content != "") content += "<br/><hr/><br/>";
    }
    if(content == "") content = "Belum ada update informasi untuk halaman ini, silahkan coba <span class='cursor-pointer text-decoration-underline' onClick='defaultChangeLogGetChangeLogsPrepare(0,0);'>halaman lain</span>";


    element = header + content;
    TDE.defaultKendoWindowChangeLog.body(element);
}
