<?php

namespace Artesaos\Restinga\Authorization;

/**
 * Class Digest.
 */
class Digest extends Basic
{
    /**
     * @var int
     */
    protected $method = CURLAUTH_DIGEST;
}
