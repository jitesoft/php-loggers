# Loggers

[![pipeline status](https://gitlab.com/jitesoft/open-source/php/loggers/badges/master/pipeline.svg)](https://gitlab.com/jitesoft/open-source/php/loggers/commits/master)
[![coverage report](https://gitlab.com/jitesoft/open-source/php/loggers/badges/master/coverage.svg)](https://gitlab.com/jitesoft/open-source/php/loggers/commits/master)
[![Back project](https://img.shields.io/badge/Open%20Collective-Tip%20the%20devs!-blue.svg)](https://opencollective.com/jitesoft-open-source)
[![PHP-Version](https://img.shields.io/packagist/php-v/jitesoft/loggers.svg)](https://packagist.org/packages/jitesoft/loggers) 

[![Packagist PHP Version (2.x.x/dev-php-7)](https://img.shields.io/badge/v2.x-%3E%3D7.4.2%7C%3E%3D8-blue)](https://packagist.org/packages/jitesoft/loggers)

This repository contains a set of loggers implementing the PSR-3 logger interface.  
Pull-requests and feature requests welcome.

## Php7 and Php8

The `php-7` (or `dev-php-7`) branch is not actively maintained, while security patches might
be applied to it.  
The v2.x tags will be used for php7 and no new features will be applied.  
From version 3.0.0 and forward, the package will use the `psr/log >= 3.0.0` package,
which requires php8 or over, as will this package.

## Implemented loggers

All loggers (with the exception of the NullLogger) are able to set which logging levels they should actually log on
via the `setLogLevel` method.

### `StdLogger`

Logs output to stdout and stderr.  
It's possible to change the format of the output and of the timestamp via the `setFormat` and `setTimeFormat` methods
in the instance class.

### `FileLogger`

The FileLogger is probably the most useful logger. All it does is to print the output to a file of choice 
(defaults to `/tmp/log.txt`).  
It's (as with `StdLogger`) possible to change the format of the output and of the timestamp.

### `JsonLogger`

The JsonLogger is a StdLogger which logs a json object instead of the standard
formatted string.  
The json object looks as the following:

```json
{ "severity": "error", "message": "Formatted message.", "context": { }, "time": "1977-04-22T06:00:00Z", "ts": 230533200 }
```

### `JsonFileLogger`

The JsonFileLogger is a FileLogger which logs a json object instead of
the standard formatted string.
Each log entry will be a new object, the following format is used:

```json
{ "severity": "error", "message": "Formatted message.", "context": { }, "time": "1977-04-22T06:00:00Z", "ts": 230533200 }
```

### `PDOLogger`

Logs output to a PDO connection of choice. The table that it expects to add data to should look like the following:

```text
level   - varchar(255)
message - text
time    - datetime
```

Convenience method:

```sql
CREATE TABLE IF NOT EXISTS log_messages (`level` int, `message` TEXT, `time` TIME )
``` 

### `SysLogLogger`

The SysLogLogger sends your logs to a local syslog server.  
As of right now, it is not able to use a remote server, but should later on...

Internally it uses the php `syslog` and `openlog` methods. Check the constructor docs for default values.

### `MultiLogger`

The MultiLogger was created to make it possible to log with multiple loggers in a single logger.  
This due to the fact that you often wish to bind the logger to the LoggerInterface for dependency injection
something that will not allow you to bind multiple loggers!  
You can add and remove loggers via `addLogger(LoggerInterface $logger, string $name = null)` 
and `removeLogger(LoggerInterface|string $logger)`

### `CallbackLogger`

The CallbackLogger is basically just a callback which gets invoked on log. 
The callback is passed the following arguments:

```text
string: loglevel
string: message (message with context placeholders replaced)
string: text (message without context placeholders replaced)
array:  context
```

### `NullLogger`

_Deprecated since 2.3.0, removed in 3.0.0_

Null logger does absolutely nothing!

### `CompactJsonLogger`

Logger using (Compact Log Event Format JSON)[https://clef-json.org/] output to streams.

Output format:

```json
{"@t":"DateTime as ISO8601 String","@l":(int)level,"@m":"Formatted message","@mt":"Message template","@r": {"context-key": "context-value"}}
```

### `CompactJsonFileLogger`

Logger using (Compact Log Event Format JSON)[https://clef-json.org/] output to file.

```json
{"@t":"DateTime as ISO8601 String","@l":(int)level,"@m":"Formatted message","@mt":"Message template","@r": {"context-key": "context-value"}}
```

----

License

```text
MIT License

Copyright (c) 2020 Jitesoft

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```
