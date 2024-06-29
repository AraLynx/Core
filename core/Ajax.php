<?php
namespace app\core;

class Ajax
{
    protected Application $app;
    protected string $link = "";
    public array $get = [];
    public array $post = [];
    public array $sanitizeResult = [];
    public array $file = [];
    protected string $accessChecks;
    protected string $key;
    protected string $token;
    protected int $pageId;
    protected int $POSId;

    protected string $formGroup;
    protected array $dynamicForms;
    protected string $dynamicForm;

    protected array $validations;
    protected array $validationErrors;

    protected array $sanitations;

    protected bool $isError = false;
    protected string $message = '';

    protected $data;
    protected $datas;
    protected $isBackDate = false;
    protected array $originalDatas;
    protected array $newDatas;
    protected array $noCaches;

    public function __construct(string $accessChecks = "", int $pageId = NULL, int $POSId = NULL)
    {
        $this->app = Application::$app;
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $this->link = str_replace("/ajax/","/cache/ajax/",strtolower($scriptName));
        $this->get = $_GET;
        $this->post = $_POST;
        $this->accessChecks = strtolower($accessChecks);
        $this->key = $this->post["key"];
        $this->pageId = $pageId ?? 0;
        $this->POSId = $POSId ?? 0;

        $this->noCaches = [
            "/tde/chronos/cache/ajax/profile/accountgetuser.php",
            "/tde/chronos/cache/ajax/profile/profilegetdata.php",

            "/tde/chronos/cache/ajax/default/defaultgetusersettings.php",
            "/tde/chronos/cache/ajax/default/defaultworker.php"
        ];

        $this->init();
    }
    //REDIRECT TO APP
    public function setStatusParams(array $statusParams){$this->app->setStatusParams($statusParams);}
    public function setStatusCode(int $statusCode, array $statusParams = NULL){$this->app->setStatusCode($statusCode, $statusParams);}
    public function getStatusCode(){return $this->app->getStatusCode();}
    public function statusMessage(){return $this->app->statusMessage();}

    #region init
        protected function init()
        {
            if(!in_array($this->link,$this->noCaches) && !in_array($this->accessChecks,["","r"]) && !in_array($this->app->app_name,["Hephaestus"]))$this->generateCacheFile();

            if(!isset($this->post["isDebug"]) && $this->post["isAuth"])$this->validateAuth();
            $this->validateToken();
            if($this->accessChecks)$this->validateAccess();

            $this->dynamicForms = [];
            $this->dynamicForm = "";

            $this->setData("");
            $this->setDatas(array());
        }
            protected function generateCacheFile()
            {
                $now = \DateTime::createFromFormat('U.u', microtime(true));
                $now->setTimeZone(new \DateTimeZone('Asia/Jakarta'));
                $fileName = $now->format("Ymd_His_u");

                $linkArray = explode("/",str_replace(".php","",$this->link));

                $dir = dirname(__DIR__,3);

                foreach($linkArray AS $folder)
                {
                    $dir .= "/".$folder;
                    if(!is_dir($dir))mkdir($dir);
                }

                $dir .= "/".date("Ym");
                if(!is_dir($dir))mkdir($dir);

                $cacheFile = fopen($dir."/".$fileName.".json", "w");
                fwrite($cacheFile, "{\"datetime\":\"".$now->format("m-d-Y H:i:s.u")."\",");
                //fwrite($cacheFile, "link:".$this->link."\n");
                fwrite($cacheFile, "\"get\":".json_encode($this->get).",");
                fwrite($cacheFile, "\"post\":".json_encode($this->post)."}");
                fclose($cacheFile);
            }
            protected function validateAuth()
            {
                if($this->getStatusCode() != 100) return null;

                if(!isset($this->post["loginUserId"]))$this->setStatusCode(601);//Form token is not provided
                else if(!isset($this->post["loginTokenHash"]))$this->setStatusCode(601);//Form token is not provided
                else
                {
                    $this->addSanitation("post","loginUserId",["int"]);

                    $loginUserId = $this->post["loginUserId"];
                    $loginTokenHash = $this->post["loginTokenHash"];
                    $Auth = new Auth($loginUserId,$loginTokenHash);

                    if(!$Auth->validateAjax())$this->setStatusCode(605);//Form token hash is expired
                    else if(APP_NAME == "Plutus")
                    {
                        //$this->isBackDate = count($Auth->getBackDate()) ? 1 : 0;
                    }
                }
            }
            protected function validateToken()
            {
                if($this->getStatusCode() != 100) return null;

                if(!isset($this->post["token"]))$this->setStatusCode(601);//Form token is not provided
                else
                {
                    $this->token = $this->post["token"];
                    $salt = $this->post["formId"];
                    $CSRF = new CSRF(array("key" => $this->key, "salt" => $salt));
                    $CSRF->compareToken($this->token);

                    $this->removeAuthPost();
                }
            }
                protected function removeAuthPost()
                {
                    $this->formGroup = $this->post["formGroup"];
                    unset($this->post["key"]);
                    unset($this->post["token"]);
                    unset($this->post["formGroup"]);
                    unset($this->post["formId"]);
                    if($this->post["isAuth"])
                    {
                        unset($this->post["isAuth"]);
                        unset($this->post["loginTokenHash"]);
                    }
                    if(isset($this->post["isDebug"]))unset($this->post["isDebug"]);
                }
            protected function validateAccess()
            {
                //if(APP_NAME == "Plutus" && !isset($this->post["PosId"])){$this->setStatusCode(611); return null;}//Please choose POS
                if($this->pageId)$PageId = $this->pageId;
                else
                {
                    $ajaxFolder = explode("/",$this->link)[5];
                    $chars = str_split($ajaxFolder);

                    $PageId = "";
                    foreach($chars AS $index => $char)
                    {
                        if(is_numeric($char))
                            $PageId .= $char;
                        else
                            break;
                    }
                    $PageId = (int)$PageId;
                }

                $SP = new StoredProcedure($this->app->app_name, "SP_Sys_Ajax_validateAccess");
                $SP->addParameters(["PageId" => $PageId, "UserId" => $this->post["loginUserId"]]);
                if(APP_NAME == "Plutus")
                {
                    if(isset($this->post["PosId"]) && $this->post["PosId"] != "*")$SP->addParameters(["POSId" => $this->post["PosId"]]);
                    else if($this->POSId)$SP->addParameters(["POSId" => $this->POSId]);
                    else if(isset($this->post["POSId"]))$SP->addParameters(["POSId" => $this->post["POSId"]]);
                    else if(isset($this->post["loginBranchId"]))
                    {
                        $SP->addParameters(["BranchId" => $this->post["loginBranchId"]]);
                        $this->addSanitation("post","loginBranchId",["int"]);
                        //dd($this->post["loginBranchId"]);
                    }
                    else {$this->setStatusCode(611); return null;}//Please choose POS
                }

                if(!count($SP->f5())){$this->setStatusCode(608); return null;}

                $row = $SP->f5()[0];
                //dd($SP->SPGenerateQuery());
                if(str_contains($this->accessChecks,"d") && !$row["D"]){$this->setStatusCode(610); return null;}
                if(str_contains($this->accessChecks,"u") && !$row["U"]){$this->setStatusCode(609); return null;}
                if(str_contains($this->accessChecks,"c") && !$row["C"]){$this->setStatusCode(607); return null;}
                if(str_contains($this->accessChecks,"r") && !$row["R"]){$this->setStatusCode(608); return null;}
            }
    #endregion init

