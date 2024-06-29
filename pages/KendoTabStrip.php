<?php
namespace app\pages;
use app\core\Page;

class KendoTabStrip extends Page
{
    protected array $contents;
    protected int $selectedIndex = 0;
    protected array $disabledIndexes = [];
    public function __construct(array $params)
    {
        parent::__construct($params["page"]);
        $this->id = $params["id"] ?? "";
        $this->group = $params["group"] ?? "";

        $this->contents = $params["contents"] ?? [];
        $this->selectedIndex = $params["selectedIndex"] ?? 0;
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
        $this->elementId = "{$this->group}TabStrip{$this->id}";
        $this->html = "<div id='{$this->elementId}'>";

        $this->renderContent();
    }
    protected function renderContent()
    {
        $titles = [];
        $bodies = [];
        foreach($this->contents AS $index => $content)
        {
            $titles[] = $content["title"];
            $bodies[] = $content["body"];
            $disabled = $content["disable"] ?? false;
                if($disabled)$this->disabledIndexes[] = $index;
            $selected = $content["selected"] ?? false;
                if($selected)$this->selectedIndex = $index;
        }

        $this->html .= "<ul>";
        foreach($titles AS $title)
        {
            $this->html .= "<li>{$title}</li>";
        }
        $this->html .= "</ul>";

        foreach($bodies AS $body)
        {
            $this->html .= "<div>{$body}</div>";
        }
    }
    public function end()
    {
        if($this->getStatusCode() != 100) {return false;}
        if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        $this->isEnd = 1;

        $this->html .= "</div>";
        $this->js .= "TDE.{$this->elementId} = $('#{$this->elementId}').kendoTabStrip({animation:  {open: {effects: 'fadeIn'}}}).data('kendoTabStrip');";
        $this->js .= "TDE.{$this->elementId}.select({$this->selectedIndex});";
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
#endregion data process
}
