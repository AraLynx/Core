function attendanceGetDataSuccess(result){
    isAttendanceData = true;
    if(result.datas.isParent)$("#profile_teamsAttendance_btn").removeClass("d-none");
}
function attendanceGetAttendancesSuccess(result){
    TDE.attendanceKendoGridAttendances.populate(result.datas.atts);
}
