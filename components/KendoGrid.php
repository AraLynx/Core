<?php
namespace app\components;
use app\core\Component;

class KendoGrid extends Component
{
    protected array $toolbars;
    protected string $toolbarString;
    protected string $excelFileName;
    protected string $pdfFileName;

    protected bool $columnMenu;
    protected bool $filterable;
    protected bool $sortable;
    protected bool $resizable;
    protected bool $groupable;
    protected int $height;

    protected array $columns;

    protected bool $pageable;
    protected bool $pageRefresh;
    protected bool $pageSizes;
    protected int $pageButtonCount;
    protected int $pageSize;

    protected string $rowClass;
    protected string $rowExpand;

    protected bool $isDetailInit;
    protected string $detailInit;
    protected string $detailTemplate;

    protected bool $isAutoFitColumn;
    protected array $autoFitColumns;

    public function __construct(array $params)
    {
        parent::__construct($params["page"]);
        $this->id = $params["id"] ?? "";
        $this->group = $params["group"] ?? "";

        $this->toolbarString = $params["toolbarString"] ?? "";

        if(isset($params["toolbars"]))
            foreach($params["toolbars"] as $index => $toolbar)
                $this->toolbars[] = $toolbar;
        else $this->toolbars = [];

        $this->excelFileName = $params["excelFileName"] ?? "";
            if($this->excelFileName)$this->toolbars[] = "excel";
        $this->pdfFileName = $params["pdfFileName"] ?? "";
            if($this->pdfFileName)$this->toolbars[] = "pdf";

        $this->columnMenu = $params["columnMenu"] ?? true;
        $this->filterable = $params["filterable"] ?? true;
        $this->sortable = $params["sortable"] ?? true;
        $this->resizable = $params["resizable"] ?? true;
        $this->groupable = $params["groupable"] ?? false;
        //$this->height = $params["height"] ?? 500;

        $this->columns = $params["columns"] ?? [];

        $this->pageable = $params["pageable"] ?? true;
        $this->pageRefresh = $params["pageRefresh"] ?? false;
        $this->pageSizes = $params["pageSizes"] ?? false;
        $this->pageButtonCount = $params["pageButtonCount"] ?? 0;
        $this->pageSize = $params["pageSize"] ?? 50;

        $this->rowClass = $params["rowClass"] ?? "RowClass";
        $this->rowExpand = $params["rowExpand"] ?? "x";

        $this->isDetailInit = $params["isDetailInit"] ?? false;
            $this->height = $params["height"] ?? ($this->isDetailInit ? 0 : 500);
        $this->detailInit = $params["detailInit"] ?? "";
        $this->detailTemplate = $params["detailTemplate"] ?? "";

        $this->isAutoFitColumn = $params["isAutoFitColumn"] ?? false;
    }

    #region init
    #endregion init

    #region set status
        public function begin()
        {
            if($this->getStatusCode() != 100){return false;}
            if($this->isBegin){$this->setStatusCode(601);return false;}//Page is already begin
            if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

            $this->isBegin = 1;
            $this->elementId = "{$this->group}KendoGrid{$this->id}";
            $this->html .= "<div id='{$this->elementId}'></div>";
        }
        public function end(string $ItemKeyName = "Items")
        {
            if($this->getStatusCode() != 100) {return false;}
            if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
            if($this->isEnd){$this->setStatusCode(604);return false;}//Page is already ended

            $this->isEnd = 1;

            if($this->isDetailInit)
            {
                $functionName = "kendoGridDetailInit_".($this->app->getCounter());
                $this->globalJS .= "let {$functionName}_options = {";
                    $this->generateColumnMenu();
                    if($this->height)$this->globalJS .= "height: {$this->height},";
                    $this->generateColumns($this->columns);
                    $this->generateDetailInit();
                    $this->generateDataBound();
                $this->globalJS .= "};";
                $this->globalJS .= "function {$functionName}(e){";
                    $this->globalJS .= "{$functionName}_options.dataSource = e.data.{$ItemKeyName};";
                    $this->globalJS .= "$('<div class=\'{$functionName}\'><div/>').appendTo(e.detailCell).kendoGrid({$functionName}_options);";
                $this->globalJS .= "}";

                return $functionName;
            }
            else
            {
                $this->js .= "TDE.{$this->elementId} = $('#{$this->elementId}').kendoGrid({";
                    $this->generateToolbar();
                    $this->generateColumnMenu();
                    if($this->height)$this->js .= "height: {$this->height},";
                    $this->generateColumns($this->columns);
                    $this->generatePageable();
                    $this->generateDetailTemplate();
                    $this->generateDetailInit();
                    $this->generateDataBound();
                $this->js .= "}).data('kendoGrid');";
                $this->generateTDEFunctions();
            }
        }
    #endregion

