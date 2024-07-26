class AraCoreFieldEditor extends AraCoreField{
    constructor(params){
        super(params);

        this.init();
    }

    init(){
        if(this.theme === "kendo"){
            this.kendoParams.stylesheets = [
                '/'+COMMON_CSS+'bootstrap.AraCore.min.css',
                '/'+COMMON_CSS+'index.css',
                '/'+COMMON_CSS+'color.css',
                '/'+KENDOUI_ROOT+'css/kendo.bootstrap.min.css',
                '/'+KENDOUI_ROOT+'css/kendo.common-bootstrap.min.css',
                '/'+FONTAWESOME_ROOT+'css/all.css'
            ];
            this.kendoParams.tools  = [
                'bold','italic','underline',
                'undo','redo',
                'justifyLeft','justifyCenter','justifyRight',
                'insertUnorderedList','insertImage',
                'createLink','unlink',
                'tableWizard','tableProperties','tableCellProperties','createTable','addRowAbove','addRowBelow','addColumnLeft','addColumnRight','deleteRow','deleteColumn','mergeCellsHorizontally','mergeCellsVertically','splitCellHorizontally','splitCellVertically','tableAlignLeft','tableAlignCenter','tableAlignRight',
                'formatting',
                {
                    name: 'fontName',
                    items: [
                        { text: 'Andale Mono', value: '\'Andale Mono\'' },
                        { text: 'Arial', value: 'Arial' },
                        { text: 'Arial Black', value: '\'Arial Black\'' },
                        { text: 'Book Antiqua', value: '\'Book Antiqua\'' },
                        { text: 'Comic Sans MS', value: '\'Comic Sans MS\'' },
                        { text: 'Courier New', value: '\'Courier New\'' },
                        { text: 'Georgia', value: 'Georgia' },
                        { text: 'Helvetica', value: 'Helvetica' },
                        { text: 'Impact', value: 'Impact' },
                        { text: 'Symbol', value: 'Symbol' },
                        { text: 'Tahoma', value: 'Tahoma' },
                        { text: 'Terminal', value: 'Terminal' },
                        { text: 'Times New Roman', value: '\'Times New Roman\'' },
                        { text: 'Trebuchet MS', value: '\'Trebuchet MS\'' },
                        { text: 'Verdana', value: 'Verdana' },
                    ]
                },
                'fontSize','foreColor','backColor',
            ];

            if('value' in this.kendoParams)delete this.kendoParams.value;
            if('readonly' in this.kendoParams)delete this.kendoParams.readonly;
            if('enable' in this.kendoParams)delete this.kendoParams.enable;

            AraCore[this.id] = $("#"+this.id).kendoEditor(this.kendoParams).data("kendoEditor");

            if(this.fieldValue) AraCore[this.id].value(value);
            if(this.isReadOnly){
                let editorBody = $(AraCore[this.id].body);
                editorBody.removeAttr("contenteditable").find("a").on("click.readonly", false);
            }
        }

        this.afterInitField();
    }
}
