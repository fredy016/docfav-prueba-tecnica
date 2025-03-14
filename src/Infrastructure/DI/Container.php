<?php

namespace Src\Infrastructure\DI;

use Psr\Container\ContainerInterface;
use Exception;

class Container implements ContainerInterface
{
    private array $services = [];

    public function set(string $id, callable $service): void
    {
        $this->services[$id] = $service;
    }

    public function get(string $id)
    {
        if (!isset($this->services[$id])) {
            throw new Exception("Servicio no encontrado: " . $id);
        }
        return $this->services[$id]($this);
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }
}