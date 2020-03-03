<?php

namespace Vladidas\ParallelPHP\Services;

use Vladidas\ParallelPHP\Interfaces\PromiseInterface;

/**
 * Class Promise
 * @package Vladidas\ParallelPHP\Services
 * @author  Vlad Golubtsov <v.golubtsov@bvblogic.com>
 */
class Promise implements PromiseInterface
{
    /**
     * @var array|null
     */
    private $items;

    /**
     * @var array
     */
    private $result = [];

    /**
     * @var string|null
     */
    private $exception;

    /**
     * Promise constructor.
     * @param $items
     * @throws \Exception
     */
    public function __construct($items = null)
    {
        if (is_null($items)) {
            return;
        }

        if (!is_iterable($items)) {
            throw new \Exception('Items are non-iterable!');
        }

        foreach ($items as $key => $item) {
            $this->items[$key] = $item;
        }
    }

    /**
     * @param callable $item
     * @return $this
     */
    public function addItem(callable $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param $key
     * @return Promise
     * @throws \Exception
     */
    public function removeItem($key): self
    {
        if (!is_iterable($this->items)) {
            throw new \Exception('Items are non-iterable!');
        }

        if (!array_key_exists($key, $this->items)) {
            throw new \Exception("Key $key does not exist!");
        }

        unset($this->items[$key]);

        return $this;
    }

    /**
     * @return array|null
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * @param callable $callback
     * @return Promise
     * @throws \Throwable
     */
    public function then(callable $callback): self
    {
        try {

            /** @var array|null $items */
            $items = $this->getItems();

            if (is_null($items)) {
                throw new \Exception('The event list is empty!');
            }

            if (!$this->result) {
                $this->handle();
            }

            if ($this->exception) {
                throw new \Exception($this->exception);
            }

            call_user_func_array($callback, $this->result);

        } catch (\Exception $exception) {

            $this->exception = $exception;

        }

        return $this;
    }

    /**
     * @throws \Throwable
     */
    public function handle()
    {
        $parallel = new Parallel($this->getItems());
        $this->result = $parallel->handle();
    }

    /**
     * @param callable $callback
     * @return Promise
     */
    public function resolve(callable $callback): self
    {
        if (!$this->result) {
            return $this;
        }

        if (!$this->exception) {
            call_user_func_array($callback, $this->result);
        }

        return $this;
    }

    /**
     * @param callable $callback
     * @return Promise
     */
    public function reject(callable $callback): self
    {
        if (!$this->result) {
            return $this;
        }

        if ($this->exception) {
            $callback($this->exception);
        }

        return $this;
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function finally(callable $callback)
    {
        if (!$this->result) {
            return $this;
        }

        array_push($this->result, $this->exception);
        call_user_func_array($callback, $this->result);
    }
}
