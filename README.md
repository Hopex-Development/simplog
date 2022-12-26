# Simple data logging

<p>
    <img alt="Package version" src="https://packages-api.hopex.ru/api/simplog/version/package">
    <img alt="Package version" src="https://packages-api.hopex.ru/api/simplog/packagist/hopex/downloads">
    <img alt="Package version" src="https://packages-api.hopex.ru/api/simplog/packagist/hopex/stars">
    <img alt="PHP version" src="https://packages-api.hopex.ru/api/simplog/version/php">
    <img alt="License" src="https://packages-api.hopex.ru/api/simplog/license">
</p>

The library contains a simple class, and it's facade, for simple data and exception logging on JSON format.

## Installing

```
composer require hopex/simplog
```

## Usage

Simple data logging. Your data will be saved to a file `./logs/runtime/NameOfLogFile.log`:
```php
(new Logger())->putData($data, 'NameOfLogFile');
```

### Directory

Default logging directory is `./logs/`. You can change the location directory of the log 
files and the "logging level", after which your logging file will be 
saved along the path `./example/logs/MyLevel/NameOfLogFile.log`:
```php
(new Logger())
    ->setWorkDirectory('example/logs')
    ->setLevel('MyLevel')
    ->putData($data, 'NameOfLogFile');
```

### Date and time format

Timezone default UTC and date format is `Y-m-d H:i:s`. You can also change the time format and time zone that are used inside the logging files:
```php
(new Logger())
    ->setTimeZone('Europe/Moscow')
    ->setDateFormat('(Y) H:i:s')
    ->putData([
        'example' => [
            'parameter' => 1    
        ]
    ], 'NameOfLogFile');
```
Output log file:
```json
{
    "(2022) 19:13:28": {
        "example": {
          "parameter": 1
        }
    }
}
```

### Data of exceptions

You can log exception data by easily passing it to the `putException` function:

```php
(new Logger())
    ->setDateFormat('H:i:s')
    ->setLevel('Exceptions')
    ->putException($e, date('Y-m-d'), true);
```
Output log file `./logs/exceptions/2022.24.12.log`:
```json
{
    "17:45:31": {
        "message": "Some message",
        "file": "G:\\OSPanel\\domains\\localhost\\example.php",
        "line": 10,
        "trace": "#0 {main}"
    }
}
```

### Common

The class has a built-in function `clearLevel` of cleaning the logging working directory 
from unnecessary files:

```php
(new Logger())
    ->clearLevel()
    ->putData($data, 'NameOfLogFile');
```
