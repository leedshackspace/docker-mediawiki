#!/bin/bash

set -e
exec "php /bootstrap/bootstrap-db.php"
if [[ ! -z "${GOD_NAME}" ]] && [[ ! -z "${GOD_PASS}" ]]; then
    exec "php /var/www/mediawiki/w/maintenance/createAndPromote.php ${GOD_NAME} ${GOD_PASS} --bureaucrat --sysop --interface-admin --force"
fi
envsubst '$URL_PREFIX' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf
exec "$@"

