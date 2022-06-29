<?php

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

## Database settings
$wgDBtype = "postgres";
$wgDBserver = getenv("DB_HOST") ?: "postgres";
$wgDBname = getenv("DB_NAME") ?: "postgres";
$wgDBuser = getenv("DB_USER") ?: "postgres";
$wgDBpassword = getenv("DB_PASS");

# Postgres specific settings
$wgDBport = getenv("DB_PORT") ?: "5432";
$wgDBmwschema = "mediawiki";