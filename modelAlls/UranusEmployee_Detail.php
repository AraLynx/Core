<?php
namespace app\modelAlls;
use app\core\ModelAll;
use app\core\Record;

class UranusEmployee_Detail extends ModelAll
{
    public function __construct($params = NULL)
    {
        $params["dbName"] = "uranus";
        $params["dataName"] = "Employee_Detail";

        parent::__construct($params);
    }
}

class UranusEmployee_DetailRecord extends Record
{
    protected array $positionFields = [
        "DirectorateName","DivisionName","DepartmentName","SubDepartmentName","SectionName","PositionName","GroupName"
        ,"DirectorateCode","DivisionCode","DepartmentCode","SubDepartmentCode","SectionCode","PositionCode"
    ];

    protected array $childPositionIds;
    protected array $directChildPositionIds;
    protected array $allChildPositionIds;

    protected array $parentPositionIds;
    protected array $directParentPositionIds;
    protected array $allParentPositionIds;

    protected array $relOfChild;
    protected array $relOfParent;

    protected bool $isGenerateSelectTemplate;
    protected bool $isGenerateAvatar;
    protected bool $isGenerateNameProfile;
    protected bool $isGeneratePositionProfile;
    protected bool $isGeneratePOSProfile;
    protected bool $isGeneratePositionHierarchy;

    public array $selectTemplate;
    public string $avatarFileLink;
    public string $avatarHtml;
    public string $nameProfile;
    public string $positionProfile;
    public string $POSProfile;

    public function __construct(array $params, array $record)
    {
        parent::__construct($params, $record);

        $this->isGenerateSelectTemplate = $params["generateSelectTemplate"] ?? false;

        $this->isGenerateAvatar = $params["generateAvatar"] ?? true;
        $this->isGenerateNameProfile = $params["generateNameProfile"] ?? true;
        $this->isGeneratePositionProfile = $params["generatePositionProfile"] ?? true;
        $this->isGeneratePOSProfile = $params["generatePOSProfile"] ?? true;
        $this->isGeneratePositionHierarchy = $params["generatePositionHierarchy"] ?? false;

        $this->initialize();
    }

    #region init
        protected function initialize()
        {
            if($this->getStatusCode() != 100) return null;

            if($this->isGenerateAvatar)$this->generateAvatar();
            if($this->isGenerateNameProfile)$this->generateNameProfile();
            if($this->isGeneratePositionProfile)$this->generatePositionProfile();
            if($this->isGeneratePOSProfile)$this->generatePOSProfile();
            if($this->isGeneratePositionHierarchy)$this->generatePositionHierarchy();

            if($this->isGenerateSelectTemplate)$this->generateSelectTemplate();
        }
    #endregion init

    #region set status
    #endregion

    #region setting variable
    #endregion setting variable

    #region getting / returning variable
        public function getPositionHierarchy(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            if(isset($params))$this->generatePositionHierarchy($params);
            if(!isset($this->childPositionIds))$this->generatePositionHierarchy();

            return [
                "childPositionIds" => $this->childPositionIds
                ,"directChildPositionIds" => $this->directChildPositionIds
                ,"allChildPositionIds" => $this->allChildPositionIds

                ,"parentPositionIds" => $this->parentPositionIds
                ,"directParentPositionIds" => $this->directParentPositionIds
                ,"allParentPositionIds" => $this->allParentPositionIds
            ];
        }
    #endregion  getting / returning variable

