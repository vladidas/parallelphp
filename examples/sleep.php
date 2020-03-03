<?php

use Vladidas\ParallelPHP\Services\Promise;

require_once __DIR__ . '/../vendor/autoload.php';

/** @var Promise $promise */
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
if (true) {
    $promise
        ->removeItem(1)
        ->removeItem(2);
}

/**
 * Starting to execute the event list.
 */
$promise
    ->then(function ($first) {
        var_dump('then #1:', $first);
    })
    ->then(function ($first) {
        var_dump('then #2:', $first);
    });

/**
 * If the list items were resolved.
 */
$promise
    ->resolve(function ($first) {
        var_dump('resolve: ', $first);
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
    ->finally(function ($first) {
        var_dump('finally: ', $first);
    });