    #region setting variable
    #endregion setting variable

    #region getting / returning variable
    #endregion  getting / returning variable

    #region data process
        protected function generateToolbar()
        {
            if($this->getStatusCode() != 100) {return false;}
            if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
            if(!$this->isEnd){$this->setStatusCode(604);return false;}//Page is not yet ended

            if($this->toolbarString)
            {
                $this->js .= "toolbar:'{$this->toolbarString}',";
            }
            else if(count($this->toolbars))
            {
                $this->js .= "toolbar:[";
                foreach($this->toolbars AS $index => $toolbar)
                {
                    $this->js .= "'{$toolbar}',";
                }
                $this->js .= "],";

                if($this->excelFileName)$this->js .= "excel: {fileName: '{$this->excelFileName}',allPages: true},";
                if($this->pdfFileName)$this->js .= "pdf: {fileName: '{$this->pdfFileName}',allPages: true},";
            }
        }
        protected function generateColumnMenu()
        {
            if($this->getStatusCode() != 100) {return false;}
            if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
            if(!$this->isEnd){$this->setStatusCode(604);return false;}//Page is not yet ended

            if($this->isDetailInit)
            {
                if($this->columnMenu)$this->globalJS .= "columnMenu: true,";
                if($this->filterable)$this->globalJS .= "filterable: true,";
                if($this->sortable)$this->globalJS .= "sortable: true,";
                if($this->resizable)$this->globalJS .= "resizable: true,";
                if($this->groupable)$this->globalJS .= "groupable: true,";
            }
            else
            {
                if($this->columnMenu)$this->js .= "columnMenu: true,";
                if($this->filterable)$this->js .= "filterable: true,";
                if($this->sortable)$this->js .= "sortable: true,";
                if($this->resizable)$this->js .= "resizable: true,";
                if($this->groupable)$this->js .= "groupable: true,";
            }
        }
        protected function generatePageable()
        {
            if($this->getStatusCode() != 100) {return false;}
            if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
            if(!$this->isEnd){$this->setStatusCode(604);return false;}//Page is not yet ended

            $this->js .= "dataSource:{pageSize: {$this->pageSize}},";

            if($this->pageRefresh || $this->pageSizes || $this->pageButtonCount)
            {
                $this->js .= "pageable: {";
                    if($this->pageRefresh)$this->js .= "refresh: true,";
                    if($this->pageSizes)$this->js .= "pageSizes: true,";
                    if($this->pageButtonCount)$this->js .= "buttonCount: {$this->pageButtonCount},";
                $this->js .= "}";
            }
            else if($this->pageable)$this->js .= "pageable: true,";

        }
        protected function generateColumns(array $columns)
        {
            if($this->getStatusCode() != 100) {return false;}
            if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
            if(!$this->isEnd){$this->setStatusCode(604);return false;}//Page is not yet ended

            if($this->isDetailInit)
            {
                $this->globalJS .= "columns:[";
                foreach($columns AS $index => $column)
                {
                    $field = $column["field"] ?? false;
                    $template = $column["template"] ?? false;
                    $title = $column["title"] ?? str_replace("_"," ",$field);
                    $locked = $column["locked"] ?? false;
                    $formatType = $column["formatType"] ?? false;
                    $formatManual = $column["formatManual"] ?? "";
                    $width = $column["width"] ?? false;
                    $attributes = $column["attributes"] ?? [];
                    $encoded = $column["encoded"] ?? false;

                    $groupable = $column["groupable"] ?? true;
                    $aggregates = $column["aggregates"] ?? [];
                    $groupFooterTemplate = $column["groupFooterTemplate"] ?? "";

                    $headerAttributes = $column["headerAttributes"] ?? [];

                    $childColumns = $column["columns"] ?? [];

                    $this->globalJS .= "{";
                        if($formatType)
                        {
                            if($formatType == "rowNumber")
                            {
                                if(!$width)$width = 50;
                                if(!$title) $title = "No";
                                $template = "#= ++rowNumber #";
                            }
                            else if($formatType == "currency")
                            {
                                $this->globalJS .= "format:'Rp {0:n0}',";
                                if(!isset($attributes["class"]))$attributes["class"] = "text-end";
                                else $attributes["class"] .=" text-end";
                                if(!$width)$width = 120;
                            }
                            else if($formatType == "percentage")
                            {
                                $this->globalJS .= "format:'{0:n2} %',";
                                if(!isset($attributes["class"]))$attributes["class"] = "text-end";
                                else $attributes["class"] .=" text-end";
                                if(!$width)$width = 80;
                            }
                            else if($formatType == "numeric")
                            {
                                $this->globalJS .= "format:'{0:n0}',";
                                if(!isset($attributes["class"]))$attributes["class"] = "text-end";
                                else $attributes["class"] .=" text-end";
                                if(!$width)$width = 80;
                            }
                            else if($formatType == "dec" || $formatType == "decimal")
                            {
                                $this->globalJS .= "format:'{0:n2}',";
                                if(!isset($attributes["class"]))$attributes["class"] = "text-end";
                                else $attributes["class"] .=" text-end";
                                if(!$width)$width = 80;
                            }
                            else if($formatType == "dec4" || $formatType == "decimal4")
                            {
                                $this->globalJS .= "format:'{0:n4}',";
                                if(!isset($attributes["class"]))$attributes["class"] = "text-end";
                                else $attributes["class"] .=" text-end";
                                if(!$width)$width = 100;
                            }
                            else if($formatType == "text-end")
                            {
                                if(!isset($attributes["class"]))$attributes["class"] = "text-end";
                                else $attributes["class"] .=" text-end";
                                if(!$width)$width = 100;
                            }
                            else if($formatType == "numberText")
                            {
                                if(!$width)$width = 170;
                            }
                            else if($formatType == "invoiceNumberText")
                            {
                                if(!$width)$width = 210;
                            }
                            else if($formatType == "date")
                            {
                                if(!$width)$width = 100;
                            }
                            else if($formatType == "time")
                            {
                                if(!$width)$width = 100;
                            }
                            else if($formatType == "dateTime")
                            {
                                if(!$width)$width = 140;
                            }
                            else if($formatType == "faIcon")
                            {
                                if(!$width)$width = 60;
                                if(!isset($attributes["class"]))$attributes["class"] = "text-center";
                                else $attributes["class"] .=" text-center";
                                $encoded = false;
                            }
                            else if($formatType == "action")
                            {
                                //$locked = $column["locked"] ?? true;
                                if(!$field)$field = "Action";
                                if(!$title) $title = " ";
                                if(!$width)$width = 50;
                                if(!isset($attributes["class"]))$attributes["class"] = "text-center";
                                else $attributes["class"] .=" text-center";
                                $encoded = false;
                            }
                        }
                        else if($formatManual)$this->globalJS .= "format:'{$formatManual}',";

                        if($width)$this->globalJS .= "width:{$width},";
                        else $this->autoFitColumns[] = $field;

                        if($title)$this->globalJS .= "title:'{$title}',";

                        if($template)$this->globalJS .= "template:'{$template}',";
                        else if($field)$this->globalJS .= "field:'{$field}',";

                        if($locked && !$this->detailInit && !$this->detailTemplate)
                            $this->globalJS .= "locked:true,";

                        if(count($attributes))
                        {
                            $this->globalJS .= "attributes:{";
                            foreach($attributes AS $attribute => $value)
                            {
                                $this->globalJS .= "'{$attribute}':'{$value}',";
                            }
                            $this->globalJS .= "},";
                        }

                        if(count($headerAttributes))
                        {
                            /*
                            BUGGY
                            krn style yg otomatis dijalankan kendo, letaknya di element dgn class k-header,
                            sedang yang harus di styl ing itu child element dgn class k-link nya

                            jadi harus manual buat css tambahan, contohnya mau tambah [justiry-content-center]

                            Solusi harus manual set ini di CSS file di halaman itu (atau bisa juga taro di chronos : index.css)
                            .k-header.justify-content-center .k-link{
                                justify-content: center;
                            }

                            */
                            $this->globalJS .= "headerAttributes:{";
                            foreach($headerAttributes AS $attribute => $value)
                            {
                                $this->globalJS .= "'{$attribute}':'{$value}',";
                            }
                            $this->globalJS .= "},";
                        }


                        if(!$encoded)$this->globalJS .= "encoded:false,";

                        if($this->groupable)
                        {
                            if(!$groupable) $this->globalJS .= "groupable:{$groupable},";
                            if(count($aggregates))
                            {
                                $this->globalJS .= "aggregates:[";
                                foreach($aggregates AS $index=> $aggregate)
                                {
                                    $this->globalJS .= "{$aggregate},";
                                }
                                $this->globalJS .= "],";
                            }
                            if($groupFooterTemplate) $this->globalJS .= "groupFooterTemplate:{$groupFooterTemplate},";
                        }

                        if(count($childColumns))
                        {
                            $this->generateColumns($childColumns);
                        }
                    $this->globalJS .= "},";
                }
                $this->globalJS .= "],";
            }
            else
            {
                $this->js .= "columns:[";
                foreach($columns AS $index => $column)
                {
                    $field = $column["field"] ?? false;
                    $template = $column["template"] ?? false;
                    $title = $column["title"] ?? str_replace("_"," ",$field);
                    $locked = $column["locked"] ?? false;
                    $formatType = $column["formatType"] ?? false;
                    $formatManual = $column["formatManual"] ?? "";
                    $width = $column["width"] ?? false;
                    $attributes = $column["attributes"] ?? [];
                    $encoded = $column["encoded"] ?? false;

                    $groupable = $column["groupable"] ?? true;
                    $aggregates = $column["aggregates"] ?? [];
                    $groupFooterTemplate = $column["groupFooterTemplate"] ?? "";

                    $headerAttributes = $column["headerAttributes"] ?? [];

                    $childColumns = $column["columns"] ?? [];

                    $this->js .= "{";
                        if($formatType)
                        {
                            if($formatType == "rowNumber")
                            {
                                if(!$width)$width = 50;
                                if(!$title) $title = "No";
                                $template = "#= ++rowNumber #";
                                if(!isset($attributes["class"]))$attributes["class"] = "text-end";
                                else $attributes["class"] .=" text-end";
                            }
                            else if($formatType == "currency")
                            {
                                $this->js .= "format:'Rp {0:n0}',";
                                if(!isset($attributes["class"]))$attributes["class"] = "text-end";
                                else $attributes["class"] .=" text-end";
                                if(!$width)$width = 120;
                            }
                            else if($formatType == "percentage")
                            {
                                $this->js .= "format:'{0:n2} %',";
                                if(!isset($attributes["class"]))$attributes["class"] = "text-end";
                                else $attributes["class"] .=" text-end";
                                if(!$width)$width = 80;
                            }
                            else if($formatType == "numeric")
                            {
                                $this->js .= "format:'{0:n0}',";
                                if(!isset($attributes["class"]))$attributes["class"] = "text-end";
                                else $attributes["class"] .=" text-end";
                                if(!$width)$width = 80;
                            }
                            else if($formatType == "dec" || $formatType == "decimal")
                            {
                                $this->js .= "format:'{0:n2}',";
                                if(!isset($attributes["class"]))$attributes["class"] = "text-end";
                                else $attributes["class"] .=" text-end";
                                if(!$width)$width = 80;
                            }
                            else if($formatType == "dec4" || $formatType == "decimal4")
                            {
                                $this->js .= "format:'{0:n4}',";
                                if(!isset($attributes["class"]))$attributes["class"] = "text-end";
                                else $attributes["class"] .=" text-end";
                                if(!$width)$width = 100;
                            }
                            else if($formatType == "text-end")
                            {
                                if(!isset($attributes["class"]))$attributes["class"] = "text-end";
                                else $attributes["class"] .=" text-end";
                                if(!$width)$width = 100;
                            }
                            else if($formatType == "numberText")
                            {
                                if(!$width)$width = 170;
                            }
                            else if($formatType == "invoiceNumberText")
                            {
                                if(!$width)$width = 210;
                            }
                            else if($formatType == "date")
                            {
                                if(!$width)$width = 100;
                            }
                            else if($formatType == "time")
                            {
                                if(!$width)$width = 100;
                            }
                            else if($formatType == "dateTime")
                            {
                                if(!$width)$width = 140;
                            }
                            else if($formatType == "faIcon")
                            {
                                if(!$width)$width = 60;
                                if(!isset($attributes["class"]))$attributes["class"] = "text-center";
                                else $attributes["class"] .=" text-center";
                                $encoded = false;
                            }
                            else if($formatType == "action")
                            {
                                //$locked = $column["locked"] ?? true;
                                if(!$field)$field = "Action";
                                if(!$title) $title = " ";
                                if(!$width)$width = 50;
                                if(!isset($attributes["class"]))$attributes["class"] = "text-center";
                                else $attributes["class"] .=" text-center";
                                $encoded = false;
                            }
                        }
                        else if($formatManual)$this->js .= "format:'{$formatManual}',";

                        if($width)$this->js .= "width:{$width},";
                        else $this->autoFitColumns[] = $field;

                        if($title)$this->js .= "title:'{$title}',";

                        if($template)$this->js .= "template:'{$template}',";
                        else if($field)$this->js .= "field:'{$field}',";

                        if($locked && !$this->detailInit && !$this->detailTemplate)
                            $this->js .= "locked:true,";

                        if(count($attributes))
                        {
                            $this->js .= "attributes:{";
                            foreach($attributes AS $attribute => $value)
                            {
                                $this->js .= "'{$attribute}':'{$value}',";
                            }
                            $this->js .= "},";
                        }

                        if(count($headerAttributes))
                        {
                            /*
                            BUGGY
                            krn style yg otomatis dijalankan kendo, letaknya di element dgn class k-header,
                            sedang yang harus di styl ing itu child element dgn class k-link nya

                            jadi harus manual buat css tambahan, contohnya mau tambah [justiry-content-center]

                            Solusi harus manual set ini di CSS file di halaman itu (atau bisa juga taro di chronos : index.css)
                            .k-header.justify-content-center .k-link{
                                justify-content: center;
                            }

                            */
                            $this->js .= "headerAttributes:{";
                            foreach($headerAttributes AS $attribute => $value)
                            {
                                $this->js .= "'{$attribute}':'{$value}',";
                            }
                            $this->js .= "},";
                        }


                        if(!$encoded)$this->js .= "encoded:false,";

                        if($this->groupable)
                        {
                            if(!$groupable) $this->js .= "groupable:{$groupable},";
                            if(count($aggregates))
                            {
                                $this->js .= "aggregates:[";
                                foreach($aggregates AS $index=> $aggregate)
                                {
                                    $this->js .= "{$aggregate},";
                                }
                                $this->js .= "],";
                            }
                            if($groupFooterTemplate) $this->js .= "groupFooterTemplate:{$groupFooterTemplate},";
                        }

                        if(count($childColumns))
                        {
                            $this->generateColumns($childColumns);
                        }
                    $this->js .= "},";
                }
                $this->js .= "],";
            }
        }
        protected function generateDataBound()
        {
            if($this->getStatusCode() != 100) {return false;}
            if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
            if(!$this->isEnd){$this->setStatusCode(604);return false;}//Page is not yet ended

            if($this->isDetailInit)
            {
                $this->globalJS .= "dataBound: function(e) {";
                    if($this->rowExpand == "all")$this->globalJS .= "this.expandRow(this.tbody.find('tr.k-master-row'));";
                    else if($this->rowExpand == "first")$this->globalJS .= "this.expandRow(this.tbody.find('tr.k-master-row').first());";
                    $this->globalJS .= "$.each(this.dataSource.data(), function (i, row) {";
                        $this->globalJS .= "$('tr[data-uid=\"' + row.uid + '\"]').addClass('k-grid-border-bottom');";

                        $this->globalJS .= "if (row.hasOwnProperty('RowClass')) {";
                            $this->globalJS .= "$('tr[data-uid=\"' + row.uid + '\"]').addClass(row.RowClass);";
                        $this->globalJS .= "}";
                    $this->globalJS .= "});";

                    if($this->isAutoFitColumn) {
                        foreach ($this->autoFitColumns as $column) {
                            $this->globalJS .= "this.autoFitColumn('{$column}');";
                        }
                    }
                $this->globalJS .= "},";

                $this->globalJS .= "dataBinding: function() {";
                    $this->globalJS .= "rowNumber = (this.dataSource.page() -1) * this.dataSource.pageSize();";
                $this->globalJS .= "}";
            }
            else
            {
                $this->js .= "dataBound: function(e) {";
                    if($this->rowExpand == "all")$this->js .= "this.expandRow(this.tbody.find('tr.k-master-row'));";
                    else if($this->rowExpand == "first")$this->js .= "this.expandRow(this.tbody.find('tr.k-master-row').first());";
                    $this->js .= "$.each(this.dataSource.data(), function (i, row) {";
                        $this->js .= "$('tr[data-uid=\"' + row.uid + '\"]').addClass('k-grid-border-bottom');";

                        $this->js .= "if (row.hasOwnProperty('RowClass')) {";
                            $this->js .= "$('tr[data-uid=\"' + row.uid + '\"]').addClass(row.RowClass);";
                        $this->js .= "}";
                    $this->js .= "});";

                    if($this->isAutoFitColumn) {
                        foreach ($this->autoFitColumns as $column) {
                            $this->js .= "this.autoFitColumn('{$column}');";
                        }
                    }
                $this->js .= "},";

                $this->js .= "dataBinding: function() {";
                    $this->js .= "rowNumber = (this.dataSource.page() -1) * this.dataSource.pageSize();";
                $this->js .= "}";
            }
        }
        protected function generateDetailTemplate()
        {
            if($this->getStatusCode() != 100) {return false;}
            if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
            if(!$this->isEnd){$this->setStatusCode(604);return false;}//Page is not yet ended

            //if($this->detailTemplate)$this->js .= "detailTemplate : '{$this->detailTemplate}',";
        }
        protected function generateDetailInit()
        {
            if($this->getStatusCode() != 100) {return false;}
            if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
            if(!$this->isEnd){$this->setStatusCode(604);return false;}//Page is not yet ended

            if($this->detailInit)
                if($this->isDetailInit)
                    $this->globalJS .= "detailInit : {$this->detailInit},";
                else
                    $this->js .= "detailInit : {$this->detailInit},";
        }
        protected function generateTDEFunctions()
        {
            if($this->getStatusCode() != 100) {return false;}
            if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
            if(!$this->isEnd){$this->setStatusCode(604);return false;}//Page is not yet ended

            //POPULATE
            $this->js .= "TDE.{$this->elementId}.populate = function(datas){";
                //SAVE SETTINGAN SETIAP SUB GRID BERDASARKAN ID, BARIS MANA SAJA YG TERBUKA DAN TERTUTUP
                if($this->detailInit)
                {
                    $this->js .= "let rowIdDisplays = {};
                        let existingDataSource = $('#{$this->elementId}').data().kendoGrid.dataSource.view();
                        if(existingDataSource.length){
                            let firstData = existingDataSource[0];
                            if('Id' in firstData){
                                //COLUMN NAME [Id] EXIST

                                let rowUidToIds = {};
                                for(row of existingDataSource){
                                    let id = row.Id;
                                    let rowUid = row.uid;
                                    rowUidToIds[rowUid] = id;
                                }

                                $('#{$this->elementId} .k-master-row').each(function( index ) {
                                    let rowUid = $(this).attr('data-uid');
                                    let display = 'none';
                                    if($(this).next('tr.k-detail-row').length){
                                        display = $(this).next('tr.k-detail-row').css('display');
                                    }
                                    if(rowUidToIds[rowUid])
                                        rowIdDisplays[rowUidToIds[rowUid]] = display;
                                });
                            }
                        };";
                }
                //THE REAL POPULATE FUNCTION
                $this->js .= "TDE.{$this->elementId}.dataSource.data(datas);";

                //KLO ADA LOCKED COLUMN, HEIGHT NYA KEPOTONG SETINGGI HEADER, JADI ADA GAP WHITE SPACE DI BAWAH TIAP SUBGRID, NEED FUTHER INVESTIGATION
                if($this->detailInit){
                    $this->js .= "let hasLockedColumn = false;
                        //DIBUKA SEMUA
                        $('#{$this->elementId} .k-master-row').each(function( index ) {
                            TDE.{$this->elementId}.expandRow(this);
                        });

                        //CEK ADA LOCKED COLUMN TIDAK
                        $('.{$this->detailInit}').each(function () {
                            if($(this).find('div.k-grid-content-locked').length !== 0){
                                hasLockedColumn = true;
                            };
                        });

                        //READJUST HEIGHT KLO ADA LOCKED COLUMN
                        if(hasLockedColumn){
                            $('.{$this->detailInit} .k-grid-content-locked').each(function () {
                                $(this).height($(this).height()+$(this).prev().height());
                            });
                            $('.{$this->detailInit} .k-grid-content').each(function () {
                                $(this).height($(this).height()+$(this).prev().prev().height());
                            });
                        };

                        //DITUTUP SEMUA
                        $('#{$this->elementId} .k-master-row').each(function( index ) {
                            TDE.{$this->elementId}.collapseRow(this);
                        });";
                }

                //RESTORE SETTINGAN SETIAP SUB GRID BERDASARKAN ID, BARIS MANA SAJA YG TERBUKA DAN TERTUTUP
                if($this->detailInit)
                {
                    $this->js .= "if(datas.length){
                            let firstData = datas[0];
                            if('Id' in firstData){
                                //COLUMN NAME [Id] EXIST
                                let newDataSource = $('#{$this->elementId}').data().kendoGrid.dataSource.view();

                                let rowUidToIds = {};
                                for(row of newDataSource){
                                    let id = row.Id;
                                    let rowUid = row.uid;
                                    rowUidToIds[rowUid] = id;
                                }

                                $('#{$this->elementId} .k-master-row').each(function( index ) {
                                    let rowUid = $(this).attr('data-uid');
                                    let display = rowIdDisplays[rowUidToIds[rowUid]];
                                    if(display === 'table-row'){
                                        TDE.{$this->elementId}.expandRow(this);
                                    }
                                });
                            }
                        }";
                }

                //BALIK KE PAGE 1 KALAU DATA NYA SEDIKIT
                $this->js .= "let nowPage = TDE.{$this->elementId}.dataSource.page();
                    let dataLength = datas.length;
                    if(!datas.length || Math.ceil(dataLength / {$this->pageSize}) < nowPage){
                        TDE.{$this->elementId}.dataSource.page(1);
                    }";
            $this->js .= "};";

            //DETAIL INIT SET OPTIONS
            $this->js .= "TDE.{$this->elementId}.detailInitSetOptions = function(params){";
                if($this->detailInit)
                {
                    $this->js .= "for(key in params){
                            {$this->detailInit}_options[key] = params[key];
                        };";

                    //UNTUK YG SUDAH TERLANJUT TERBUKA, DI UPDATE JUGA
                    /*
                    $this->js .= "$('.{$this->detailInit}').each(function () {
                            $(this).data('kendoGrid').setOptions({$this->detailInit}_options);
                        });";
                    */
                }
                else
                {
                    $this->js .= "alert('detailInitSetOptions fn can only be used with detailInit initiated');";
                }
            $this->js .= "};";
        }
    #endregion data process
}
