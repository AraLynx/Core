class AraCoreFieldSelect extends AraCoreField{
    constructor(params){
        super(params);

        this.dataTextField = "";
        if('dataTextField' in params)this.dataTextField = params.dataTextField;
        this.dataValueField = "";
        if('dataValueField' in params)this.dataValueField = params.dataValueField;
        this.heightInPixel = 350;
        if('heightInPixel' in params)this.heightInPixel = params.heightInPixel;
        this.filter = "";
        if('filter' in params)this.filter = params.filter;
        this.options = [];this.optionsLenght = 0;
        if('options' in params)this.options = params.options;
        this.headerTemplate = "";
        if('headerTemplate' in params)this.headerTemplate = params.headerTemplate;
        this.footerTemplate = "";
        if('footerTemplate' in params)this.footerTemplate = params.footerTemplate;

        this.onFiltering = false;
        if('onFiltering' in params)this.onFiltering = params.onFiltering;
        this.onSelect = false;
        if('onSelect' in params)this.onSelect = params.onSelect;

        if(this.theme === "kendo"){
            this.kendoType = "kendoDropDownList";
            if('kendoType' in params)this.kendoType = params.kendoType;
            this.dataSourceType = "DataSource";
            if('dataSourceType' in params)this.dataSourceType = params.dataSourceType;
        }

        this.typeDetail = "";
        if('typeDetail' in params)this.typeDetail = params.typeDetail;
        this.template = "";
        if('template' in params)this.template = params.template;
        this.additionalParams = false;
        if('additionalParams' in params)this.additionalParams = params.additionalParams;

        this.initSelect();
    }

    initSelect(){
        if(this.theme === "kendo"){
            if(this.dataTextField)this.kendoParams.dataTextField = this.dataTextField;
            if(this.dataValueField)this.kendoParams.dataValueField = this.dataValueField;
            if(this.heightInPixel)this.kendoParams.height = this.heightInPixel;
            if(this.filter)this.kendoParams.filter = this.filter;
            if(this.headerTemplate)this.kendoParams.headerTemplate = this.headerTemplate;
            if(this.footerTemplate)this.kendoParams.footerTemplate = this.footerTemplate;
            if(this.template)this.kendoParams.template = this.dataTextemplatetField;

            if('readonly' in this.kendoParams)delete this.kendoParams.readonly;
        }
    }

    /* KENDO SECTION */
    generateKendoSelect(){
        if(this.typeDetail === "monthYearPicker") this.generateKendoSelect_monthYearPicker();
        else if(this.typeDetail === "cbpPicker") this.generateKendoSelect_cbpPicker();
        else this.generateKendoSelect_();
    }
        generateKendoSelect_(){
            AraCore[this.id] = $("#"+this.id)[this.kendoType](this.kendoParams).data(this.kendoType);

            if(this.isReadOnly)AraCore[this.id].readonly();

            for(let option of this.options)this.optionsLenght++;

            this.afterInitField();

            /* OLD FUNCTION */
            let thisObj = this;
            AraCore[this.id].populate = function(datas){thisObj.populate(datas);};
            AraCore[this.id].reset = function(){thisObj.reset();};

            if(this.onFiltering)AraCore[this.id].bind("filtering",window[this.onFiltering]);
            if(this.onSelect)AraCore[this.id].bind("select",window[this.onSelect]);

            if(this.optionsLenght)this.populate(this.options);
        }
        generateKendoSelect_monthYearPicker(){
            //console.log(this.options);
            //console.log(this.additionalParams);
            for(let template of this.additionalParams.templates){
                let elementId = this.id;
                if(template === "month"){
                    elementId += "Month";
                }
                else if(template === "year"){
                    elementId += "Year";
                }

                AraCore[elementId] = $("#"+elementId)[this.kendoType](this.kendoParams).data(this.kendoType);
                if(this.isReadOnly)AraCore[elementId].readonly();

                //this.afterInitField();
                if(this.onChange)AraCore[elementId].bind("change",window[this.onChange]);
                if(this.isInfo)AraCore[elementId+"Info"] = $("#"+elementId+"Info");
            }
            if(this.isInfo)AraCore[this.id+"Info"] = $("#"+this.id+"Info");
            this.populate();
        }
        generateKendoSelect_cbpPicker(){
            //console.log(this.options);
            //console.log(this.additionalParams);
            for(let template of this.additionalParams.templates){
                let CBP = this.cbpPicker_getCBPfromTemplate(template);
                let elementId = this.id + CBP + "Id";

                AraCore[elementId] = $("#"+elementId)[this.kendoType](this.kendoParams).data(this.kendoType);
                let thisObj = this;
                AraCore[elementId].bind("change",function(){
                    thisObj.cbpPicker_change(template);
                });

                if(this.isReadOnly)AraCore[elementId].readonly();

                //this.afterInitField();
                if(this.onChange)AraCore[elementId].bind("change",window[this.onChange]);
            }
            if(this.isInfo)AraCore[this.id+"Info"] = $("#"+this.id+"Info");
            this.reset();
        }

    /* RE-WRITE PARENT METHOD IF NEEDED */
    value(value = null, isDefault = false){
        if(this.typeDetail === "monthYearPicker") return this.value_monthYearPicker(value, isDefault);
        else if(this.typeDetail === "cbpPicker") return this.value_cbpPicker(value, isDefault);
        else return super.value(value, isDefault);
    }
        value_monthYearPicker(value = null, isDefault = false){
            if(value === null){
                let returns = {};
                for(let template of this.additionalParams.templates)
                {
                    let elementId = this.id;
                    if(template === "month"){
                        elementId += "Month";
                    }
                    else if(template === "year"){
                        elementId += "Year";
                    }
                    returns[template] = AraCore[elementId].value();
                }
                return returns;
            }
            else{
                //set value
            }
        }
        value_cbpPicker(value = null, isDefault = false){
            if(value === null){
                //get value
                let returns = {};
                for(let template of this.additionalParams.templates)
                {
                    let CBP = this.cbpPicker_getCBPfromTemplate(template);
                    let elementId = this.id+CBP+"Id";
                    returns[template] = AraCore[elementId].value();
                }
                //console.log(returns);
                return returns;
            }
            else{
                //set value
            }
        }

    reset(){
        //console.log('reset');
        if(this.typeDetail === "monthYearPicker") this.reset_monthYearPicker();
        else if(this.typeDetail === "cbpPicker") this.reset_cbpPicker();
        else this.reset_();
    }
        reset_(){
            //console.log(this,'reset_');
            this.populate(this.options);
            this.value(this.fieldValue);
        }
        reset_monthYearPicker(){
            //console.log('reset_monthYearPicker');

        }
        reset_cbpPicker(){
            //console.log('reset_cbpPicker');
            let firstTemplate = this.additionalParams.templates[0];

            for(let template of this.additionalParams.templates){
                let CBP = this.cbpPicker_getCBPfromTemplate(template);
                let elementId = this.id + CBP + "Id";
                if(this.theme === "kendo"){
                    AraCore[elementId].setDataSource(new kendo.data[this.dataSourceType]({data:[]}));
                }

                if(firstTemplate === template)this.populate(template);

                /*
                if(firstTemplate === template){
                    let datas = this.options[CBP];
                    let [options, selected] = this.generateOptions(datas);
                    if(this.theme === "kendo"){
                        AraCore[elementId].setDataSource(new kendo.data[this.dataSourceType]({data:options}));
                    }
                }
                */
            }
        }

    /* NEW EXCLUSIVE METHOD */
    generateOptions(datas = null){
        let options = [];
        let selected = '';

        //console.log(datas);
        if(datas !== null){
            for (let data of datas){
                if(data instanceof Array){
                    //array
                    options.push({Value: data[0], Text: data[1]});
                    if(data.length == 3 && data[2]){
                        selected = data[0];
                    }
                }
                else if(data instanceof Object){
                    //associative array = object
                    if('Value' in data && 'Text' in data){
                        options.push(data);
                        if('Selected' in data){
                            selected = data.Value;
                        }
                    }
                }
                else{
                    //it's a string
                    options.push({Value: data, Text: data});
                }
            }
        }

        return [options,selected];
    }
    getTemplateIndex(thisTemplate){
        let thisIndex = 0;
        let index = 0;
        for(let template of this.additionalParams.templates){
            if(thisTemplate === template)
                thisIndex = index;
            index++;
        }
        return thisIndex;
    }
    populate(datas = null){
        //console.log('populate', datas);
        if(this.typeDetail === "monthYearPicker") this.populate_monthYearPicker(datas);
        else if(this.typeDetail === "cbpPicker") this.populate_cbpPicker(datas);
        else this.populate_(datas);
    }
        populate_(datas = null){
            //console.log('populate_', datas);
            if(this.theme === "kendo"){
                AraCore[this.id].setDataSource(new kendo.data[this.dataSourceType]({data:[]}));
                //AraCore[this.id].select(-1); /* NOT COMPATIBLE WITH kendoMultiSelect & kendoDropDownTree*/
            }
            AraCore[this.id].value("");
            //AraCore[this.id].select(-1); /* NOT COMPATIBLE WITH kendoMultiSelect & kendoDropDownTree*/

            let [options, selected] = this.generateOptions(datas);

            if(this.theme === "kendo"){
                AraCore[this.id].setDataSource(new kendo.data[this.dataSourceType]({data:options}));
            }

            if(selected){
                AraCore[this.id].value(selected);
            }
        }
        populate_monthYearPicker(datas = null){
            //console.log('populate_monthYearPicker', datas);
            if(datas !== null)console.log("Month Year Picker can't be populate with data");
            else{
                for(let template of this.additionalParams.templates){
                    let elementId = this.id;
                    let rawOptions = [];
                    if(template === "month"){
                        elementId += "Month";
                        rawOptions = this.options.month;
                    }
                    else if(template === "year"){
                        elementId += "Year";
                        rawOptions = this.options.year;
                    }

                    let [options, selected] = this.generateOptions(rawOptions);
                    //console.log(elementId, rawOptions, options);
                    if(this.theme === "kendo"){
                        AraCore[elementId].setDataSource(new kendo.data[this.dataSourceType]({data:options}));
                    }
                    if(selected){
                        AraCore[elementId].value(selected);
                    }
                }
            }
        }
        populate_cbpPicker(datas = null){
            //console.log('populate_cbpPicker', datas);
            if(datas instanceof Array)console.log("CPB Picker can't be populate with data");
            else if(datas === null)this.reset();
            else{
                //console.log('populate_cbpPicker_else', datas);
                //console.log(this.options);
                let template = datas;
                let firstTemplate = this.additionalParams.templates[0];
                let CBP = this.cbpPicker_getCBPfromTemplate(template);
                let elementId = this.id + CBP + "Id";
                datas = this.options[CBP];
                //console.log(datas);
                if(firstTemplate !== template){
                    //cek value of cbp before
                    //console.log(template);
                    let thisIndex = this.getTemplateIndex(template);

                    let lastIndex = thisIndex - 1;
                    let lastTemplate = this.additionalParams.templates[lastIndex];
                    let lastValue = this.value()[lastTemplate];
                    //console.log(lastValue);

                    datas = this.options[CBP][lastValue];
                }

                let [options, selected] = this.generateOptions(datas);
                if(this.theme === "kendo"){
                    AraCore[elementId].setDataSource(new kendo.data[this.dataSourceType]({data:options}));
                }

                if(options.length){
                    if(firstTemplate !== template){
                        AraCore[elementId].open();
                    }
                }
            }
        }

    //#region CBPPicker
    cbpPicker_getCBPfromTemplate(template){
        let CBP = "";
        switch(template){
            case "brand" : CBP = "Brand";break;
            case "company" : CBP = "Company";break;
            case "branch" : CBP = "Branch";break;
            case "pos" : CBP = "POS";break;
        }
        return CBP;
    }
        cbpPicker_change(thisTemplate){
            //console.log(this, thisTemplate);
            let thisCBP = this.cbpPicker_getCBPfromTemplate(thisTemplate);
            let thisCBPIndex = this.getTemplateIndex(thisTemplate);
            let totalIndex = this.additionalParams.templates.length-1;

            if(thisCBPIndex < totalIndex){
                //ada CBP selanjutnya
                let nextCBPIndex = thisCBPIndex + 1;
                let nextTemplate = this.additionalParams.templates[nextCBPIndex];

                this.populate(nextTemplate);
            }

            let onChangeFunction = this.additionalParams.onChangeArrayFunctions[thisCBP];
            if(onChangeFunction){
                window[onChangeFunction]();
            }
        }
    //#endregion CBPPicker
}
