<?php
?>
<h2>Welcome to <?php echo APP_NAME;?></h2>
<div id="moduleList02" class="d-flex mw-100" style="min-width:100%">
    <div class="mw-100">
        <div class="overflow-auto">
            <div id="module-list" class="module-list d-flex">
            <?php
                $ModuleId = 0;
                foreach($_MODULE_PAGES AS $index => $modulePage)
                {
                    if($ModuleId != $modulePage["ModuleId"])
                    {
                        if($ModuleId != 0)
                        {
                                echo "</ul>";
                            echo "</div>";
                        }
                        $ModuleId = $modulePage["ModuleId"];

                        echo "<div class='module-item dropdown-center btn-group'>";
                            echo "<a class='btn btn-secondary px-4' type='button' href='/".ROOT."{$modulePage["ModuleRouteName"]}'>";
                                echo "<img class='module-image' src='/".IMAGE_ROOT."module/{$modulePage['ModuleImage']}' title='{$modulePage['ModuleName']}'/>";
                            echo "</a>";
                            echo "<button class='btn btn-secondary dropdown-toggle dropdown-toggle-split' type='button' data-bs-toggle='dropdown' aria-expanded='false'></button>";
                            echo "<ul class='dropdown-menu'>";
                            echo "<li><a class='fw-bold text-center text-decoration-underline dropdown-item' href='/".ROOT."{$modulePage["ModuleRouteName"]}'>{$modulePage['ModuleName']}</a></li>";
                    }

                    $PageRouteName = $modulePage["PageRouteName"] ? $modulePage["PageRouteName"] : "p{$modulePage["PageId"]}";
                    echo "<li><a class='dropdown-item' href='/".ROOT."{$modulePage["ModuleRouteName"]}/{$PageRouteName}'>{$modulePage['PageName']}</a></li>";
                }
                    echo "</ul>";
                echo "</div>";
            ?>
            </div>
        </div>
    </div>
</div>
<br/>
<main id="articles">
    <h6>NEWS FEED</h6>
</main>
