<?php
define("PARAMS",[
    "env" => $_ENV["ENV"] ?? "prod",
    "deafult_password" => DEFAULT_PASSWORD,
    "app_name" => APP_NAME,
    "configs" => [
        "db" => [
            "aracore" => [
                "type" => $_ENV["ARACORE_DB_TYPE"],
                "host" => $_ENV["ARACORE_DB_HOST"],
                "name" => $_ENV["ARACORE_DB_NAME"],
                "user" => $_ENV["ARACORE_DB_USER"],
                "password" => $_ENV["ARACORE_DB_PASSWORD"],
            ],
            /*
            "gaia" => [
                "type" => $_ENV["GAIA_DB_TYPE"],
                "host" => $_ENV["GAIA_DB_HOST"],
                "name" => $_ENV["GAIA_DB_NAME"],
                "user" => $_ENV["GAIA_DB_USER"],
                "password" => $_ENV["GAIA_DB_PASSWORD"],
            ],
            */
        ],
        /*
        "worker" => [
            "main_engine" => $_ENV["DEFAULT_WORKER"] ?? "on",
            "unread_email" => $_ENV["DEFAULT_WORKER_UNREAD_EMAIL"] ?? "on",
            "wmap" => $_ENV["DEFAULT_WORKER_WMAP"] ?? "on",
            "new_change_log" => $_ENV["DEFAULT_WORKER_NEW_CHANGELOG"] ?? "on"
        ]
        */
    ],
    "defaultSettingNames" => ["NotificationSound","NotificationVibrate"],
    "defaultSettingValues" => [
        "NotificationSound" => "dry pop up notification.wav",
        "NotificationVibrate" => 500,
    ]
]);
