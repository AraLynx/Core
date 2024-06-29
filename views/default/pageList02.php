<div id="pageList02" class="d-flex mw-100" style="min-width:100%">
    <div id="page_content"  class="mw-100">
        <div class="overflow-auto">
            <div id="module-list" class="module-list d-flex">
                <?php
                    $modulePageGroup = 0;
                    foreach($_MODULE_PAGES AS $index => $modulePage)
                    {
                        if($moduleId == $modulePage["ModuleId"])
                        {
                            if($modulePageGroup != $modulePage["PageGroup"])
                            {
                                if($modulePageGroup != 0)
                                {
                                        echo "</ul>";
                                    echo "</div>";
                                }
                                $modulePageGroup = $modulePage["PageGroup"];

                                $modulePageGroupName = $moduleGroups[$modulePageGroup] ?? "Others #{$modulePageGroup}";
                                echo "<div class='module-item dropdown-center btn-group'>";
                                    echo "<button class='btn btn-secondary px-2' type='button'>";
                                        echo "{$modulePageGroupName}";
                                    echo "</button>";
                                    echo "<button class='btn btn-secondary dropdown-toggle dropdown-toggle-split' type='button' data-bs-toggle='dropdown' aria-expanded='false'></button>";
                                    echo "<ul class='dropdown-menu'>";
                            }

                            $PageRouteName = $modulePage["PageRouteName"] ? $modulePage["PageRouteName"] : "p{$modulePage["PageId"]}";
                            echo "<li><a class='dropdown-item' href='/".ROOT."{$modulePage["ModuleRouteName"]}/{$PageRouteName}'>{$modulePage['PageName']}</a></li>";

                        }
                    }
                ?>
            </div>
        </div>
        <br/>
        <main id="articles">
            <h6>NEWS FEED</h6>
        </main>
    </div>
</div>
