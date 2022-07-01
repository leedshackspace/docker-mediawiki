<?php

$wgDBserver = getenv("DB_HOST") ?: "postgres";
$wgDBname = getenv("DB_NAME") ?: "postgres";
$wgDBuser = getenv("DB_USER") ?: "postgres";
$wgDBpassword = getenv("DB_PASS");
$wgDBport = getenv("DB_PORT") ?: "5432";
$wgDBmwschema = getenv("DB_SCHEMA") ?: "mediawiki";

$queryBaseFile = "/var/www/mediawiki/w/maintenance/postgres/tables.sql";
# TASTY SQLi "SET search_path TO $wgDBmwschema;".
$queryBase = file_get_contents($queryBaseFile);

$queryGenFile = "/var/www/mediawiki/w/maintenance/postgres/tables-generated.sql";
# TASTY SQLi "SET search_path TO $wgDBmwschema;".
$queryGen = file_get_contents($queryGenFile);

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

#echo "Issuing \n $queryBase\n";
echo "Issuing tables.sql\n";
$result = pg_query($pgv_connection, $queryBase);
#var_dump($result);
if ($result == false) {
    echo "Base setup failed rolling back\n";
    $result = pg_query($pgv_connection, "ROLLBACK;");
    #var_dump($result);
    if ($result == false) {
        echo "Rollback failed?!?\n";
    }
} else {
    echo "Committing\n"
    $result = pg_query($pgv_connection, "COMMIT;");
    if ($result == false) {
        echo "Commit failed?!?\n";
    }
    #echo "Issuing \n $queryGen\n";
    echo "Issuing tables-generated.sql\n";
    $result = pg_query($pgv_connection, $queryGen);
    #var_dump($result);
    if ($result == false) {
        echo "Extras setup failed rolling back\n";
        $result = pg_query($pgv_connection, "ROLLBACK;");
        #var_dump($result);
        if ($result == false) {
            echo "Rollback failed?!?\n";
        }
    } else {
        $result = pg_query($pgv_connection, "COMMIT;");
        if ($result == false) {
            echo "Commit failed?!?\n";
        }
    }
}

pg_close($pgv_connection);