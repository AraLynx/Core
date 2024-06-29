<?php
require_once dirname(__DIR__,4)."/Chronos/functions/numeric.php";

$DateStart = $post["DateStart"];
$DateEnd = $post["DateEnd"];

$documentAdditionalInfo = "";
if($DateStart == $DateEnd) $documentAdditionalInfo = "transaksi tgl {$DateStart}";
else $documentAdditionalInfo = "transaksi periode {$DateStart} s/d {$DateEnd}";

$params = [
    "cbpProfile" => $CBPProfile,

    "documentTitle" => "LAPORAN HARIAN BANK",
    "documentAdditionalInfo" => $documentAdditionalInfo,

    "paperSize" => "A4 landscape",
    "itemMaxCount" => 24,
    "itemCountForHeader" => 2,
    "itemCountForFooter" => 8,

    "items" => $report,

    "footerSignatures" => [
        [
            "title" => "Dibuat",
            "name" => $User->Name,
            "position" => $User->PositionName,
            "dateTime" => date("j F Y, H:i:s")
        ],
        [
            "title" => "Diketahui",
        ],
        [
            "title" => "Disejutui",
        ],
    ],
];
$PrintOut = new \app\core\PrintOut($params);
$PageItems = $PrintOut->generateItems();
echo $PrintOut->getPrepareView();
//dd($PageItems);
?>
<?php
$tableIsOpen = false;
foreach($PageItems AS $Page => $Items)
{?>
    <section class="sheet p-4">
        <?php
            echo $PrintOut->getHeader([
                "page" => $Page,
                "logo" => ["isShow" => false],
            ]);
        ?>
        <div class="print_body">
            <?php
                foreach($Items AS $Item)
                {
                    $type = $Item["type"];
                    if($type == "summary")
                    {
                        echo "<p class='fw-bold'>COA {$Item["Code"]} | {$Item["Name"]} : Saldo ".generatePrice($Item["Balance"])."</p>";
                    }
                    else
                    {
                        if(!$tableIsOpen)
                        {
                            $tableIsOpen = true;
                            ?>
                            <table>
                                <tr>
                                    <th width="40px"><p class='text-center'>No.</p></th>
                                    <th width="120px"><p class='text-center'>Tanggal</p></th>
                                    <th width="200px"><p class='text-center'>No Referensi</p></th>
                                    <th width="345px"><p class='text-center'>Keterangan</p></th>
                                    <th width="120px"><p class='text-center'>Debit (Rp)</p></th>
                                    <th width="120px"><p class='text-center'>Credit (Rp)</p></th>
                                    <th width="140px"><p class='text-center'>Saldo (Rp)</p></th>
                                </tr>
                        <?php }

                        if($type == "transaction")
                        {?>
                            <tr>
                                <td><p class="text-end"><?php echo $Item["No"] ? $Item["No"] : "";?></p></td>
                                <td><p><?php echo $Item["DateTime"];?></p></td>
                                <td><p><span class="d-inline-block text-truncate" style="max-width: 200px;"><?php echo $Item["ReferenceNumber"];?></span></p></td>
                                <td><p><span class="d-inline-block text-truncate" style="max-width: 345px;"><?php echo $Item["Description"];?></span></p></td>
                                <td><p class="text-end"><?php echo generatePrice($Item["Debit"]);?></p></td>
                                <td><p class="text-end"><?php echo generatePrice($Item["Credit"]);?></p></td>
                                <td><p class="text-end"><?php echo generatePrice($Item["Balance"]);?></p></td>
                            </tr>
                        <?php }
                        else if($type == "total")
                        {?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><p class="text-end fw-bold">Total</p></td>
                                <td><p class="text-end fw-bold"><?php echo generatePrice($Item["Debit"]);?></p></td>
                                <td><p class="text-end fw-bold"><?php echo generatePrice($Item["Credit"]);?></p></td>
                                <td></td>
                            </tr>
                        <?php }
                        else if($type == "newLine")
                        {
                            echo "</table><br/>";
                            $tableIsOpen = false;
                        }
                    }
                }
                if($tableIsOpen)
                {
                    echo "</table>";
                    $tableIsOpen = false;
                }
            ?>
        </div>
        <?php
            echo $PrintOut->getFooter([
                "page" => $Page
            ]);
        ?>
    </section>
<?php }
?>
