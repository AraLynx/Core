<?php
namespace app\components;
use app\core\Component;

class BSModal extends Component
{
    protected string $defaultTitle = "Information";
    protected string $defaultBody = "Info goes here";
    protected string $defaultFooter = "";

    protected string $title = "";
    protected string $body = "";
    protected string $footer = "";

    protected string $mask = "static";
    protected string $closeOnEscapeKeyPress = "true";
    protected string $focus = "true";

    public function __construct(array $params)
    {
        parent::__construct($params["page"]);
        $this->id = $params["id"] ?? "";
        $this->group = $params["group"] ?? "";

        if(isset($params["title"]))
        {
            $this->defaultTitle = $params["title"];
            $this->setTitle($params["title"]);
        }
        if(isset($params["body"]))
        {
            $this->defaultBody = $params["body"];
            $this->setBody($params["body"]);
        }
        if(isset($params["footer"]))
        {
            $this->defaultFooter = $params["footer"];
            $this->setFooter($params["footer"]);
        }
        if(isset($params["mask"]))$this->setMask($params["mask"]);
        if(isset($params["setCloseOnEscapeKeyPress"]))$this->setCloseOnEscapeKeyPress($params["setCloseOnEscapeKeyPress"]);
        if(isset($params["focus"]))$this->setFocus($params["focus"]);
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
            $this->elementId = "{$this->group}Modal{$this->id}";
        }
        public function end()
        {
            if($this->getStatusCode() != 100) {return false;}
            if(!$this->isBegin) {$this->setStatusCode(602);return false;}//Page is not yet begin
            if($this->isEnd){$this->setStatusCode(603);return false;}//Page is already ended

            $this->isEnd = 1;

            $this->html = "<div class='modal'
                id='{$this->elementId}'
                data-bs-backdrop= '{$this->mask}'
                data-bs-keyboard= '{$this->closeOnEscapeKeyPress}'
                data-bs-focus= '{$this->focus}'
                tabindex='-1'
                aria-labelledby='{$this->elementId}Label'
                aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='{$this->elementId}Title'>{$this->title}</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body' id='{$this->elementId}Body'>{$this->body}</div>
                        <div class='modal-footer' id='{$this->elementId}Footer'>{$this->footer}</div>
                    </div>
                </div>
            </div>";

            $this->js .= "TDE.{$this->elementId} = new bootstrap.Modal(document.getElementById('{$this->elementId}'));
                    TDE.{$this->elementId}.Title = $('#{$this->elementId}Title');
                    TDE.{$this->elementId}.Body = $('#{$this->elementId}Body');
                    TDE.{$this->elementId}.Footer = $('#{$this->elementId}Footer');

                    TDE.{$this->elementId}.Reset = function(){
                        let title = \"{$this->defaultTitle}\";
                        let body = \"{$this->defaultBody}\";
                        let footer = \"{$this->defaultFooter}\";

                        TDE.{$this->elementId}.Title.html(title);
                        TDE.{$this->elementId}.Body.html(body);
                        TDE.{$this->elementId}.Footer.html(footer);

                        TDE.{$this->elementId}.Body.removeClass('alert-primary');
                        TDE.{$this->elementId}.Body.removeClass('alert-secondary');
                        TDE.{$this->elementId}.Body.removeClass('alert-success');
                        TDE.{$this->elementId}.Body.removeClass('alert-danger');
                        TDE.{$this->elementId}.Body.removeClass('alert-warning');
                        TDE.{$this->elementId}.Body.removeClass('alert-info');
                        TDE.{$this->elementId}.Body.removeClass('alert-light');
                        TDE.{$this->elementId}.Body.removeClass('alert-dark');
                    };";

            $this->js .= "TDE.{$this->elementId}.Display = function (params = {}){
                        TDE.{$this->elementId}.Reset();
                        if('title' in params)TDE.{$this->elementId}.Title.html(params.title);
                        if('body' in params)TDE.{$this->elementId}.Body.html(params.body);
                        if('footer' in params)TDE.{$this->elementId}.Footer.html(params.footer);
                        TDE.{$this->elementId}.show();
                    };";
        }

        public function setTitle(string $title)
        {
            $this->title = $title;
        }
        public function setBody(string $body)
        {
            $this->body = $body;
        }
        public function setFooter(string $footer)
        {
            $this->footer = $footer;
        }
        public function setMask(string $mask)
        {
            /*
            mask value options
            ======================
            false   = no mask
            true    = show mask + close on click outside
            static  = show mask + not close on click outside
            */
            $this->mask = $mask;
        }
        public function setCloseOnEscapeKeyPress(bool $closeOnEscapeKeyPress)
        {
            $this->closeOnEscapeKeyPress = $closeOnEscapeKeyPress;
        }
        public function setFocus(bool $focus)
        {
            $this->focus = $focus;
        }
    #endregion setting variable

    #region getting / returning variable
    #endregion  getting / returning variable

    #region data process
    #endregion data process
}
