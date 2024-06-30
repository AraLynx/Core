<?php
namespace app\pages;
use app\core\Page;

class KendoWindow extends Page
{
    protected string $title;
    protected string $body;
    protected string $width;
    protected string $maxWidth;
    protected string $height;
    protected string $maxHeight;
    protected string $visible;
    protected bool $pinned;

    public function __construct(array $params)
    {
        parent::__construct($params["page"]);
        $this->id = $params["id"] ?? "";
        $this->group = $params["group"] ?? "";

        $this->title = $params["title"] ?? "";
        $this->body = $params["body"] ?? "";
        $this->width = $params["width"] ?? "500px";
        $this->maxWidth = $params["maxWidth"] ?? 0;
        $this->height = $params["height"] ?? "";
        $this->maxHeight = $params["maxHeight"] ?? 500;
        $this->pinned = $params["pinned"] ?? false;

        $this->visible = $params["visible"] ?? "false";
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
            $this->elementId = "{$this->group}KendoWindow{$this->id}";
        }
        public function end()
        {
            if($this->getStatusCode() != 100) {return false;}
            if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
            if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

            $this->isEnd = 1;
            $this->html = "<div id='{$this->elementId}'><div class='container' id='{$this->elementId}_body'>{$this->body}</div></div>";

            $this->js .= "TDE.{$this->elementId} = $('#{$this->elementId}').kendoWindow({
                    title: '{$this->title}',
                    visible: {$this->visible},";
            if($this->width)$this->js .= "width: '{$this->width}',";
            if($this->maxWidth)$this->js .= "maxWidth: {$this->maxWidth},";
            if($this->height)$this->js .= "height: '{$this->height}',";
            if($this->maxHeight)$this->js .= "maxheight: {$this->maxHeight},";
            if($this->pinned)$this->js .= "pinned: {$this->pinned},";
            $this->js .= "actions: ['Pin','Minimize','Maximize','Close'],";
            $this->js .= "}).data('kendoWindow');";

            //additional function
            $this->js .= "TDE.{$this->elementId}.body = function (content){
                $('#{$this->elementId}_body').html(content);
                TDE.{$this->elementId}.center();
                TDE.{$this->elementId}.open();
            };";
        }
    #endregion setting variable

    #region getting / returning variable
    #endregion  getting / returning variable

    #region data process
    #endregion data process
}
