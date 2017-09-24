<?php

namespace Artesaos\Restinga\Data;

use Artesaos\Restinga\Http\ErrorBag;

/**
 * Trait ManipulateResponses.
 */
trait ManipulateResponses
{
    /**
     * @var \Artesaos\Restinga\Contracts\Http\ErrorBag|null
     */
    protected $errors = null;

    /**
     * @return bool
     */
    public function checkResponse()
    {
        if ($this->response->code >= 200 && $this->response->code <= 299) {
            return true;
        } else {
            $this->errors = $this->factoryErrors($this->response->code, $this->response->raw_body);

            return false;
        }
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return $this->errors ? true : false;
    }

    /**
     * @return \Artesaos\Restinga\Contracts\Http\ErrorBag|null
     */
    public function getErrors()
    {
        return $this->errors ? $this->errors : new ErrorBag($this->response->code);
    }
}
