<?php
?>
<main class="">
    <h2>Welcome to <?php echo APP_NAME;?></h2>
    <?php
        echo "<div class='row'>";
        $ModuleId = 0;
        foreach($_MODULE_PAGES AS $index => $modulePage)
        {
            if($ModuleId != $modulePage["ModuleId"])
            {
                echo "<div class='h6 module-button col-{$modulePage["ModuleBsColumn"]}'>";
                    echo "<a class='btn btn-primary d-flex justify-content-center align-items-center h-100' role='button' href='/".ROOT."{$modulePage["ModuleRouteName"]}'>";
                        echo "<img class='module-image me-2 mb-1' src='/".IMAGE_ROOT."module/{$modulePage['ModuleImage']}'/>";
                        echo "<p>{$modulePage['ModuleName']}</p>";
                    echo "</a>";
                echo "</div>";

                $ModuleId = $modulePage["ModuleId"];
            }
        }
        echo "</div>";
    ?>
</main>
