<script src="/<?php echo COMMON_JS;?>default_sidebar.js" defer></script>
<?php
?>
<div id="sidebar" class="offcanvas offcanvas-start bg-dark" tabindex="-1" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header">
        <img src="/<?php echo COMMON_IMAGE;?>Logo_<?php echo strtoupper(APP_NAME);?>_100White.png" alt="Logo" style="height:25px;"/>
        <h5 class="offcanvas-title text-light text-center" id="sidebarLabel">
            <?php echo APP_NAME;?> Pages
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body pt-0">
        <hr class="d-lg-none text-white">
        <div id="sidebarContent">
            <?php
                $ModuleId = 0;
                $PageId = 0;
                foreach($_MODULE_PAGES AS $index => $modulePage)
                {
                    if($ModuleId != $modulePage["ModuleId"])
                    {
                        //NEW MODULE
                        if($ModuleId)
                        {
                            echo "</div>";
                            echo "<hr class='text-light m-1'/>";
                        }

                        echo "<a class='d-flex align-items-center text-light' role='button' data-bs-toggle='collapse' data-bs-target='#collapse_{$modulePage['ModuleId']}'>";
                            echo "<img class='module-image me-2 mb-1' src='/".IMAGE_ROOT."module/{$modulePage['ModuleImage']}'/>";
                            echo "<p>{$modulePage['ModuleName']}</p>";
                        echo "</a>";
                        echo "<div id='collapse_{$modulePage['ModuleId']}' class='accordion-collapse collapse' data-bs-parent='#sidebarContent'>";

                        $ModuleId = $modulePage["ModuleId"];
                    }

                    $PageRouteName = $modulePage["PageRouteName"] ? $modulePage["PageRouteName"] : "p{$modulePage["PageId"]}";
                    echo "<a class='d-flex align-items-center ms-4 text-light' role='button' href='/".ROOT."{$modulePage["ModuleRouteName"]}/{$PageRouteName}'>";
                        echo "<img class='page-image me-2 mb-1' src='/".IMAGE_ROOT."page/{$modulePage['PageImage']}'/>";
                        echo "<p>{$modulePage['PageName']}</p>";
                    echo "</a>";
                }
                echo "</div>";
            ?>
            <?php
            if($_IS_REPORT_ACCESS)
            { ?>
                <hr class='text-light m-1'/>
                <a class="d-flex align-items-center text-light" role="button" href='/<?php echo ROOT;?>report'>
                    <i class='fa-solid fa-chart-line fa-fw pe-4'></i>
                    <p>REPORT</p>
                </a>
            <?php }
            ?>

            <hr class='text-light m-1'/>
            <a class="d-flex align-items-center text-light" role="button" onClick="defaultChangeLogGetChangeLogsFromSidebar();">
                <i class='fa-solid fa-book fa-fw pe-4'></i>
                <p>CHANGE LOG</p>
            </a>
            <hr class='text-light m-1'/>
            <?php
            if(APP_NAME != "Gaia")
            { ?>
                <a class="d-flex align-items-center text-light" role="button" href="/<?php echo TDE_ROOT;?>/Gaia/">
                    <img src="/<?php echo COMMON_IMAGE;?>Logo_GAIA_16.png" class="pe-1"/>
                    <p>GAIA</p>
                </a>
            <?php }

            if(APP_NAME != "Selene")
            { ?>
                <a class="d-flex align-items-center text-light" role="button" href="/<?php echo TDE_ROOT;?>/Selene/">
                    <img src="/<?php echo COMMON_IMAGE;?>Logo_SELENE_16.png" class="pe-1"/>
                    <p>SELENE</p>
                </a>
            <?php }

            if(APP_NAME != "Plutus")
            { ?>
                <a class="d-flex align-items-center text-light" role="button" href="/<?php echo TDE_ROOT;?>/Plutus/">
                    <img src="/<?php echo COMMON_IMAGE;?>Logo_PLUTUS_16.png" class="pe-1"/>
                    <p>PLUTUS</p>
                </a>
            <?php }

            if(APP_NAME == "Plutus" && count($_OTHER_BRANCHES))
            { ?>
                <a class="d-flex align-items-center text-light" role="button" onClick="TDE.sidebar.toggle();TDE.defaultKendoWindowSwitchBranch.center().open();">
                    <i class="fa-solid fa-repeat fa-fw pe-4"></i>
                    <p>SWITCH BRANCH</p>
                </a>
            <?php }
            ?>
            <a class="d-flex align-items-center text-light" role="button" onClick="defaultLogoutConfirmationMessage();">
                <i class="fa-solid fa-arrow-right-from-bracket fa-fw pe-4"></i>
                <p>LOGOUT</p>
            </a>
        </div>
    </div>
</div>
