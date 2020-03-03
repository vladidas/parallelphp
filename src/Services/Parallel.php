<?php

namespace Vladidas\ParallelPHP\Services;

use function Amp\Promise\wait;
use function Amp\ParallelFunctions\parallelMap;
use Vladidas\ParallelPHP\Interfaces\ParallelInterface;

/**
 * Class Parallel
 * @package Vladidas\ParallelPHP\Services
 * @author  Vlad Golubtsov <v.golubtsov@bvblogic.com>
 */
class Parallel implements ParallelInterface
{
    /**
     * @var array
     */
    private $items;

    /**
     * Parallel constructor.
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param $key
     * @return mixed
     */
    private function executeItem($key)
    {
        return $this->items[$key]();
    }

    /**
     * @return mixed
     * @throws \Throwable
     */
    public function handle()
    {
        return wait(
            parallelMap(
                array_keys($this->items),
                function ($key) {
                    return $this->executeItem($key);
                }
            )
        );
    }
}
