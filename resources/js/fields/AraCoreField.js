//console.log("hidden.js loaded");
class AraCoreField{
    constructor(params){
        this.id = params.id;

        this.theme = "kendo";
        if('theme' in params)this.theme = params.theme;

        this.fieldValue = "";
        if('value' in params)this.fieldValue = params.value;

        this.placeHolder = "";
        if('placeHolder' in params)this.placeHolder = params.placeHolder;

        this.isReadOnly = false;
        if('isReadOnly' in params)this.isReadOnly = params.isReadOnly;

        this.isDisable = false;
        if('isDisable' in params)this.isDisable = params.isDisable;

        this.onChange = false;
        if('onChange' in params)this.onChange = params.onChange;

        this.isInfo = false;
        if('isInfo' in params)this.isInfo = params.isInfo;

        if(this.theme === "kendo"){
            this.kendoParams = {};
        }

        this.initField();
    }

    initField(){
        if(this.theme === "kendo"){
            if(this.fieldValue)this.kendoParams.value = this.fieldValue;
            if(this.placeHolder)this.kendoParams.placeholder = this.placeHolder;
            if(this.isReadOnly)this.kendoParams.readonly = true;
            if(this.isDisable)this.kendoParams.enable = false;
        }
    }

    afterInitField(){
        if(this.theme === "kendo"){
            if(this.onChange)AraCore[this.id].bind("change",window[this.onChange]);
        }

        if(this.isInfo)AraCore[this.id+"Info"] = $("#"+this.id+"Info");

        /* OLD FUNCTION */
        if(AraCore[this.id] !== undefined){
            //console.log(this.id, AraCore[this.id]);
            let thisObj = this;
            AraCore[this.id].reset = function(){thisObj.reset();}
        }
    }

    value(value = null, isDefault = false){
        if(value === null){
            //get value
            return AraCore[this.id].value();
        }
        else{
            //set value
            AraCore[this.id].value(value);
            if(isDefault){
                this.fieldValue = value;
            }
        }
    }

    reset(){
        AraCore[this.id].value(this.fieldValue);
    }
}
