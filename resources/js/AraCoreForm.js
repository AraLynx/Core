//console.log("hidden.js loaded");
class AraCoreForm{
    constructor(params){
        this.id = params.id;

        this.fields = [];

        this.init();
    }

    init(){
    }

    addFieldObj(AraCoreFieldObj){
        if(!(this.fields.includes(AraCoreFieldObj)))
            this.fields.push(AraCoreFieldObj);
    }
    reset(){
        this.fields.forEach(function (AraCoreFieldObj, index){
            //console.log(AraCoreFieldObj);
            AraCoreFieldObj.reset();
        });
    }
}
