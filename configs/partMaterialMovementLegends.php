<?php
$partMaterialMovementLegends = [
    "GR" => "GOOD RECEIVE",
    "GI" => "GOOD ISSUE",
    "GI (X)" => "BATAL GOOD ISSUZE",
    "MTO" => "MUTASI OUT (KELUAR)",
    "MTO (X)" => "BATAL MUTASI OUT (KELUAR)",
    "MTO (R)" => "MUTASI OUT (KELUAR), TIDAK DITERIMA",
    "MTI" => "MUTASI IN (MASUK)",
    "ADJ" => "QTY ADJUSTMENT",
];
?>

<div class="row">
    <div class="col">
        <?php
            $codes = ["GR", "GI", "GI (X)", "ADJ"];
            $legends = [];
            foreach($codes AS $index => $code)
            {
                $legends[] = $code." : ".$partMaterialMovementLegends[$code];
            }
            echo implode("<br/>",$legends);
        ?>
    </div>
    <div class="col">
        <?php
            $codes = ["MTO", "MTO (X)", "MTO (R)", "MTI"];
            $legends = [];
            foreach($codes AS $index => $code)
            {
                $legends[] = $code." : ".$partMaterialMovementLegends[$code];
            }
            echo implode("<br/>",$legends);
        ?>
    </div>
</div>
