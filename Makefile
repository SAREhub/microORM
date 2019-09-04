export DOCKERUTIL_PATH = ./vendor/sarehub/dockerutil/bin/dockerutil
export PROJECT = microorm

INFO = Make to create test mysql service
HELP_TARGET_MAX_CHAR_NUM=30
include bin/Help

export BIN_SCRIPTS_PATH = bin/test

## Cleans test env and inits all depending services like database
test_init: test_clean test_init_base test_init_database

## Creates test network
test_init_base:
	bash ${BIN_SCRIPTS_PATH}/init.sh

## Creates test database service
test_init_database:
	bash ${BIN_SCRIPTS_PATH}/database/deploy.sh

## Creates test database service
test_init_database_admin:
	bash ${BIN_SCRIPTS_PATH}/database/deploy_admin.sh

## Cleans test env
test_clean:
	bash ${BIN_SCRIPTS_PATH}/clean.sh



