<?php
namespace app\components;
use app\core\Component;

class ApprovalView extends Component
{
    public function __construct(array $params)
    {
        parent::__construct($params["page"]);
        $this->id = $params["id"] ?? "";
        $this->group = $params["group"] ?? "";
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
        $this->elementId = "{$this->group}ApprovalView{$this->id}";
    }
    public function end()
    {
        if($this->getStatusCode() != 100) {return false;}
        if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
        if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

        $this->isEnd = 1;

        $this->html .= "<div id='{$this->elementId}' class='d-none'>";
            $this->html .= "<h5 id='{$this->elementId}Title'>APPROVAL PROFILE</h5>";

                $gridParams = [
                    "page" => $this->page,
                    "group" => $this->group,
                    "id" => "ApprovalView{$this->id}",
                    "columnMenu" => false,
                    "filterable" => false,
                    "sortable" => false,
                    "resizable" => false,
                    "pageable" => false,
                    "height" => false,
                    "columns" => [
                        ["formatType" => "rowNumber"],
                        //["field" => "Action","title" => " ","formatType" => "action"],
                        ["field" => "ApprovalTypeItemName","title" => "Jenjang","width" => 250],
                        ["field" => "StatusCode","title" => "Status","width" => 100, "attributes" => ["class" => "text-center"]],
                        ["field" => "ApproveDisapproveEmployeeName","title" => "Oleh","width" => 250],
                        ["field" => "ApproveDisapproveDateTime","title" => "Waktu", "formatType" => "dateTime"],
                        ["field" => "ApproveDisapproveGeneralNotes","title" => "Catatan"],
                    ]
                ];
                $grid = new \app\components\KendoGrid($gridParams);
                $grid->begin();
                $grid->end();
            $this->html .= $grid->getHtml();

            $this->html .= "<hr/>";
        $this->html .= "</div>";

        $this->js .= "TDE.{$this->elementId} = $('#{$this->elementId}');";

        $this->js .= "TDE.{$this->elementId}.setTitle = function(TitleName){
            $('#{$this->elementId}Title').html(TitleName);
        };";
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
