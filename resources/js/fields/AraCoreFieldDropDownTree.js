class AraCoreFieldDropDownTree extends AraCoreFieldSelect{
    constructor(params){
        if(params.theme === "kendo"){
            params.kendoType = "kendoDropDownTree";
            params.dataSourceType = "HierarchicalDataSource"; //DEFAULT : DataSource
        }
        super(params);

        this.init();
    }

    init(){
        if(this.theme === "kendo"){

            this.generateKendoSelect();
        }
    }
}
