## Container environment variables

Here are all the environment variables that are currently setup; more will ideally be added to make configs more universal

Docs should be as self descriptive as possible; anything flagged with SECURITY should put in a secret in your container engine

### Container specific

You can setup a route prefix to the wiki using URL PREFIX.

* `URL_PREFIX` - OPTIONAL - The URL Prefix of the container

The container will autocreate a GOD account (i.e. full perms wiki access) if these are passed in

* `GOD_NAME` - REQUIRED - The username of the GOD account created
* `GOD_PASS` - REQUIRED | SECURITY - The password of the GOD account created

### Mediawiki settings

These settings are directly passed into LocalSettings.php

* `WG_SITENAME` - REQUIRED - The mediawiki site name - [https://www.mediawiki.org/wiki/Manual:$wgSitename]($wgSitename)
* `WG_METANAMESPACE` - OPTIONAL - Mediawiki Meta Namespace - [https://www.mediawiki.org/wiki/Manual:$wgMetaNamespace]($wgMetaNamespace)
* `WG_SERVER` - REQUIRED - URL on which the mediawiki instance will be hosted - [https://www.mediawiki.org/wiki/Manual:$wgServer]($wgServer)
* `WG_SECRETKEY` - REQUIRED | SECURITY - Mediawiki's Secret key - [https://www.mediawiki.org/wiki/Manual:$wgSecretKey]($wgSecretKey)
* `WG_UPGRADEKEY` - REQUIRED | SECURITY - Mediawiki's Secret key - [https://www.mediawiki.org/wiki/Manual:$wgUpgradeKey]($wgUpgradeKey)

#### Mediawiki Rights settings

These setup the mediawiki rights settings

TODO Document

* `WG_RIGHTSPAGE` - OPTIONAL
* `WG_RIGHTSURL`- OPTIONAL
* `WG_RIGHTSTEXT` - OPTIONAL
* `WG_RIGHTSICON` - OPTIONAL

### SMTP settings

The SMTP connection settings

TODO: ensure SMTP is turned off if these aren't passed

* `SMTP_URL` - OPTIONAL
* `SMTP_PORT` - OPTIONAL
* `SMTP_USER` - OPTIONAL
* `SMTP_PASS` - OPTIONAL | SECURITY

### Database settings

This container is setup to use postgres and type exposure is provided as the bootstrapping also assumes postgres

* `DB_HOST` - OPTIONAL - Postgres Host - Default: `postgres`
* `DB_NAME` - OPTIONAL - Postgres DB Name - Default: `postgres`
* `DB_USER` - OPTIONAL - Postgres User - Default: `postgres`
* `DB_PASS` - REQUIRED | SECURITY - Postgres Password, must be provided as there is no default
* `DB_PORT` - OPTIONAL - Postgres Port - Default `5432`
* `DB_SCHEMA` - OPTIONAL - Mediawiki's schema name - Default `mediawiki`

## SAML Settings

* `SAML_METADATA_URL` - REQUIRED - URL pointing at SAML metadata