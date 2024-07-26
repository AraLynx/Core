class AraCoreFieldSwitch extends AraCoreField{
    constructor(params){
        super(params);

        this.checked = false;
        if('checked' in params)this.checked = params.checked;
        this.messageChecked = "YES";
        if('messageChecked' in params)this.messageChecked = params.messageChecked;
        this.messageUncheked = "NO";
        if('messageUncheked' in params)this.messageUncheked = params.messageUncheked;
        this.size = "small";
        if('size' in params)this.size = params.size;
        this.trackRounded = "small";
        if('trackRounded' in params)this.trackRounded = params.trackRounded;
        this.thumbRounded = "small";
        if('thumbRounded' in params)this.thumbRounded = params.thumbRounded;

        this.init();
    }

    init(){
        if(this.theme === "kendo"){
            if(this.checked)this.kendoParams.checked = true;

            this.kendoParams.messages = {};
            if(this.messageChecked)this.kendoParams.messages.checked = this.messageChecked;
            if(this.messageUncheked)this.kendoParams.messages.unchecked = this.messageUncheked;

            if(this.size)this.kendoParams.size = this.size;
            if(this.trackRounded)this.kendoParams.trackRounded = this.trackRounded;
            if(this.thumbRounded)this.kendoParams.thumbRounded = this.thumbRounded;
            if(this.isDisable)this.kendoParams.enabled = false;

            if('value' in this.kendoParams)delete this.kendoParams.value;
            if('placeholder' in this.kendoParams)delete this.kendoParams.placeholder;
            if('enable' in this.kendoParams)delete this.kendoParams.enable;

            AraCore[this.id] = $("#"+this.id).kendoSwitch(this.kendoParams).data("kendoSwitch");
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
        AraCore[this.id].check(this.fieldValue);
    }
}
