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
            ["title" => "Faktur", "headerAttributes" => ["class" => "justify-content-center"], "columns" =>[
                ["field" => "CompleteDateTime", "title" => "Tanggal", "formatType" => "date"],
                ["field" => "POSName", "title" => "POS", "width" => 120],
                ["field" => "NumberText", "title" => "No Dokumen", "formatType" => "numberText"],
                ]
            ],
            ["field" => "SalesMethod", "title" => "Kode Jual", "width" => 120],
            ["title" => "Pelanggan", "columns" =>[
                ["field" => "CustomerName", "title" => "Nama", "width" => 250],
                ]
            ],
            ["title" => "Kendaraan", "headerAttributes" => ["class" => "justify-content-center"], "columns" =>[
                ["title" => "Tipe", "template" => "#= VehicleGroupName # #= VehicleTypeName #", "width" => 350],
                ["field" => "UnitEngineNumber", "title" => "Nomor Mesin", "width" => 120],
                ]
            ],
            ["title" => "Harga", "columns" =>[
                ["field" => "OTRPrice", "title" => "Total AR", "formatType" => "currency"],
                ]
            ],
            ["title" => "SCO / SPV / SM / BM", "width" => 250, "template" => "(#= TeamLeaderEmployeeId #) #= TeamLeaderEmployeeName # - #= TeamLeaderEmployeeGroupName #"],
        ],
    );
    $grid = new \app\pages\KendoGrid($gridParams);
    $grid->begin();
    $grid->end();
    $grid->render();
    ?>
</div>
