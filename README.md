# Loggers

[![pipeline status](https://gitlab.com/jitesoft/open-source/php/loggers/badges/master/pipeline.svg)](https://gitlab.com/jitesoft/open-source/php/loggers/commits/master)
[![coverage report](https://gitlab.com/jitesoft/open-source/php/loggers/badges/master/coverage.svg)](https://gitlab.com/jitesoft/open-source/php/loggers/commits/master)
[![Back project](https://img.shields.io/badge/Open%20Collective-Tip%20the%20devs!-blue.svg)](https://opencollective.com/jitesoft-open-source)
[![PHP-Version](https://img.shields.io/packagist/php-v/jitesoft/loggers.svg)](https://packagist.org/packages/jitesoft/loggers)

This repository contains a set of loggers implementing the PSR-3 logger interface.  
Pull-requests and feature requests welcome.

For usage with PHP versions under 7.4, please use the 1.x tags (or php-7.2 branch). All version 2+ builds are using PHP
7.4 features and hence requires php 7.4 or higher.

## Implemented loggers

### `StdLogger`

Logs output to stdout and stderr.

### `FileLogger`
### `PDOLogger`
### `SysLogLogger`
### `MultiLogger`
### `CallbackLogger`
### `NullLogger`
