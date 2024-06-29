<?php
?>
<script>
    $(document).ready(function(){
    });
</script>

<div id="pageList01" class="d-flex mw-100" style="min-width:100%">
    <div id="page_content" class="flex-fill mw-100">
        <div id="page-list" >
            <div class='d-flex justify-content-start'>
                <?php
                foreach($_MODULE_PAGES AS $index => $modulePage)
                {
                    if($moduleId == $modulePage["ModuleId"])
                    {?>
                        <div class='h6 page-button'>
                            <a class='btn btn-secondary d-flex align-items-center h-100' role='button' href='<?php echo "/".ROOT."{$modulePage["ModuleRouteName"]}/{$modulePage["PageRouteName"]}";?>'>
                                <img class='page-image me-2 mb-1' src='<?php echo "/".IMAGE_ROOT."page/{$modulePage["PageImage"]}";?>'/>
                                <p><?php echo $modulePage["PageName"];?></p>
                            </a>
                        </div>
                    <?php }
                }?>
            </div>
        </div>
        <br/>
        <main id="articles">
            <h6>NEWS FEED</h6>
        </main>
    </div>
</div>
