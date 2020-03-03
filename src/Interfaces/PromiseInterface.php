<?php

namespace Vladidas\ParallelPHP\Interfaces;

use Vladidas\ParallelPHP\Services\Promise;

/**
 * Interface PromiseInterface
 * @package Vladidas\ParallelPHP\Interfaces
 * @author  Vlad Golubtsov <v.golubtsov@bvblogic.com>
 */
interface PromiseInterface
{
    /**
     * @param callable $item
     * @return $this
     */
    public function addItem(callable $item): Promise;

    /**
     * @param $key
     * @return Promise
     * @throws \Exception
     */
    public function removeItem($key): Promise;

    /**
     * @return array|null
     */
    public function getItems(): ?array;

    /**
     * @param callable $callback
     * @return Promise
     * @throws \Throwable
     */
    public function then(callable $callback): Promise;

    /**
     * @throws \Throwable
     */
    public function handle();

    /**
     * @param callable $callback
     * @return Promise
     */
    public function resolve(callable $callback): Promise;

    /**
     * @param callable $callback
     * @return Promise
     */
    public function reject(callable $callback): Promise;

    /**
     * @param callable $callback
     */
    public function finally(callable $callback);
}
