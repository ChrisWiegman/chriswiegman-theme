DOCKER_RUN     := @docker run --rm
COMPOSER_IMAGE := -v $$(pwd):/app --user $$(id -u):$$(id -g) composer
NODE_IMAGE     := -w /home/node/app -v $$(pwd):/home/node/app --user node node:lts
HIGHLIGHT      :=\033[0;32m
END_HIGHLIGHT  :=\033[0m # No Color
THEME_VERSION  := $$(grep "^Version" style.css | awk -F' ' '{print $3}' | cut -d ":" -f2 | sed 's/ //g')

.PHONY: build
build:  | clean-assets
	@echo "Building theme assets"
	$(DOCKER_RUN) $(NODE_IMAGE) npm run build-assets

.PHONY: chriswiegman-theme.zip
chriswiegman-theme.zip: clean-release build
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
		kana destroy --confirm-destroy; \
	fi
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
install:
	$(DOCKER_RUN) $(COMPOSER_IMAGE) install
	$(DOCKER_RUN) $(NODE_IMAGE) npm install
	$(MAKE) build

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

.PHONY: setup
setup: | copy-prod-assets import-db

.PHONY: start
start: ## Starts the development environment including downloading and setting up everything it needs
	if [ ! -d ./wordpress/ ]; then \
		$(MAKE) install; \
	fi
	if [ ! "$$(docker ps | grep kana-chriswiegman-theme-wordpress)" ]; then \
		echo "Starting Kana"; \
		kana start; \
		echo "You can open your dev site at: ${HIGHLIGHT}https://chriswiegman-theme.sites.kana.li${END_HIGHLIGHT}"; \
		echo "See the readme for further details."; \
	fi

.PHONY: stop
stop: ## Stops the development environment. This is non-destructive.
	if [ "$$(docker ps | grep kana-chriswiegman-theme-wordpress)" ]; then \
		echo "Stopping Kana"; \
		kana stop; \
	fi

.PHONY: update
update:
	$(DOCKER_RUN) $(NODE_IMAGE) npm update
	$(DOCKER_RUN) $(COMPOSER_IMAGE) update

.PHONY: watch
watch:
	@echo "Building and watching theme assets"
	$(DOCKER_RUN) -d $(NODE_IMAGE) npm run watch
