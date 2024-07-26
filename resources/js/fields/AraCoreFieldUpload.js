class AraCoreFieldUpload extends AraCoreField{
    constructor(params){
        super(params);

        this.asyncSaveUrl = CORE_JS+"/Core/ajax/kendoUploadSave.php";
        if('asyncSaveUrl' in params)this.asyncSaveUrl = params.asyncSaveUrl;
        this.asyncRemoveUrl = CORE_JS+"/Core/ajax/kendoUploadRemove.php";
        if('asyncRemoveUrl' in params)this.asyncRemoveUrl = params.asyncRemoveUrl;
        this.asyncAutoUpload = true;
        if('asyncAutoUpload' in params)this.asyncAutoUpload = params.asyncAutoUpload;
        this.asyncBatch = true;
        if('asyncBatch' in params)this.asyncBatch = params.asyncBatch;

        this.validationMaxFileSize = 2097152;
        if('validationMaxFileSize' in params)this.validationMaxFileSize = params.validationMaxFileSize;
        this.validationAllowedExtensions = [];
        if('validationAllowedExtensions' in params)this.validationAllowedExtensions = params.validationAllowedExtensions;

        this.isMultiple = false;
        if('isMultiple' in params)this.isMultiple = params.isMultiple;

        this.onSelectFunction = false;
        if('onSelectFunction' in params)this.onSelectFunction = params.onSelectFunction;
        this.onUploadFunction = false;
        if('onUploadFunction' in params)this.onUploadFunction = params.onUploadFunction;
        this.onProgressFunction = false;
        if('onProgressFunction' in params)this.onProgressFunction = params.onProgressFunction;
        this.onCancelFunction = false;
        if('onCancelFunction' in params)this.onCancelFunction = params.onCancelFunction;
        this.onRemoveFunction = false;
        if('onRemoveFunction' in params)this.onRemoveFunction = params.onRemoveFunction;
        this.onSuccessFunction = false;
        if('onSuccessFunction' in params)this.onSuccessFunction = params.onSuccessFunction;

        this.onSuccessUploadFunction = false;
        if('onSuccessUploadFunction' in params)this.onSuccessUploadFunction = params.onSuccessUploadFunction;
        this.onSuccessRemoveFunction = false;
        if('onSuccessRemoveFunction' in params)this.onSuccessRemoveFunction = params.onSuccessRemoveFunction;

        this.onCompleteFunction = false;
        if('onCompleteFunction' in params)this.onCompleteFunction = params.onCompleteFunction;
        this.onErrorFunction = false;
        if('onErrorFunction' in params)this.onErrorFunction = params.onErrorFunction;

        this.onErrorUploadFunction = false;
        if('onErrorUploadFunction' in params)this.onErrorUploadFunction = params.onErrorUploadFunction;
        this.onErrorRemoveFunction = false;
        if('onErrorRemoveFunction' in params)this.onErrorRemoveFunction = params.onErrorRemoveFunction;

        this.init();
    }

    init(){
        let elementId = this.id;
        if(this.theme === "kendo"){
            if(this.isDisable)this.kendoParams.enabled = false;

            this.kendoParams.async = {};
            if(this.asyncSaveUrl)this.kendoParams.async.saveUrl = this.asyncSaveUrl;
            if(this.asyncRemoveUrl)this.kendoParams.async.removeUrl = this.asyncRemoveUrl;
            this.kendoParams.async.autoUpload = true;
            this.kendoParams.async.batch = true;

            this.kendoParams.validation = {}
            if(this.validationMaxFileSize)this.kendoParams.validation.maxFileSize = this.validationMaxFileSize;
            if(this.validationAllowedExtensions)this.kendoParams.validation.allowedExtensions = this.validationAllowedExtensions;

            if(!this.isMultiple)this.kendoParams.multiple = this.isMultiple;

            /*
                event documentation : https://docs.telerik.com/kendo-ui/api/javascript/ui/upload#events
            */
            if(this.onSelectFunction)kendoParams.select = function(e){window[this.onSelectFunction](e);};
            if(this.onUploadFunction)kendoParams.upload = function(e){window[this.onUploadFunction](e);};
            if(this.onProgressFunction)kendoParams.progress = function(e){window[this.onProgressFunction](e);};
            if(this.onCancelFunction)kendoParams.cancel = function(e){window[this.onCancelFunction](e);};
            if(this.onRemoveFunction)kendoParams.remove = function(e){window[this.onRemoveFunction](e);};
            this.kendoParams.success = function(e){
                if(this.onSuccessFunction)window[this.onSuccessFunction](e);
                if(e.operation == 'upload'){
                    $('#'+elementId+'File').val(1);
                    $('#'+elementId+'FileDirectory').val(e.response.fileDirectory);
                    $('#'+elementId+'FileOriginalName').val(e.response.fileOriginalName);
                    $('#'+elementId+'FileUniqueName').val(e.response.fileUniqueName);
                    $('#'+elementId+'FileSize').val(e.response.fileSize);
                    $('#'+elementId+'FileType').val(e.response.fileType);
                    $('#'+elementId+'FileExtension').val(e.files[0].extension);
                    if(this.onSuccessUploadFunction)window[this.onSuccessUploadFunction](e);
                }
                else if(e.operation == 'remove'){
                    $('#'+elementId+'File').val(0);
                    $('#'+elementId+'FileDirectory').val('');
                    $('#'+elementId+'FileOriginalName').val('');
                    $('#'+elementId+'FileUniqueName').val('');
                    $('#'+elementId+'FileSize').val(0);
                    $('#'+elementId+'FileType').val('');
                    $('#'+elementId+'FileExtension').val('');
                    if(this.onSuccessRemoveFunction)window[this.onSuccessRemoveFunction](e);
                }
            };
            if(this.onCompleteFunction)this.kendoParams.complete = function(e){window[this.onCompleteFunction](e);};
            this.kendoParams.error = function(e){
                if(this.onErrorFunction)window[this.onErrorFunction](e);
                if(e.operation == 'upload'){
                    if(this.onErrorUploadFunction)window[this.onErrorUploadFunction](e);
                }
                else if(e.operation == 'remove'){
                    if(this.onErrorRemoveFunction)window[this.onErrorRemoveFunction](e);
                }
            };

            if('value' in this.kendoParams)delete this.kendoParams.value;
            if('placeholder' in this.kendoParams)delete this.kendoParams.placeholder;
            if('readonly' in this.kendoParams)delete this.kendoParams.readonly;
            if('enable' in this.kendoParams)delete this.kendoParams.enable;

            AraCore[this.id] = $("#"+this.id).kendoUpload(this.kendoParams).data("kendoUpload");
        }

        this.afterInitField();
    }

    /* RE-WRITE PARENT FUNCTION IF NEEDED */
    reset(){
        AraCore[this.id].value('');
        $('#'+this.id+'File').val(0);
        $('#'+this.id+'FileDirectory').val('');
        $('#'+this.id+'FileOriginalName').val('');
        $('#'+this.id+'FileUniqueName').val('');
        $('#'+this.id+'FileSize').val(0);
        $('#'+this.id+'FileType').val('');
        $('#'+this.id+'FileExtension').val('');
    }
}
