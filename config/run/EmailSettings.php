<?php 

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

## UPO means: this is also a user preference option

$containerSMTPUrl = getenv("SMTP_URL") ?: "smtp.host";
$containerSMTPHost = parse_url($containerSMTPUrl, PHP_URL_HOST) ?: $containerSMTPUrl;
$containerIDHost = parse_url(getenv("WG_SERVER"), PHP_URL_HOST) ?: getenv("WG_SERVER");

$containerSMTPAuth = getenv("SMTP_USER") && getenv("SMTP_PASS");

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "emergency@$containerSMTPHost";
$wgPasswordSender = "passwords@$containerSMTPHost";

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

$wgSMTP = array(
    'host'     => $containerSMTPUrl,
    'IDHost'   => $containerIDHost,
    'port'     => getenv("SMTP_PORT"),
    'auth'     => $containerSMTPAuth,
    'username' => getenv("SMTP_USER") ?: 'my_user_name', 
    'password' => getenv("SMTP_PASS") ?: 'my_password'
   );