    #region set status
        public function setError(string $message)
        {
            if($message)
            {
                $statusCode = 599;//AJAX : Manual error triger
                $this->setStatusCode($statusCode);
                $this->setIsError(true);
                $this->setMessage($message);
            }
        }
    #endregion

    #region setting variabel
        protected function setIsError(bool $IsError){$this->isError = $IsError;}
        public function getIsError(){return $this->isError;}
        public function setMessage(string $message){$this->message = $message;}
        public function getMessage(){return $this->message;}
        public function setData($data){$this->data = $data;}
        public function getData(){return $this->data;}
        public function setDatas($datas){$this->datas = $datas;}
        public function getDatas(){return $this->datas;}

        public function addOriginalData(string $db, string $table, int $id, array $datas)
        {
            $this->originalDatas[] = array(
                "Database" => $db,
                "Table" => $table,
                "Id" => $id,
                "Datas" => $datas
            );
        }
        public function addNewData(string $db, string $table, int $id)
        {
            $this->newDatas[] = array(
                "Database" => $db,
                "Table" => $table,
                "Id" => $id
            );
        }

        public function addValidation(string $method,string $key, array $rules)
        {
            if($this->getStatusCode() != 100) return null;

            $this->validations[$method][$key] = $rules;
        }
        public function addSanitation(string $method,string $key, array $rules)
        {
            if($this->getStatusCode() != 100) return null;

            $this->sanitations[$method][$key] = $rules;
        }
        public function setPost(string $name, $value){
            if($this->getStatusCode() != 100) return null;

            $this->post[$name] = $value;
        }
        public function unsetPost(string $name){
            if($this->getStatusCode() != 100) return null;

            unset($this->post[$name]);
        }


        #region isDynamicForm
            public function isDynamicForm(string $method)
            {
                foreach($this->$method["DynamicForm"] AS $index => $dynamicFormName)
                {
                    $this->setDynamicForms([$dynamicFormName]);
                }
                unset($this->$method["DynamicForm"]);
            }
            public function setDynamicForms(array $dynamicForms)
            {
                if($this->getStatusCode() != 100) return null;

                foreach($dynamicForms AS $index => $dynamicForm)
                {
                    $this->dynamicForms[] = $dynamicForm;
                }
            }
            public function setDynamicForm(string $dynamicForm)
            {
                //dd($dynamicForm,$this->post);
                if($this->getStatusCode() != 100) return null;

                if(in_array($dynamicForm, $this->dynamicForms))
                {
                    $this->dynamicForm = $dynamicForm;

                    foreach($this->dynamicForms AS $index => $dynamicForm)
                    {
                        if($this->dynamicForm == $dynamicForm)
                        {
                            foreach($this->post AS $inputName => $value)
                            {
                                if(substr($inputName, 0, strlen($dynamicForm)) == $dynamicForm)
                                {
                                    $this->post[substr($inputName, strlen($dynamicForm))] = $value;
                                    unset($this->post[$inputName]);
                                }
                            }
                            foreach($this->get AS $inputName => $value)
                            {
                                if(substr($inputName, 0, strlen($dynamicForm)) == $dynamicForm)
                                {
                                    $this->get[substr($inputName, strlen($dynamicForm))] = $value;
                                    unset($this->get[$inputName]);
                                }
                            }
                        }
                        else
                        {
                            foreach($this->post AS $inputName => $value)
                            {
                                if(substr($inputName, 0, strlen($dynamicForm)) == $dynamicForm)
                                {
                                    unset($this->post[$inputName]);
                                }
                            }
                            foreach($this->get AS $inputName => $value)
                            {
                                if(substr($inputName, 0, strlen($dynamicForm)) == $dynamicForm)
                                    unset($this->get[$inputName]);
                            }
                        }
                    }
                }
            }
            public function generateDynamicParameters(array $params)
            {
                if($this->getStatusCode() != 100) return null;

                $object = $params["object"];
                $dynamicFormName = $params["dynamicFormName"];
                $inputReqireds = $params["inputReqired"] ?? [];
                $inputNames = $params["inputName"] ?? [];
                $inputDatePickerRanges = $params["inputDatePickerRange"] ?? [];

                if($dynamicFormName)
                {
                    foreach($inputNames AS $index => $inputName)
                    {
                        if(in_array($inputName, $inputReqireds))
                            $object->addParameters($inputName,  $this->post[$dynamicFormName.$inputName]);
                        else
                            if(isset($this->post[$dynamicFormName.$inputName]) && $this->post[$dynamicFormName.$inputName])
                                $object->addParameters($inputName,  $this->post[$dynamicFormName.$inputName]);
                    }
                    foreach($inputDatePickerRanges AS $index => $inputName)
                    {
                        if(in_array($inputName, $inputReqireds))
                        {
                            $object->addParameter("{$inputName}Start",  $this->post["{$dynamicFormName}{$inputName}Start"]);
                            $object->addParameter("{$inputName}End",  $this->post["{$dynamicFormName}{$inputName}End"]);
                        }
                        else
                        {
                            if(isset($this->post["{$dynamicFormName}{$inputName}Start"]) && $this->post["{$dynamicFormName}{$inputName}Start"])
                                $object->addParameter("{$inputName}Start",  $this->post["{$dynamicFormName}{$inputName}Start"]);
                            if(isset($this->post["{$dynamicFormName}{$inputName}End"]) && $this->post["{$dynamicFormName}{$inputName}End"])
                                $object->addParameter("{$inputName}End",  $this->post["{$dynamicFormName}{$inputName}End"]);
                        }
                    }
                }
            }
        #endregion

