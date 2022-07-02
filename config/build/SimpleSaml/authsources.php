<?php

if (file_exists("/config/SimpleSaml/authsources.php")) {
    require_once "/config/SimpleSaml/authsources.php";
} else {
    require_once "/config-bake/SimpleSaml/authsources.php";
}