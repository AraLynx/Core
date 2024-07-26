class AraCoreFieldText extends AraCoreField{
    constructor(params){
        super(params);

        this.placeHolder = "";
        if('placeHolder' in params)this.placeHolder = params.placeHolder;

        this.init();
    }

    init(){
        if(this.theme === "kendo"){
            AraCore[this.id] = $("#"+this.id).kendoTextBox(this.kendoParams).data("kendoTextBox");
        }

        this.afterInitField();
    }
}