        #region isAMPPicker
            public function isAmpPicker(string $method, string $inputName = "")
            {
                if($this->getStatusCode() != 100) return null;

                $isApplication = false;
                $isModule = false;
                $isPage = false;

                if(isset($this->$method["{$inputName}ApplicationId"]) && $this->$method["{$inputName}ApplicationId"] != "*")$isApplication = 1;
                if(isset($this->$method["{$inputName}ModuleId"]) && $this->$method["{$inputName}ModuleId"] != "*")$isModule = 1;
                if(isset($this->$method["{$inputName}PageId"]) && $this->$method["{$inputName}PageId"] != "*")$isPage = 1;

                if($isApplication)
                {
                    //rename input name dari PageId jadi PageId
                    //$this->$method["{$inputName}ApplicationId"] = explode("_",$this->$method["{$inputName}PageId"])[0];
                    $this->$method["{$inputName}ModuleId"] = 0;
                    $this->$method["{$inputName}PageId"] = 0;
                }
                if($isModule)
                {
                    //rename input name dari PageId jadi PageId
                    $this->$method["{$inputName}ApplicationId"] = explode("_",$this->$method["{$inputName}ModuleId"])[0];
                    $this->$method["{$inputName}ModuleId"] = explode("_",$this->$method["{$inputName}ModuleId"])[1];
                    $this->$method["{$inputName}PageId"] = 0;
                }
                if($isPage)
                {
                    //rename input name dari PageId jadi PageId
                    $this->$method["{$inputName}ApplicationId"] = explode("_",$this->$method["{$inputName}PageId"])[0];
                    $this->$method["{$inputName}ModuleId"] = explode("_",$this->$method["{$inputName}PageId"])[1];
                    $this->$method["{$inputName}PageId"] = explode("_",$this->$method["{$inputName}PageId"])[2];
                }

                if(isset($this->$method["{$inputName}ApplicationId"]))$this->addSanitation($method,"{$inputName}ApplicationId",["int"]);
                if(isset($this->$method["{$inputName}ModuleId"]))$this->addSanitation($method,"{$inputName}ModuleId",["int"]);
                if(isset($this->$method["{$inputName}PageId"]))$this->addSanitation($method,"{$inputName}PageId",["int"]);

                //FILTERS
                $filters["ApplicationIds"] = $this->$method["{$inputName}CbpFilterApplicationIds"] ?? [];
                $filters["ModuleIds"] = $this->$method["{$inputName}CbpFilterModuleIds"] ?? [];
                $filters["PageIds"] = $this->$method["{$inputName}CbpFilterPageIds"] ?? [];

                if(count($filters["ApplicationIds"]) && (!isset($this->$method["{$inputName}ApplicationId"]) || $this->$method["{$inputName}ApplicationId"] == "*" || !$this->$method["{$inputName}ApplicationId"]))$this->$method["{$inputName}ApplicationIds"] = implode(";",$filters["ApplicationIds"]);
                if(count($filters["ModuleIds"]) && (!isset($this->$method["{$inputName}ModuleId"]) || $this->$method["{$inputName}ModuleId"] == "*" || !$this->$method["{$inputName}ModuleId"]))$this->$method["{$inputName}ModuleIds"] = implode(";",$filters["ModuleIds"]);
                if(count($filters["PageIds"]) && (!isset($this->$method["{$inputName}PageId"]) || $this->$method["{$inputName}PageId"] == "*" || !$this->$method["{$inputName}PageId"]))$this->$method["{$inputName}PageIds"] = implode(";",$filters["PageIds"]);

                unset($this->$method["{$inputName}CbpFilterApplicationIds"]);
                unset($this->$method["{$inputName}CbpFilterModuleIds"]);
                unset($this->$method["{$inputName}CbpFilterPageIds"]);
            }
        #endregion isAMPPicker

