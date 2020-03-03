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
        return \DB::table('users')->get();
    })
    ->addItem(function () {
        return \DB::table('products')->get();
    })
    ->addItem(function () {
        return \DB::table('orders')->get();
    })
    ->addItem(function () {
        return \DB::table('cities')->get();
    });

/**
 * Remove item by key.
 */
if (true) {
    $promise
        ->removeItem(3);
}

/**
 * Starting to execute the event list.
 */
$promise
    ->then(function ($users, $products, $orders) {
        var_dump('then #1:', $users, $products, $orders);
    })
    ->then(function ($users, $products) {
        var_dump('then #2:', $users, $products);
    });

/**
 * If the list items were resolved.
 */
$promise
    ->resolve(function ($users, $products, $orders) {
        var_dump('resolve: ', $users, $products, $orders);
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
    ->finally(function ($users, $products, $orders) {
        var_dump('finally: ', $users, $products, $orders);
    });
