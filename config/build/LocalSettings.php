<?php

if (file_exists("/config/LocalSettings.php")) {
    require_once "/config/LocalSettings.php";
} else {
    require_once "/config-bake/LocalSettings.php";
}