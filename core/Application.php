<?php
namespace app\core;

use app\core\Controller;

class Application
{
    protected array $taxPercentages;
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public TimeStamp $timestamp;
    public static Application $app;
    public Controller $controller;

    public string $env;
    public string $app_name;
    public array $configs;
    public array $defaultSettingNames;
    public array $defaultSettingValues;

    protected int $statusCode = 100;
    protected string $statusMessage = "";
    protected array $statusParams = [];

    protected int $counter = 0;

    protected int $moduleId = 0;
    protected int $pageId = 0;

    protected int|array $backDate = 0;

    public function __construct(string $rootDir, array $params)
    {
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->timestamp = new TimeStamp();

        $this->router = new Router($this->request, $this->response);
        //$this->db = new Database($params["configs"]["db"]);
        $this->env = $params["env"] ?? "prod";
        $this->app_name = $params["app_name"];
        $this->configs = $params["configs"];
        $this->defaultSettingNames = $params["defaultSettingNames"];
        $this->defaultSettingValues = $params["defaultSettingValues"];

        $this->statusMessage = $this->statusMessage();

        $this->init();
    }

#region init
    protected function init()
    {
        if($this->getStatusCode() != 100) return null;

        $this->generateTaxPercetange();
    }

    protected function generateTaxPercetange()
    {
        if($this->getStatusCode() != 100) return null;

        $this->taxPercentages = [
            "pph22" => [
                "1900-01-01" => 1.5,
            ],
            "ppn" => [
                "1900-01-01" => 10,
                "2022-04-01" => 11
            ],
            "ppnbm_1" => [
                "1900-01-01" => 10,
            ],
            "ppnbm_2" => [
                "1900-01-01" => 20,
            ],
            "ppnbm_3" => [
                "1900-01-01" => 25,
            ],
            "ppnbm_4" => [
                "1900-01-01" => 35,
            ],
            "bm" => [
                "1900-01-01" => 10,
                "2022-04-01" => 11
            ],
            "pbb" => [
                "1900-01-01" => 0.5,
            ]
        ];
    }
#endregion init

#region set status
    public function setStatusCode(int $statusCode, array $statusParams = NULL)
    {
        if($this->getStatusCode() != 100) return null;

        //ONLY SET ERROR CODE IF EVERYTHING IS OKAY, SO THAT PREVIOUSE ERROR CODE IS NOT REPLACED
        $this->statusCode = $statusCode;
        if(isset($statusParams))$this->setStatusParams($statusParams);
    }
#endregion

#region setting variable
    public function setStatusParams($statusParams)
    {
        $this->statusParams = $statusParams;
    }
    public function setModuleId(int $moduleId)
    {
        if($this->getStatusCode() != 100) return null;

        $this->moduleId = $moduleId;
        $this->pageId = 0;
    }
    public function setPageId(int $pageId)
    {
        if($this->getStatusCode() != 100) return null;

        $this->pageId = $pageId;
    }
    public function setBackDate(array $backDate)
    {
        if($this->getStatusCode() != 100) return null;

        $this->backDate = $backDate;
    }
#endregion setting variable

#region getting / returning variable
    public function isValidDate(string $date, string $format = "Y-m-d")
    {
        if($this->getStatusCode() != 100) return null;

        $dateTime = \DateTime::createFromFormat($format, $date);
        return $dateTime && $dateTime->format($format) === $date;
    }
    public function getTaxPercentage(string|array $params = null)
    {
        if($this->getStatusCode() != 100) return null;

        $type = "ppn";
        $date = date("Y-m-d");

        if(is_array($params))
        {
            $type = $params["type"] ?? "ppn";
            $date = $params["date"] ?? date("Y-m-d");
        }
        else if(is_string($params) && $this->isValidDate($params))
        {
            $date = $params;
        }

        $return = "";
        foreach($this->taxPercentages[$type] AS $dateValid => $taxPercentage)
        {
            if($dateValid<= $date)$return = $taxPercentage;
        }
        return $return;
    }
    public function getTaxIndex(string|array $params = null)
    {
        if($this->getStatusCode() != 100) return null;

        $taxPercentage = $this->getTaxPercentage($params);
        $taxIndex = (100 + $taxPercentage) / 100;

        return $taxIndex;
    }
    public function calculateTax(string|array $params = "")
    {
        if($this->getStatusCode() != 100) return null;


    }
    public function getBackDate()
    {
        if($this->getStatusCode() != 100) return null;

        /*
        $return = [];
        if(is_array($this->backDate))$return = $this->backDate[$this->pageId] ?? [];
        else $return = $this->backDate;
        return $return;
        */
        return $this->backDate[$this->pageId] ?? [];
    }
    public function getCounter()
    {
        if($this->getStatusCode() != 100) return null;

        $this->counter++;
        return $this->counter;
    }
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    public function statusMessage()
    {
        $message = "";
        switch($this->getStatusCode())
        {
            case 100 : $message = "OK";break;

            //APP CORE ERROR
            case 200 : $message = "APP CORE ERROR";break;
                case 201 : $message = "core::Application error {$this->statusParams[0]}";break;
                case 202 : $message = "core::Router error {$this->statusParams[0]}";break;
                case 203 : $message = "core::Request error {$this->statusParams[0]}";break;
                case 204 : $message = "core::Response error {$this->statusParams[0]}";break;
                case 205 : $message = "core::Auth error {$this->statusParams[0]}";break;
                case 206 : $message = "core::Controller error {$this->statusParams[0]}";break;

                case 299 : $message = "Manual error triger";break;

            //CONTROLLER
            case 300 : $message = "CONTROLLER ERROR";break;
                case 399 : $message = "Manual error triger";break;

            //PAGE
            case 400 : $message = "PAGE ERROR";break;
                case 401 : $message = "Page is already begin";break;
                case 402 : $message = "Page is not yet begin";break;
                case 403 : $message = "Page is already ended";break;
                case 404 : $message = "Page is not yet ended";break;

                    //FORM
                    case 410 : $message = "Form Error";break;
                    case 411 : $message = "Form input type is not valid";break;
                    case 412 : $message = "Form collapsable cannot be re-initialize";break;
                    case 413 : $message = "Form column already started";break;
                    case 414 : $message = "Form column not yet init";break;

                    //KENDO GRID
                    case 420 : $message = "KendoGrid Error";break;

                    //KENDO WINDOW
                    case 430 : $message = "KendoWindow Error";break;

                case 499 : $message = "Manual error triger";break;

            //TDE HELPER
            case 500 : $message = "TDE Helper ERROR";break;

                //KENDO GRID HELPER
                case 510 : $message = "KendoGrid Helper Error";break;

                //KENDO COMBO BOX HELPER
                case 520 : $message = "KendoComboBox Helper Error";break;

                //DATA TABLE HELPER
                case 530 : $message = "DataTable Helper Error";break;

                //PHP SPREADSHEET
                case 540 : $message = "PhpSpreadsheet Helper Error";break;

                //PHP MAILER
                case 550 : $message = "Php Mailer Helper Error";break;

                //CHANGE LOG
                case 560 : $message = "ChangeLog Helper Error";break;
                case 561 : $message = "ChangeLog Helper Error: Not Same Origin";break;
                case 562 : $message = "ChangeLog Helper Error: Origin path no recognize";break;

                case 599 : $message = "Manual error triger";break;

            //AJAX
            case 600 : $message = "AJAX ERROR";break;
                case 601 : $message = "Ajax : Form authentication is not provided";break;//FORM TOKEN
                case 602 : $message = "Ajax : Form authentication is not valid";break;//FORM TOKEN
                case 603 : $message = "Ajax : Form validation error";break;
                case 604 : $message = "Ajax : Form sanitation error";break;
                case 605 : $message = "Ajax : Login authentication is expired, please re-login to your account";break;//LOGIN TOKEN HASH
                case 606 : $message = "Ajax : You dont have access on this page";break;
                case 607 : $message = "Ajax : Your account doesn't have 'Create' access for this page";break;
                case 608 : $message = "Ajax : Your account doesn't have 'Read' access for this page";break;
                case 609 : $message = "Ajax : Your account doesn't have 'Update' access for this page";break;
                case 610 : $message = "Ajax : Your account doesn't have 'Delete' access for this page";break;
                case 611 : $message = "Ajax : Please choose POS";break;
                case 612 : $message = "Ajax : Index POS not found: ".$this->statusParams[0];break;
                case 613 : $message = "Ajax : Index GET not found: ".$this->statusParams[0];break;

                case 690 : $message = "Ajax : Error by PHP";break;
                case 699 : $message = "Ajax : Manual error triger";break;

            //DATABASE
            case 700 : $message = "STORED PROCEDURE ERROR";break;
                //MODEL
                case 710 : $message = "DB Model : SP NAME (".$this->statusParams[1].") NOT FOUND IN DB ".$this->statusParams[0]."";break;
                case 711 : $message = "DB Model : SP COLUMN (".$this->statusParams[2].") NOT FOUND IN [".$this->statusParams[0]."].[".$this->statusParams[1]."]";break;
                case 712 : $message = "DB Model : SP [".$this->statusParams[0]."].[".$this->statusParams[1]."] DECLARED PARAMETER IS NOT SET";break;
                case 713 : $message = "DB Model : SP PARAMETER (".$this->statusParams[2].") NOT FOUND IN [".$this->statusParams[0]."].[".$this->statusParams[1]."]";break;
                case 714 : $message = "DB Model : COLUMN ID FOR SP [".$this->statusParams[0]."].[".$this->statusParams[1]."] IS NOT SET";break;
                case 715 : $message = "DB Model : CHILD CLASS ".$this->statusParams[0]." DOESN'T EXIST";break;
                case 716 : $message = "DB Model : CHILD CLASS ".$this->statusParams[0]." : FOREIGN ID COLUMN IS NOT SET";break;
                case 717 : $message = "DB Model : CHILD CLASS ".$this->statusParams[2]."DOESN'T EXIST IN [".$this->statusParams[0]."].[".$this->statusParams[1]."]";break;
                case 718 : $message = "";break;
                case 719 : $message = "";break;

                //FACT ERROR
                case 720 : $message = "";break;
                case 721 : $message = "";break;
                case 722 : $message = "";break;
                case 723 : $message = "";break;
                case 724 : $message = "";break;
                case 725 : $message = "";break;
                case 726 : $message = "";break;
                case 727 : $message = "";break;
                case 728 : $message = "";break;
                case 729 : $message = "";break;

                //DIM ERROR
                case 730 : $message = "";break;
                case 731 : $message = "";break;
                case 732 : $message = "";break;
                case 733 : $message = "";break;
                case 734 : $message = "";break;
                case 735 : $message = "";break;
                case 736 : $message = "";break;
                case 737 : $message = "";break;
                case 738 : $message = "";break;
                case 739 : $message = "";break;

                //REL ERROR
                case 740 : $message = "";break;
                case 741 : $message = "";break;
                case 742 : $message = "";break;
                case 743 : $message = "";break;
                case 744 : $message = "";break;
                case 745 : $message = "";break;
                case 746 : $message = "";break;
                case 747 : $message = "";break;
                case 748 : $message = "";break;
                case 749 : $message = "";break;

                //LOG ERROR
                case 750 : $message = "";break;
                case 751 : $message = "";break;
                case 752 : $message = "";break;
                case 753 : $message = "";break;
                case 754 : $message = "";break;
                case 755 : $message = "";break;
                case 756 : $message = "";break;
                case 757 : $message = "";break;
                case 758 : $message = "";break;
                case 759 : $message = "";break;

                //TEMP ERROR
                case 760 : $message = "";break;
                case 761 : $message = "";break;
                case 762 : $message = "";break;
                case 763 : $message = "";break;
                case 764 : $message = "";break;
                case 765 : $message = "";break;
                case 766 : $message = "";break;
                case 767 : $message = "";break;
                case 768 : $message = "";break;
                case 769 : $message = "";break;

                //TRANS ERROR
                case 770 : $message = "SP Trans : Transaction already started.";break;
                case 771 : $message = "SP Trans : Transaction not started yet.";break;
                case 772 : $message = "SP Trans : Try and catch already started.";break;
                case 773 : $message = "SP Trans : Try and catch not set yet";break;
                case 774 : $message = "SP Trans : Transaction commit / rollback is not prepared";break;
                case 775 : $message = "SP Trans : Parameter {$this->statusParams[0]} already exists";break;
                case 776 : $message = "SP Trans : Parameter {$this->statusParams[0]} doesn't exists";break;
                case 777 : $message = "SP Trans : ";break;
                case 778 : $message = "SP Trans : DB Validation error : {$this->statusParams[0]}";break;
                case 779 : $message = "SP Trans : Transaction error
                                        <br/>Error Number: {$this->statusParams["ErrorNumber"]}
                                        <br/>Error Severity: {$this->statusParams["ErrorSeverity"]}
                                        <br/>Error State: {$this->statusParams["ErrorState"]}
                                        <br/>Error Procedure: {$this->statusParams["ErrorProcedure"]}
                                        <br/>Error Line: {$this->statusParams["ErrorLine"]}
                                        <br/>Error Message: {$this->statusParams["ErrorMessage"]}";break;

                //STORED PROCEDURE
                case 781 : $message = "SP : Preparation error (missing query)";break;
                case 782 : $message = "SP : Not yet fully prepared";break;
                case 783 : $message = "";break;
                case 784 : $message = "";break;
                case 785 : $message = "";break;
                case 786 : $message = "";break;
                case 787 : $message = "";break;
                case 788 : $message = "";break;

                case 799 : $message = "Manual error triger.";break;

            //AUTH
            case 800 : $message = "AUTH ERROR";break;
                case 811 : $message = "Auth : Your employee status is expired. Please contact your supervisor or HR team";break;
                case 821 : $message = "Auth : Token is expired";break;
                case 822 : $message = "Auth : Token hash is not provided";break;
                case 823 : $message = "Auth : Device Type is not recognize";break;
                case 899 : $message = "Auth : Manual error triger";break;

            //OTHER
            case 900 : $message = "MANUAL TRIGGER ERROR";break;
        }
        return $message;
    }
    public function getDefaultSettingNames()
    {
        if($this->getStatusCode() != 100) return null;

        return $this->defaultSettingNames;
    }
    public function getDefaultSettingValue($key)
    {
        if($this->getStatusCode() != 100) return null;

        return $this->defaultSettingValues[$key] ?? "";
    }
    public function getModuleId()
    {
        if($this->getStatusCode() != 100) return null;

        return $this->moduleId;
    }
    public function getPageId()
    {
        if($this->getStatusCode() != 100) return null;

        return $this->pageId;
    }
#endregion  getting / returning variable

#region data process
    public function run()
    {
        if($this->getStatusCode() != 100) return null;

        $path = $this->router->resolve();
        echo $path;
    }
#endregion data process
}
