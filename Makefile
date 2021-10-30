ROOT_DIR = $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))
APP_NAME = Base eShop

SHELL ?= /bin/bash
ARGS = $(filter-out $@,$(MAKECMDGOALS))
DIR = $(notdir $(shell pwd))

IMAGE_TAG = latest
IMAGE_NAME = beetroot/e-shop

BUILD_ID ?= $(shell /bin/date "+%Y%m%d-%H%M%S")

.SILENT: ;               # no need for @
.ONESHELL: ;             # recipes execute in same shell
.NOTPARALLEL: ;          # wait for this target to finish
.EXPORT_ALL_VARIABLES: ; # send all vars to shell
Makefile: ;              # skip prerequisite discovery

# Run make help by default
.DEFAULT_GOAL = help

ifneq ("$(wildcard ./VERSION)","")
VERSION ?= $(shell cat ./VERSION | head -n 1)
else
VERSION ?= 0.0.1
endif

# Public targets
.PHONY: title build up bash down reload nginx mysql

title:
	$(info $(APP_NAME) v$(VERSION))

build:
	docker build \
		--build-arg VERSION=$(VERSION) \
		--build-arg BUILD_ID=$(BUILD_ID) \
		-t $(IMAGE_NAME):$(IMAGE_TAG) \
		--no-cache \
		--force-rm .

up:
	docker-compose up -d

down: ## Stop and kill containers
	docker-compose down

bash:
	docker-compose exec app bash

nginx:
	docker-compose exec webserver sh

mysql:
	docker-compose exec database mysql -u beetroot -pbeetroot

reload: ## down -> build -> up
	make down && make build && make up