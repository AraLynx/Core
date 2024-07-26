//console.log("hidden.js loaded");
class AraCoreFieldHidden extends AraCoreField{
    constructor(params){
        super(params);

        this.init();
    }

    init(){
        AraCore[this.id] =  $("#"+this.id);
        AraCore[this.id].value =  $("#"+this.id).val;//rename val() jadi value() biar sama kaya kendo

        AraCore[this.id].value(this.fieldValue);

        this.afterInitField();
    }
}