        #region isCbpPicker
            public function isCbpPicker(string $method, string $inputName = "")
            {
                if($this->getStatusCode() != 100) return null;

                $isBrand = false;
                $isCompany = false;
                $isBranch = false;
                $isPOS = false;

                $template = $this->$method["{$inputName}CbpTemplate"];
                unset($this->$method["{$inputName}CbpTemplate"]);

                if(isset($this->$method["{$inputName}BrandId"]))$isBrand = 1;
                if(isset($this->$method["{$inputName}CompanyId"]))$isCompany = 1;
                if(isset($this->$method["{$inputName}BranchId"]))$isBranch = 1;
                if(isset($this->$method["{$inputName}PosId"]))$isPOS = 1;

                if($template == "cb")
                {
                    if($isBrand && $this->$method["{$inputName}BrandId"] && $this->$method["{$inputName}BrandId"] != "*")
                    {
                        $this->$method["{$inputName}BrandId"] = explode("_",$this->$method["{$inputName}BrandId"])[1];
                    }
                }
                else if($template == "bc")
                {
                    if($isCompany && $this->$method["{$inputName}CompanyId"] && $this->$method["{$inputName}CompanyId"] != "*")
                    {
                        $this->$method["{$inputName}CompanyId"] = explode("_",$this->$method["{$inputName}CompanyId"])[1];
                    }
                }

                if($isPOS)
                {
                    //rename input name dari PosId jadi POSId
                    $this->$method["{$inputName}POSId"] = $this->$method["{$inputName}PosId"];
                    unset($this->$method["{$inputName}PosId"]);
                }

                if(isset($this->$method["{$inputName}BrandId"]))$this->addSanitation($method,"{$inputName}BrandId",["int"]);
                if(isset($this->$method["{$inputName}CompanyId"]))$this->addSanitation($method,"{$inputName}CompanyId",["int"]);
                if(isset($this->$method["{$inputName}BranchId"]))$this->addSanitation($method,"{$inputName}BranchId",["int"]);
                if(isset($this->$method["{$inputName}POSId"]))$this->addSanitation($method,"{$inputName}POSId",["int"]);

                //FILTERS
                $filters["BrandIds"] = $this->$method["{$inputName}CbpFilterBrandIds"] ?? [];
                $filters["CompanyIds"] = $this->$method["{$inputName}CbpFilterCompanyIds"] ?? [];
                $filters["BranchIds"] = $this->$method["{$inputName}CbpFilterBranchIds"] ?? [];
                $filters["POSIds"] = $this->$method["{$inputName}CbpFilterPOSIds"] ?? [];

                if(count($filters["BrandIds"]) && (!isset($this->$method["{$inputName}BrandId"]) || $this->$method["{$inputName}BrandId"] == "*" || !$this->$method["{$inputName}BrandId"]))$this->$method["{$inputName}BrandIds"] = implode(";",$filters["BrandIds"]);
                if(count($filters["CompanyIds"]) && (!isset($this->$method["{$inputName}CompanyId"]) || $this->$method["{$inputName}CompanyId"] == "*" || !$this->$method["{$inputName}CompanyId"]))$this->$method["{$inputName}CompanyIds"] = implode(";",$filters["CompanyIds"]);
                if(count($filters["BranchIds"]) && (!isset($this->$method["{$inputName}BranchId"]) || $this->$method["{$inputName}BranchId"] == "*" || !$this->$method["{$inputName}BranchId"]))$this->$method["{$inputName}BranchIds"] = implode(";",$filters["BranchIds"]);
                if(count($filters["POSIds"]) && (!isset($this->$method["{$inputName}POSId"]) || $this->$method["{$inputName}POSId"] == "*" || !$this->$method["{$inputName}POSId"]))$this->$method["{$inputName}POSIds"] = implode(";",$filters["POSIds"]);

                unset($this->$method["{$inputName}CbpFilterBrandIds"]);
                unset($this->$method["{$inputName}CbpFilterCompanyIds"]);
                unset($this->$method["{$inputName}CbpFilterBranchIds"]);
                unset($this->$method["{$inputName}CbpFilterPOSIds"]);
            }
        #endregion isCbpPicker
    #endregion setting variabel

    #region getting / returning variabel
        public function getGet($params = NULL){
            if($this->getStatusCode() != 100) return null;

            if($params == NULL)return $this->get;

            if(is_string($params))
            {
                if(!array_key_exists($params,$this->get))
                {
                    $this->setStatusCode(613, [$params]);
                    return [];
                }

                return $this->get[$params];
            }

            if(is_array($params))
            {
                $return = [];
                foreach($params AS $param)
                {
                    if(is_array($param))[$field, $newField] = $param;
                    else $field = $newField = $param;

                    if(!array_key_exists($field,$this->get))
                    {
                        $this->setStatusCode(613, [$field]);
                        return [];
                    }

                    $return[$newField] = $this->get[$field];
                }
                return $return;
            }
        }
        public function getPost($params = NULL){
            if($this->getStatusCode() != 100) return null;

            if($params == NULL)return $this->post;

            if(is_string($params))
            {
                if(!array_key_exists($params,$this->post))
                {
                    //$this->setStatusCode(612, [$params]);
                    return null;
                }

                return $this->post[$params];
            }

            if(is_array($params))
            {
                $return = [];
                foreach($params AS $param)
                {
                    if(is_array($param))[$field, $newField] = $param;
                    else $field = $newField = $param;

                    if(!array_key_exists($field,$this->post))
                    {
                        //$this->setStatusCode(612, [$field]);
                        //return [];
                    }
                    else
                    {
                        $return[$newField] = $this->post[$field];
                    }


                }
                return $return;
            }
        }
        public function getIsBackDate(){
            if($this->getStatusCode() != 100) return null;

            return $this->isBackDate;
        }
    #endregion  getting / returning variabel

