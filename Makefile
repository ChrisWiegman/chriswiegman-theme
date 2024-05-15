DOCKER_RUN     := @docker run --rm
HIGHLIGHT      :=\033[0;32m
END_HIGHLIGHT  :=\033[0m # No Color
THEME_VERSION  := $$(grep "^Version" style.css | awk -F' ' '{print $3}' | cut -d ":" -f2 | sed 's/ //g')
ARGS            = `arg="$(filter-out $@,$(MAKECMDGOALS))" && echo $${arg:-${1}}`

%:
	@:

.PHONY: build
build:  | clean-assets
	@echo "Building theme assets"
	if [ ! -d ./node_modules/ ]; then \
		$(MAKE) install-npm; \
	fi
	npm run build

.PHONY: change
change:
	docker run \
		--rm \
		--platform linux/amd64 \
		--mount type=bind,source=$(PWD),target=/src \
		-w /src \
		-it \
		ghcr.io/miniscruff/changie \
		new

.PHONY: changelog
changelog:
	docker run \
		--rm \
		--platform linux/amd64 \
		--mount type=bind,source=$(PWD),target=/src \
		-w /src \
		-it \
		ghcr.io/miniscruff/changie \
		batch $(call ARGS,defaultstring)
	docker run \
		--rm \
		--platform linux/amd64 \
		--mount type=bind,source=$(PWD),target=/src \
		-w /src \
		-it \
		ghcr.io/miniscruff/changie \
		merge

.PHONY: chriswiegman-theme-version.zip
chriswiegman-theme-version.zip: clean-release
	@echo "Building release file: chriswiegman-theme.$(THEME_VERSION).zip"
	THEME_VERSION=$(THEME_VERSION) && \
		cd ../ && \
		zip \
		--verbose \
		--recurse-paths \
		--exclude="*.changes/*" \
		--exclude="*.git/*" \
		--exclude="*.github/*" \
		--exclude="*.vscode/*" \
		--exclude="*node_modules/*" \
		--exclude="*.changie.yml" \
		--exclude="*.gitignore" \
		--exclude="*.kana.json" \
		--exclude="*.npmrc" \
		--exclude="*.nvmrc" \
		--exclude="*CHANGELOG.md" \
		--exclude="*composer.json" \
		--exclude="*composer.lock" \
		--exclude="*Makefile" \
		--exclude="*package-lock.json" \
		--exclude="*package.json" \
		--exclude="*phpcs.xml" \
		--exclude="*pods.json" \
		--exclude="*README.md" \
		--exclude="*vendor/*" \
		chriswiegman-theme/chriswiegman-theme.$$THEME_VERSION.zip \
		chriswiegman-theme/*
	if [ ! -f ./chriswiegman-theme.$(THEME_VERSION).zip  ]; then \
		echo "file not available"; \
		exit 1; \
	fi

.PHONY: clean
clean: clean-assets clean-prod-assets clean-build clean-release

.PHONY: clean-assets
clean-assets:
	@echo "Cleaning up theme assets"
	rm -f assets/*.js
	rm -f assets/*.css
	rm -f assets/*.map

.PHONY: clean-build
clean-build:
	@echo "Cleaning up build-artifacts"
	rm -rf \
		node_modules \
		wordpress \
		vendor \
		.vscode/*.log

.PHONY: clean-prod-assets
clean-prod-assets:
	@echo "Cleaning old production assets"
	rm -rf ./wordpress/wp-content/mysql.sql
	rm -rf ./wordpress/wp-content/uploads/*

.PHONY: clean-release
clean-release:
	@echo "Cleaning up release file"
	rm -f chriswiegman-theme*.zip

.PHONY: copy-prod-assets
copy-prod-assets: | clean-prod-assets
	@echo "Copying assets from chriswiegman.com"
	rsync -aqz -e "ssh" --progress chriswiegman@chriswiegman.ssh.wpengine.net:/home/wpe-user/sites/chriswiegman/wp-content/uploads/ ./wordpress/wp-content/uploads/
	scp -O chriswiegman@chriswiegman.ssh.wpengine.net:/home/wpe-user/sites/chriswiegman/wp-content/mysql.sql ./wordpress/wp-content/

.PHONY: import-db
import-db:
	echo "Importing production database"
	kana db import ./wordpress/wp-content/mysql.sql --replace-domain=chriswiegman.com
	kana wp plugin activate debug-bar
	kana wp plugin activate query-monitor

.PHONY: destroy
destroy: ## Destroys the developer environment completely (this is irreversible)
	if [ -d ./wordpress/ ]; then \
		kana destroy --force; \
	fi
	$(MAKE) clean

.PHONY: help
help:  ## Display help
	@awk -F ':|##' \
		'/^[^\t].+?:.*?##/ {\
			printf "\033[36m%-30s\033[0m %s\n", $$1, $$NF \
		}' $(MAKEFILE_LIST) | sort

.PHONY: install
install: | install-composer install-npm

.PHONY: install-composer
install-composer:
	composer install

.PHONY: install-npm
install-npm:
	npm install
	$(MAKE) build

.PHONY: lint
lint: ## Run all linting
	@echo "Running PHP linting"
	if [ ! -d ./vendor/ ]; then \
		$(MAKE) install-composer; \
	fi
	./vendor/bin/phpcs --standard=./phpcs.xml

.PHONY: open-db
open-db: ## Open the database in TablePlus
	@echo "Opening the database for direct access"
	open mysql://wordpress:wordpress@127.0.0.1:$$(lando info --service=database --path 0.external_connection.port | tr -d "'")/wordpress?enviroment=local&name=$database&safeModeLevel=0&advancedSafeModeLevel=0

.PHONY: release
release: chriswiegman-theme-version.zip

.PHONY: reset
reset: destroy start ## Resets a running dev environment to new

.PHONY: setup
setup: | copy-prod-assets import-db

.PHONY: start
start: ## Starts the development environment including downloading and setting up everything it needs
	if [ ! -d ./wordpress/ ]; then \
		$(MAKE) install; \
	fi
	if [ ! "$$(docker ps | grep kana-chriswiegman-theme-wordpress)" ]; then \
		kana start; \
	fi

.PHONY: stop
stop: ## Stops the development environment. This is non-destructive.
	if [ "$$(docker ps | grep kana-chriswiegman-theme-wordpress)" ]; then \
		kana stop; \
	fi

.PHONY: update
update: | update-composer update-npm

.PHONY: update-composer
update-composer:
	composer update

.PHONY: update-npm
update-npm:
	npm update


.PHONY: watch
watch:
	@echo "Building and watching theme assets"
	npm run watch
