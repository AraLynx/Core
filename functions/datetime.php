<?php
function generateDateText($date, $oldFormat = "Y-m-d", $newFormat = "j F Y"){
    $dateObj = \DateTime::createFromFormat($oldFormat, $date);
    return $dateObj->format($newFormat);
}

function generateDateTimeText($datetime, $oldFormat = "Y-m-d H:i:s", $newFormat = "j F Y, H:i:s"){
    $datetimeObj = \DateTime::createFromFormat($oldFormat, $datetime);
    return $datetimeObj->format($newFormat);

}
