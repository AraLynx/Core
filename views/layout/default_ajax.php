<script src="/<?php echo COMMON_JS;?>default_ajax.js" defer></script>
<?php
$modalParams = array(
    "page" => "default",
    "group" => "ajax",
    "id" => "",
    "title" => "Information",
    "body" => "Page is loading...",
    "footer" => "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>"
);
$ajaxModal = new \app\pages\BSModal($modalParams);
$ajaxModal->begin();
$ajaxModal->end();
$ajaxModal->render();
