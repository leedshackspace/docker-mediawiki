<?php

if (file_exists("/config/SimpleSaml/config.php")) {
    require_once "/config/SimpleSaml/config.php";
} else {
    require_once "/config-bake/SimpleSaml/config.php";
}