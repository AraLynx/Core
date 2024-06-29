const linkAjax = "/"+COMMON_AJAX+"report/";

const reportIdHasVehicleGroups = [10,24,25,26,27,28,29,31];
const reportIdHasVehicleTypes = [10,24,25,26,27,28,29,31];

$(document).ready(function(){
    //console.log(selectOptions);
    setTimeout(function() {
        reportGetReportGenerateDepartments();
    }, 100);

});

function reportGetReportGenerateDepartments(){
    TDE.reportGetReportDepartmentId.reset();
    TDE.reportGetReportReportGroup.reset();
    TDE.reportGetReportReportId.reset();
    TDE.reportGetReportCompanyId.reset();
    TDE.reportGetReportBranchId.reset();
    TDE.reportGetReportPOSId.reset();
    let reportId = TDE.reportGetReportReportId.value() * 1;
    if(reportId){
        /*Reset Vehicle Group*/if(reportIdHasVehicleGroups.includes(reportId)){TDE["reportGetReport_"+reportId+"_VehicleGroupId"].reset();}
        /*Reset Vehicle Type*/if(reportIdHasVehicleTypes.includes(reportId)){TDE["reportGetReport_"+reportId+"_VehicleTypeId"].reset();}
    }

    let nextLists = selectOptions["Departments"];
    //console.log(nextLists);
    TDE.reportGetReportDepartmentId.populate(nextLists);
    if(nextLists.length == 1){
        TDE.reportGetReportDepartmentId.select(0);
        reportGetReportDepartmentIdChange();
    }
}
function reportGetReportDepartmentIdChange(e){
    TDE.reportGetReportReportGroup.reset();
    TDE.reportGetReportReportId.reset();
    TDE.reportGetReportCompanyId.reset();
    TDE.reportGetReportBranchId.reset();
    TDE.reportGetReportPOSId.reset();
    let reportId = TDE.reportGetReportReportId.value() * 1;
    if(reportId){
        /*Reset Vehicle Group*/if(reportIdHasVehicleGroups.includes(reportId)){TDE["reportGetReport_"+reportId+"_VehicleGroupId"].reset();}
        /*Reset Vehicle Type*/if(reportIdHasVehicleTypes.includes(reportId)){TDE["reportGetReport_"+reportId+"_VehicleTypeId"].reset();}
    }

    if(TDE.reportGetReportDepartmentId.select() != -1){
        let value = TDE.reportGetReportDepartmentId.value();
        let text = TDE.reportGetReportDepartmentId.text();
        let nextLists = selectOptions["ReportGroups"][value];
        //console.log(nextLists);
        TDE.reportGetReportReportGroup.populate(nextLists);
        if(nextLists.length == 1){
            TDE.reportGetReportReportGroup.select(0);
            reportGetReportReportGroupChange();
        }
        else
            TDE.reportGetReportReportGroup.open();
    }
}
function reportGetReportReportGroupChange(e){
    TDE.reportGetReportReportId.reset();
    TDE.reportGetReportCompanyId.reset();
    TDE.reportGetReportBranchId.reset();
    TDE.reportGetReportPOSId.reset();
    let reportId = TDE.reportGetReportReportId.value() * 1;
    if(reportId){
        /*Reset Vehicle Group*/if(reportIdHasVehicleGroups.includes(reportId)){TDE["reportGetReport_"+reportId+"_VehicleGroupId"].reset();}
        /*Reset Vehicle Type*/if(reportIdHasVehicleTypes.includes(reportId)){TDE["reportGetReport_"+reportId+"_VehicleTypeId"].reset();}
    }

    if(TDE.reportGetReportReportGroup.select() != -1){
        let value = TDE.reportGetReportDepartmentId.value()+'_'+TDE.reportGetReportReportGroup.value();
        let text = TDE.reportGetReportReportGroup.text();
        let nextLists = selectOptions["Reports"][value];
        //console.log(nextLists);
        TDE.reportGetReportReportId.populate(nextLists);
        if(nextLists.length == 1){
            TDE.reportGetReportReportId.select(0);
            reportGetReportReportIdChange();
        }
        else
            TDE.reportGetReportReportId.open();
    }
}
function reportGetReportReportIdChange(e){
    TDE.reportGetReportCompanyId.reset();
    TDE.reportGetReportBranchId.reset();
    TDE.reportGetReportPOSId.reset();
    let reportId = TDE.reportGetReportReportId.value() * 1;
    if(reportId){
        /*Reset Vehicle Group*/if(reportIdHasVehicleGroups.includes(reportId)){TDE["reportGetReport_"+reportId+"_VehicleGroupId"].reset();}
        /*Reset Vehicle Type*/if(reportIdHasVehicleTypes.includes(reportId)){TDE["reportGetReport_"+reportId+"_VehicleTypeId"].reset();}
    }

    if(TDE.reportGetReportReportId.select() != -1){
        let value = TDE.reportGetReportReportId.value();
        let text = TDE.reportGetReportReportId.text();
        let nextLists = selectOptions["Companies"][value];
        //console.log(nextLists);
        TDE.reportGetReportCompanyId.populate(nextLists);
        if(nextLists.length == 1){
            TDE.reportGetReportCompanyId.select(0);
            reportGetReportCompanyIdChange();
        }
        else
            TDE.reportGetReportCompanyId.open();

        //load div report
        $(".reportDiv").addClass("d-none");
        if ($("#reportDiv_"+value).length){
            TDE.reportFormGetReport.DynamicForm["_"+value+"_"].show();
            $("#reportDiv_"+value).removeClass("d-none");
        }
        else {
            $("#reportUnderDevelopmentTitle").html(text);
            $("#reportDivUnderDevelopment").removeClass("d-none");
        }
    }
}
function reportGetReportCompanyIdChange(e){
    TDE.reportGetReportBranchId.reset();
    TDE.reportGetReportPOSId.reset();
    let reportId = TDE.reportGetReportReportId.value() * 1;
    if(reportId){
        /*Reset Vehicle Group*/if(reportIdHasVehicleGroups.includes(reportId)){TDE["reportGetReport_"+reportId+"_VehicleGroupId"].reset();}
        /*Reset Vehicle Type*/if(reportIdHasVehicleTypes.includes(reportId)){TDE["reportGetReport_"+reportId+"_VehicleTypeId"].reset();}
    }

    if(TDE.reportGetReportCompanyId.select() != -1){
        let value = TDE.reportGetReportCompanyId.value();
        if(value != "*")value = TDE.reportGetReportReportId.value()+'_'+TDE.reportGetReportCompanyId.value();
        let text = TDE.reportGetReportCompanyId.text();
        let nextLists = selectOptions["Branches"][value];
        //console.log(nextLists);
        TDE.reportGetReportBranchId.populate(nextLists);
        if(nextLists.length == 1){
            TDE.reportGetReportBranchId.select(0);
            reportGetReportBranchIdChange();
        }
        else
            TDE.reportGetReportBranchId.open();
    }
}
function reportGetReportBranchIdChange(e){
    TDE.reportGetReportPOSId.reset();
    let reportId = TDE.reportGetReportReportId.value() * 1;
    if(reportId){
        /*Reset Vehicle Group*/if(reportIdHasVehicleGroups.includes(reportId)){TDE["reportGetReport_"+reportId+"_VehicleGroupId"].reset();}
        /*Reset Vehicle Type*/if(reportIdHasVehicleTypes.includes(reportId)){TDE["reportGetReport_"+reportId+"_VehicleTypeId"].reset();}
    }

    if(TDE.reportGetReportBranchId.select() != -1){
        let value = TDE.reportGetReportBranchId.value();
        if(value != "*")value = TDE.reportGetReportReportId.value()+'_'+TDE.reportGetReportCompanyId.value()+'_'+TDE.reportGetReportBranchId.value();
        let text = TDE.reportGetReportBranchId.text();
        let nextLists = selectOptions["POSes"][value];
        //console.log(nextLists);
        TDE.reportGetReportPOSId.populate(nextLists);
        if(nextLists.length == 1){
            TDE.reportGetReportPOSId.select(0);
        }
        else
            TDE.reportGetReportPOSId.open();

        let brandId = selectOptions.BranchBrandIds[TDE.reportGetReportBranchId.value()] * 1;
        if(reportIdHasVehicleGroups.includes(reportId)){
            if(TDE.reportGetReportBranchId.select() != -1 && TDE.reportGetReportBranchId.value() != '*'){
                TDE["reportGetReport_"+reportId+"_VehicleGroupId"].populate(selectOptions.VehicleGroups[brandId]);
            }
        }
    }
}
//#region VehicleGroupIdChange
    function reportGetReport_VehicleGroupIdChange(){
        let reportId = TDE.reportGetReportReportId.value() * 1;
        if(reportId){
            if(reportIdHasVehicleTypes.includes(reportId)){
                TDE["reportGetReport_"+reportId+"_VehicleTypeId"].reset();

                if(TDE["reportGetReport_"+reportId+"_VehicleGroupId"].select() != -1 && TDE["reportGetReport_"+reportId+"_VehicleGroupId"].value() != '*'){
                    let VehicleGroupId = TDE["reportGetReport_"+reportId+"_VehicleGroupId"].value();
                    //console.log(VehicleGroupId);
                    TDE["reportGetReport_"+reportId+"_VehicleTypeId"].populate(selectOptions.VehicleTypes[VehicleGroupId]);
                    TDE["reportGetReport_"+reportId+"_VehicleTypeId"].open();
                }
            }
        }
    }
