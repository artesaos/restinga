<?php

namespace Artesaos\Restinga\Http\Format\Send;

trait SendJson
{
    public function encode()
    {
        return json_encode($this->attributes);
    }

    public function getContentTypeHeader()
    {
        return 'application/json';
    }
}
