<?php
namespace app\components\fields;
use app\components\fields\Field;

class Select extends Field
{
    /*Field Child Properties*/
    //protected string|int|array $childProperty;
    protected string $typeDetail;
    protected array $selectParams;

    /*Field Custom Attributes*/
    //protected string|int|array $customFieldAttribute;

    /*customJsObjParam*/
    //protected string|int|array $customJsObjParam;
    protected string $dataTextField;
    protected string $dataValueField;
    protected int $heightInPixel;
    protected string $filter;
    protected array $options;
    protected string $headerTemplate;
    protected string $footerTemplate;
    protected string $template;

    protected bool|string $onFiltering;
    protected bool|string $onSelect;

    public function __construct(array $params)
    {
        parent::__construct($params);

        /*Field Properties*/
        $this->elementTag = "input";
        $this->jsClassName = "TDEFieldDropDownList";

        /*Field Child Properties*/
        //$this->childProperty = $params["childProperty"] ?? "";
        $this->typeDetail = $params["selectTypeDetail"] ?? "";

        /*Field Custom Element Attributes*/
        //$this->customFieldAttribute = $params["customFieldAttribute"] ?? "";

        /*customJsObjParam*/
        //$this->customJsObjParam = $params["customJsObjParam"] ?? "";
        $this->dataTextField = $params["selectTextField"] ?? "Text";
        $this->dataValueField = $params["selectValueField"] ?? "Value";
        $this->heightInPixel = $params["selectListHeight"] ?? 350;
        $this->filter = $params["selectFilter"] ?? "contains";
        $this->options = $params["selectOptions"] ?? [];

        $this->headerTemplate = $params["selectHeaderTemplate"] ?? "";
        $this->footerTemplate = $params["selectFooterTemplate"] ?? "";
        $this->template = $params["selectTemplate"] ?? "";

        $this->onFiltering = $params["selectFiltering"] ?? false;
        $this->onSelect = $params["selectSelect"] ?? false;

        // SPECIAL SELECT
        $this->selectParams = [];
        switch($this->typeDetail){
            case "monthYearPicker" : $this->construct_MonthYearPicker($params);break;
            case "cbpPicker" : $this->construct_CBPPicker($params);break;
        }

        $this->selectInit();
    }
        protected function construct_MonthYearPicker($params = [])
        {
            $this->selectParams["templates"] = $params["selectTemplates"] ?? ["month","year"];
            $this->selectParams["yearMin"] = $params["selectYearMin"] ?? 2015;
            $this->selectParams["yearMax"] = $params["selectYearMax"] ?? (int)date("Y");
        }
        protected function construct_CBPPicker($params = [])
        {
            $this->selectParams["templates"] =  $params["selectTemplates"] ?? ["brand","company","branch","pos"];
            $this->selectParams["isAddAll"] = $params["selectCBPIsAddAll"] ?? false;
            $this->selectParams["cabangPOSes"] = $params["selectCBPCabangPOSes"] ?? [1,2,3];
            $this->selectParams["isWS"] = $params["selectCBPIsWS"] ?? false;
            $this->selectParams["isSH"] = $params["selectCBPIsSH"] ?? false;
            $this->selectParams["filters"] = $params["selectCBPFilters"] ?? [];
            $this->selectParams["hiddenInputTemplate"] = "";
            $this->selectParams["isHO"] = $params["cbpPickerIsHO"] ?? false;//MUNCUL DI PICKER Brand
            $this->selectParams["onChangeArray"] = $params["inputOnChangeArray"] ?? false;
        }
#region init
    protected function selectInit()
    {
        if($this->getStatusCode() != 100){return false;}
        switch($this->typeDetail){
            case "monthYearPicker" : $this->selectInit_MonthYearPicker();break;
            case "cbpPicker" : $this->selectInit_CBPPicker();break;
            default : $this->selectInit_();
        }
    }
        protected function selectInit_(){}
    //#region selectInit_MonthYearPicker
        protected function selectInit_MonthYearPicker()
        {
            [$monthValue, $yearValue] = $this->selectInit_MonthYearPicker_getMonthYearValue();
            $this->selectInit_MonthYearPicker_generateOptions($monthValue, $yearValue);
        }
            protected function selectInit_MonthYearPicker_getMonthYearValue()
            {
                $monthValue = (int)date("m");
                $yearValue = (int)date("Y");
                if(in_array($this->value, ["today", "this month"]))
                {
                    $monthValue = (int)date("m");
                    $yearValue = (int)date("Y");
                }
                else if($this->value == "this year")
                {
                    $monthValue = 1;
                    $yearValue = (int)date("Y");
                }
                else if($this->value == "end year")
                {
                    $monthValue = 12;
                    $yearValue = (int)date("Y");
                }
                else if($this->value == "all year")
                {
                    $monthValue = "*";
                    $yearValue = "*";
                }
                return [$monthValue,$yearValue];
            }
            protected function selectInit_MonthYearPicker_generateOptions($monthValue, $yearValue)
            {
                $this->options = [];
                if(in_array("year",$this->selectParams["templates"]))
                {
                    $template = "year";
                    $this->options[$template] = [];
                    if($this->value == "all year")
                    {
                        $this->options[$template][] = ["*", "All Year", "*" == $yearValue];
                    }
                    for($year = $this->selectParams["yearMax"] ; $year > $this->selectParams["yearMin"] ; $year--)
                    {
                        $this->options[$template][] = [$year, $year, $year == $yearValue];
                    }
                }
                if(in_array("month",$this->selectParams["templates"]))
                {
                    $template = "month";
                    $this->options[$template] = [
                        [1, "January", 1 == $monthValue]
                        ,[2, "February", 2 == $monthValue]
                        ,[3, "March", 3 == $monthValue]
                        ,[4, "April", 4 == $monthValue]
                        ,[5, "May", 5 == $monthValue]
                        ,[6, "June", 6 == $monthValue]
                        ,[7, "July", 7 == $monthValue]
                        ,[8, "August", 8 == $monthValue]
                        ,[9, "September", 9 == $monthValue]
                        ,[10, "October", 10 == $monthValue]
                        ,[11, "November", 11 == $monthValue]
                        ,[12, "December", 12 == $monthValue]
                    ];
                }
            }
    //#endregion selectInit_MonthYearPicker

