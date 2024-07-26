<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="description" content="" />
        <meta name="author" content="" />

        <link rel="shortcut icon" href="/<?php echo CORE_IMAGE;?>Logo_<?php echo strtoupper(APP_NAME);?>_16.png" type="image/png">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="/<?php echo CORE_CSS;?>bootstrap.tde.min.css">

        <!-- Custom CSS -->
        <link rel="stylesheet" type="text/css" href="/<?php echo CORE_CSS;?>index.css">
        <link rel="stylesheet" type="text/css" href="/<?php echo CORE_CSS;?>color.css">
        <link rel="stylesheet" type="text/css" href="/<?php echo CORE_CSS;?>default.css">

        <!-- Kendo CSS -->
        <link rel="stylesheet" type="text/css" href="/<?php echo KENDOUI_DIR;?>css/kendo.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/<?php echo KENDOUI_DIR;?>css/kendo.common-bootstrap.min.css">
        <!--<link rel="stylesheet" type="text/css" href="/<?php echo KENDOUI_DIR;?>css/kendo.dataviz.min.css">-->
        <!--<link rel="stylesheet" type="text/css" href="/<?php echo KENDOUI_DIR;?>css/kendo.dataviz.bootstrap.min.css">-->

        <!-- Font Awesome CSS -->
        <link href="/<?php echo FONTAWESOME_DIR;?>css/all.css" rel="stylesheet">

        {{dynamic_css}}

        <!-- JAVASCRIPT -->
        <script src="/<?php echo KENDOUI_DIR;?>js/jquery.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="/<?php echo BOOTSTRAP_DIR;?>js/bootstrap.bundle.min.js" defer></script>

        <!-- Kendo JS -->
        <script src="/<?php echo KENDOUI_DIR;?>js/kendo.all.min.js" defer></script>
        <!--<script src="/<?php echo KENDOUI_DIR;?>js/kendo.dataviz.min.js" defer></script>-->
        <script src="/<?php echo KENDOUI_DIR;?>js/jszip.min.js" defer></script>

        <title>{{page_title}}</title>
        <?php
            $audios_notifications_path = dirname(__DIR__, 2)."/resources/audios/notifications";
            foreach(scandir($audios_notifications_path) AS $file)
            {
                if($file && $file != "." && $file != "..")
                {
                    echo "<audio id='audio_{$file}' src='/".CORE_AUDIO."notifications/{$file}'></audio>";
                }
            }
        ?>

        <script>
            const APP_ROOT = '<?php echo APP_ROOT;?>';

            const CORE_AJAX = '<?php echo CORE_AJAX;?>';
            const CORE_AUDIO = '<?php echo CORE_AUDIO;?>';

            const AJAX_ROOT = '<?php echo AJAX_ROOT;?>';
            const IMAGE_ROOT = '<?php echo IMAGE_ROOT;?>';

            const EMPLOYEE_ID = <?php echo $_EMPLOYEE["Id"];?>;
            const USER_ID = <?php echo $_EMPLOYEE["UserId"];?>;
            const ENVIRONMENT = '<?php echo $_ENVIRONMENT;?>';
        </script>
        <script src="/<?php echo CORE_JS;?>index.js"></script>
        <script src="/<?php echo CORE_JS;?>default.js"></script>
        <?php require_once 'fieldJs.php';?>

        <?php
            echo "
                <style>
                    .tde-list-group {
                        --bs-list-group-active-color: var(--bs-body-bg) !important;
                        --bs-list-group-active-bg: var(--bs-".strtolower(APP_NAME).") !important;
                        --bs-list-group-active-border-color: var(--bs-".strtolower(APP_NAME).") !important;
                    }
                </style>
            ";
        ?>
    </head>

    <body class="d-none">
        <?php
        require_once 'default_header.php';
        require_once 'default_sidebar.php';
        require_once 'default_ajax.php';

        if(APP_NAME != "Hephaestus" && $_ENVIRONMENT == "prod")
        {
            require_once 'default_userSettings.php';
            require_once 'default_worker.php';
        }
        if(APP_NAME == "Plutus" && count($_OTHER_BRANCHES)) require_once 'default_switchBranch.php';
        require_once 'default_logOut.php';
        ?>
        <div id="content" class="container-lg">
            {{content}}
        </div>
        <?php

        require_once 'default_commonModal.php';
        require_once 'default_changeLog.php';
        require_once 'default_footer.php';

        ?>
        {{dynamic_js}}

        <script>
            $(document).ready(function(){
                $("body").removeClass("d-none");
            });
        </script>
    </body>
</html>