    #region data process
        #region validation
            public function validate(string $method)
            {
                if($this->getStatusCode() != 100) return null;

                if(APP_NAME == "Plutus")unset($this->post["loginBranchId"]);

                if(isset($this->validations[$method]))
                {
                    foreach($this->validations[$method] as $field => $rules)
                    {
                        if(!isset($this->$method[$field]))
                            $this->$method[$field] = NULL;

                        $value = $this->$method[$field];
                        if(is_array($value))
                        {
                            foreach($value AS $value_single)
                            {
                                $this->validate_each($method, $field, $rules, $value_single);
                            }
                        }
                        else
                        {
                            $this->validate_each($method, $field, $rules, $value);
                        }
                    }
                }

                if(!empty($this->validationErrors))
                {
                    $statusCode = 503;//Form validation error
                    $this->setStatusCode($statusCode);
                    $this->setDatas($this->validationErrors);
                }

                $this->dynamicForm = "";
                return $this->getStatusCode();
            }
                protected function validate_each(string $method, string|array $field, array $rules, $value)
                {
                    if($this->getStatusCode() != 100) return null;

                    foreach($rules AS $rule)
                    {
                        $ruleName = $rule;

                        if(is_array($ruleName))
                        {
                            $ruleName = $rule[0];
                        }

                        if($ruleName == 'required' && !$value)
                        {
                            $this->validateAddError($field, $ruleName);
                        }
                        if($ruleName == 'requiredIf')
                        {
                            $fieldToCheck = $rule[1];
                            $haystack = $rule[2] ?? [];
                            if(!is_array($haystack))$haystack = [$haystack];

                            $needle = $this->$method;
                            if(is_array($field))
                            {
                                for($counter = 0; $counter < count($field) - 1; $counter++)
                                {
                                    $needle = $needle[$field[$counter]];
                                }
                            }
                            $needle = $needle[$fieldToCheck];
                            if(in_array($needle, $haystack) && !$value)
                                $this->validateAddError($field, $ruleName);
                        }
                        if($ruleName == 'obj')
                        {
                            $subFields = $rule[1];
                            foreach($subFields AS $subField => $arrayRules)
                            {
                                if(is_string($field))$parentKeys = [$field];
                                else $parentKeys = $field;

                                $values = $this->$method;

                                foreach($parentKeys AS $parentKey)
                                {
                                    $values = $values[$parentKey];
                                }
                                $keys = [];
                                $value = "";
                                foreach($values AS $counter => $value)
                                {
                                    $keys = [...$parentKeys, $counter, $subField];
                                    $value = $value[$subField];
                                }
                                $this->validate_each($method, $keys, $arrayRules, $value);
                            }
                        }
                        if($ruleName == 'email' && $value && !filter_var($value,FILTER_VALIDATE_EMAIL))
                        {
                            $this->validateAddError($field, $ruleName);
                        }
                        if($ruleName == 'min' && $value && strlen($value) < $rule[1])
                        {
                            $this->validateAddError($field, $ruleName, $rule);
                        }
                        if($ruleName == 'max' && $value && strlen($value) > $rule[1])
                        {
                            $this->validateAddError($field, $ruleName, $rule);
                        }
                        if($ruleName == 'match' && $value)
                        {
                            $matchValue = $this->$method;
                            if(is_array($field))
                            {
                                for($counter = 0; $counter < count($field) - 1; $counter++)
                                {
                                    $matchValue = $matchValue[$field[$counter]];
                                }
                            }
                            $matchValue = $matchValue[$rule[1]];
                            if($value != $matchValue)
                                $this->validateAddError($field, $ruleName, $rule);
                        }
                        if($ruleName == 'hidden' && !isset($value))// boleh 0
                        {
                            $this->validateAddError($field, $ruleName);
                        }
                    }
                }
                public function validateAddError(string|array $field, string $ruleName, array $params = [])
                {
                    if($this->getStatusCode() != 100) return null;

                    $message = $this->validateErrorMessages()[$ruleName] ?? '';

                    if(is_array($field))
                        $field = implode("_",$field);

                    $message = str_replace("{field}", $field, $message);

                    foreach($params as $key => $value)
                    {
                        $message = str_replace("{".$params[0]."}", $params[1], $message);
                    }
                    $this->validationErrors[$field][] = $message;

                    $statusCode = 503;//Form validation error
                    $this->setStatusCode($statusCode);
                }
                public function validateErrorMessages()
                {
                    if($this->getStatusCode() != 100) return null;

                    return[
                        'required' => '{field} is required',
                        'requiredIf' => '{field} is required',
                        'email' => '{field} must be a valid email address',
                        'min' => '{field} must have minimum length of {min}',
                        'max' => '{field} must have maximum length of {max}',
                        'match' => '{field} must be the same as {match}',
                        'hidden' => 'Form error: missing hidden input. Please refresh the page',
                    ];
                }
        #endregion validation

