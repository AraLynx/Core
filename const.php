<?php
error_reporting(E_ALL);
date_default_timezone_set("Asia/Jakarta");

define("DEFAULT_PASSWORD",'Trimandiri123');
define("MASTER_PASSWORD_HASH",'$2y$10$Slm.Kl3EPKFk3tn/2CVY3.qDXEW21mnUyBH7EdTt1K53GP/7k3DGm');
define("IT_PASSWORD_HASH",'$2y$10$C5xQioq31gSgr8aA1ah/VumZdtgoF2/PyECNSIU7Zo3dqQhStPn4q');

define("APP_NAME","AraCore");

define("DIR","AraCore");
define("DIR_FOR_JS","/AraCore");

define("ASSET_DIR",DIR."/Archives/Asset/");
define("TEMP_DIR",DIR."/Archives/Temp/");

define("CORE_DIR",DIR."/Chronos/");
    define("CORE_RESOURCE",CORE_DIR."resources/");
        define("BOOTSTRAP_DIR",CORE_RESOURCE."bootstrap5.2.0/");
        define("KENDOUI_DIR",CORE_RESOURCE."telerik2022.1.301/");
        define("FONTAWESOME_DIR",CORE_RESOURCE."fontawesome-free6.1.1/");

        define("CORE_CSS",CORE_RESOURCE."css/");
        define("CORE_JS",CORE_RESOURCE."js/");
        define("CORE_IMAGE",CORE_RESOURCE."images/");
        define("CORE_AUDIO",CORE_RESOURCE."audios/");
    define("CORE_AJAX",CORE_DIR."ajax/");

define("ROOT",DIR."/".APP_NAME."/");
    define("RESOURCE_DIR",ROOT."resources/");
        define("JS_DIR",RESOURCE_DIR."js/");
        define("CSS_DIR",RESOURCE_DIR."css/");
        define("IMAGE_DIR", RESOURCE_DIR."images/");
        define("AUDIO_DIR", RESOURCE_DIR."audios/");

    define("AJAX_DIR", ROOT."ajax/");
    define("CACHE_DIR", ROOT."cache/");

