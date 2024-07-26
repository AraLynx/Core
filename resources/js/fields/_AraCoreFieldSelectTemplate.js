class _AraCoreFieldSelectTemplate extends AraCoreFieldSelect{
    constructor(params){
        if(params.theme === "kendo"){
            params.kendoType = "kendoDropDownList"; //DEFAULT : kendoDropDownList
            params.dataSourceType = "DataSource"; //DEFAULT : DataSource
        }
        super(params);

        this.suggest = true
        if('suggest' in params)this.suggest = params.suggest;

        this.init();
    }

    init(){
        if(this.theme === "kendo"){
            /* ADDITIONAL KENDO PARAM */
            if(this.suggest)this.kendoParams.suggest = this.suggest;

            /* NOT SUPPORTED DEFAULT KENDO PARAM */
            if('placeholder' in this.kendoParams)delete this.kendoParams.placeholder;

            this.generateKendoSelect();
        }
    }

    /* RE-WRITE PARENT METHOD IF NEEDED */
    parentMethod(){

    }

    /* NEW EXCLUSIVE METHOD */
    newMethod(){

    }
}
