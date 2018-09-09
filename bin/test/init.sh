#!/usr/bin/env bash
set -e -u
source $DOCKERUTIL_PATH
set -a
source ./bin/test/.env
set +a

function create_network() {
    docker network create --label "${TESTENV_LABEL}" --driver overlay $NETWORK --subnet $NETWORK_SUBNET &>/dev/null
}
set +e
n=0
until [ $n -ge 5 ]
do
    create_network && break
    n=$[$n+1]
    sleep 2
done
set -e
dockerutil::print_success "created network: $NETWORK"