    #region data process
        public function getAvatarLink(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            if(isset($params))$this->generateAvatar($params);
            if(!isset($this->avatarFileLink))$this->generateAvatar();

            return $this->avatarFileLink;
        }
        public function getAvatarHtml(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            if(isset($params))$this->generateAvatar($params);
            if(!isset($this->avatarHtml))$this->generateAvatar();

            return $this->avatarHtml;
        }
        public function getNameProfile(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            if(isset($params))$this->generateNameProfile($params);
            if(!isset($this->nameProfile))$this->generateNameProfile();

            return $this->nameProfile;
        }
        public function getPositionProfile(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            if(isset($params))$this->generatePositionProfile($params);
            if(!isset($this->positionProfile))$this->generatePositionProfile();

            return $this->positionProfile;
        }
        public function getPOSProfile(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            if(isset($params))$this->generatePOSProfile($params);
            if(!isset($this->POSProfile))$this->generatePOSProfile();

            return $this->POSProfile;
        }
        protected function generateSelectTemplate(array $params = NULL)
        {
            $this->isGenerateAvatar = false;
            $this->isGenerateNameProfile = false;
            $this->isGeneratePositionProfile = false;
            $this->isGeneratePOSProfile = false;

            $this->selectTemplate = [
                "Value" => $this->Id,
                "Text" => $this->Name,
                //for templates
                "AvatarFileLink" => $this->avatarFileLink ?? "",
                "Name"  => $this->Name,
                "Id"  => $this->Id,
                "PositionName" => $this->PositionName
            ];
        }
        protected function generateAvatar(array $params = NULL)
        {
            if($this->getStatusCode() != 100) return null;

            if(!isset($this->AvatarFileName) || !isset($this->GenderId)) return null;

            $avatarParams = array(
                "page" => "UranusEmployeeRecord",
                "group" => "UranusEmployeeRecord".rand(1000,9999),
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

            if(!isset($this->GenderId) || !isset($this->Name) || !isset($this->Id) || !isset($this->Username) || !isset($this->BirthDate) || !isset($this->EmailAddress)) return null;

            $glue = $params["glue"] ?? " ";

            $nameProfiles = [];

            $FaIconGender = "";
            if($this->GenderId == 1)$FaIconGender = "<i class='fa-solid fa-mars fa-fw text-primary'></i> ";
            if($this->GenderId == 2)$FaIconGender = "<i class='fa-solid fa-venus fa-fw text-danger'></i> ";
            $nameProfiles[] = "{$FaIconGender}<span class='fw-bold'>{$this->Name}</span> (NIK {$this->Id})";
            if($this->Username)$nameProfiles[] = "<small class='text-muted fst-italic ms-3'>aka {$this->Username}</small>";

            $BirthDate = \DateTime::createFromFormat('Y-m-d', $this->BirthDate);
            $BirthDay = $BirthDate->format('j F');
            $nameProfiles[] = "<i class='fa-solid fa-cake-candles fa-fw'></i> {$BirthDay}, {$this->BirthPlace}";

            if($this->EmailAddress)$nameProfiles[] = "<i class='fa-solid fa-at fa-fw'></i> {$this->EmailAddress}</small>";

            $this->nameProfile = implode("<br/>", $nameProfiles);
        }
        protected function generatePositionProfile(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            $glue = $params["glue"] ?? "-";
            $orders = $params["orders"] ?? ["DirectorateName","DivisionName","DepartmentName","SubDepartmentName","SectionName","PositionName","GroupName"];

            $positionProfiles = [];
            foreach($orders AS $index => $order)
            {
                if(in_array($order, $this->positionFields) && in_array($order, $this->columns))
                {
                    if(isset($this->$order) && $this->$order && !in_array($this->$order, $positionProfiles))
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

            if(isset($this->ESTypeId) && $this->ESTypeId >= 4)
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

            if(!isset($this->CompanyName) || !isset($this->BranchName) || !isset($this->CabangPOS) || !isset($this->PusatCabang) || !isset($this->POSName)) return null;

            $glue = $params["glue"] ?? ", ";
            $POSProfiles = [];
            $POSProfiles[] = $this->CompanyName;
            $POSProfiles[] = $this->BranchName;
            if($this->CabangPOS == "PUSAT") $POSProfiles[] = "HEAD OFFICE {$this->PusatCabang}";
            else if($this->BranchName != $this->POSName) $POSProfiles[] = $this->POSName;

            $this->POSProfile = implode($glue, $POSProfiles);
        }
        protected function generatePositionHierarchy(array $params = [])
        {
            if($this->getStatusCode() != 100) return null;

            $this->childPositionIds = [];
            $this->directChildPositionIds = [];
            $this->allChildPositionIds = [];

            $this->parentPositionIds = [];
            $this->directParentPositionIds = [];
            $this->allParentPositionIds = [];

            $model = new \app\modelRels\UranusPositionHierarchy();
            $rels = $model->f5();
            foreach($rels AS $index => $rel)
            {
                $parentPositionId = $rel->ParentPositionId;
                $childPositionId = $rel->ChildPositionId;

                if(!isset($this->relOfParent[$parentPositionId]))
                    $this->relOfParent[$parentPositionId] = [];

                $this->relOfParent[$parentPositionId][] = $childPositionId;

                if(!isset($this->relOfChild[$childPositionId]))
                    $this->relOfChild[$childPositionId] = [];

                $this->relOfChild[$childPositionId][] = $parentPositionId;
            }

            $positionId = $this->PositionId;

            $searchChild = $params["searchChild"] ?? true;
            $childOrderLimit = $params["childOrderLimit"] ?? 99;
            if($searchChild)
                $this->generateChildPositionIds($positionId, 0, $childOrderLimit);

            $searchParent = $params["searchParent"] ?? true;
            $parentOrderLimit = $params["parentOrderLimit"] ?? 99;
            if($searchParent)
                $this->generateParentPositionIds($positionId, 0, $parentOrderLimit);
        }
            protected function generateChildPositionIds(int $positionId, int $order, int $limitOrder)
            {
                if($limitOrder > $order)
                {
                    /*
                    $model = new \app\modelRels\UranusPositionHierarchy();
                    $model->addParameter("ParentPositionId", $positionId);
                    $rels = $model->f5();
                    */
                    if(isset($this->relOfParent[$positionId]))
                    {
                        foreach($this->relOfParent[$positionId] AS $index => $childPositionId)
                        {
                            $nextOrder = $order+1;

                            if(!$order && !in_array($childPositionId, $this->directChildPositionIds))
                                $this->directChildPositionIds[] = $childPositionId;

                            if(!isset($this->childPositionIds[$order]))
                                $this->childPositionIds[$order] = [];

                            if(!in_array($childPositionId, $this->childPositionIds[$order]))
                            {
                                $this->childPositionIds[$order][] = $childPositionId;
                            }

                            if(!in_array($childPositionId, $this->allChildPositionIds))
                            {
                                $this->allChildPositionIds[] = $childPositionId;
                            }

                            $this->generateChildPositionIds($childPositionId, $nextOrder, $limitOrder);
                        }
                    }
                }
            }
            protected function generateParentPositionIds(int $positionId, int $order, int $limitOrder)
            {
                if($limitOrder > $order)
                {
                    if(isset($this->relOfChild[$positionId]))
                    {
                        foreach($this->relOfChild[$positionId] AS $index => $parentPositionId)
                        {
                            $nextOrder = $order+1;

                            if(!$order && !in_array($parentPositionId, $this->directParentPositionIds))
                                $this->directParentPositionIds[] = $parentPositionId;

                            if(!isset($this->parentPositionIds[$order]))
                                $this->parentPositionIds[$order] = [];

                            if(!in_array($parentPositionId, $this->parentPositionIds[$order]))
                            {
                                $this->parentPositionIds[$order][] = $parentPositionId;
                            }

                            if(!in_array($parentPositionId, $this->allParentPositionIds))
                            {
                                $this->allParentPositionIds[] = $parentPositionId;
                            }

                            $this->generateParentPositionIds($parentPositionId, $nextOrder, $limitOrder);
                        }
                    }
                }
            }
    #endregion data process

}


