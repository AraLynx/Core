<?php
//dd("layout auth");
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Layout Auth -->
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Auth Layout" />
        <meta name="author" content="AraLynx" />

        <link rel="shortcut icon" href="/<?php echo CORE_IMAGE;?>Logo_<?php echo strtoupper(APP_NAME);?>_16.png" type="image/png">

        <!-- Bootstrap CSS -->
        <!--<link rel="stylesheet" type="text/css" href="/<?php echo BOOTSTRAP_DIR;?>css/bootstrap.css">-->
        <link rel="stylesheet" type="text/css" href="/<?php echo CORE_CSS;?>bootstrap.tde.min.css">

        <!-- Custom Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="/<?php echo CORE_CSS;?>index.css">

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
        <script src="/<?php echo BOOTSTRAP_DIR;?>js/bootstrap.bundle.min.js"></script>

        <!-- Kendo JS -->
        <script src="/<?php echo KENDOUI_DIR;?>js/kendo.all.min.js"></script>

        <title>{{page_title}}</title>

        <script>
            const APP_ROOT = '<?php echo APP_ROOT;?>';
            const CORE_AJAX = '<?php echo CORE_AJAX;?>';
        </script>
        <script src="/<?php echo CORE_JS;?>index.js"></script>
    </head>
    <body class="d-none">
        <?php
        require_once 'default_ajax.php';
        require_once 'default_commonModal.php';
        ?>
        <div id="content">
            {{content}}
        </div>
        {{dynamic_js}}

        <script>
            $(document).ready(function(){
                $("body").removeClass("d-none");
            });
        </script>
    </body>
</html>

