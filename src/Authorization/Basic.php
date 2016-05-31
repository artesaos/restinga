<?php

namespace Artesaos\Restinga\Authorization;

use Artesaos\Restinga\Contracts\Authorization;
use Unirest\Request;

/**
 * Class Basic.
 */
class Basic implements Authorization
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string|null
     */
    protected $password;

    /**
     * @var int
     */
    protected $method = CURLAUTH_BASIC;

    /**
     * @param string      $username
     * @param string|null $password
     */
    public function __construct($username, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param Request $request
     *
     * @return Request
     */
    public function setupRequest(Request $request)
    {
        $request->auth($this->username, $this->password, $this->method);

        return $request;
    }
}
