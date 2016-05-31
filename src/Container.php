<?php

namespace Artesaos\Restinga;

use Artesaos\Restinga\Contracts\Service\Descriptor;

/**
 * Class Container.
 */
class Container
{
    /**
     * @var array
     */
    protected static $services = [];

    private function __construct()
    {
    }

    /**
     * @param \Artesaos\Restinga\Contracts\Service\Descriptor $service
     */
    public static function register(Descriptor $service)
    {
        $name = $service->service();
        if ($name) {
            self::$services[$name] = $service;
        }
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public static function has($name)
    {
        return array_key_exists($name, self::$services);
    }

    /**
     * @param string $name
     *
     * @return \Artesaos\Restinga\Contracts\Service\Descriptor|null
     */
    public static function get($name)
    {
        return self::has($name) ? self::$services[$name] : null;
    }
}