        #region sanitation
            public function sanitize(string $method)
            {
                if($this->getStatusCode() != 100) return null;

                if(isset($this->sanitations[$method]))
                {
                    foreach($this->sanitations[$method] as $field => $rules)
                    {
                        if(in_array("allowEmpty",$rules) && !isset($this->$method[$field]))
                            $this->$method[$field] = "";

                        if(isset($this->$method[$field]))
                        {
                            $value = $this->$method[$field];
                            if(is_array($value))
                            {
                                $this->sanitize_array($method, $field, $rules, $value);
                            }
                            else
                            {
                                $this->sanitize_each($method, $field, $rules, $value);
                            }
                        }
                    }
                }
            }
                protected function sanitize_each(string $method, string|array $field, array $rules, $value)
                {
                    $isStar = false;
                    $allowEmpty = false;
                    foreach($rules AS $rule)
                    {
                        $ruleName = $rule;
                        if(is_array($ruleName))$ruleName = $rule[0];

                        $finalValue = $this->$method[$field];
                        if($ruleName == 'isStar')$isStar = true;
                        if($ruleName == 'allowEmpty')$allowEmpty = true;

                        if($ruleName == 'string')$finalValue = ltrim(rtrim(str_replace(["'","--"],["''"," "],strval($this->$method[$field]))));
                        if($ruleName == 'kendoEditor')$finalValue= preg_replace('/\s+/', ' ', ltrim(rtrim(str_replace(["'","--"],["''"," "],strval($this->$method[$field])))));
                        if($ruleName == 'date')$finalValue = substr(strval($this->$method[$field]),0,10);
                        if($ruleName == 'time')$finalValue = substr(strval($this->$method[$field]),0,8);
                        if($ruleName == 'dateTime')$finalValue = substr(strval($this->$method[$field]),0,19);
                        if($ruleName == 'upper')$finalValue = strtoupper($this->$method[$field]);
                        if($ruleName == 'bool' || $ruleName == 'boolean')$finalValue = $this->$method[$field] ? 1 : 0;
                        if($ruleName == 'int' || $ruleName == 'integer')$finalValue = intval($this->$method[$field]);
                        if($ruleName == 'checkbox')$finalValue = (isset($this->$method[$field]) && $this->$method[$field] == "on") ? 1 : 0;
                        if($ruleName == 'dec' || $ruleName == 'decimal')
                        {
                            $precision = 2;
                            if(is_array($rule))
                            {
                                if(!isset($rule[1]))$precision = 2;
                                else $precision = $rule[1];
                            }
                            $finalValue = round(floatval($this->$method[$field]),$precision);
                        }
                        if($ruleName == 'ecrypt')
                        {
                            $algo = PASSWORD_DEFAULT;
                            if(is_array($rule))
                            {
                                if(!isset($rule[1]))$algo = PASSWORD_DEFAULT;
                                else
                                {
                                    if($rule[1] == "hash")$algo = PASSWORD_DEFAULT;
                                    else if($rule[1] == "bcrypt")$algo = PASSWORD_BCRYPT;
                                    else if($rule[1] == "argon2i")$algo = PASSWORD_ARGON2I;
                                    else if($rule[1] == "argon2id")$algo = PASSWORD_ARGON2ID;
                                    else $algo = PASSWORD_DEFAULT;
                                }
                            }
                            $finalValue = password_hash($this->$method[$field], PASSWORD_DEFAULT);
                        }
                        if($ruleName == 'file')
                        {
                            $this->file[$field] = [];
                            $this->file[$field]["FileDirectory"] = strval($this->$method[$field."FileDirectory"]);
                            $this->file[$field]["FileOriginalName"] = strval($this->$method[$field."FileOriginalName"]);
                            $this->file[$field]["FileUniqueName"] = strval($this->$method[$field."FileUniqueName"]);
                            $this->file[$field]["FileSize"] = intval($this->$method[$field."FileSize"]);
                            $this->file[$field]["FileType"] = strval($this->$method[$field."FileType"]);
                            $this->file[$field]["FileExtension"] = strval($this->$method[$field."FileExtension"]);

                            unset($this->$method[$field]);
                            unset($this->$method[$field."FileDirectory"]);
                            unset($this->$method[$field."FileOriginalName"]);
                            unset($this->$method[$field."FileUniqueName"]);
                            unset($this->$method[$field."FileSize"]);
                            unset($this->$method[$field."FileType"]);
                            unset($this->$method[$field."FileExtension"]);
                        }

                        if(isset($this->$method[$field]))
                        {
                            if(!$isStar)
                            {
                                $this->$method[$field] = $finalValue;
                            }
                            else if($this->$method[$field] == $finalValue)
                            {
                                $this->$method[$field] = $finalValue;
                            }
                        }
                    }
                    if(!$allowEmpty && isset($this->$method[$field]) && !$this->$method[$field]) unset($this->$method[$field]);
                }
                protected function sanitize_array(string $method, string $field, array $rules, array $values)
                {
                    foreach($values AS $index => $value)
                    {
                        $isStar = false;
                        $allowEmpty = false;
                        foreach($rules AS $rule)
                        {
                            $ruleName = $rule;

                            if(is_array($ruleName))$ruleName = $rule[0];

                            $finalValue = $this->$method[$field][$index];
                            if($ruleName == 'isStar')$isStar = true;
                            if($ruleName == 'allowEmpty')$allowEmpty = true;

                            if($ruleName == 'string')$finalValue = ltrim(rtrim(str_replace(["'","--"],["''"," "],strval($this->$method[$field][$index]))));
                            if($ruleName == 'date')$finalValue = substr(strval($this->$method[$field][$index]),0,10);
                            if($ruleName == 'time')$finalValue = substr(strval($this->$method[$field][$index]),0,8);
                            if($ruleName == 'dateTime')$finalValue = substr(strval($this->$method[$field][$index]),0,19);
                            if($ruleName == 'upper')$finalValue = strtoupper($this->$method[$field][$index]);
                            if($ruleName == 'bool' || $ruleName == 'boolean')$finalValue = $this->$method[$field][$index] ? 1 : 0;
                            if($ruleName == 'int' || $ruleName == 'integer')$finalValue = intval($this->$method[$field][$index]);
                            if($ruleName == 'dec' || $ruleName == 'decimal')
                            {
                                $precision = 2;
                                if(is_array($rule))
                                {
                                    if(!isset($rule[1]))$precision = 2;
                                    else $precision = $rule[1];
                                }
                                $finalValue = round(floatval($this->$method[$field][$index]),$precision);
                            }
                            if($ruleName == 'ecrypt')
                            {
                                $algo = PASSWORD_DEFAULT;
                                if(is_array($rule))
                                {
                                    if(!isset($rule[1]))$algo = PASSWORD_DEFAULT;
                                    else
                                    {
                                        if($rule[1] == "hash")$algo = PASSWORD_DEFAULT;
                                        else if($rule[1] == "bcrypt")$algo = PASSWORD_BCRYPT;
                                        else if($rule[1] == "argon2i")$algo = PASSWORD_ARGON2I;
                                        else if($rule[1] == "argon2id")$algo = PASSWORD_ARGON2ID;
                                        else $algo = PASSWORD_DEFAULT;
                                    }
                                }
                                $finalValue = password_hash($this->$method[$field][$index], PASSWORD_DEFAULT);
                            }
                            if($ruleName == 'file')
                            {
                                if(!isset($this->file[$field]))$this->file[$field] = [];
                                if(!isset($this->file[$field][$index]))$this->file[$field][$index] = [];

                                $this->file[$field][$index]["FileDirectory"] = strval($this->$method[$field."FileDirectory"][$index]);
                                $this->file[$field][$index]["FileOriginalName"] = strval($this->$method[$field."FileOriginalName"][$index]);
                                $this->file[$field][$index]["FileUniqueName"] = strval($this->$method[$field."FileUniqueName"][$index]);
                                $this->file[$field][$index]["FileSize"] = intval($this->$method[$field."FileSize"][$index]);
                                $this->file[$field][$index]["FileType"] = strval($this->$method[$field."FileType"][$index]);
                                $this->file[$field][$index]["FileExtension"] = strval($this->$method[$field."FileExtension"][$index]);
                            }

                            if(isset($this->$method[$field]))
                            {
                                if(!$isStar)
                                {
                                    $this->$method[$field][$index] = $finalValue;
                                }
                                else if($this->$method[$field][$index] == $finalValue)
                                {
                                    $this->$method[$field][$index] = $finalValue;
                                }
                            }
                        }

                        if(!$allowEmpty && is_array($this->$method[$field]) && !$this->$method[$field][$index]) unset($this->$method[$field][$index]);
                    }
                }

