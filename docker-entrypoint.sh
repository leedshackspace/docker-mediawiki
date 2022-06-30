#!/bin/bash

set -e
# Ensures DB is setup
php /bootstrap/bootstrap-db.php
# Creates GOD account if available
if [[ ! -z "${GOD_NAME}" ]] && [[ ! -z "${GOD_PASS}" ]]; then
    php /var/www/mediawiki/w/maintenance/createAndPromote.php "${GOD_NAME}" "${GOD_PASS}" --bureaucrat --sysop --interface-admin --force
fi
# Makes Semantic mediawiki work
php /var/www/mediawiki/w/maintenance/update.php
envsubst '$URL_PREFIX' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf
exec "$@"

