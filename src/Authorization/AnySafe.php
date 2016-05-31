<?php

namespace Artesaos\Restinga\Authorization;

/**
 * Class AnySafe.
 */
class AnySafe extends Basic
{
    /**
     * @var int
     */
    protected $method = CURLAUTH_ANYSAFE;
}
