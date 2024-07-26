class AraCoreFieldDateRange extends AraCoreField{
    constructor(params){
        super(params);

        this.fieldValueStart = "";
        if('valueStart' in params)this.fieldValueStart = params.valueStart;

        this.fieldValueEnd = "";
        if('valueEnd' in params)this.fieldValueEnd = params.valueEnd;

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
            delete this.kendoParams;

            let kendoStartParams = {};
            if(this.fieldValueStart)kendoStartParams.value = this.fieldValueStart;
            if(this.format)kendoStartParams.format = this.format;
            if(this.min)kendoStartParams.min = this.min;

            let kendoEndParams = {};
            if(this.fieldValueEnd)kendoEndParams.value = this.fieldValueEnd;
            if(this.format)kendoEndParams.format = this.format;
            if(this.max)kendoEndParams.max = this.max;

            AraCore[this.id+"Start"] = $("#"+this.id+"Start").kendoDatePicker(kendoStartParams).data("kendoDatePicker");
            AraCore[this.id+"End"] = $("#"+this.id+"End").kendoDatePicker(kendoEndParams).data("kendoDatePicker");

            /*rubah date start = membatasi min date end*/
            let elementId = this.id;
            AraCore[this.id+"Start"].bind('change',function(){
                let startDate = AraCore[elementId+"Start"].value();
                let endDate = AraCore[elementId+"End"].value();
                if (startDate) {
                    startDate = new Date(startDate);
                    startDate.setDate(startDate.getDate());
                    AraCore[elementId+"End"].min(startDate);
                }
                else if (endDate) {
                    AraCore[elementId+"Start"].max(new Date(endDate));
                }
                else {
                    endDate = new Date();
                    AraCore[elementId+"Start"].max(endDate);
                    AraCore[elementId+"End"].min(endDate);
                }
            });

            /*rubah date end = membatasi max date end*/
            AraCore[this.id+"End"].bind('change',function(){
                let endDate = AraCore[elementId+"End"].value();
                let startDate = AraCore[elementId+"Start"].value();
                if (endDate) {
                    endDate = new Date(endDate);
                    endDate.setDate(endDate.getDate());
                    AraCore[elementId+"Start"].max(endDate);
                }
                else if (startDate) {
                    AraCore[elementId+"End"].min(new Date(startDate));
                }
                else {
                    endDate = new Date();
                    AraCore[elementId+"Start"].max(endDate);
                    AraCore[elementId+"End"].min(endDate);
                }
            });

            AraCore[this.id+"Start"].max(AraCore[this.id+"End"].value());
            AraCore[this.id+"End"].min(AraCore[this.id+"Start"].value());

            if(this.isReadOnly){
                AraCore[this.id+"Start"].readonly();
                AraCore[this.id+"End"].readonly();
            }
            if(this.isDisable){
                AraCore[this.id+"Start"].enable(false);
                AraCore[this.id+"End"].enable(false);
            }
        }

        this.afterInitField();

        let thisObj = this;
        AraCore[this.id+"Start"].reset = function(){thisObj.reset();}
        AraCore[this.id+"End"].reset = function(){thisObj.reset();}
    }

    /* RE-WRITE PARENT FUNCTION IF NEEDED */
    reset(){
        AraCore[this.id+"Start"].value(this.fieldValueStart);
        AraCore[this.id+"End"].value(this.fieldValueEnd);
    }
}
