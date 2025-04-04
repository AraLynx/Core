class AraCoreFieldMultiSelect extends AraCoreFieldSelect{
    constructor(params){
        if(params.theme === "kendo"){
            params.kendoType = "kendoMultiSelect";
        }
        super(params);

        this.suggest = true
        if('suggest' in params)this.suggest = params.suggest;

        this.init();
    }

    init(){
        if(this.theme === "kendo"){
            if(this.suggest)this.kendoParams.suggest = this.suggest;

            this.generateKendoSelect();
        }
    }
}
