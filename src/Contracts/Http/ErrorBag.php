<?php

namespace Artesaos\Restinga\Contracts\Http;

/**
 * Class ErrorBag.
 */
interface ErrorBag
{
    /**
     * @return int
     */
    public function code();

    /**
     * @return array
     */
    public function all();

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = false);

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function first($key);
}
