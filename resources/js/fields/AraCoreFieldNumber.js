class AraCoreFieldNumber extends AraCoreField{
    constructor(params){
        super(params);

        this.fieldValue = 0;
        if('value' in params)this.fieldValue = params.value;

        this.isSpinner = true;
        if('isSpinner' in params)this.isSpinner = params.isSpinner;

        this.isNegaitve = false;
        if('isNegaitve' in params)this.isNegaitve = params.isNegaitve;

        this.step = "x";
        if('step' in params)this.step = params.step;

        this.onSpin = false;
        if('onSpin' in params)this.onSpin = params.onSpin;

        this.min = 0;
        if('min' in params)this.min = params.min;

        this.max = "x";
        if('max' in params)this.max = params.max;

        this.decimals = "x";
        if('decimals' in params)this.decimals = params.decimals;

        this.format = "#";
        if('format' in params)this.format = params.format;

        this.init();
    }

    init(){
        if(this.theme === "kendo"){
            this.kendoParams.restricAraCorecimals = true;
            if(!this.isSpinner)this.kendoParams.spinners = this.false;
            if(this.min !== "x")this.kendoParams.min = this.min;
            if(this.max !== "x")this.kendoParams.max = this.max;
            if(this.decimals !== "x")this.kendoParams.decimals = this.decimals;
            if(this.step !== "x")this.kendoParams.step = this.step;
            if(this.format !== "x")this.kendoParams.format = this.format;

            if('readonly' in this.kendoParams)delete this.kendoParams.readonly;
            if('enable' in this.kendoParams)delete this.kendoParams.enable;

            AraCore[this.id] = $("#"+this.id).kendoNumericTextBox(this.kendoParams).data("kendoNumericTextBox");

            if(this.isReadOnly)AraCore[this.id].readonly();
            if(this.isDisable)AraCore[this.id].enable(false);

            if(this.onSpin){
                let onSpinFunction
                if(typeof this.onSpin === "boolean")onSpinFunction = this.id+"Spin";
                else if(typeof this.onSpin === "string")onSpinFunction = this.onSpin;

                if($numericOnSpinFunction)
                    AraCore[this.id].bind('spin',window[$numericOnSpinFunction]);
            }
        }

        this.afterInitField();
    }
}
