<?php

if (file_exists("/config/SimpleSaml/acl.php")) {
    require_once "/config/SimpleSaml/acl.php";
} else {
    require_once "/config-bake/SimpleSaml/acl.php";
}