            public function sanitize2(string $method)
            {
                if($this->getStatusCode() != 100) return null;

                $this->sanitizeResult = [];

                if(isset($this->sanitations[$method]))
                {
                    foreach($this->$method AS $field => $value)
                    {
                        $rules = $this->sanitations[$method][$field] ?? ["blank"];

                        if(is_array($value))
                        {
                            if($rules[0][0] == "obj")$rules = $rules[0][1];
                            $this->sanitizeResult[$field] = $this->sanitize_loop($field,$value,$rules);
                        }
                        else
                        {
                            $isStar = false;
                            $isRemove = false;
                            $allowEmpty = false;

                            foreach($rules AS $index => $rule)
                            {
                                if(is_int($index))
                                {
                                    if(is_string($rule) && $rule == "isStar")$isStar = true;
                                    else if(is_string($rule) && $rule == "remove")$isRemove = true;
                                    else if(is_string($rule) && $rule == "allowEmpty")$allowEmpty = true;
                                    else if(is_string($rule) && $rule == "file")
                                    {
                                        $this->sanitizeResult[$field] = [];
                                        $this->sanitizeResult[$field]["FileDirectory"] = strval($this->$method[$field."FileDirectory"]);
                                        $this->sanitizeResult[$field]["FileOriginalName"] = strval($this->$method[$field."FileOriginalName"]);
                                        $this->sanitizeResult[$field]["FileUniqueName"] = strval($this->$method[$field."FileUniqueName"]);
                                        $this->sanitizeResult[$field]["FileSize"] = intval($this->$method[$field."FileSize"]);
                                        $this->sanitizeResult[$field]["FileType"] = strval($this->$method[$field."FileType"]);
                                        $this->sanitizeResult[$field]["FileExtension"] = strval($this->$method[$field."FileExtension"]);

                                        unset($this->$method[$field]);
                                        unset($this->$method[$field."FileDirectory"]);
                                        unset($this->$method[$field."FileOriginalName"]);
                                        unset($this->$method[$field."FileUniqueName"]);
                                        unset($this->$method[$field."FileSize"]);
                                        unset($this->$method[$field."FileType"]);
                                        unset($this->$method[$field."FileExtension"]);
                                    }
                                    else if(!$isStar || $value != "*")$value = $this->sanitize_rule($value,$rule);
                                }
                            }
                            $this->sanitizeResult[$field] = $value;

                            //dihapus kalau :
                            $valueExists = isset($this->sanitizeResult[$field]);
                            $notAllowEmptyAndValueIsBlank = !$allowEmpty && !$this->sanitizeResult[$field];
                            $isStarAndValueIsStar = $isStar && $value == "*";

                            if($valueExists && ($isRemove || $notAllowEmptyAndValueIsBlank || $isStarAndValueIsStar)) unset($this->sanitizeResult[$field]);
                        }
                    }

                }
                $this->$method = $this->sanitizeResult;
            }
                protected function sanitize_loop(string $field, array $values, array $rules)
                {
                    $returnValues =  [];

                    foreach($values AS $key => $value)
                    {
                        $subRules = $rules;
                        if(is_int($key)){}
                        else if(isset($subRules[$key]))
                        {
                            $subRules = $subRules[$key];
                        }
                        if(isset($subRules[0][0] ) && $subRules[0][0] == "obj")$subRules = $subRules[0][1];

                        if(is_array($value))
                        {
                            $returnValues[$key] = $this->sanitize_loop($key, $value, $subRules);
                        }
                        else
                        {
                            $isStar = false;
                            $isRemove = false;
                            $allowEmpty = false;

                            foreach($subRules AS $index => $rule)
                            {
                                if(is_int($index))
                                {

                                    if(is_string($rule) && $rule == "isStar")$isStar = true;
                                    else if(is_string($rule) && $rule == "remove")$isRemove = true;
                                    else if(is_string($rule) && $rule == "allowEmpty")$allowEmpty = true;
                                    /*
                                    //HARUSNYA GA ADA CASE MULTI ARRAY TAPI FILE UPLOADAN
                                    else if(is_string($rule) && $rule == "file")
                                    {
                                        $this->sanitizeResult[$field] = [];
                                        $this->sanitizeResult[$field]["FileDirectory"] = strval($this->$method[$field."FileDirectory"]);
                                        $this->sanitizeResult[$field]["FileOriginalName"] = strval($this->$method[$field."FileOriginalName"]);
                                        $this->sanitizeResult[$field]["FileUniqueName"] = strval($this->$method[$field."FileUniqueName"]);
                                        $this->sanitizeResult[$field]["FileSize"] = intval($this->$method[$field."FileSize"]);
                                        $this->sanitizeResult[$field]["FileType"] = strval($this->$method[$field."FileType"]);
                                        $this->sanitizeResult[$field]["FileExtension"] = strval($this->$method[$field."FileExtension"]);

                                        unset($this->$method[$field]);
                                        unset($this->$method[$field."FileDirectory"]);
                                        unset($this->$method[$field."FileOriginalName"]);
                                        unset($this->$method[$field."FileUniqueName"]);
                                        unset($this->$method[$field."FileSize"]);
                                        unset($this->$method[$field."FileType"]);
                                        unset($this->$method[$field."FileExtension"]);
                                    }
                                    */
                                    else if(!$isStar || $value != "*")$value = $this->sanitize_rule($value,$rule);
                                }
                            }
                            $returnValues[$key] = $value;

                            //dihapus kalau
                            $valueExists = isset($returnValues[$key]);
                            $notAllowEmptyAndValueIsBlank = !$allowEmpty && !$returnValues[$key];
                            $isStarAndValueIsStar = $isStar && $value == "*";

                            if($valueExists && ($isRemove || $notAllowEmptyAndValueIsBlank || $isStarAndValueIsStar)) unset($returnValues[$key]);
                        }
                    }
                    return $returnValues;
                }
                public function sanitize_rule($value, string|array $rule)
                {
                    if(is_array($rule))$ruleName = $rule[0];
                    else $ruleName = $rule;

                    if($ruleName == 'string')$value = ltrim(rtrim(str_replace(["'","--"],["''"," "],strval($value))));
                    if($ruleName == 'upper')$value = strtoupper($value);
                    if($ruleName == 'textarea')$value= ltrim(rtrim(str_replace(["'","--"],["''"," "],strval($value))));
                    if($ruleName == 'kendoEditor')$value= preg_replace('/\s+/', ' ', ltrim(rtrim(str_replace(["'","--"],["''"," "],strval($value)))));
                    if($ruleName == 'date')$value = substr(strval($value),0,10);
                    if($ruleName == 'time')$value = substr(strval($value),0,8);
                    if($ruleName == 'dateTime')$value = substr(strval($value),0,19);
                    if($ruleName == 'bool' || $ruleName == 'boolean')$value = $value ? 1 : 0;
                    if($ruleName == 'int' || $ruleName == 'integer')$value = intval($value);
                    if($ruleName == 'checkbox')$value = (isset($value) && $value == "on") ? 1 : 0;
                    if($ruleName == 'dec' || $ruleName == 'decimal')
                    {
                        $precision = 2;
                        if(is_array($rule))
                        {
                            if(!isset($rule[1]))$precision = 2;
                            else $precision = $rule[1];
                        }
                        $value = round(floatval($value),$precision);
                    }
                    if($ruleName == 'ecrypt')
                    {
                        $algo = PASSWORD_DEFAULT;
                        if(is_array($rule))
                        {
                            if(isset($rule[1]))
                            {
                                if($rule[1] == "hash")$algo = PASSWORD_DEFAULT;
                                else if($rule[1] == "bcrypt")$algo = PASSWORD_BCRYPT;
                                else if($rule[1] == "argon2i")$algo = PASSWORD_ARGON2I;
                                else if($rule[1] == "argon2id")$algo = PASSWORD_ARGON2ID;
                            }
                        }
                        $value = password_hash($value, $algo);
                    }
                    return $value;
                }
        #endregion sanitazion

