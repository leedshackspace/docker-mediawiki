## Container environment variables

Here are all the environment variables that are currently setup; more will ideally be added to make configs more universal

Docs should be as self descriptive as possible; anything flagged with SECURITY should put in a secret in your container engine

### Container specific

You can setup a route prefix to the wiki using URL PREFIX.

* `URL_PREFIX` - OPTIONAL - The URL Prefix of the container

The container will autocreate a GOD account (i.e. full perms wiki access) if these are passed in

* `GOD_NAME` - OPTIONAL - The username of the GOD account created
* `GOD_PASS` - OPTIONAL | SECURITY - The password of the GOD account created

### Mediawiki settings

These settings are directly passed into LocalSettings.php

* `WG_SITENAME` - REQUIRED - The mediawiki site name - [https://www.mediawiki.org/wiki/Manual:$wgSitename]($wgSitename)
* `WG_METANAMESPACE` - OPTIONAL - 
* `WG_SERVER` - REQUIRED - 
* `WG_SECRETKEY` - REQUIRED | SECURITY - 
* `WG_UPGRADEKEY` - REQUIRED | SECURITY - 

#### Mediawiki Rights settings

ARG WG_RIGHTSPAGE
ARG WG_RIGHTSURL
ARG WG_RIGHTSTEXT
ARG WG_RIGHTSICON

### SMTP settings

ARG SMTP_URL
ARG SMTP_PORT
ARG SMTP_USER
ARG SMTP_PASS

### Database settings

ARG DB_HOST
ARG DB_NAME
ARG DB_USER
ARG DB_PASS
ARG DB_PORT

