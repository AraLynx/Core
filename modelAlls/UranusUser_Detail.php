<?php
namespace app\modelAlls;
use app\core\ModelAll;
use app\core\Record;

class UranusUser_Detail extends ModelAll
{
    public function __construct($params = NULL)
    {
        $params["dbName"] = "uranus";
        $params["dataName"] = "User_Detail";

        parent::__construct($params);
    }
}

class UranusUser_DetailRecord extends Record
{
    protected array $positionFields = [
        "DirectorateName","DivisionName","DepartmentName","SubDepartmentName","SectionName","PositionName","GroupName"
        ,"DirectorateCode","DivisionCode","DepartmentCode","SubDepartmentCode","SectionCode","PositionCode"
    ];

    protected int $isGenerateAvatar;
    protected int $isGenerateNameProfile;
    protected int $isGeneratePositionProfile;
    protected int $isGeneratePOSProfile;

    protected array $generateAvatarParams;
    protected array $generateNameProfileParams;
    protected array $generatePositionProfileParams;
    protected array $generatePOSProfileParams;

    public string $avatarFileLink;
    public string $avatarHtml;
    public string $nameProfile;
    public string $positionProfile;
    public string $POSProfile;

    public function __construct(array $params, array $record)
    {
        parent::__construct($params, $record);

        $this->isGenerateAvatar = $params["isGenerateAvatar"] ?? false;
        $this->isGenerateNameProfile = $params["isGenerateNameProfile"] ?? false;
        $this->isGeneratePositionProfile = $params["isGeneratePositionProfile"] ?? false;
        $this->isGeneratePOSProfile = $params["isGeneratePOSProfile"] ?? false;

        $this->generateAvatarParams = $params["generateAvatarParams"] ?? [];
        $this->generateNameProfileParams = $params["generateNameProfileParams"] ?? [];
        $this->generatePositionProfileParams = $params["generatePositionProfileParams"] ?? [];
        $this->generatePOSProfileParams = $params["generatePOSProfileParams"] ?? [];

        $this->initialize();
    }

#region init
    protected function initialize()
    {
        if($this->getStatusCode() != 100) return null;

        if($this->isGenerateAvatar)$this->generateAvatar($this->generateAvatarParams);
        if($this->isGenerateNameProfile)$this->generateNameProfile($this->generateNameProfileParams);
        if($this->isGeneratePositionProfile)$this->generatePositionProfile($this->generatePositionProfileParams);
        if($this->isGeneratePOSProfile)$this->generatePOSProfile($this->generatePOSProfileParams);
    }
#endregion init

#region set status
#endregion

#region setting variable
#endregion setting variable

#region getting / returning variable
    public function getAvatarFileLink(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        if(count($params))$this->generateAvatar($params);
        if(!isset($this->avatarFileLink))$this->generateAvatar();
        return $this->avatarFileLink;
    }
    public function getAvatarHtml(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        if(count($params))$this->generateAvatar($params);
        if(!isset($this->avatarHtml))$this->generateAvatar();
        return $this->avatarHtml;
    }
    public function getNameProfile(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        if(count($params))$this->generateNameProfile($params);
        if(!isset($this->nameProfile))$this->generateNameProfile();
        return $this->nameProfile;
    }
    public function getPositionProfile(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        if(count($params))$this->generatePositionProfile($params);
        if(!isset($this->positionProfile))$this->generatePositionProfile();
        return $this->positionProfile;
    }
    public function getPOSProfile(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        if(count($params))$this->generatePOSProfile($params);
        if(!isset($this->POSProfile))$this->generatePOSProfile();
        return $this->POSProfile;

    }
#endregion  getting / returning variable

#region data process
    protected function generateAvatar(array $params = NULL)
    {
        if($this->getStatusCode() != 100) return null;

        $avatarParams = array(
            "page" => "UranusUserRecord",
            "group" => "UranusUserRecord".rand(1000,9999),
            "id" => "Id".$this->Id,
            "employee" => [
                "AvatarFileName" => $this->AvatarFileName
                ,"GenderId" => $this->GenderId
            ],
            "size" => $params["size"] ?? 50
        );
        $avatar = new \app\pages\Avatar($avatarParams);
        $avatar->begin();
        $avatar->end();

        $this->avatarFileLink = $avatar->getUrl();
        $this->avatarHtml = $avatar->getHtml(true);
    }
    protected function generateNameProfile(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        $glue = $params["glue"] ?? " ";

        $nameProfiles = [];

        $FaIconGender = "";

        $FaIconGender = "";
        if($this->GenderId == 1)$FaIconGender = "<i class='fa-solid fa-mars fa-fw text-primary'></i> ";
        if($this->GenderId == 2)$FaIconGender = "<i class='fa-solid fa-venus fa-fw text-danger'></i> ";
        if($this->Username)$nameProfiles[] = "{$FaIconGender}<span class='fw-bold'>{$this->Name} (NIP {$this->EmployeeId})</span>";
        $nameProfiles[] = "<span class='text-muted fst-italic ms-3'>aka {$this->Username}</span> (UID {$this->Id})";

        $BirthDate = \DateTime::createFromFormat('Y-m-d', $this->BirthDate);
        $BirthDay = $BirthDate->format('j F');
        $nameProfiles[] = "<i class='fa-solid fa-cake-candles fa-fw'></i> {$BirthDay}, {$this->BirthPlace}";
        if($this->EmailAddress)$nameProfiles[] = "<i class='fa-solid fa-at fa-fw'></i> {$this->EmailAddress}";

        $this->nameProfile = implode("<br/>", $nameProfiles);
    }
    protected function generatePositionProfile(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        $glue = $params["glue"] ?? "-";
        $orders = $params["orders"] ?? ["DirectorateName","DivisionName","DepartmentName","SubDepartmentName","SectionName","PositionName","GroupName"];
        if($this->getStatusCode() != 100) return null;

        $positionProfiles = [];
        foreach($orders AS $index => $order)
        {
            if(in_array($order, $this->positionFields) && in_array($order, $this->columns))
            {
                if($this->$order && !in_array($this->$order, $positionProfiles))
                {
                    if($order == "GroupName")
                    {
                        if($this->$order != "-")
                        {
                            if(count($positionProfiles))
                                $positionProfiles[(count($positionProfiles) - 1)] .= " (".$this->$order.")";
                            else
                                $positionProfiles[] = "(".$this->$order.")";
                        }
                    }
                    else if($order == "PositionName" || $order == "PositionCode")
                    {
                        $positionProfiles[] = "<span class='fw-bold'>{$this->$order}</span>";
                    }
                    else $positionProfiles[] = $this->$order;
                }
            }
        }

        if($this->ESTypeId >= 4)
        {
            $endDate = \DateTime::createFromFormat('Y-m-d', $this->ESStartDate);
            $positionProfiles[] = "<span class=''>{$this->ESTypeName} {$endDate->format('j F Y')}</span>";
        }

        if($glue == "-")$glue = " - ";
        $this->positionProfile = implode($glue, $positionProfiles);
    }
    protected function generatePOSProfile(array $params = [])
    {
        if($this->getStatusCode() != 100) return null;

        $glue = $params["glue"] ?? ", ";
        $POSProfiles = [];
        $POSProfiles[] = $this->CompanyName;
        $POSProfiles[] = $this->BranchName;
        if($this->CabangPOS == "PUSAT") $POSProfiles[] = "HEAD OFFICE {$this->PusatCabang}";
        else if($this->BranchName != $this->POSName) $POSProfiles[] = $this->POSName;

        $this->POSProfile = implode($glue, $POSProfiles);
    }
#endregion data process
}


