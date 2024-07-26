class AraCoreFieldTime extends AraCoreField{
    constructor(params){
        params.value = new Date();
        if('customValue' in params)params.value = params.customValue;

        super(params);

        this.format = "";
        if('format' in params)this.format = params.format;

        this.min = new Date();
        if('min' in params)this.min = params.min;

        this.max = new Date();
        if('max' in params)this.max = params.max;

        this.init();
    }

    init(){
        if(this.theme === "kendo"){
            if(this.format)this.kendoParams.format = this.format;
            if(this.min)this.kendoParams.min = this.min;
            if(this.max)this.kendoParams.max = this.max;

            if('placeholder' in this.kendoParams)delete this.kendoParams.placeholder;
            if('readonly' in this.kendoParams)delete this.kendoParams.readonly;
            if('enable' in this.kendoParams)delete this.kendoParams.enable;

            AraCore[this.id] = $("#"+this.id).kendoTimePicker(this.kendoParams).data("kendoTimePicker");

            if(this.isReadOnly)AraCore[this.id].readonly();
            if(this.isDisable)AraCore[this.id].enable(false);

        }

        this.afterInitField();
    }

    /* RE-WRITE PARENT FUNCTION IF NEEDED */
    reset(){
        let resetDate = this.fieldValue;
        let now = new Date();
        if(this.min > now)resetDate = this.min;
        else if(this.max < now)resetDate = this.max;

        AraCore[this.id].value(resetDate);
    }
}
