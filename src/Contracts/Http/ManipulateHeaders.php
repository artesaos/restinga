<?php

namespace Artesaos\Restinga\Contracts\Http;

interface ManipulateHeaders
{
    /**
     * @param string $header
     *
     * @return bool
     */
    public function hasHeader($header);

    /**
     * @param string $header
     * @param string $value
     */
    public function addHeader($header, $value);

    /**
     * @param string $header
     */
    public function removeHeader($header);
}
