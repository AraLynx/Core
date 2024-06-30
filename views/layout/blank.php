<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta name="description" content="" />
        <meta name="author" content="" />

        <link rel="shortcut icon" href="/<?php echo CORE_IMAGE;?>home/Logo16.png" type="image/png">

        <!-- Custom CSS -->
        <link rel="stylesheet" type="text/css" href="/<?php echo CORE_CSS;?>index.css">

        {{dynamic_css}}

        <!-- JAVASCRIPT -->
        <script src="/<?php echo KENDOUI_DIR;?>js/jquery.min.js"></script>

        <title>{{page_title}}</title>
        <script>
        </script>
        <script src="/<?php echo CORE_JS;?>index.js"></script>
    </head>

    <body class="d-none">
        <?php
        ?>
        {{content}}
        {{dynamic_js}}

        <script>
            $(document).ready(function(){
                $("body").removeClass("d-none");
            });
        </script>
    </body>
</html>
