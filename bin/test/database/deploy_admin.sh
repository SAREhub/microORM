#!/usr/bin/env bash
set -e -u
source $DOCKERUTIL_PATH
set -a
source ./bin/test/.env
set +a

docker service create \
    --name ${DATABASE_SERVICE_ADMIN} \
    --network ${NETWORK} \
    --label "${TESTENV_LABEL}" \
    --publish ${DATABASE_ADMIN_PUBLISH_PORT}:${DATABASE_ADMIN_PORT} \
    --env MYSQL_ROOT_PASSWORD="${DATABASE_PASSWORD}" \
    --env PMA_HOST="${DATABASE_HOST}" \
    --detach=true \
    ${DATABASE_ADMIN_IMAGE} &>/dev/null

dockerutil::print_success "created service: $DATABASE_SERVICE_ADMIN"