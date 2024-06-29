<!doctype html>
<html lang="en">
    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta name="author" content="" />

    <link rel="shortcut icon" href="/<?php echo COMMON_IMAGE;?>Logo_<?php echo strtoupper(APP_NAME);?>_16.png" type="image/png">

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="/<?php echo BOOTSTRAP_ROOT;?>css/bootstrap.css">-->
    <!-- Custom Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="/<?php echo COMMON_CSS;?>bootstrap.tde.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="/<?php echo COMMON_CSS;?>index.css">
    <link rel="stylesheet" type="text/css" href="/<?php echo COMMON_CSS;?>color.css">
    <link rel="stylesheet" type="text/css" href="/<?php echo COMMON_CSS;?>default.css">
    <link rel="stylesheet" type="text/css" href="/<?php echo COMMON_CSS;?>print.css">
    <link rel="stylesheet" type="text/css" href="/<?php echo COMMON_CSS;?>paper.css">

    <!-- Kendo CSS -->
    <link rel="stylesheet" type="text/css" href="/<?php echo KENDOUI_ROOT;?>css/kendo.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/<?php echo KENDOUI_ROOT;?>css/kendo.common-bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/<?php echo KENDOUI_ROOT;?>css/kendo.dataviz.min.css">
    <link rel="stylesheet" type="text/css" href="/<?php echo KENDOUI_ROOT;?>css/kendo.dataviz.bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link href="/<?php echo FONTAWESOME_ROOT;?>css/all.css" rel="stylesheet">

    <style>{{dynamic_css}}</style>

    <!-- JAVASCRIPT -->
    <script src="/<?php echo KENDOUI_ROOT;?>js/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="/<?php echo BOOTSTRAP_ROOT;?>js/bootstrap.bundle.min.js" defer></script>

    <!-- Kendo JS -->
    <script src="/<?php echo KENDOUI_ROOT;?>js/kendo.all.min.js" defer></script>

    <title>{{page_title}}</title>
    </head>
    <body class="d-none">
        {{content}}
    </body>
    <script>{{dynamic_js}}</script>

    <script>
        $(document).ready(function(){
            $("body").removeClass("d-none");
        });
    </script>
</html>
