# WordPress Plugin Starter

Minimal and sustainable WordPress theme for ChrisWiegman.com.

## Setup and Usage of the Development Environment

A fully featured development environment is included using PHP 7.4 and more. Scripts to run commands including setup and more use _make_ as a task runner. See the instructions below for getting started.

Before starting your workstation will need the following:

- [Docker](https://www.docker.com/)
- [Lando](https://lando.dev/)

1. Clone the repository

`git clone https://github.com/chriswiegman/chriswiegman-theme.git`

2. Start Lando

```bash
cd chriswiegman-theme
make start
```

When finished, Lando will give you the local URL of your site. You can finish the WordPress setup there.

WordPress Credentials:

**URL:** _https://chriswiegman-theme.lndo.site/wp-admin_

**Admin User:** _admin_

**Admin Password:** \_password

## Using Xdebug

Xdebug 3 released a [number of changes](https://xdebug.org/docs/upgrade_guide) that affect the way Xdebug works. Namely, it no longer listens on every request and requires a "trigger" to enable the connection. Use one of the following plugins to enable the trigger on your machine:

- [Xdebug Helper for Firefox](https://addons.mozilla.org/en-GB/firefox/addon/xdebug-helper-for-firefox/) ([source](https://github.com/BrianGilbert/xdebug-helper-for-firefox)).
- [Xdebug Helper for Chrome](https://chrome.google.com/extensions/detail/eadndfjplgieldjbigjakmdgkmoaaaoc) ([source](https://github.com/mac-cain13/xdebug-helper-for-chrome)).
- [XDebugToggle for Safari](https://apps.apple.com/app/safari-xdebug-toggle/id1437227804?mt=12) ([source](https://github.com/kampfq/SafariXDebugToggle)).

## Build the project

The theme minified versions of any JavaScript files:

```bash
make build
```

Note, assets will also build during the install phase.

We also use [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) with [WordPress Coding Standards](https://github.com/WordPress/WordPress-Coding-Standards) and [JSHint](http://jshint.com/) with [WordPress' JS Standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#installing-and-running-jshint). Linting will automagically be setup for you if you use [Visual Studio Code](https://code.visualstudio.com/). If you want to run it manually use the following:

```bash
make test-lint
```

or, to run an individual lint, use one of the following:

```bash
make test-lint-php
```

You can run all testing (all lints and unit tests) together with the following:

```bash
make test
```
