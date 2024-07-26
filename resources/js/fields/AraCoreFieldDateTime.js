class AraCoreFieldDateTime extends AraCoreField{
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

        if(APP_NAME === "Plutus"){
            this.backDate = {};
            if('backDate' in params)this.backDate = params.backDate;

            this.backDateFormId = "";
            if('backDateFormId' in params)this.backDateFormId = params.backDateFormId;

            this.backDatePOSElementIds = [];
            if('backDatePOSElementIds' in params)this.backDatePOSElementIds = params.backDatePOSElementIds;
        }

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

            AraCore[this.id] = $("#"+this.id).kendoDatePicker(this.kendoParams).data("kendoDatePicker");

            if(this.isReadOnly)AraCore[this.id].readonly();
            if(this.isDisable)AraCore[this.id].enable(false);

            let backDate = this.backDate;

            if(APP_NAME === "Plutus"){
                let maxBackDate = 0;
                let POSIds = Object.keys(backDate);

                POSIds.forEach((POSId) => {
                    let monthBackDate = backDate[POSId];
                    if(maxBackDate < monthBackDate)
                        maxBackDate = monthBackDate;
                });

                let yearBackDate = new Date().getFullYear();
                let monthBackDate = new Date().getMonth() - maxBackDate;
                AraCore[this.id].min(new Date(yearBackDate, monthBackDate, 1));

                if(this.backDatePOSElementIds.length){
                    let updateBackDateFunctionName = "UpdateBackDate";
                    let backDateFormId = this.backDateFormId;
                    let backDatePOSElementIds = this.backDatePOSElementIds;

                    AraCore[this.id][updateBackDateFunctionName] = function (){
                        let now = new Date();
                        let year = now.getFullYear();
                        let month = now.getMonth();
                        let backDateMonth = 0;

                        //CHECK AVAILABLE BACK DATE MONTH
                        for (const backDatePOSElementId of backDatePOSElementIds){
                            let POSId = AraCore[backDateFormId+backDatePOSElementId].value() * 1;
                            if(POSId in backDate){
                                if(!backDateMonth) backDateMonth = backDate[POSId];
                                else if(backDate[POSId] < backDateMonth)backDateMonth = backDate[POSId];
                            }
                            else backDateMonth = 0;
                        }
                        if(backDateMonth == -1){
                            year = 1900;
                            month = 0;
                        }
                        else{
                            month = month - backDateMonth;
                        }
                        let minDate = new Date(year, month, 1);
                        let pickedDate = AraCore[this.id].value();

                        AraCore[this.id].min(minDate);
                        if(pickedDate < minDate){
                            AraCore[this.id].value(minDate);
                        }
                    }

                    for (const backDatePOSElementId of backDatePOSElementIds){
                        AraCore[backDateFormId+backDatePOSElementId].bind('change',window[AraCore[this.id][updateBackDateFunctionName]])
                    }
                }
            }
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
