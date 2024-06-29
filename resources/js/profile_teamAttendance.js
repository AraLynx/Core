
let teamAttendancePositionList = [];
let teamAttendanceEmployeeList = [];
let teamAttendancePositionIds = [];
function teamAttendanceGetDataSuccess(result){
    isTeamAttendanceData = true;

    teamAttendancePositionList = result.datas.positions;
    TDE.teamAttendanceGetAttendancesPositionIds.populate(teamAttendancePositionList);

    teamAttendanceEmployeeList = result.datas.children;
    teamAttendanceGetAttendancesPopulateEmployees();

    let element = "";
    let inputClass = "dynamicEmployeeIdInputClass";
    $("."+inputClass).remove();
    for(Employee of teamAttendanceEmployeeList)
    {
        element = "<input type='hidden' class='"+inputClass+"' name='OriginalEmployeeIds["+Employee.Id+"]' value='"+Employee.PositionId+"'/>";
        TDE.teamAttendanceFormGetAttendances.append(element);
    }
}
function teamAttendanceGetAttendancesPositionIdsChange(e){
    teamAttendancePositionIds = TDE.teamAttendanceGetAttendancesPositionIds.value();
    teamAttendanceGetAttendancesPopulateEmployees();
}
function teamAttendanceGetAttendancesPopulateEmployees(){
    let Employees = [];
    if(!teamAttendancePositionIds.length)
        Employees = teamAttendanceEmployeeList;
    else{
        for(let Employee of teamAttendanceEmployeeList){
            for(let PositionId of teamAttendancePositionIds){
                if(Employee.PositionId == PositionId)
                    Employees.push(Employee);
            }
        }
    }
    TDE.teamAttendanceGetAttendancesEmployeeIds.populate(Employees);
}
function teamAttendanceGetAttendancesSuccess(result){
    TDE.teamAttendanceKendoGridAttendances.populate(result.datas);
}

//FORM ADD REQUEST TEAM ATTENDANCE
function teamAttendanceAddRequestPrepare(){
    teamAttendanceAddRequestGetData();
}
function teamAttendanceAddRequestGetDataSuccess(result){
    TDE.teamAttendanceAddRequestAttendanceRequestTypeId.populate(result.datas.AttendanceRequestTypes);
    TDE.teamAttendanceAddRequestEmployeeId.populate(teamAttendanceEmployeeList);
    TDE.teamAttendanceKendoWindowAddRequest.center().open();
}
function teamAttendanceAddRequestAttendanceRequestTypeIdChange(e){
    if(TDE.teamAttendanceAddRequestAttendanceRequestTypeId.select() != -1){
        let AttendaceRequestTypeId = TDE.teamAttendanceAddRequestAttendanceRequestTypeId.value();
        $("#teamAttendanceAddRequestGetAttendanceRequestTypeId").val(AttendaceRequestTypeId);
        teamAttendanceAddRequestGetAttendanceRequestType();
    }
}
function teamAttendanceAddRequestGetAttendanceRequestTypeSuccess(result){
    let DateTypeId = result.data;
    $("#teamAttendanceAddRequestDateTypeId").val(DateTypeId);
    TDE.teamAttendanceFormAddRequest.DynamicForm["DateTypeId"+DateTypeId].show();
    TDE.teamAttendanceKendoWindowAddRequest.center();
}
function teamAttendanceAddRequestSuccess(result){
    TDE.commonModal.Display({title:"UNDER DEVELOPMENT", body:"Sorry for the inconvenient.<br/>This action is not ready and still under development."});
}
