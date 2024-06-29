<?php
    /**
     * HOW TO USE
     *
     * Change pagename to your parent content (eg: Training).
     * Change groupname/GroupName to sub content (eg: Source/Material).
     */
?>

<script>
    $(document).ready(function(){
    });
</script>

<main id="pagename" class="d-lg-flex w-100">
    <!-- Side NavBar -->
    <div id="pagename_menu" class="me-lg-3 mb-4 mb-lg-0" style="min-width:180px">
        <!-- Mobile Nav Accordion -->
        <div class="accordion d-lg-none mb-2">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#pagename_menu_item" aria-expanded="false" aria-controls="pagename_menu_item">Menu list</button>
                </h2>
            </div>
        </div>

        <!-- Nav Menu list -->
        <nav id="pagename_menu_item" class="accordion-collapse collapse h-100 d-lg-block">
            <div class="list-group tde-list-group" role="tablist">
                <a id="list-group-groupname1" class="list-group-item list-group-item-action active d-flex align-items-center py-3 py-lg-2" data-bs-toggle="list" href="#pagename_groupname1" role="tab">
                    <!-- You can add custom onClick="function();" to anchor(a) tag -->
                    <i class="fa-fw fa-solid fa-database me-2" title="GroupName1"></i>
                    <span class="fw-semibold">GroupName1</s>
                </a>

                <a id="list-group-groupname2" class="list-group-item list-group-item-action d-flex align-items-center py-3 py-lg-2" data-bs-toggle="list" href="#pagename_groupname2" role="tab">
                    <!-- You can add custom onClick="function();" to anchor(a) tag -->
                    <i class="fa-fw fa-solid fa-database me-2" title="GroupName2"></i>
                    <span class="fw-semibold">GroupName2</s>
                </a>
            </div>
        </nav>
    </div>

    <!-- Content -->
    <div id="pagename_content" class="tab-content flex-fill border rounded p-2 p-lg-3 pt-lg-2">
        <div id="pagename_groupname1" class="tab-pane fade show active" role="tabpanel">
            <div class="d-flex align-items-center">
                <!-- <i class="fa-fw fa-solid fa-users fa-xl" title="GroupName1"></i> -->
                <h1 class="mb-3">GroupName1</h1>
            </div>
            <?php
                //
            ?>
        </div>

        <div id="pagename_groupname2" class="tab-pane fade" role="tabpanel">
            <div class="d-flex align-items-center">
                <!-- <i class="fa-fw fa-solid fa-users fa-xl" title="GroupName2"></i> -->
                <h1 class="mb-3">GroupName2</h1>
            </div>
            <?php
                //
            ?>
        </div>
    </div>
</main>
