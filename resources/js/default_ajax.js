class Ajax{
    constructor(ajaxParams){
        this.type = 'post';
        this.dataType = 'json';
        this.async = true;
        this.result = [];
        this.functionName = '';

        this.url = ajaxParams.url;
        this.formId = ajaxParams.formId;
        this.data = $("#"+this.formId).serialize();
        this.dataParams = {};

        if('type' in ajaxParams)this.type = ajaxParams.type;
        if('dataType' in ajaxParams)this.dataType = ajaxParams.dataType;
        if('async' in ajaxParams)this.async = ajaxParams.async;
        if('functionName' in ajaxParams)this.functionName = ajaxParams.functionName;
        if('dataParams' in ajaxParams)this.dataParams = ajaxParams.dataParams;

        if(Object.keys(this.dataParams).length){
            this.data += '&'+$.param(this.dataParams);
        }

        if('modalTitle' in ajaxParams)this.modalTitle = ajaxParams.modalTitle;
        if('modalBody' in ajaxParams)this.modalBody = ajaxParams.modalBody;
        if('modalFooter' in ajaxParams)this.modalFooter = ajaxParams.modalFooter;
    }

    runAjax(runParams = {}){
        $("#"+this.formId+" .invalid-feedback").html("&nbsp;");

        let functionName = this.functionName;
        let isShowModal = runParams.isShowModal

        if(isShowModal){
            TDE.ajaxModal.Reset();
            TDE.ajaxModal.Body.removeClass("text-danger");
            TDE.ajaxModal.Footer.html("<p class='text-center text-secondary fst-italic'>Please don't close this window while loading...</p>");

            TDE.ajaxModal.show();
        }
        //console.log($("#"+this.formId).serialize());
        //console.log(this.dataParams);
        //console.log(this.data);
        $.ajax({
            type: this.type,
            url: this.url,
            data:this.data,
            dataType: this.dataType,
            async: this.async,
            success: function (result) {
                if(isShowModal)TDE.ajaxModal.hide();

                this.result = result;
                if(!result.isError){//result.statusCode == 100 => OK
                    if(result.statusCode == 100){//OK
                        if('success' in runParams)runParams.success(result);
                    }
                }
                else{
                    if(isShowModal){
                        if(result.statusCode == 503){//"Form validation error"
                            var errors = result.datas;
                            $.each(errors, function(field, messages){
                                if(document.getElementById(result.formGroup+"InvalidFeedback"+field)){
                                    $("#"+result.formGroup+"InvalidFeedback"+field).html(messages[0]);
                                }
                                else{
                                    TDE.ajaxModal.Reset();
                                    TDE.ajaxModal.Body.addClass("text-danger");
                                    TDE.ajaxModal.Body.html(messages[0]);
                                    TDE.ajaxModal.show();
                                }
                            });
                        }
                        else if(result.statusCode == 599){//"Manual error triger
                            TDE.ajaxModal.Reset();
                            TDE.ajaxModal.Body.addClass("text-danger");
                            TDE.ajaxModal.Body.html(this.result["message"]);
                            TDE.ajaxModal.show();
                        }
                        else{
                            TDE.ajaxModal.Reset();
                            TDE.ajaxModal.Body.addClass("text-danger");
                            TDE.ajaxModal.Body.html(this.result["statusMessage"]);
                            TDE.ajaxModal.show();
                        }
                    }
                }
            }
        })
        .done(function(){
            if('done' in runParams)runParams.done();
        })
        .fail(function(){
            if('fail' in runParams)runParams.fail();
            else if(isShowModal){
                TDE.ajaxModal.Reset();
                TDE.ajaxModal.Body.addClass("text-danger");
                TDE.ajaxModal.Body.html(functionName+" module failed");
                TDE.ajaxModal.show();
            }
        })
        .always(function(){
            if('always' in runParams)runParams.always();
        });
    }

    getResult(){
        //console.log(this.result);
        return this.result;
    }
}
