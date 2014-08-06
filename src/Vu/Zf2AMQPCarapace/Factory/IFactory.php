<?php


namespace Vu\Zf2AMQPCarapace\Factory;

/**
 * Interface IFactory
 *
 * @package ZF2AMQPCarapace\Factory
 */
interface IFactory {
    /**
     * @param string $factory_name
     * @return mixed
     */
    public function create($factory_name);

    /**
     * @param array $configuration
     * @return mixed
     */
    public function createFromArray(array $configuration);
} 