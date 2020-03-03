## Welcome to ParrallelPHP package :)

### Minimal requirements:
> PHP 7.0

### A few words about the package:
This package allows you to call functions and execute them in parallel without waiting for the previous one to complete.
This allows you to speed up the execution of the script as a whole.

####For example:
```php
<?php
   // You have three functions:
   $functions = [
       function () {
           sleep(1);
           return 11;
       },
       function () {
           sleep(2);
           return 22;
       },
       function () {
           sleep(3);
           return 33;
       }
   ];
   
   // If you do them synchronously:
   $functions[0](); // 1 sec.
   $functions[1](); // 2 sec.
   $functions[2](); // 3 sec.
   // Spend = 6 sec.
```

```php
<?php
    // If you do them using parallel calling:
    $promise = new Promise();
    $promise
        ->addItem(function () {
            sleep(1);
            return 11;
        })
        ->addItem(function () {
            sleep(2);
            return 22;
        })
        ->addItem(function () {
            sleep(3);
            return 33;
        })
        ->then(function ($first, $second, $third) {
            var_dump('then #1:', $first, $second, $third);
        })
        ->resolve(function ($first, $second, $third) {
            var_dump('resolve: ', $first, $second, $third);
        })
        ->finally(function ($first, $second, $third) {
            var_dump('finally: ', $first, $second, $third);
        });
    // Spend 3 sec.
   ```
Great, isn't it?

This package is just a decorator between AmPHP and you using Promise methods to increase ease of use.

### Examples:

```php
<?php

$promise = new Promise();

/**
 * Add items.
 */
$promise
    ->addItem(function () {
        sleep(1);
        return 11;
    })
    ->addItem(function () {
        sleep(2);
        return 22;
    })
    ->addItem(function () {
        sleep(3);
        return 33;
    });

/**
 * Remove items by key.
 */
if ($conditions) {
    $promise
        ->removeItem(2)
        ->removeItem(3);
}

/**
 * Starting to execute the event list.
 */
$promise
    ->then(function ($first, $second, $third) {
        var_dump('then #1:', $first, $second, $third);
    })
    ->then(function ($first, $second, $third) {
        var_dump('then #2:', $first, $second, $third);
    });

/**
 * If the list items were resolved.
 */
$promise
    ->resolve(function ($first, $second, $third) {
        var_dump('resolve: ', $first, $second, $third);
    });

/**
 * If the list items were rejected.
 */
$promise
    ->reject(function ($exception) {
        var_dump('reject: ', $exception);
    });

/**
 * The final method to complete.
 */
$promise
    ->finally(function ($first, $second, $third) {
        var_dump('finally: ', $first, $second, $third);
    });
```

In the case of Laravel it can be considered as:

```php
$promise
    ->addItem(function () {
        $users = \DB::table('users')->get();
        // Some slow process
        return $users;
    })
    ->addItem(function () {
        $products = \DB::table('products')->get();
        // Some slow process
        return $products;
    });
```

You can also add items using __constructor in Promise class:

```php
```php
<?php

$promise = new Promise([
    function () {
           sleep(1);
           return 11;
       },
       function () {
           sleep(2);
           return 22;
       },
       function () {
           sleep(3);
           return 33;
       }
]);

...

$promise
        ->addItem(function () {
            sleep(1);
            return 11;
        })
        ->removeItem(2)
        ->then(function ($first, $second, $third) {
            var_dump('then #1:', $first, $second, $third);
        });

...
```