//#endregion

//#region 20
function reportGetReport_20_DetailPrepareData(transactionCode, sparepartPOSId){
    $("#reportGetReport_20_DetailPeriodeStart").val(kendo.toString(TDE.reportGetReport_20_PeriodeStart.value(),"yyyy-MM-dd"));
    $("#reportGetReport_20_DetailPeriodeEnd").val(kendo.toString(TDE.reportGetReport_20_PeriodeEnd.value(),"yyyy-MM-dd"));
    $("#reportGetReport_20_DetailSparepartPOSId").val(sparepartPOSId);
    $("#reportGetReport_20_DetailTransactionCode").val(transactionCode);
    reportGetReport_20_Detail();
}
function reportGetReport_20_DetailSuccess(result){
    TDE.reportKendoGridGetReport_20_Detail.populate(result.datas);
    TDE.reportKendoWindowGetReport_20_Detail.center().open();
}
//#endregion

//#region 25
    function reportGetReport_25_LocationPartnerTypeIdChange(){
        if(TDE.reportGetReportBrandId.select() != -1)
        {
            if(TDE.reportGetReportCompanyId.select() != -1 && TDE.reportGetReportCompanyId.value() != '*')
            {
                if(TDE.reportGetReportBranchId.select() != -1 && TDE.reportGetReportBranchId.value() != '*')
                {
                    if(TDE.reportGetReportPosId.select() != -1 && TDE.reportGetReportPosId.value() != '*')
                    {
                        reportGetReportPOSIdOnChange();
                    }
                    else {
                        reportGetReportBranchIdOnChange();
                    }
                }
                else {
                    reportGetReportCompanyIdOnChange();
                }
            }
            else {
                reportGetReportBrandIdOnChange();
            }
        }
    }
