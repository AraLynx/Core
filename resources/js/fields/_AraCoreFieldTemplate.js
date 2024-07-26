class _AraCoreFieldTemplate extends AraCoreField{
    constructor(params){
        super(params);

        this.property01 = "";
        if('property01' in params)this.property01 = params.property01;
        this.property02 = "";
        if('property02' in params)this.property02 = params.property02;

        this.initTempalte();
    }

    initTempalte(){
        if(this.theme === "kendo"){
            /* PREPARE KENDO PARAMETERS THAT EXCLUDED FROM PARENT */
            if(this.property01)this.kendoParams.property01 = this.property01;
            if(this.property02)this.kendoParams.property02 = this.property02;

            /*
            DELETE PARAMETERS THAT NOT SUPPORTED IN THIS PARTICULAR KENDO OBJECT
            SEE https://docs.telerik.com/kendo-ui/api/javascript/ui/ FOR FULL DOCUMENTATION
            */
            if('placeholder' in this.kendoParams)delete this.kendoParams.placeholder;
            if('readonly' in this.kendoParams)delete this.kendoParams.readonly;
            if('enable' in this.kendoParams)delete this.kendoParams.enable;

            /* CREATING KENDO OBJECT */
            AraCore[this.id] = $("#"+this.id).kendoTemplate(this.kendoParams).data("kendoTemplate");

            /* TRIGGER FUNCTION ON INIT IF NECESSARY */
            if(this.isReadOnly)AraCore[this.id].readonly();
            if(this.isDisable)AraCore[this.id].enable(false);
        }

        this.afterInitField();
    }

    /* RE-WRITE PARENT METHOD IF NEEDED */
    parentMethod(){

    }

    /* NEW EXCLUSIVE METHOD */
    newMethod(){

    }
}
