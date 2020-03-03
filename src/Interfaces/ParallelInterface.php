<?php

namespace Vladidas\ParallelPHP\Interfaces;

/**
 * Interface ParallelInterface
 * @package Vladidas\ParallelPHP\Interfaces
 * @author  Vlad Golubtsov <v.golubtsov@bvblogic.com>
 */
interface ParallelInterface
{
    /**
     * Parallel constructor.
     * @param array $items
     */
    public function __construct(array $items);

    /**
     * @return mixed
     * @throws \Throwable
     */
    public function handle();
}