//#endregion

function reportGetReportSuccess(result){
    let value = TDE.reportGetReportReportId.value();
    TDE["reportKendoGrid_"+value].populate(result["datas"]);
}

//#region GenerateExcel
function reportGenerateExcelPrepareData(ReportId){
    let formGroup = "report";
    let formId = "GenerateExcel";
    let formGroupId = formGroup+formId;

    let originGroup = "report";
    let originId = "GetReport";
    let originGroupId = originGroup+originId;

    $("#"+formGroupId+"ReportId").val(TDE[originGroupId+"ReportId"].value());
    $("#"+formGroupId+"CompanyId").val(TDE[originGroupId+"CompanyId"].value());
    $("#"+formGroupId+"CompanyName").val(TDE[originGroupId+"CompanyId"].text());
    $("#"+formGroupId+"BranchId").val(TDE[originGroupId+"BranchId"].value());
    $("#"+formGroupId+"BranchName").val(TDE[originGroupId+"BranchId"].text());
    $("#"+formGroupId+"POSId").val(TDE[originGroupId+"POSId"].value());
    $("#"+formGroupId+"POSName").val(TDE[originGroupId+"POSId"].text());

    let inputNameTexts = [];
    let inputNameDatePickers = [];
    let inputNameTimePickers = [];
    let inputNameDateTimePickers = [];
    let inputNameDatePickerRanges = [];
    let inputNameSelects = [];

    if(ReportId == 1){inputNameTexts = ["DateMonth", "DateYear"];}
    if(ReportId == 2){inputNameTexts = ["DateMonth", "DateYear"];}
    if(ReportId == 3){inputNameDatePickerRanges = ["InvoiceDate"];}
    if(ReportId == 4){inputNameDatePickerRanges = ["InvoiceDate"];}
    if(ReportId == 5) {
        inputNameDatePickerRanges = ["Date"];
        inputNameTexts = ["SPKNumber","DocumentNumber","ReferenceNumber"];
    }
    if(ReportId == 8){
        inputNameDatePickerRanges = ["DepositDate"];
        inputNameTexts = ["VINNumber","EngineNumber","SPKNumber","CustomerName","STNKName"];
    }
    if(ReportId == 9){inputNameDatePickerRanges = ["Periode"];}
    if(ReportId == 10){
        inputNameSelects = ["VehicleGroup","VehicleType","Status"];
        inputNameTexts = ["UnitColorDescription","UnitVIN","UnitEngineNumber","UnitYear","AgeMinimum"];
    }
    if(ReportId == 11){inputNameDatePickerRanges = ["PKBCompleteDate"];}
    if(ReportId == 12){inputNameDatePickerRanges = ["PKBCompleteDate"];}
    if(ReportId == 17){inputNameDatePickerRanges = ["Periode"];}
    if(ReportId == 20){
        inputNameDatePickerRanges = ["Periode"];
        inputNameTexts = ["SparepartCode","SparepartName"]
    }
    if(ReportId == 21){
        inputNameSelects = ["ReferenceType"];//Id TIDAK PERLU DITULIS
        inputNameDatePickerRanges = ["InvoiceDate"];
    }
    if(ReportId == 22){
        inputNameDatePickerRanges = ["Date"];
        inputNameSelects = ["Division","Status"];
    }
    if(ReportId == 23){inputNameTexts = ["Field","ReferenceNumber"]; inputNameDatePickerRanges = ["Value"]; inputNameSelects = ["ProgramType","Status"];}
    if(ReportId == 24){
        inputNameDatePickerRanges = ["Date"];
        inputNameTexts = ["PICSales","NumberValue","FromValue","DateType","NumberType","FromType"];
        inputNameSelects = ["ReferenceType","Method","VehicleGroup","VehicleType"];
    }
    if(ReportId == 25){inputNameSelects = ["LocationPartnerType","LocationPartner","Status","VehicleGroup","VehicleType"];}
    if(ReportId == 26){inputNameSelects = ["VehicleGroup","VehicleType","Status"];}
    if(ReportId == 27){
        inputNameTexts = ["UnitColor","UnitEngineNumber","UnitVIN","UnitYear","SalesMethod"];
        inputNameDatePickerRanges = ["CompleteDate"];
        inputNameSelects = ["VehicleGroup","VehicleType"];//Id TIDAK PERLU DITULIS
    }
    if(ReportId == 28){
        inputNameTexts = ["DateType","UnitColor","DocumentNumberType","EmployeeType","CustomerType","DocumentNumberValue","EmployeeValue","CustomerValue"];
        inputNameDatePickerRanges = ["DateValue"];
        inputNameSelects = ["VehicleGroup","VehicleType","Status"];
    }
    if(ReportId == 29){
        inputNameTexts = ["ColorDescription","EngineNumber","VIN","UnitYear"];
        inputNameSelects = ["VehicleGroup","VehicleType","Status"];
    }
    if(ReportId == 30){inputNameTexts = ["Field","Value"];}
    if(ReportId == 31){
        inputNameDatePickerRanges = ["InvoiceDate"];
        inputNameSelects = ["VehicleGroup","VehicleType"];
    }
    if(ReportId == 32){inputNameTexts = ["DateMonth", "DateYear"];}
    if(ReportId == 33){
        inputNameTexts = ["DateMonth", "DateYear"];
        inputNameSelects = ["StatusPDI"];
    }
    if(ReportId == 35){inputNameTexts = ["DateMonth", "DateYear"];}
    if(ReportId == 36){
        inputNameTexts = ["CaroserieNumber","PONumber","UnitIdentityType","UnitIdentityValue"];
        inputNameDatePickerRanges = ["GRDate"];
    }
    if(ReportId == 37){
        inputNameDatePickerRanges = ["GRDate"];
    }
    if(ReportId == 38){inputNameTexts = ["DateApplyYear", "DateApplyMonth", "StatusCode", "DocumentNumber"];}
    if(ReportId == 39){inputNameTexts = ["DateMonth", "DateYear"];}
    if(ReportId == 40){inputNameTexts = ["DateMonth", "DateYear"];}
    if(ReportId == 41){inputNameTexts = ["DateMonth", "DateYear"];}
    if(ReportId == 42){
        inputNameDatePickerRanges = ["Date"];
        inputNameTexts = ["DateType"];
    }
    if(ReportId == 44){
        inputNameDatePickerRanges = ["Date"];
    }

    let intputId = formGroupId+'_'+ReportId+'_';
    let originInputId = originGroupId+'_'+ReportId+'_';

    for(inputName of inputNameTexts){
        $("#"+intputId+inputName).val(TDE[originInputId+inputName].value());
    }
    for(inputName of inputNameDatePickers){
        $("#"+intputId+inputName).val(kendo.toString(TDE[originInputId+inputName].value(),"yyyy-MM-dd"));
    }
    for(inputName of inputNameTimePickers){
        $("#"+intputId+inputName).val(kendo.toString(TDE[originInputId+inputName].value(),"HH:mm:ss"));
    }
    for(inputName of inputNameDateTimePickers){
        $("#"+intputId+inputName).val(kendo.toString(TDE[originInputId+inputName].value(),"yyyy-MM-dd HH:mm:ss"));
    }
    for(inputName of inputNameDatePickerRanges){
        $("#"+intputId+inputName+"Start").val(kendo.toString(TDE[originInputId+inputName+"Start"].value(),"yyyy-MM-dd"));
        $("#"+intputId+inputName+"End").val(kendo.toString(TDE[originInputId+inputName+"End"].value(),"yyyy-MM-dd"));
    }
    for(inputName of inputNameSelects){
        $("#"+intputId+inputName+"Id").val(TDE[originInputId+inputName+"Id"].value());
        $("#"+intputId+inputName+"Name").val(TDE[originInputId+inputName+"Id"].text());
    }

    reportGenerateExcel();
}
function reportGenerateExcelRawPrepareData(ReportId){
    let formGroup = "report";
    let formId = "GenerateExcel";
    let formGroupId = formGroup+formId;

    let originGroup = "report";
    let originId = "GetReport";
    let originGroupId = originGroup+originId;

    $("#"+formGroupId+"ReportId").val(TDE[originGroupId+"ReportId"].value()+'Raw');
    $("#"+formGroupId+"CompanyId").val(TDE[originGroupId+"CompanyId"].value());
    $("#"+formGroupId+"CompanyName").val(TDE[originGroupId+"CompanyId"].text());
    $("#"+formGroupId+"BranchId").val(TDE[originGroupId+"BranchId"].value());
    $("#"+formGroupId+"BranchName").val(TDE[originGroupId+"BranchId"].text());
    $("#"+formGroupId+"POSId").val(TDE[originGroupId+"POSId"].value());
    $("#"+formGroupId+"POSName").val(TDE[originGroupId+"POSId"].text());

    let inputNameTexts = [];
    let inputNameDatePickers = [];
    let inputNameTimePickers = [];
    let inputNameDateTimePickers = [];
    let inputNameDatePickerRanges = [];
    let inputNameSelects = [];
    if(ReportId == 20){
        inputNameDatePickerRanges = ["Periode"];
        inputNameTexts = ["SparepartCode","SparepartName"];
    }
    let intputId = formGroupId+'_'+ReportId+'Raw_';
    let originInputId = originGroupId+'_'+ReportId+'_';

    for(inputName of inputNameTexts){
        $("#"+intputId+inputName).val(TDE[originInputId+inputName].value());
    }
    for(inputName of inputNameDatePickers){
        $("#"+intputId+inputName).val(kendo.toString(TDE[originInputId+inputName].value(),"yyyy-MM-dd"));
    }
    for(inputName of inputNameTimePickers){
        $("#"+intputId+inputName).val(kendo.toString(TDE[originInputId+inputName].value(),"HH:mm:ss"));
    }
    for(inputName of inputNameDateTimePickers){
        $("#"+intputId+inputName).val(kendo.toString(TDE[originInputId+inputName].value(),"yyyy-MM-dd HH:mm:ss"));
    }
    for(inputName of inputNameDatePickerRanges){
        $("#"+intputId+inputName+"Start").val(kendo.toString(TDE[originInputId+inputName+"Start"].value(),"yyyy-MM-dd"));
        $("#"+intputId+inputName+"End").val(kendo.toString(TDE[originInputId+inputName+"End"].value(),"yyyy-MM-dd"));
    }
    for(inputName of inputNameSelects){
        $("#"+intputId+inputName+"Id").val(TDE[originInputId+inputName+"Id"].value());
        $("#"+intputId+inputName+"Name").val(TDE[originInputId+inputName+"Id"].text());
    }
    reportGenerateExcel();
}
function reportGenerateExcelSuccess(result){
    if(result.datas.FileLink){
        TDE.commonModal.Display({
            title:"Download Excel"
            ,body:"Your report is ready. Click <a href='"+result.datas.FileLink+"' download='"+result.datas.ExcelFileName+".xlsx' onClick='TDE.commonModal.hide();'>here</a> to download the report"
        });
    }
    else{
        TDE.commonModal.Display({
            title:"Error Download Excel"
            ,body:"There's error(s) on the report. Please try again. If the error occur persistence, please contact <span class='text-danger'>System Administrator</span>"
        });
    }
}
//#endregion

