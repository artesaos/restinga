<?php

namespace Artesaos\Restinga\Http;

/**
 * Class ManipulateHeaders.
 */
trait ManipulateHeaders
{
    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @param string $header
     *
     * @return bool
     */
    public function hasHeader($header)
    {
        return array_key_exists($header, $this->headers);
    }

    /**
     * @param string $header
     * @param string $value
     */
    public function addHeader($header, $value)
    {
        $this->headers[$header] = $value;
    }

    /**
     * @param string $header
     */
    public function removeHeader($header)
    {
        if ($this->hasHeader($header)) {
            unset($this->headers[$header]);
        }
    }
}
