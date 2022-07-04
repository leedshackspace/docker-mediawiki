<?php

/**
 * The configuration of SimpleSAMLphp
 */

$wgDBserver = getenv("DB_HOST") ?: "postgres";
$wgDBname = getenv("DB_NAME") ?: "postgres";
$wgDBuser = getenv("DB_USER") ?: "postgres";
$wgDBpassword = getenv("DB_PASS");
$wgDBport = getenv("DB_PORT") ?: "5432";
$wgDBmwschema = getenv("DB_SCHEMA") ?: "mediawiki";
$pgv_connection_string = "pgsql:host=$wgDBserver;dbname=$wgDBname;port=$wgDBport;user=$wgDBuser;password=$wgDBpassword";


$config = [

    'baseurlpath' => 'simplesaml/',

    /*
     * The 'application' configuration array groups a set configuration options
     * relative to an application protected by SimpleSAMLphp.
     */
    //'application' => [
        /*
         * The 'baseURL' configuration option allows you to specify a protocol,
         * host and optionally a port that serves as the canonical base for all
         * your application's URLs. This is useful when the environment
         * observed in the server differs from the one observed by end users,
         * for example, when using a load balancer to offload TLS.
         *
         * Note that this configuration option does not allow setting a path as
         * part of the URL. If your setup involves URL rewriting or any other
         * tricks that would result in SimpleSAMLphp observing a URL for your
         * application's scripts different than the canonical one, you will
         * need to compute the right URLs yourself and pass them dynamically
         * to SimpleSAMLphp's API.
         */
        //'baseURL' => 'https://example.com',
    //],

    /*
     * The following settings are *filesystem paths* which define where
     * SimpleSAMLphp can find or write the following things:
     * - 'certdir': The base directory for certificate and key material.
     * - 'loggingdir': Where to write logs.
     * - 'datadir': Storage of general data.
     * - 'tempdir': Saving temporary files. SimpleSAMLphp will attempt to create
     *   this directory if it doesn't exist.
     * When specified as a relative path, this is relative to the SimpleSAMLphp
     * root directory.
     */
    'certdir' => 'cert/',
    'loggingdir' => 'log/',
    'datadir' => 'data/',
    'tempdir' => '/tmp/simplesaml',

    /*
     * The timezone of the server. This option should be set to the timezone you want
     * SimpleSAMLphp to report the time in. The default is to guess the timezone based
     * on your system timezone.
     *
     * See this page for a list of valid timezones: http://php.net/manual/en/timezones.php
     */
    'timezone' => null,

    /**********************************
     | SECURITY CONFIGURATION OPTIONS |
     **********************************/

    'secretsalt' => getenv("WG_SECRETKEY") ?: "deadbeefB16B00B5deadbeef0D15EA5EdeadbeefDEADDEADdeadbeefFFBADD11",

    'auth.adminpassword' => getenv("WG_UPGRADEKEY") ?: "deadbeefcafebabe",

    'admin.protectindexpage' => true,
    'admin.protectmetadata' => false,

    'admin.checkforupdates' => true,

    'showerrors' => false,
    'errorreporting' => false,

    'logging.level' => SimpleSAML\Logger::NOTICE,
    'logging.handler' => 'stderr',

    'logging.facility' => defined('LOG_LOCAL5') ? constant('LOG_LOCAL5') : LOG_USER,
    'logging.processname' => 'simplesamlphp',
    'logging.logfile' => 'simplesamlphp.log',
     'module.enable' => [
         'core' => true,
         'saml' => true
     ],
    'production' => true,
    'idpdisco.enableremember' => true,
    'idpdisco.rememberchecked' => true,
    'idpdisco.validate' => true,

    'store.type'                    => 'sql',
    'store.sql.dsn'                 => $pgv_connection_string,
    'store.sql.prefix' => 'SimpleSAMLphp',

    /**************************
     | METADATA CONFIGURATION |
     **************************/

    /*
     * This option allows you to specify a directory for your metadata outside of the standard metadata directory
     * included in the standard distribution of the software.
     */
    'metadatadir' => 'metadata',

    /*
     * This option configures the metadata sources. The metadata sources is given as an array with
     * different metadata sources. When searching for metadata, SimpleSAMLphp will search through
     * the array from start to end.
     *
     * Each element in the array is an associative array which configures the metadata source.
     * The type of the metadata source is given by the 'type' element. For each type we have
     * different configuration options.
     *
     * Flat file metadata handler:
     * - 'type': This is always 'flatfile'.
     * - 'directory': The directory we will load the metadata files from. The default value for
     *                this option is the value of the 'metadatadir' configuration option, or
     *                'metadata/' if that option is unset.
     *
     * XML metadata handler:
     * This metadata handler parses an XML file with either an EntityDescriptor element or an
     * EntitiesDescriptor element. The XML file may be stored locally, or (for debugging) on a remote
     * web server.
     * The XML metadata handler defines the following options:
     * - 'type': This is always 'xml'.
     * - 'file': Path to the XML file with the metadata.
     * - 'url': The URL to fetch metadata from. THIS IS ONLY FOR DEBUGGING - THERE IS NO CACHING OF THE RESPONSE.
     *
     * MDQ metadata handler:
     * This metadata handler looks up for the metadata of an entity at the given MDQ server.
     * The MDQ metadata handler defines the following options:
     * - 'type': This is always 'mdq'.
     * - 'server': Base URL of the MDQ server. Mandatory.
     * - 'validateFingerprint': The fingerprint of the certificate used to sign the metadata. You don't need this
     *                          option if you don't want to validate the signature on the metadata. Optional.
     * - 'cachedir': Directory where metadata can be cached. Optional.
     * - 'cachelength': Maximum time metadata can be cached, in seconds. Defaults to 24
     *                  hours (86400 seconds). Optional.
     *
     * PDO metadata handler:
     * This metadata handler looks up metadata of an entity stored in a database.
     *
     * Note: If you are using the PDO metadata handler, you must configure the database
     * options in this configuration file.
     *
     * The PDO metadata handler defines the following options:
     * - 'type': This is always 'pdo'.
     *
     * Examples:
     *
     * This example defines two flatfile sources. One is the default metadata directory, the other
     * is a metadata directory with auto-generated metadata files.
     *
     * 'metadata.sources' => [
     *     ['type' => 'flatfile'],
     *     ['type' => 'flatfile', 'directory' => 'metadata-generated'],
     * ],
     *
     * This example defines a flatfile source and an XML source.
     * 'metadata.sources' => [
     *     ['type' => 'flatfile'],
     *     ['type' => 'xml', 'file' => 'idp.example.org-idpMeta.xml'],
     * ],
     *
     * This example defines an mdq source.
     * 'metadata.sources' => [
     *      [
     *          'type' => 'mdq',
     *          'server' => 'http://mdq.server.com:8080',
     *          'cachedir' => '/var/simplesamlphp/mdq-cache',
     *          'cachelength' => 86400
     *      ]
     * ],
     *
     * This example defines an pdo source.
     * 'metadata.sources' => [
     *     ['type' => 'pdo']
     * ],
     *
     * Default:
     * 'metadata.sources' => [
     *     ['type' => 'flatfile']
     * ],
     */
    'metadata.sources' => [
        ['type' => 'flatfile'],
        ['type' => 'xml', 'file' => '/config-bake/pulledMetadata.xml'],
    ],
];