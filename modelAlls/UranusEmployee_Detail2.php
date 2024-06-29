<?php
namespace app\modelAlls;
use app\core\ModelAll;
use app\core\Record;

class UranusEmployee_Detail2 extends ModelAll
{
    public function __construct($params = NULL)
    {
        $params["dbName"] = "uranus";
        $params["dataName"] = "Employee_Detail2";

        parent::__construct($params);
    }
}

class UranusEmployee_Detail2Record extends Record
{
    protected bool $isGenerateEmployeeProfile;
    protected array $EmployeeProfiles = [];
    protected string $EmployeeProfile = "";

    protected bool $isGenerateEmployeeAgreementProfile;
    protected array $EmployeeAgreementProfiles = [];
    protected string $EmployeeAgreementProfile = "";

    protected bool $isGenerateEmployeePositionProfile;
    protected array $EmployeePositionProfiles = [];
    protected string $EmployeePositionProfile = "";

    public function __construct(array $params, array $record)
    {
        parent::__construct($params, $record);

        $this->isGenerateEmployeeProfile = $params["isGenerateEmployeeProfile"] ?? false;
        $this->isGenerateEmployeeAgreementProfile = $params["isGenerateEmployeeAgreementProfile"] ?? false;
        $this->isGenerateEmployeePositionProfile = $params["isGenerateEmployeePositionProfile"] ?? false;

        $this->initialize();
    }

    #region init
        protected function initialize()
        {
            if($this->getStatusCode() != 100) return null;

            if($this->isGenerateEmployeeProfile)$this->generateEmployeeProfile();
            if($this->isGenerateEmployeeAgreementProfile)$this->generateEmployeeAgreementProfile();
            if($this->isGenerateEmployeePositionProfile)$this->generateEmployeePositionProfile();
        }
    #endregion init

    #region set status
    #endregion

    #region setting variable
        public function setSomething(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

        }
    #endregion setting variable

    #region getting / returning variable
        public function getEmployeeProfile(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            $delimiter = "<br/>";
            $this->EmployeeProfile = implode($delimiter, $this->EmployeeProfiles);
            return $this->EmployeeProfile;
        }
        public function getEmployeeAgreementProfile(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            $delimiter = "<br/>";
            $this->EmployeeAgreementProfile = implode($delimiter, $this->EmployeeAgreementProfiles);
            return $this->EmployeeAgreementProfile;

        }
        public function getEmployeePositionProfile(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            $delimiter = "<br/><br/>";
            $this->EmployeePositionProfile = implode($delimiter, $this->EmployeePositionProfiles);
            return $this->EmployeePositionProfile;

        }
    #endregion  getting / returning variable

