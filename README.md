# Simple data logging

<p>
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

## Documentation

| Methods            | Description                                                                                                                                                                | Example for usage                                                                                                                       |
|:-------------------|:---------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------|
| `setWorkDirectory` | Specifies the root directory of the hierarchy of logging levels. It can take several directories in turn one after the other in the form of a standard path.               | `setWorkDirectory('logging')` <br> `setWorkDirectory('logging/sub-folder')`                                                             |
| `setLevel`         | Specifies the name of the directory where you want to save the logging file. It can't take several directories in turn one after the other in the form of a standard path. | `setLevel('requests')`                                                                                                                  |
| `setTimeZone`      | Specifies the current timezone.                                                                                                                                            | `setTimeZone('UTC')` <br> `setTimeZone('Europe/Amsterdam')`                                                                             |
| `setDateFormat`    | Sets the time format in the main key of one log element in the logging file. Will not be used if V is specified.                                                           | `setDateFormat('H:i:s')` <br> `setDateFormat('(Y) H:i:s')`                                                                              |
| `setItemKey`       | Sets the primary key of one log element in the logging file. In this case, the current time will not be indicated.                                                         | `setItemKey('custom-key')`                                                                                                              |
| `setItemsLimit`    | Sets the maximum number of elements in a single logging file. The value must be greater than zero. By default, 1000 keys.                                                  | `setItemsLimit(10)` <br> `setItemsLimit(5000)`                                                                                          |
| `setPermissions`   | Sets access rights to the logging file.                                                                                                                                    | `setLogFilePermissions(0755)` <br> `setLogFilePermissions(644)`                                                                         |
| `setFileName`      | Sets the name of the logging file.                                                                                                                                         | `setFileName('my-requests-logs')`                                                                                                       |
| `error`            | Logging any object as an error message.                                                                                                                                    | Similarly as for `custom`.                                                                                                              |
| `warning`          | Logging any object as a warning.                                                                                                                                           | Similarly as for `custom`.                                                                                                              |
| `info`             | Logging of any object as an informational message.                                                                                                                         | Similarly as for `custom`.                                                                                                              |
| `custom`           | Logging of any object.                                                                                                                                                     | `custom(new SomeClass())` <br> `custom('Some message')` <br> `custom(['key' => 'value'])`                                               |
| `exception`        | Logging of the exception object with the possibility of adding additional keys.                                                                                            | `exception(new \Exceptions())` <br> `exception(new \Exceptions(), true)` <br> `exception(new \Exceptions(), false, ['key' => 'value'])` |
| `clearLevel`       | The requirement to clear the directory where the logging file should be saved from other files.                                                                            | `clearLevel()`                                                                                                                          |