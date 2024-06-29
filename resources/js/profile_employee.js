
function employeeGetEmployeesSuccess(result){
    //console.log(result.datas);
    TDE.employeeKendoGridEmployees.populate(result.datas);
}