    #region data process
        protected function generateEmployeeProfile(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            $GenderIcon = "";
            if($this->GenderId == 1)$GenderIcon = "<i class='fa-solid fa-mars color_male'></i> ";
            else if($this->GenderId == 2)$GenderIcon = "<i class='fa-solid fa-venus color_female'></i> ";
            $this->EmployeeProfiles[] = "<b>{$this->Name}</b> {$GenderIcon}(NIP {$this->Id})";
            //$this->EmployeeProfiles[] = "Payroll ID {$this->PayrollId}";
            $this->EmployeeProfiles[] = "<i class='fa-solid fa-cake-candles'></i> {$this->BirthPlace} / {$this->BirthDate} ({$this->Age} yo.)";
            $this->EmployeeProfiles[] = "{$this->ReligionName}, {$this->MaritalStatusName} ({$this->DependentName})";
            if($this->KTPNumber)$this->EmployeeProfiles[] = "KTP {$this->KTPNumber}";
            if($this->NPWPNumber)$this->EmployeeProfiles[] = "NPWP {$this->NPWPNumber}";
            $this->EmployeeProfiles[] = "<b>Enrollment at {$this->EnrollmentDate} ({$this->WorkYear} year(s))</b>";
        }
        protected function generateEmployeeAgreementProfile(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            if($this->AgreementId)
            {
                if(!$this->AgreementEndDate)
                {
                    if($this->EmployeeIsActive)$AgrementPriode = "since";
                    else $AgrementPriode = "at";
                    $AgrementPriode .= " {$this->AgreementStartDate}";
                }
                else
                {
                    $AgrementPriode = "(from ";
                    $AgrementPriode .= "{$this->AgreementStartDate}";
                    $AgrementPriode .= " till ";
                    $AgrementPriode .= "<span class='";
                        if($this->AgreementEndDate < date("Y-m-d"))$AgrementPriode .= "text-danger";
                        $AgrementPriode .= "'>";
                            $AgrementPriode .= "{$this->AgreementEndDate}";
                    $AgrementPriode .= "</span>";
                    $AgrementPriode .= ")";
                }

                $this->EmployeeAgreementProfiles[] = "<b>{$this->ESTypeName}</b> {$AgrementPriode}";
                if($this->AgreementDocumentNumber)$this->EmployeeAgreementProfiles[] = "</b>{$this->AgreementDocumentNumber}</b>";
                if($this->AgreementGeneralNotes)$this->EmployeeAgreementProfiles[] = "<br/><i>{$this->AgreementGeneralNotes}</i>";
                if($this->AgreementInternalNotes)$this->EmployeeAgreementProfiles[] = "<br/><i><span class='light_grey'>{$this->AgreementInternalNotes}</span></i>";
            }
            else
            {
                $this->EmployeeAgreementProfiles[] = "<b>{$this->ESTypeName}</b>";
            }
        }
        protected function generateEmployeePositionProfile(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            $this->EmployeePositionProfiles = [];
            //dd($this->EPositions);
            $EPositions = $this->EPositions ?? [];
            foreach($EPositions AS $EPosition)
            {
                //dd($EPosition);
                $EmployeePosition = [];

                $Position = "<b>";
                $Position .= "{$EPosition->OSPositionName}";
                if($EPosition->OSPositionCode)$Position .= " (<i>{$EPosition->OSPositionCode}</i>)";
                if($EPosition->OSPositionGradeName)$Position .= " - <i>{$EPosition->OSPositionGradeName}</i>";
                if($EPosition->OSPositionGradeCode)$Position .= " <i>({$EPosition->OSPositionGradeCode})</i>";
                $Position .= "</b>";

                $LastOSLevel = "";
                $LastOSName = "";
                $LastOSCode = "";
                foreach($EPosition->OSs AS $OS)
                {
                    $LastOSLevel = $OS->OSTypeNameAlt;
                    $LastOSName = $OS->OSName;
                    $LastOSCode = $OS->OSCode;
                }
                $EmployeePosition[] = "{$Position}";


                $OS = "{$LastOSLevel}: {$LastOSName}";
                if($LastOSCode)$OS .= " (<i>{$LastOSCode}</i>)";
                $EmployeePosition[] = "{$OS}";

                if($EPosition->IsHeadOffice)$Area = "Head Office";
                else
                {
                    $Area = "{$EPosition->CompanyAlias} {$EPosition->BranchName}";
                    if($EPosition->CabangPOSId == 2)$Area .= " ({$EPosition->POSName})";
                }
                $EmployeePosition[] = "{$Area}";

                if($EPosition->DocumentNumber)$EmployeePosition[] = "{$EPosition->DocumentNumber}";

                if(!$EPosition->EndDate) $PositionPriode = "since {$EPosition->StartDate}";
                else
                {
                    if($EPosition->DocumentNumber) $PositionPriode = "(from {$EPosition->StartDate} till {$EPosition->EndDate})";
                    else $PositionPriode = "from {$EPosition->StartDate} till {$EPosition->EndDate}";
                }
                $EmployeePosition[] = "{$PositionPriode}";

                $this->EmployeePositionProfiles[] = implode("<br/>",$EmployeePosition);
            }
        }
    #endregion data process

}


