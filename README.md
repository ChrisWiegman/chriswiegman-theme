# WordPress Plugin Starter

Minimal and sustainable WordPress theme for ChrisWiegman.com.

## Setup and Usage of the Development Environment

A fully featured development environment is included using PHP 7.4 and more. Scripts to run commands including setup and more use _make_ as a task runner. See the instructions below for getting started.

Before starting your workstation will need the following:

* [Docker](https://www.docker.com/)
* [Lando](https://lando.dev/)

1. Clone the repository

`git clone https://gitea.chriswiegman.com/chriswiegman/chriswiegman-themme.git`

2. Start Lando

```bash
cd chriswiegman-theme
make start
```

When finished, Lando will give you the local URL of your site. You can finish the WordPress setup there.

WordPress Credentials:

__URL:__ _https://chriswiegman-theme.lndo.site/wp-admin_

__Admin User:__ _admin_

__Admin Password:__ _password

## Build and Testing

The theme minified versions of any JavaScript files:

```bash
make build
```

Note, assets will also build during the install phase.

The project uses the WP_Mock library for unit testing. Once setup run the following for unit tests:

```bash
make test-unit
```

We also use [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) with [WordPress Coding Standards](https://github.com/WordPress/WordPress-Coding-Standards) and [JSHint](http://jshint.com/) with [WordPress' JS Standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#installing-and-running-jshint). Linting will automagically be setup for you if you use [Visual Studio Code](https://code.visualstudio.com/). If you want to run it manually use the following:

```bash
make test-lint
```

or, to run an individual lint, use one of the following:

```bash
make test-lint-php
```

```bash
make test-lint-javascript
```

You can run all testing (all lints and unit tests) together with the following:

```bash
make test
```
