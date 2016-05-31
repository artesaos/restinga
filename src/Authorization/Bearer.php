<?php

namespace Artesaos\Restinga\Authorization;

use Artesaos\Restinga\Contracts\Authorization;
use Unirest\Request;

/**
 * Class Bearer.
 */
class Bearer implements Authorization
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @param Request $request
     *
     * @return Request
     */
    public function setupRequest(Request $request)
    {
        $request->defaultHeader('Authorization', sprintf('Bearer %s', $this->token));

        return $request;
    }
}
