<?php
$title = "Info";
$body = "Information goes here";
$footer = "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
$modalParams = array(
    "page" => "default",
    "group" => "common",
    "id" => "",
    "title" => $title,
    "body" => $body,
    "footer" => $footer
);
$commonModal = new \app\pages\BSModal($modalParams);
$commonModal->begin();
$commonModal->end();
$commonModal->render();