    //#region selectInit_CBPPicker
        protected function selectInit_CBPPicker()
        {
            [$isAddAllBrand, $isAddAllCompany, $isAddAllBranch, $isAddAllPOS] = $this->selectInit_CBPPicker_getIsAddAll();
            $this->selectParams["isAddAllBrand"] = $isAddAllBrand;
            $this->selectParams["isAddAllCompany"] = $isAddAllCompany;
            $this->selectParams["isAddAllBranch"] = $isAddAllBranch;
            $this->selectParams["isAddAllPOS"] = $isAddAllPOS;
        }
            protected function selectInit_CBPPicker_getIsAddAll()
            {
                /* SHOW ALL OPTION */
                $isAddAllBrand = false;
                $isAddAllCompany = false;
                $isAddAllBranch = false;
                $isAddAllPOS = false;

                if(is_bool($this->selectParams["isAddAll"]))
                {
                    $isAddAllBrand = $this->selectParams["isAddAll"];
                    $isAddAllCompany = $this->selectParams["isAddAll"];
                    $isAddAllBranch = $this->selectParams["isAddAll"];
                    $isAddAllPOS = $this->selectParams["isAddAll"];
                }
                else if(is_array($this->selectParams["isAddAll"]))
                {
                    if(in_array("brand",$this->selectParams["isAddAll"]))$isAddAllBrand = true;
                    if(in_array("company",$this->selectParams["isAddAll"]))$isAddAllCompany = true;
                    if(in_array("branch",$this->selectParams["isAddAll"]))$isAddAllBranch = true;
                    if(in_array("pos",$this->selectParams["isAddAll"]))$isAddAllPOS = true;
                }

                return [$isAddAllBrand, $isAddAllCompany, $isAddAllBranch, $isAddAllPOS];
            }
    //#endregion selectInit_MonthYearPicker
#endregion init

#region set status
    public function begin()
    {
        parent::begin();

        //$this->generateSelectCustomFieldAttributes();
        $this->generateSelectCustomJsObjParams();
    }
    public function end()
    {
        parent::end();
    }
#endregion

#region setting variable
#endregion setting variable

#region getting / returning variable
#endregion  getting / returning variable

#region data process
    public function doSometing()
    {
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended
        /*
        DO SOMETHING HERE
        */
    }
    public function doSometingAfterEnd()
    {
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if(!$this->isEnd){$this->setStatusCode(604);return false;}//Page is not yet ended
        /*
        DO SOMETHING HERE
        */
    }
    protected function generateSelectCustomFieldAttributes()
    {
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        //if($this->customFieldAttribute)$this->customFieldAttributes[] = ["key" => "customFieldAttribute","value" => $this->customFieldAttribute];
    }
    protected function generateSelectCustomJsObjParams()
    {
        if($this->getStatusCode() != 100){return false;}
        if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        //if($this->customJsObjParam)$this->customJsObjParams[] = ["key" => "customJsObjParam","value" => "'{$this->customJsObjParam}'"];
        if($this->typeDetail)$this->customJsObjParams[] = ["key" => "typeDetail","value" => "'{$this->typeDetail}'"];
        if($this->dataTextField)$this->customJsObjParams[] = ["key" => "dataTextField","value" => "'{$this->dataTextField}'"];
        if($this->dataValueField)$this->customJsObjParams[] = ["key" => "dataValueField","value" => "'{$this->dataValueField}'"];
        if($this->heightInPixel)$this->customJsObjParams[] = ["key" => "heightInPixel","value" => "{$this->heightInPixel}"];
        if($this->filter)$this->customJsObjParams[] = ["key" => "filter","value" => "'{$this->filter}'"];
        if($this->options)$this->customJsObjParams[] = ["key" => "options","value" => json_encode($this->options)];
        if($this->headerTemplate)$this->customJsObjParams[] = ["key" => "headerTemplate","value" => "'{$this->headerTemplate}'"];
        if($this->footerTemplate)$this->customJsObjParams[] = ["key" => "footerTemplate","value" => "'{$this->footerTemplate}'"];
        if($this->template)$this->customJsObjParams[] = ["key" => "template","value" => "'{$this->template}'"];
        if($this->onFiltering)
        {
            if(is_string($this->onFiltering))$onFilteringFunction = "{$this->onFiltering}";
            else $onFilteringFunction = "{$this->id}Filtering";
            $this->customJsObjParams[] = ["key" => "onFiltering","value" => "'{$onFilteringFunction}'"];
        }
        if($this->onSelect)
        {
            if(is_string($this->onSelect))$onSelectFunction = "{$this->onSelect}";
            else $onSelectFunction = "{$this->id}Select";
            $this->customJsObjParams[] = ["key" => "onSelect","value" => "'{$onSelectFunction}'"];
        }

        switch($this->typeDetail){
            case "monthYearPicker" : $this->generateSelectCustomJsObjParams_MonthYearPicker();break;
            case "cbpPicker" : $this->generateSelectCustomJsObjParams_CBPPicker();break;
            default : $this->generateSelectCustomJsObjParams_();
        }
    }
        protected function generateSelectCustomJsObjParams_(){}
        protected function generateSelectCustomJsObjParams_MonthYearPicker(){
            $additionalParams["templates"] = $this->selectParams["templates"];

            if(count($this->selectParams))$this->customJsObjParams[] = ["key" => "additionalParams","value" => json_encode($additionalParams)];
        }
        protected function generateSelectCustomJsObjParams_CBPPicker(){
            $additionalParams["templates"] = $this->selectParams["templates"];
            $additionalParams["onChangeArrayFunctions"] = $this->generateField_CBPPicker_getOnChangeFunctions();

            if(count($this->selectParams))$this->customJsObjParams[] = ["key" => "additionalParams","value" => json_encode($additionalParams)];

        }
    protected function generateField($params = [])
    {
        switch($this->typeDetail){
            case "monthYearPicker" : $this->generateField_MonthYearPicker($params);break;
            case "cbpPicker" : $this->generateField_CBPPicker($params);break;
            default : parent::generateField($params);
        }
    }
        protected function generateField_MonthYearPicker($params = [])
        {
            if($this->getStatusCode() != 100){return false;}
            if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
            if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

            $isHtml = $params["isHtml"] ?? true;
            $isJs = $params["isJs"] ?? true;

            if($isHtml)
            {
                $this->html .= "<div class='col-lg-{$this->col}'>";
                    $this->html .= "<div class='d-lg-flex justify-content-between'>";
                        $inputGroupCount = count($this->fieldGroups);

                        foreach($this->fieldGroups AS $fieldGroup)
                        {
                            $this->generateId($fieldGroup);
                            $this->generateName($fieldGroup);

                            $this->html .= "<div style='width:calc(100%/{$inputGroupCount});'>";
                                foreach($this->selectParams["templates"] AS $index => $template)
                                {
                                    if($index) $this->html .= " ";//for spacer

                                    if($template == "year")
                                    {
                                        $sufix = "Year";
                                        $this->style .= ";width:7.3rem";
                                    }
                                    if($template == "month")
                                    {
                                        $sufix = "Month";
                                        $this->style .= ";width:11rem";
                                    }
                                    $this->generateFieldElement(["sufix" => $sufix]);
                                }
                                $this->generateFieldInvalidFeedback();
                                $this->html .= $this->getCustomFieldEndHtml();
                            $this->html .= "</div>";

                            if($isJs)
                            {
                                $this->generateFieldJs();
                            }
                        }
                    $this->html .= "</div>";
                $this->html .= "</div>";
            }
        }
        protected function generateField_CBPPicker($params = [])
        {
            if($this->getStatusCode() != 100){return false;}
            if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
            if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

            $this->selectParams["qParam"] = $this->generateField_CBPPicker_getQueryParam();

            $isHtml = $params["isHtml"] ?? true;
            $isJs = $params["isJs"] ?? true;

            if($isHtml)
            {
                $this->html .= "<div class='col-lg-{$this->col}'>";
                    $this->html .= "<div class='d-lg-flex justify-content-between'>";
                        $inputGroupCount = count($this->fieldGroups);

                        foreach($this->fieldGroups AS $fieldGroup)
                        {
                            $this->generateId($fieldGroup);
                            $this->generateName($fieldGroup);

                            $this->html .= "<div style='width:calc(100%/{$inputGroupCount});'>";

                                $SP = new \app\core\StoredProcedure('uranus');

                                $loopCounter = 0;
                                $firstTemplate = "";

                                $isBrand = 0;
                                $isCompany = 0;
                                $isBranch = 0;
                                $isPOS = 0;
                                $hiddenInputTemplate = "";
                                $query = "";
                                $showOptionAll = "";
                                $options = [];

                                foreach($this->selectParams["templates"] AS $index => $template)
                                {
                                    if($index) $this->html .= " ";//for spacer
                                    $loopCounter = $index+1;
                                    if(!$index) $firstTemplate = $template;
                                    $template = ucfirst(strtolower($template));/*Capitalize 1st letter*/

                                    if($template == "Pos")$template = "POS";

                                    $sufix = "{$template}Id";

                                    $ListOfDatas = [];
                                    $valueColumnNames = [];
                                    $columnKeys = [];

                                    if($template == "Brand")
                                    {
                                        $isBrand = $loopCounter;
                                        $hiddenInputTemplate .= "b";
                                        $this->style .= ";width:11rem";

                                        $ListOfDatas = [];
                                        if($this->selectParams["isHO"])$ListOfDatas[] = ["Id" => 99, "CompanyId" => 0, "Name" => "HEAD OFFICE"];

                                        $q = "EXEC [SP_Sys_Form_GetDBrand]{$this->selectParams["qParam"]}";
                                        $SP->SPPrepare($q);
                                        $SP->addSanitation("Id",["int"]);
                                        $SP->addSanitation("Name",["string"]);
                                        $SP->addSanitation("CompanyId",["int"]);
                                        $SP->execute();
                                        $ListOfDatas = array_merge($ListOfDatas,$SP->getRow());

                                        if($isCompany)$columnKeys[] = "CompanyId";//COMPANY DULUAN

                                        if($isCompany && $isCompany < $isBrand)$valueColumnNames[] = "CompanyId";
                                        $valueColumnNames[] = "Id";

                                        $showOptionAll = $this->selectParams["isAddAllBrand"];
                                    }
                                    else if($template == "Company")
                                    {
                                        $isCompany = $loopCounter;
                                        $hiddenInputTemplate .= "c";
                                        $this->style .= ";width:18.2rem";

                                        $q = "EXEC [SP_Sys_Form_GetDCompany]{$this->selectParams["qParam"]}";
                                        $SP->SPPrepare($q);
                                        $SP->addSanitation("Id",["int"]);
                                        $SP->addSanitation("BrandId",["int"]);
                                        $SP->addSanitation("Alias",["string"]);
                                        $SP->addSanitation("Name",["string"]);
                                        $SP->execute();
                                        $ListOfDatas = $SP->getRow();

                                        if($isBrand)$columnKeys[] = "BrandId";//BRAND DULUAN

                                        if($isBrand && $isBrand < $isCompany)$valueColumnNames[] = "BrandId";
                                        $valueColumnNames[] = "Id";

                                        $showOptionAll = $this->selectParams["isAddAllCompany"];
                                    }
                                    else if($template == "Branch")
                                    {
                                        $isBranch = $loopCounter;
                                        $this->style .= ";width:18.2rem";

                                        $q = "EXEC [SP_Sys_Form_GetDBranch]{$this->selectParams["qParam"]}";
                                        $SP->SPPrepare($q);
                                        $SP->addSanitation("Id",["int"]);
                                        $SP->addSanitation("CompanyId",["int"]);
                                        $SP->addSanitation("BrandId",["int"]);
                                        $SP->addSanitation("Alias",["string"]);
                                        $SP->addSanitation("Name",["string"]);
                                        $SP->execute();
                                        $ListOfDatas = $SP->getRow();

                                        if($isBrand && $isCompany)
                                        {
                                            if($isBrand < $isCompany)
                                            {
                                                $columnKeys[] = "BrandId";
                                                $columnKeys[] = "CompanyId";
                                            }
                                            else
                                            {
                                                $columnKeys[] = "CompanyId";
                                                $columnKeys[] = "BrandId";
                                            }
                                        }
                                        else if($isBrand)$columnKeys[] = "BrandId";
                                        else if($isCompany)$columnKeys[] = "CompanyId";

                                        $valueColumnNames[] = "Id";

                                        $showOptionAll = $this->selectParams["isAddAllBranch"];
                                    }
                                    else if($template == "POS")
                                    {
                                        $isPOS = $loopCounter;
                                        $this->style .= ";width:25rem";

                                        $q = "EXEC [SP_Sys_Form_GetDPOS]{$this->selectParams["qParam"]}";
                                        $SP->SPPrepare($q);
                                        $SP->addSanitation("Id",["int"]);
                                        $SP->addSanitation("CompanyId",["int"]);
                                        $SP->addSanitation("BrandId",["int"]);
                                        $SP->addSanitation("BranchId",["int"]);
                                        $SP->addSanitation("Alias",["string"]);
                                        $SP->addSanitation("Name",["string"]);
                                        $SP->addSanitation("CabangPOS",["int"]);
                                        $SP->execute();
                                        $ListOfDatas = $SP->getRow();

                                        if($isBranch)$columnKeys[] = "BranchId";
                                        else if($isBrand && $isCompany)
                                        {
                                            if($isBrand < $isCompany)
                                            {
                                                $columnKeys[] = "BrandId";
                                                $columnKeys[] = "CompanyId";
                                            }
                                            else
                                            {
                                                $columnKeys[] = "CompanyId";
                                                $columnKeys[] = "BrandId";
                                            }
                                        }
                                        else if($isBrand)$columnKeys[] = "BrandId";
                                        else if($isCompany)$columnKeys[] = "CompanyId";

                                        $valueColumnNames[] = "Id";

                                        $showOptionAll = $this->selectParams["isAddAllPOS"];
                                    }

                                    if(count($columnKeys))
                                    {
                                        //ADA SELECT BOX SEBELUMNYA, BUAT OBJECT OPSI SELECT BERDASARKAN KEY SEBELUMNYA
                                        //if($template == "Branch")dd($ListOfDatas);
                                        $Helper = new \app\TDEs\DataTableHelper();
                                        $Helper->addDatas("data", $ListOfDatas);
                                        $Helper->generateKeyData("data", $columnKeys);
                                        $ListOfDatas = $Helper->getSavedData("dataWithKey", false);
                                        //if($template == "Branch")dd($ListOfDatas);
                                        foreach($ListOfDatas AS $key => $datas)
                                        {
                                            $ListOfDatas[$key] = [];
                                            $Helper = new \app\TDEs\KendoComboBoxHelper();
                                            $Helper->addDatas($template, $datas);
                                            $Helper->convertData($template, [$valueColumnNames,"Name"], $showOptionAll);
                                            $ListOfDatas[$key] = $Helper->getSavedData($template);
                                        }
                                        //if($template == "Branch")dd($template,$datas,$valueColumnNames,$showOptionAll);
                                        //if($template == "Branch")dd($ListOfDatas);
                                    }
                                    else
                                    {
                                        //1st SELECT, TIDAK PERLU BUAT OBJECT OPSI DGN KEY
                                        $Helper = new \app\TDEs\KendoComboBoxHelper();
                                        $Helper->addDatas($template, $ListOfDatas);
                                        $Helper->convertData($template, [$valueColumnNames,"Name"], $showOptionAll);
                                        $ListOfDatas = $Helper->getSavedData($template);
                                    }
                                    $options[$template] = $ListOfDatas;

                                    $this->generateFieldElement(["sufix" => $sufix]);
                                }

                                /*insert CbpTemplate*/
                                //$elementId = "{$this->id}CbpTemplate";
                                $elementName = "{$this->name}CbpTemplate";
                                $this->html .= "<input name='{$elementName}' type='hidden' form='{$this->formElementId}' value='{$hiddenInputTemplate}'/>";

                                /*insert CbpFilterBrandIds */
                                $brandIds = $this->selectParams["filters"]["brandIds"] ?? [];
                                $companyIds = $this->selectParams["filters"]["companyIds"] ?? [];
                                $branchIds = $this->selectParams["filters"]["branchIds"] ?? [];
                                $posIds = $this->selectParams["filters"]["posIds"] ?? [];
                                foreach($brandIds AS $id)
                                {
                                    $this->html .= "<input name='{$this->name}CbpFilterBrandIds[]' type='hidden' form='{$this->formElementId}' value='{$id}'/>";
                                }
                                foreach($companyIds AS $id)
                                {
                                    $this->html .= "<input name='{$this->name}CbpFilterCompanyIds[]' type='hidden' form='{$this->formElementId}' value='{$id}'/>";
                                }
                                foreach($branchIds AS $id)
                                {
                                    $this->html .= "<input name='{$this->name}CbpFilterBranchIds[]' type='hidden' form='{$this->formElementId}' value='{$id}'/>";
                                }
                                foreach($posIds AS $id)
                                {
                                    $this->html .= "<input name='{$this->name}CbpFilterPOSIds[]' type='hidden' form='{$this->formElementId}' value='{$id}'/>";
                                }

                                $this->generateFieldInvalidFeedback();
                                $this->html .= $this->getCustomFieldEndHtml();

                            $this->html .= "</div>";

                            if($isJs)
                            {
                                $this->customJsObjParams[] = ["key" => "options","value" => json_encode($options)];
                                $this->generateFieldJs();
                            }
                        }
                    $this->html .= "</div>";
                $this->html .= "</div>";
            }
        }
            protected function generateField_CBPPicker_getQueryParam()
            {
                /* ID FILTERS */
                $brandIds = $this->selectParams["filters"]["brandIds"] ?? [];
                $companyIds = $this->selectParams["filters"]["companyIds"] ?? [];
                $branchIds = $this->selectParams["filters"]["branchIds"] ?? [];
                $posIds = $this->selectParams["filters"]["posIds"] ?? [];

                $qParams = [];
                if(count($brandIds))$qParams[] = "@BrandIds = '".implode(";",$brandIds)."'";
                if(count($companyIds))$qParams[] = "@CompanyIds = '".implode(";",$companyIds)."'";
                if(count($branchIds))$qParams[] = "@BranchIds = '".implode(";",$branchIds)."'";
                if(count($posIds))$qParams[]  = "@POSIds = '".implode(";",$posIds)."'";

                if(count($this->selectParams["cabangPOSes"]))$qParams[] = "@CabangPOSes = '".implode(";",$this->selectParams["cabangPOSes"])."'";

                if($this->selectParams["isWS"])$qParams[]  = "@IsWS = 1";
                if($this->selectParams["isSH"])$qParams[]  = "@IsSH = 1";

                $qParam = count($qParams) ? " ".implode(",", $qParams) : "";

                return $qParam;
            }
            protected function generateField_CBPPicker_getOnChangeFunctions()
            {
                /* ON CHANGE TRIGGER */
                $onChangeArrayFunctions = [];
                $onChangeArrayFunctions["Brand"] = "";
                $onChangeArrayFunctions["Company"] = "";
                $onChangeArrayFunctions["Branch"] = "";
                $onChangeArrayFunctions["POS"] = "";
                $this->generateId();
                if($this->selectParams["onChangeArray"])
                {
                    $inputOnChangeArray = $this->selectParams["onChangeArray"];
                    if(is_bool($inputOnChangeArray) && $inputOnChangeArray)
                    {
                        $onChangeFunctionName = "{$this->id}CBPChange";
                        $onChangeArrayFunctions["Brand"] = $onChangeFunctionName;
                        $onChangeArrayFunctions["Company"] = $onChangeFunctionName;
                        $onChangeArrayFunctions["Branch"] = $onChangeFunctionName;
                        $onChangeArrayFunctions["POS"] = $onChangeFunctionName;
                    }
                    else if(is_string($inputOnChangeArray))
                    {
                        $onChangeArrayFunctions["Brand"] = $inputOnChangeArray;
                        $onChangeArrayFunctions["Company"] = $inputOnChangeArray;
                        $onChangeArrayFunctions["Branch"] = $inputOnChangeArray;
                        $onChangeArrayFunctions["POS"] = $inputOnChangeArray;
                    }
                    else if(is_array($inputOnChangeArray))
                    {
                        if(isset($inputOnChangeArray["brand"]))
                        {
                            if($inputOnChangeArray["brand"])
                            {
                                if(is_bool($inputOnChangeArray["brand"]))
                                {
                                    $onChangeArrayFunctions["Brand"] = "{$this->id}BrandIdChange";
                                }
                                else
                                {
                                    $onChangeArrayFunctions["Brand"] = $inputOnChangeArray["brand"];
                                }
                            }
                        }
                        if(isset($inputOnChangeArray["company"]))
                        {
                            if($inputOnChangeArray["company"])
                            {
                                if(is_bool($inputOnChangeArray["company"]))
                                {
                                    $onChangeArrayFunctions["Company"] = "{$this->id}CompanyIdChange";
                                }
                                else
                                {
                                    $onChangeArrayFunctions["Company"] = $inputOnChangeArray["company"];
                                }
                            }
                        }
                        if(isset($inputOnChangeArray["branch"]))
                        {
                            if($inputOnChangeArray["branch"])
                            {
                                if(is_bool($inputOnChangeArray["branch"]))
                                {
                                    $onChangeArrayFunctions["Branch"] = "{$this->id}BranchIdChange";
                                }
                                else
                                {
                                    $onChangeArrayFunctions["Branch"] = $inputOnChangeArray["branch"];
                                }
                            }
                        }
                        if(isset($inputOnChangeArray["pos"]))
                        {
                            if($inputOnChangeArray["pos"])
                            {
                                if(is_bool($inputOnChangeArray["pos"]))
                                {
                                    $onChangeArrayFunctions["POS"] = "{$this->id}POSIdChange";
                                }
                                else
                                {
                                    $onChangeArrayFunctions["POS"] = $inputOnChangeArray["pos"];
                                }
                            }
                        }
                    }
                }

                return $onChangeArrayFunctions;
            }
#endregion data process
}
