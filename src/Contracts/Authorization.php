<?php

namespace Artesaos\Restinga\Contracts;

use Unirest\Request;

/**
 * Interface Authorization.
 */
interface Authorization
{
    /**
     * @param Request $request
     *
     * @return Request
     */
    public function setupRequest(Request $request);
}
