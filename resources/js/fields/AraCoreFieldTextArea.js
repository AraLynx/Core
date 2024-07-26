class AraCoreFieldTextArea extends AraCoreField{
    constructor(params){
        super(params);

        this.placeHolder = "";
        if('placeHolder' in params)this.placeHolder = params.placeHolder;

        this.rows = 5;
        if('rows' in params)this.rows = params.rows;

        this.maxLength = 500;
        if('maxLength' in params)this.maxLength = params.maxLength;

        this.isShowCounter = true;
        if('isShowCounter' in params)this.isShowCounter = params.isShowCounter;

        this.init();
    }

    init(){
        let textAreaCounterId = this.id+"TextAreaCounter";
        if(this.theme === "kendo"){
            if(this.isShowCounter){
                let span = $("<span>", {
                    id: textAreaCounterId,
                    text: "0",
                });

                let div = $("<div>");
                div.append(span);
                div.append("/");
                div.append(this.maxLength);

                $("#"+this.id).after(div);
            }

            if(this.rows)this.kendoParams.rows = this.rows;
            if(this.maxLength)this.kendoParams.maxLength = this.maxLength;

            AraCore[this.id] = $("#"+this.id).kendoTextArea(this.kendoParams).data("kendoTextArea");
        }

        this.afterInitField();

        let thisObj = this;
        AraCore[this.id].updateCounter = function(){thisObj.updateCounter();}

        if(this.isShowCounter){
            $("#"+this.id).on('input',function(){thisObj.updateCounter();});
        }
    }

    /* NEW EXCLUSIVE METHOD */
    updateCounter(){
        if(this.isShowCounter){
            let textAreaCounterId = this.id+"TextAreaCounter";
            $("#"+textAreaCounterId).html($("#"+this.id).val().length);
        }
    }
}
