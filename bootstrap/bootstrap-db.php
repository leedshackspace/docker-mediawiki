<?php

$wgDBserver = getenv("DB_HOST") ?: "postgres";
$wgDBname = getenv("DB_NAME") ?: "postgres";
$wgDBuser = getenv("DB_USER") ?: "postgres";
$wgDBpassword = getenv("DB_PASS");
$wgDBport = getenv("DB_PORT") ?: "5432";
$wgDBmwschema = getenv("DB_SCHEMA") ?: "mediawiki";

$queryBaseFile = "/var/www/mediawiki/w/maintenance/postgres/tables.sql";
$queryBase = file_get_contents($queryBaseFile);

$queryGenFile = "/var/www/mediawiki/w/maintenance/postgres/tables-generated.sql";
$queryGen = file_get_contents($queryGenFile);

$queryUpdateFile = "/var/www/mediawiki/w/maintenance/postgres/update-keys.sql";
$queryUpdate = file_get_contents($queryUpdateFile);

$pgv_connection_string = "host=$wgDBserver dbname=$wgDBname port=$wgDBport user=$wgDBuser password=$wgDBpassword";
$pgv_connection = pg_connect($pgv_connection_string);
if ($pgv_connection == false) {
    echo "connection failed\n";
    exit;
}

# TASTY SQLi "CREATE SCHEMA IF NOT EXISTS $wgDBmwschema"
#$result = pg_prepare($pgv_connection, "create_schema_prep", 'CREATE SCHEMA IF NOT EXISTS $1');
#$result = pg_execute($pgv_connection, "create_schema_prep", array($wgDBmwschema));

#$result = pg_prepare($pgv_connection, "select_schema_prep", 'SET search_path TO $1');
#$result = pg_execute($pgv_connection, "select_schema_prep", array($wgDBmwschema));

# TASTY SQLi
$result = pg_query($pgv_connection, "CREATE SCHEMA IF NOT EXISTS $wgDBmwschema; SET search_path TO $wgDBmwschema;");

echo "Issuing tables.sql\n";
$result = pg_query($pgv_connection, $queryBase);
if ($result == false) {
    echo "Base setup failed rolling back\n";
    $result = pg_query($pgv_connection, "ROLLBACK;");
    if ($result == false) {
        echo "Rollback failed?!?\n";
    }
} else {
    echo "Committing\n";
    $result = pg_query($pgv_connection, "COMMIT;");
    if ($result == false) {
        echo "Commit failed?!?\n";
    }
    echo "Issuing tables-generated.sql\n";
    $result = pg_query($pgv_connection, $queryGen);
    if ($result == false) {
        echo "Extras setup failed rolling back\n";
        $result = pg_query($pgv_connection, "ROLLBACK;");
        if ($result == false) {
            echo "Rollback failed?!?\n";
        }
    } else {
        echo "Committing\n";
        $result = pg_query($pgv_connection, "COMMIT;");
        if ($result == false) {
            echo "Commit failed?!?\n";
        }
        echo "Issuing update-keys.sql\n";
        $result = pg_query($pgv_connection, $queryUpdate);
        if ($result == false) {
            echo "Update keys setup failed rolling back\n";
            $result = pg_query($pgv_connection, "ROLLBACK;");
            if ($result == false) {
                echo "Rollback failed?!?\n";
            }
        } else {
            echo "Committing\n";
            $result = pg_query($pgv_connection, "COMMIT;");
            if ($result == false) {
                echo "Commit failed?!?\n";
            }
        }
    }
}

pg_close($pgv_connection);