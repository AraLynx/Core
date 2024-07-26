class AraCoreFieldCheckBox extends AraCoreField{
    constructor(params){
        super(params);

        this.checked = false;
        if('checked' in params)this.checked = params.checked;
        this.label = "";
        if('label' in params)this.label = params.label;
        this.size = "medium";
        if('size' in params)this.size = params.size;
        this.rounded = "medium";
        if('rounded' in params)this.rounded = params.rounded;

        this.init();
    }

    init(){
        if(this.theme === "kendo"){
            if(this.checked)this.kendoParams.checked = true;
            if(this.label)this.kendoParams.label = this.label;
            if(this.size)this.kendoParams.size = this.size;
            if(this.rounded)this.kendoParams.rounded = this.rounded;
            if(this.isDisable)this.kendoParams.enabled = false;

            if('value' in this.kendoParams)delete this.kendoParams.value;
            if('placeholder' in this.kendoParams)delete this.kendoParams.placeholder;
            if('readonly' in this.kendoParams)delete this.kendoParams.readonly;
            if('enable' in this.kendoParams)delete this.kendoParams.enable;

            AraCore[this.id] = $("#"+this.id).kendoCheckBox(this.kendoParams).data("kendoCheckBox");
        }

        this.afterInitField();
    }

    /* RE-WRITE PARENT FUNCTION IF NEEDED */
    value(checked = null, isDefault = false){
        if(checked === null){
            //get value
            return AraCore[this.id].check();
        }
        else{
            //set value
            AraCore[this.id].check(checked);
            if(isDefault){
                this.checked = checked;
            }
        }
    }
    reset(){
        AraCore[this.id].check(this.checked);
    }
}
