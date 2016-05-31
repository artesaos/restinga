<?php

namespace Artesaos\Restinga\Authorization;

/**
 * Class NTLM.
 */
class NTLM extends Basic
{
    /**
     * @var int
     */
    protected $method = CURLAUTH_NTLM;
}
