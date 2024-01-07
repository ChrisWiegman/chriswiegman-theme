# The WordPress theme for ChrisWiegman.com

Minimal and sustainable WordPress theme for ChrisWiegman.com.

## Getting the theme

You can download the latest version from the [releases page](https://github.com/ChrisWiegman/chriswiegman-theme/releases) in this repo.

## Setup and Usage of the Development Environment

A fully featured development environment is included using PHP 8.2 and more. Scripts to run commands including setup and more use _make_ as a task runner. See the instructions below for getting started.

Before starting your workstation will need the following:

- [Docker](https://www.docker.com/)
- [Kana](https://github.com/ChrisWiegman/chriswiegman-theme)

1. Clone the repository

`git clone https://github.com/chriswiegman/chriswiegman-theme.git`

2. Start Kana

```bash
cd chriswiegman-theme
make start
```

When finished, Kana will open a development version of your site in the browser and you're ready to go

WordPress Credentials:

**URL:** _https://chriswiegman-theme.lndo.site/wp-admin_

**Admin User:** _admin_

**Admin Password:** _password_

## Using Xdebug

Xdebug 3 released a [number of changes](https://xdebug.org/docs/upgrade_guide) that affect the way Xdebug works. Namely, it no longer listens on every request and requires a "trigger" to enable the connection. Use one of the following plugins to enable the trigger on your machine:

- [Xdebug Helper for Firefox](https://addons.mozilla.org/en-GB/firefox/addon/xdebug-helper-for-firefox/) ([source](https://github.com/BrianGilbert/xdebug-helper-for-firefox)).
- [Xdebug Helper for Chrome](https://chrome.google.com/extensions/detail/eadndfjplgieldjbigjakmdgkmoaaaoc) ([source](https://github.com/mac-cain13/xdebug-helper-for-chrome)).
- [XDebugToggle for Safari](https://apps.apple.com/app/safari-xdebug-toggle/id1437227804?mt=12) ([source](https://github.com/kampfq/SafariXDebugToggle)).

To enable Xdebug using the built-in Kana configuration use the following:

```bash
kana xdebug on
```

## Build the project

```bash
make build
```

Note, assets will also build during the install phase if you use `make start`.

I also use [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) with [WordPress Coding Standards](https://github.com/WordPress/WordPress-Coding-Standards) and [JSHint](http://jshint.com/) with [WordPress' JS Standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/#installing-and-running-jshint). Linting will automagically be setup for you if you use [Visual Studio Code](https://code.visualstudio.com/). If you want to run it manually use the following:

```bash
make lint
```
