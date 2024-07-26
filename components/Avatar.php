<?php
namespace app\components;
use app\core\Component;

class Avatar extends Component
{
    protected string $urlLink;
    protected int $size;
    protected array $employee;

    public function __construct(array $params)
    {
        parent::__construct($params["page"]);
        $this->id = $params["id"] ?? "";
        $this->group = $params["group"] ?? "";
        $this->employee = $params["employee"];
        $this->size = $params["size"] ?? 50;
    }

    #region init
    #endregion init

    #region set status
    #endregion

    #region setting variable
        public function begin()
        {
            if($this->getStatusCode() != 100){return false;}
            if($this->isBegin){$this->setStatusCode(601);return false;}//Page is already begin
            if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

            $this->isBegin = 1;
            $this->elementId = "{$this->group}Avatar{$this->id}";

            $this->validateAvatar();
        }
        public function end()
        {
            if($this->getStatusCode() != 100) {return false;}
            if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
            if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

            $this->isEnd = 1;
        }
    #endregion setting variable

    #region getting / returning variable
        public function getUrl()
        {
            if($this->getStatusCode() != 100){return false;}
            if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
            if(!$this->isEnd){$this->setStatusCode(604);return false;}//Page is not yet ended

            return $this->urlLink;
        }
        public function getDir()
        {
            return getcwd();
        }
        public function getHowDeepRoot()
        {
            $cwd = getcwd();
            $folders = explode("\\",$cwd);
            $startCounting = false;
            $counter = 0;
            foreach($folders AS $index => $folder)
            {
                if($folder == TDE_ROOT)$startCounting = true;

                if($startCounting)$counter++;
            }
            return $counter;
        }
    #endregion  getting / returning variable

    #region data process
        public function validateAvatar()
        {
            if($this->getStatusCode() != 100){return false;}
            if(!$this->isBegin){$this->setStatusCode(602);return false;}//Page is not yet begin
            if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

            $backDir = "";
            for($counter = 0 ; $counter < $this->getHowDeepRoot() ; $counter++)
            {
                $backDir .= "../";
            }
            if(!$this->employee["AvatarFileName"] || !file_exists($backDir.ASSET_ROOT."UserAvatar/{$this->employee["AvatarFileName"]}"))
            {
                if($this->employee["GenderId"] == 1)$this->urlLink = "/".CORE_IMAGE."avatar-male.png";
                else $this->urlLink = "/".CORE_IMAGE."avatar-female.png";
            }
            else
            {
                $this->urlLink = "/".ASSET_ROOT."UserAvatar/{$this->employee["AvatarFileName"]}";
            }

            $this->html = "<img src='{$this->urlLink}' id='{$this->elementId}' class='avatar avatar-{$this->size}'/>";
        }
    #endregion data process
}
