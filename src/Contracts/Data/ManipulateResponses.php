<?php

namespace Artesaos\Restinga\Contracts\Data;

/**
 * Interface ManipulateResponses.
 */
interface ManipulateResponses
{
    /**
     * @return bool
     */
    public function checkResponse();

    /**
     * @return bool
     */
    public function hasErrors();

    /**
     * @return \Artesaos\Restinga\Contracts\Http\ErrorBag|null
     */
    public function getErrors();
}
