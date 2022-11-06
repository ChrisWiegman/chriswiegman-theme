DOCKER_RUN     := @docker run --rm
COMPOSER_IMAGE := -v $$(pwd):/app --user $$(id -u):$$(id -g) composer
NODE_IMAGE     := -w /home/node/app -v $$(pwd):/home/node/app --user node node:lts
HIGHLIGHT      :=\033[0;32m
END_HIGHLIGHT  :=\033[0m # No Color
THEME_VERSION  := $$(grep "^Version" style.css | awk -F' ' '{print $3}' | cut -d ":" -f2 | sed 's/ //g')

.PHONY: build
build: build-assets

.PHONY: build-assets
build-assets: | clean-assets
	@echo "Building theme assets"
	$(DOCKER_RUN) $(NODE_IMAGE) npm run build-assets

.PHONY: build-docker
build-docker: build-docker-node build-docker-php

.PHONY: chriswiegman-theme.zip
chriswiegman-theme.zip: clean-release build-assets
	@echo "Building release file: chriswiegman-theme.$(THEME_VERSION).zip"
	rm -rf chriswiegman-theme.$(THEME_VERSION).zip
	rm -rf build
	mkdir build
	cp -av theme build
	mv build/theme build/chriswiegman-theme
	THEME_VERSION=$(THEME_VERSION) && cd build && zip -r chriswiegman-theme.$$THEME_VERSION.zip *
	mv build/chriswiegman-theme.$(THEME_VERSION).zip ./

.PHONY: chriswiegman-theme-version.zip
chriswiegman-theme-version.zip: clean-release
	@echo "Building release file: chriswiegman-theme.$(THEME_VERSION).zip"
	THEME_VERSION=$(THEME_VERSION) && cd ../ && zip --verbose -r -x=@chriswiegman-theme/.zipignore chriswiegman-theme/chriswiegman-theme.$$THEME_VERSION.zip chriswiegman-theme/*
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
	rm -rf ./wordpress/wp-content/plugins/*
	rm -rf ./wordpress/wp-content/uploads/*

.PHONY: clean-release
clean-release:
	@echo "Cleaning up release file"
	rm -f chriswiegman-theme*.zip

.PHONY: copy-prod-assets
copy-prod-assets: | clean-prod-assets
	@echo "Copying assets from chriswiegman.com"
	rsync -avz -e "ssh" --progress chriswiegman@chriswiegman.ssh.wpengine.net:/home/wpe-user/sites/chriswiegman/wp-content/plugins/ ./wordpress/wp-content/plugins/
	rsync -avz -e "ssh" --progress chriswiegman@chriswiegman.ssh.wpengine.net:/home/wpe-user/sites/chriswiegman/wp-content/uploads/ ./wordpress/wp-content/uploads/
	scp chriswiegman@chriswiegman.ssh.wpengine.net:/home/wpe-user/sites/chriswiegman/wp-content/mysql.sql ./wordpress/wp-content/

.PHONY: import-db
import-db:
	echo "Importing production database"
	kana db-import ./wordpress/wp-content/mysql.sql
	kana wp search-replace https://chriswiegman.com https://chriswiegman-theme.lndo.site --all-tables

.PHONY: destroy
destroy: ## Destroys the developer environment completely (this is irreversible)
	kana destroy
	$(MAKE) clean

.PHONY: flush-cache
flush-cache: ## Clears all server caches enabled within WordPress
	@echo "Flushing cache"
	kana wp cache flush

.PHONY: delete-transients
delete-transients: ## Deletes all WordPress transients stored in the database
	@echo "Deleting transients"
	kana wp transient delete --all

.PHONY: help
help:  ## Display help
	@awk -F ':|##' \
		'/^[^\t].+?:.*?##/ {\
			printf "\033[36m%-30s\033[0m %s\n", $$1, $$NF \
		}' $(MAKEFILE_LIST) | sort

.PHONY: install
install: | clean-assets clean-build
	$(MAKE) install-composer
	$(MAKE) install-npm
	$(MAKE) build-assets

.PHONY: install-composer
install-composer:
	$(DOCKER_RUN) $(COMPOSER_IMAGE) install

.PHONY: install-npm
install-npm:
	$(DOCKER_RUN) $(NODE_IMAGE) npm install

.PHONY: kana-start
kana-start:
	if [ ! -d ./wordpress/ ]; then \
		$(MAKE) install; \
	fi
	if [ ! "$$(docker ps | grep kana_chriswiegman-theme_wordpress)" ]; then \
		echo "Starting Kana"; \
		kana start --theme --local; \
	fi
	if [ ! -f ./wordpress/wp-content/plugins/debug-bar/debug-bar.php ]; then \
		$(MAKE) setup-wordpress-plugins; \
		$(MAKE) setup-wordpress-theme; \
		echo "You can open your dev site at: ${HIGHLIGHT}https://chriswiegman-theme.sites.kana.li${END_HIGHLIGHT}"; \
		echo "See the readme for further details."; \
	fi

.PHONY: kana-stop
kana-stop:
	if [ "$$(docker ps | grep kana_chriswiegman-theme_wordpress)" ]; then \
		echo "Stopping Kana"; \
		kana stop; \
	fi

.PHONY: lint
lint: ## Run all linting
	@echo "Running PHP linting"
	docker run \
		-v "$$(pwd):/app" \
		--workdir /app \
		--rm \
		php:7.4-cli \
		/app/vendor/bin/phpcs --standard=./phpcs.xml

.PHONY: open-db
open-db: ## Open the database in TablePlus
	@echo "Opening the database for direct access"
	open mysql://wordpress:wordpress@127.0.0.1:$$(lando info --service=database --path 0.external_connection.port | tr -d "'")/wordpress?enviroment=local&name=$database&safeModeLevel=0&advancedSafeModeLevel=0


.PHONY: relase
release: chriswiegman-theme-version.zip

.PHONY: reset
reset: destroy start ## Resets a running dev environment to new

.PHONY: setup-site
setup: | copy-prod-assets import-db
	kana wp plugin deactivate ewww-image-optimizer
	$(MAKE) setup-wordpress-plugins

.PHONY: setup-wordpress-plugins
setup-wordpress-plugins:
	kana wp plugin install debug-bar --activate
	kana wp plugin install query-monitor --activate

.PHONY: setup-wordpress-theme
setup-wordpress-theme:
	kana wp theme activate chriswiegman-theme

.PHONY: start
start: kana-start ## Starts the development environment including downloading and setting up everything it needs

.PHONY: stop
stop: kana-stop ## Stops the development environment. This is non-destructive.

.PHONY: update-composer
update-composer:
	$(DOCKER_RUN) $(COMPOSER_IMAGE) update

.PHONY: update-npm
update-npm:
	$(DOCKER_RUN) $(NODE_IMAGE) npm update

.PHONY: watch
watch:
	@echo "Building and watching theme assets"
	$(DOCKER_RUN) -d $(NODE_IMAGE) npm run watch
