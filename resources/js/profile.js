const linkAjax = "/"+COMMON_AJAX+"profile/";
//alert("JS LOADED");
let isAttendanceData = false;
let isTeamAttendanceData = false;
function profileShowSubContent(subContent){
    $(".profile_content").addClass("d-none");
    $("#profile_"+subContent).removeClass("d-none");
    if(subContent == "account")
    {
        accountGetUser();
    }
    else if(subContent == "chat")
    {

    }
    else if(subContent == "message")
    {

    }
    else if(subContent == "approval")
    {
        approvalGetApprovals();
    }
    else if(subContent == "attendance")
    {
        if(!isAttendanceData)attendanceGetData();
    }
    else if(subContent == "teamAttendance")
    {
        if(!isTeamAttendanceData)teamAttendanceGetData();
    }
    else if(subContent == "employee")
    {

    }
    else if(subContent == "news")
    {

    }
}

function profileGetDataSuccess(result){
    $("#profile_menu_user_avatar").html(result.data.avatarHtml);
    $("#profile_menu_user_employeeName").html(result.data.Name);
    $("#profile_menu_user_employeeId").html(result.data.EmployeeId);
    $("#profile_menu_user_username").html(result.data.Username);
    $("#profile_menu_user_employee_position").html(result.data.PositionName);
}
