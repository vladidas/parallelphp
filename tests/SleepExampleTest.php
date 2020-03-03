<?php

namespace Vladidas\ParallelPHP\Tests;

use PHPUnit\Framework\TestCase;
use Vladidas\ParallelPHP\Services\Promise;

/**
 * Class SleepExampleTest
 * @package Vladidas\ParallelPHP\Tests
 * @author  Vlad Golubtsov <v.golubtsov@bvblogic.com>
 */
class SleepExampleTest extends TestCase
{
    /** @var Promise */
    private $promise;

    /**
     * @throws \Exception
     */
    public function setUp(): void
    {
        $this->promise = new Promise();
        $this->promise
            ->addItem(function () {
                sleep(1);
                return 11;
            })
            ->addItem(function () {
                sleep(2);
                return 22;
            });
    }

    public function testInstantsOf()
    {
        $this->assertInstanceOf(Promise::class, $this->promise);
    }

    public function testAddItemMethod()
    {
        $promise = $this->promise
            ->addItem(function () {
                sleep(1);
                return 11;
            });

        $this->assertInstanceOf(Promise::class, $promise);
    }

    public function testRemoveItemMethod()
    {
        $promise = $this->promise
            ->removeItem(1);

        $this->assertInstanceOf(Promise::class, $promise);
    }

    public function testResolveMethodWithoutThen()
    {
        $promise = $this->promise
            ->resolve(function ($first, $second) {
                var_dump($first, $second);
            })
            ->resolve(function ($first, $second) {
                var_dump($first, $second);
            });

        $this->assertInstanceOf(Promise::class, $promise);
    }

    public function testRejectMethodWithoutThen()
    {
        $promise = $this->promise
            ->reject(function ($exception) {
                var_dump($exception);
            })
            ->reject(function ($exception) {
                var_dump($exception);
            });

        $this->assertInstanceOf(Promise::class, $promise);
    }

    public function testFinallyMethodWithoutThen()
    {
        $promise = $this->promise
            ->finally(function ($first, $second, $exception) {
                var_dump($first, $second, $exception);
            })
            ->finally(function ($first, $second, $exception) {
                var_dump($first, $second, $exception);
            });

        $this->assertInstanceOf(Promise::class, $promise);
    }

    public function testThenMethod()
    {
        $promise = $this->promise
            ->then(function ($first, $second) {
                var_dump($first, $second);
            })
            ->then(function ($first, $second) {
                var_dump($first, $second);
            });

        $this->assertInstanceOf(Promise::class, $promise);
    }

    public function testResolveAfterThenMethod()
    {
        $promise = $this->promise
            ->resolve(function ($first, $second) {
                var_dump($first, $second);
            })
            ->resolve(function ($first, $second) {
                var_dump($first, $second);
            });

        $this->assertInstanceOf(Promise::class, $promise);
    }

    public function testRejectAfterThenMethod()
    {
        $promise = $this->promise
            ->reject(function ($exception) {
                var_dump($exception);
            })
            ->reject(function ($exception) {
                var_dump($exception);
            });

        $this->assertInstanceOf(Promise::class, $promise);
    }

    public function testFinallyAfterThenMethod()
    {
        $promise = $this->promise
            ->finally(function ($first, $second, $exception) {
                var_dump($first, $second, $exception);
            })
            ->finally(function ($first, $second, $exception) {
                var_dump($first, $second, $exception);
            });

        $this->assertInstanceOf(Promise::class, $promise);
    }
}
