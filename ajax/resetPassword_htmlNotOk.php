<?php

?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="description" content="" />
        <meta name="author" content="" />

        <link rel="shortcut icon" href="/<?php echo IMAGE_ROOT;?>Logo16.png" type="image/png">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="/<?php echo COMMON_CSS;?>bootstrap.tde.min.css">

        <!-- Custom Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="/<?php echo COMMON_CSS;?>index.css">
        <link rel="stylesheet" type="text/css" href="/<?php echo COMMON_CSS;?>color.css">
        <link rel="stylesheet" type="text/css" href="/<?php echo COMMON_CSS;?>default.css">

        <!-- Kendo CSS -->
        <link rel="stylesheet" type="text/css" href="/<?php echo KENDOUI_ROOT;?>css/kendo.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/<?php echo KENDOUI_ROOT;?>css/kendo.common-bootstrap.min.css">
        <!--<link rel="stylesheet" type="text/css" href="/<?php echo KENDOUI_ROOT;?>css/kendo.dataviz.min.css">-->
        <!--<link rel="stylesheet" type="text/css" href="/<?php echo KENDOUI_ROOT;?>css/kendo.dataviz.bootstrap.min.css">-->

        <!-- Font Awesome CSS -->
        <link href="/<?php echo FONTAWESOME_ROOT;?>css/all.css" rel="stylesheet">

        <!-- JAVASCRIPT -->
        <script src="/<?php echo KENDOUI_ROOT;?>js/jquery.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="/<?php echo BOOTSTRAP_ROOT;?>js/bootstrap.bundle.min.js" defer></script>

        <!-- Kendo JS -->
        <script src="/<?php echo KENDOUI_ROOT;?>js/kendo.all.min.js" defer></script>
        <!--<script src="/<?php echo KENDOUI_ROOT;?>js/kendo.dataviz.min.js" defer></script>-->
        <script src="/<?php echo KENDOUI_ROOT;?>js/jszip.min.js" defer></script>

        <title>BAD LINK</title>

        <script>
            const ROOT = '<?php echo ROOT;?>';

            const COMMON_AJAX = '<?php echo COMMON_AJAX;?>';
            const COMMON_AUDIO = '<?php echo COMMON_AUDIO;?>';

            const AJAX_ROOT = '<?php echo AJAX_ROOT;?>';
            const IMAGE_ROOT = '<?php echo IMAGE_ROOT;?>';
        </script>

        <script src="/<?php echo COMMON_JS;?>index.js"></script>
        <script src="/<?php echo COMMON_JS;?>default.js"></script>
    </head>

    <body class="d-none">
        <main class="container">
            <div class="mt-3">
                <h1>Opps! The link is expired</h1>
                We are redirecting this page to the login page.
            </div>
            <div class="mt-4" class="dark_grey">
                TDE System, <?php echo date("Y");?>
            </div>
        </main>

        <script>
            $(document).ready(function(){
                $("body").removeClass("d-none");

                let timeout = setTimeout(function() {
                    window.location.href = "https://vibi.trimandirigroup.com:816/<?php echo TDE_ROOT;?>/<?php echo $ajax->get["a"];?>/profile";
                }, (5 * 1000));
            });
        </script>
    </body>
</html>
