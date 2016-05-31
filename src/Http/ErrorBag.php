<?php

namespace Artesaos\Restinga\Http;

use Artesaos\Restinga\Contracts\Http\ErrorBag as ErrorBagContract;

/**
 * Class ErrorBag.
 */
class ErrorBag implements ErrorBagContract
{
    /**
     * @var int
     */
    protected $code;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var string
     */
    protected $raw;

    /**
     * {@inheritdoc}
     */
    public function __construct($code, $errors = [], $raw = '')
    {
        $this->code = $code;
        $this->errors = (array) $errors;
        $this->raw = $raw;
    }

    /**
     * {@inheritdoc}
     */
    public function code()
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->errors;
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return array_key_exists($key, $this->errors);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = false)
    {
        if ($this->has($key)) {
            return $this->errors[$key];
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function first($key)
    {
        $error = $this->get($key);
        if (is_array($error)) {
            return reset($error);
        }

        return $error;
    }
}
