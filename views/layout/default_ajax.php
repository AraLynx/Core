<script src="/<?php echo CORE_JS;?>default_ajax.js" defer></script>
<?php
$modalParams = array(
    "page" => "default",
    "group" => "ajax",
    "id" => "",
    "title" => "Information",
    "body" => "Page is loading...",
    "footer" => "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>"
);
$ajaxModal = new \app\components\BSModal($modalParams);
$ajaxModal->begin();
$ajaxModal->end();
$ajaxModal->render();