//#region GeneratePrintOut
function reportGeneratePrintOutPrepareData(ReportId){
    TDE.reportGeneratePrintOutTokenReportId.val(ReportId);
    reportGeneratePrintOutToken();
}
function reportGeneratePrintOutTokenSuccess(result){
    let reportId = result.datas.reportId;
    let tokenString = result.datas.tokenString;

    let formGroup = "report";
    let formId = "GeneratePrintOut";
    let formGroupId = formGroup+formId;

    let originGroup = "report";
    let originId = "GetReport";
    let originGroupId = originGroup+originId;

    let windowTargetSufix1 = Date.now();
    let windowTargetSufix2 = Math.floor(Math.random() * 1000000).toString();
    let windowTargetSufix = windowTargetSufix1 + windowTargetSufix2;
    //console.log(windowTargetSufix1, windowTargetSufix2, windowTargetSufix);
    let windowTarget = 'w_' + windowTargetSufix;
    //let windowTarget = "_blank";
    let form = document.createElement("form");
    form.setAttribute("id", formGroupId);
    form.setAttribute("method", "post");
    form.setAttribute("action", "/"+ROOT+"reportPrint?t="+tokenString);
    form.setAttribute("target", windowTarget);

    let hiddenField;
    for(inputs of [
        ["ReportId",TDE[originGroupId+"ReportId"].value()],
        ["CompanyId",TDE[originGroupId+"CompanyId"].value()],
        ["CompanyName",TDE[originGroupId+"CompanyId"].text()],
        ["BranchId",TDE[originGroupId+"BranchId"].value()],
        ["BranchName",TDE[originGroupId+"BranchId"].text()],
        ["POSId",TDE[originGroupId+"POSId"].value()],
        ["POSName",TDE[originGroupId+"POSId"].text()]]){
        hiddenField = document.createElement("input");
        hiddenField.setAttribute("id", formGroupId+inputs[0]);
        hiddenField.setAttribute("name", inputs[0]);
        hiddenField.setAttribute("value", inputs[1]);
        form.appendChild(hiddenField);
    }

    let intputId = formGroupId+'_'+reportId+'_';
    let originInputId = originGroupId+'_'+reportId+'_';

    let inputNameTexts = [];
    let inputNameDatePickers = [];
    let inputNameTimePickers = [];
    let inputNameDateTimePickers = [];
    let inputNameDatePickerRanges = [];
    let inputNameSelects = [];

    if(reportId == 44){
        inputNameDatePickerRanges.push("Date");
    }

    for(inputName of inputNameTexts){
        hiddenField = document.createElement("input");
        hiddenField.setAttribute("id", intputId+inputName);
        hiddenField.setAttribute("name", inputName);
        hiddenField.setAttribute("value", TDE[originInputId+inputName].value());
        form.appendChild(hiddenField);
    }
    for(inputName of inputNameDatePickers){
        hiddenField = document.createElement("input");
        hiddenField.setAttribute("id", intputId+inputName);
        hiddenField.setAttribute("name", inputName);
        hiddenField.setAttribute("value", kendo.toString(TDE[originInputId+inputName].value(),"yyyy-MM-dd"));
        form.appendChild(hiddenField);
    }
    for(inputName of inputNameTimePickers){
        hiddenField = document.createElement("input");
        hiddenField.setAttribute("id", intputId+inputName);
        hiddenField.setAttribute("name", inputName);
        hiddenField.setAttribute("value", kendo.toString(TDE[originInputId+inputName].value(),"HH:mm:ss"));
        form.appendChild(hiddenField);
    }
    for(inputName of inputNameDateTimePickers){
        hiddenField = document.createElement("input");
        hiddenField.setAttribute("id", intputId+inputName);
        hiddenField.setAttribute("name", inputName);
        hiddenField.setAttribute("value", kendo.toString(TDE[originInputId+inputName].value(),"yyyy-MM-dd HH:mm:ss"));
        form.appendChild(hiddenField);
    }
    for(inputName of inputNameDatePickerRanges){
        hiddenField = document.createElement("input");
        hiddenField.setAttribute("id", intputId+inputName+"Start");
        hiddenField.setAttribute("name", inputName+"Start");
        hiddenField.setAttribute("value", kendo.toString(TDE[originInputId+inputName+"Start"].value(),"yyyy-MM-dd"));
        form.appendChild(hiddenField);

        hiddenField = document.createElement("input");
        hiddenField.setAttribute("id", intputId+inputName+"End");
        hiddenField.setAttribute("name", inputName+"End");
        hiddenField.setAttribute("value", kendo.toString(TDE[originInputId+inputName+"End"].value(),"yyyy-MM-dd"));
        form.appendChild(hiddenField);
    }
    for(inputName of inputNameSelects){
        hiddenField = document.createElement("input");
        hiddenField.setAttribute("id", intputId+inputName+"Id");
        hiddenField.setAttribute("name", inputName);
        hiddenField.setAttribute("value", TDE[originInputId+inputName+"Id"].value());
        form.appendChild(hiddenField);

        hiddenField = document.createElement("input");
        hiddenField.setAttribute("id", intputId+inputName+"Name");
        hiddenField.setAttribute("name", inputName);
        hiddenField.setAttribute("value", TDE[originInputId+inputName+"Id"].text());
        form.appendChild(hiddenField);
    }
    document.body.appendChild(form);

    window.open('', windowTarget);

    form.submit();

    $("#"+formGroupId).remove();
}
//#endregion