        #region remove variable
        public function unsetVariable(string $method, string|array $fields)
        {
            if($this->getStatusCode() != 100) return null;
            if(is_string($fields) && isset($this->$method[$fields]))
                unset($this->$method[$fields]);
            else{
                foreach($fields AS $field)
                {
                    $this->unsetVariable($method,$field);
                }
            }
        }
        #endregion remove variable

        public function moveFile(string $field, string $assetDirectory, string $newFileName = "")
        {
            $return = [
                "fileDirectory" => "",
                "fileName" => ""
            ];

            if($this->getStatusCode() != 100) return $return;

            $file = $this->file[$field];

            $AssetDir = __DIR__."/../../Archives";
            if(!is_dir($AssetDir))mkdir($AssetDir);//GENERATE ARCHIVES FOLDER

            $AssetDir .= "/Asset";
            if(!is_dir($AssetDir))mkdir($AssetDir);//GENERATE ARCHIVES/ASSET FOLDER

            $assetDirectoryArray = explode("/", $assetDirectory);
            foreach($assetDirectoryArray AS $folder)
            {
                $AssetDir .= "/".$folder;
                if(!is_dir($AssetDir))mkdir($AssetDir);
            }

            if(!$newFileName)$newFileName = $file["FileUniqueName"].$file["FileExtension"];
            else $newFileName = $newFileName.$file["FileExtension"];

            $originalFileLink = $file["FileDirectory"]."/".$file["FileUniqueName"];
            $newFileLink = $AssetDir."/".$newFileName;

            if(!rename($originalFileLink, $newFileLink)) return $return;

            return [
                "fileDirectory" => "/Archives/Asset/{$assetDirectory}",
                "fileName" => $newFileName
            ];
        }

        public function end()
        {
            $result["statusCode"] = $this->getStatusCode();
            $result["statusMessage"] = $this->statusMessage();
            $result["data"] = $this->getData();
            $result["datas"] = $this->getDatas();

            if($this->getStatusCode() == 100)
            {
                $result["isError"] = false;
            }
            else
            {
                $result["isError"] = true;
                if($this->getStatusCode() == 503) //Form validation error
                {
                    $result["formGroup"] = $this->formGroup ?? "";
                }
                else if($this->getStatusCode() == 500)//AJAX ERROR
                {
                    $result["errorCount"] = count(error_get_last());
                    $result["warning"] = error_get_last();
                }
                else if($this->getStatusCode() == 599)//Manual error triger
                {
                    $result["message"] = $this->getMessage();
                }
            }
            echo json_encode($result);
        }
    #endregion data process
}
