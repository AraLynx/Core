class AraCoreFieldDropDownList extends AraCoreFieldSelect{
    constructor(params){
        if(params.theme === "kendo"){
            params.kendoType = "kendoDropDownList";
        }
        super(params);

        this.init();
    }

    init(){
        if(this.theme === "kendo"){
            if('placeHolder' in this.kendoParams)delete this.kendoParams.placeHolder;

            this.generateKendoSelect();
        }
    }
}
