<?php
function generateNumber($number, $delimiterThousand = ".", $delimiterDecimal = ",", $decimalNumber = false){
    if(round($number) != $number && $decimalNumber === false) $decimalNumber = 2;
    if($decimalNumber === false)$decimalNumber = 0;
    return number_format($number,$decimalNumber,$delimiterDecimal,$delimiterThousand);
}
function generateDecimal($number, $decimalNumber = 2, $delimiterThousand = ".", $delimiterDecimal = ","){
    return number_format($number,$decimalNumber,$delimiterDecimal,$delimiterThousand);
}
function generatePrice($number, $currency = "rupiah", $isNegatifColor = true, $negatifClass = "text-danger"){
    if($currency == "rupiah") $return = "Rp ".generateNumber($number);
    else $return = generateNumber($number, ",", ".");

    if($isNegatifColor && $number < 0)
    {
        $return = "<span class='{$negatifClass}'>{$return}</span>";
    }
    return $return;
}
function generatePercent($number1, $number2, $decimalNumber = 2, $delimiterThousand = ".", $delimiterDecimal = ","){
    return generateDecimal(($number1/$number2)*100,$decimalNumber,$delimiterDecimal,$delimiterThousand)."%";
}
