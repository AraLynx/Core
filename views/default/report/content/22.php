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
        ["title" => "Tri Mandiri", "headerAttributes" => ["class" => "justify-content-center"], "columns" =>[
            ["field" => "BrandName", "title" => "Merk",  "width" => 80],
            ["field" => "CompanyName", "title" => "Perusahaan", "width" => 200],
            ["field" => "BranchName", "title" => "Cabang", "width" => 200],
            ["field" => "POSName", "title" => "POS", "width" => 180],
            ]
        ],
        ["title" => "Referensi",  "headerAttributes" => ["class" => "justify-content-center"], "columns" =>[
            ["field" => "ReferenceNumber", "title" => "Dokumen", "width" => 250],
            ["field" => "PartnerName", "title" => "Konsumen", "width" => 250],
            ]
        ],
        ["title" => "Penerimaan",  "headerAttributes" => ["class" => "justify-content-center"], "columns" =>[
            ["field" => "HariPenerimaan", "title" => "Hari", "width" => 70],
            ["field" => "ReceivedDate", "title" => "Tanggal", "formatType" => "date"],
            ["field" => "ReceivedNumber", "title" => "Dokumen", "width" => 270],
            ["field" => "ReceiveNominal", "title" => "Tunai", "formatType" => "currency"],
            ["field" => "ReceivedFromName", "title" => "Penyetor", "width" => 250],
            ["field" => "ReceivedByEmployeeName", "title" => "Kasir", "width" => 250],
            ]
        ],
        ["title" => "Setoran",  "headerAttributes" => ["class" => "justify-content-center"], "columns" =>[
            ["field" => "DepositDate", "title" => "Tanggal", "formatType" => "date"],
            ["field" => "DepositReferenceNumber", "title" => "Referensi", "width" => 150],
            ["field" => "COA6Name", "title" => "Akun Bank", "width" => 180],
            ["field" => "Aging", "title" => "Umur", "formatType" => "numeric"],
            ]
        ],
    ],
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
