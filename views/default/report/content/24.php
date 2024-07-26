<?php
?>
<div id='reportDiv_<?php echo $reportId;?>' class='reportDiv d-none'>
    <?php
    $gridParams = array(
        "page" => "report",
        "group" => "report",
        "id" => "_{$reportId}",
        "toolbarString" => "<div class=\'btn btn-secondary align-middle\' onclick=\'reportGenerateExcelPrepareData({$reportId})\'>Export to Excel</div>",
        "columns" => [
            ["title" => "No", "formatType" => "rowNumber"],
            ["field" => "Cabang", "title" => "Cabang", "width" => 180],
            ["title" => "Pelanggan", "headerAttributes" => ["class" => "justify-content-center"], "columns" =>[
                ["field" => "PelangganNo", "title" => "Nomor", "formatType" => "numeric"],
                ["field" => "PelangganNama", "title" => "Nama"],
                ]
            ],
            ["field" => "Penyetor", "title" => "Penyetor"],
            ["title" => "Nomor", "headerAttributes" => ["class" => "justify-content-center"], "columns" =>[
                ["field" => "NomorCetakan", "title" => "Cetakan", "formatType" => "numberText"],
                ["field" => "NomorSistem", "title" => "Dokumen", "formatType" => "numberText"],
                ["field" => "NomorReferensi", "title" => "Referensi", "formatType" => "numberText"],
                ]
            ],
            ["field" => "PICSales", "title" => "PIC Sales"],
            ["field" => "Divisi", "title" => "Divisi", "width" => 80],
            ["title" => "Tanggal", "headerAttributes" => ["class" => "justify-content-center"], "columns" =>[
                ["field" => "TglDokumen", "title" => "Dokumen", "width" => 120],
                ["field" => "TglJurnal", "title" => "Jurnal", "width" => 120],
                ]
            ],
            ["field" => "Kendaraan", "title" => "Kendaraan", "width" => 150],
            ["field" => "Keterangan", "title" => "Keterangan", "width" => 300],
            ["field" => "Method", "title" => "Metode", "width" => 80],
            ["field" => "Nominal", "title" => "Nominal","formatType" => "currency"],
        ],
    );
    $grid = new \app\components\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
