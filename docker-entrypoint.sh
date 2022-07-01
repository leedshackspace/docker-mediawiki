#!/bin/bash

set -e
# Ensures DB is setup
#php /bootstrap/bootstrap-db.php
# Use the installer script because manually bootstrapping seems to break
php /var/www/mediawiki/w/maintenance/install.php --confpath /tmp \
    --dbname "${DB_NAME:-postgres}" --dbtype "postgres" \
    --dbpass "${DB_PASS}" --dbuser "${DB_USER:-postgres}" \
    --dbport "${DB_PORT:-5432}" --dbschema "${DB_SCHEMA:-mediawiki}" \
    --dbserver "${DB_HOST:-postgres}" --pass "${GOD_PASS}" "${WG_SITENAME}" "${GOD_NAME}" || true # Allow failiure if database already exists
# Creates GOD account if available
if [[ ! -z "${GOD_NAME}" ]] && [[ ! -z "${GOD_PASS}" ]]; then
    php /var/www/mediawiki/w/maintenance/createAndPromote.php "${GOD_NAME}" "${GOD_PASS}" --bureaucrat --sysop --interface-admin --force
fi
# Makes Semantic mediawiki work
php /var/www/mediawiki/w/maintenance/update.php --quick
envsubst '$URL_PREFIX' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf
exec "$@"

