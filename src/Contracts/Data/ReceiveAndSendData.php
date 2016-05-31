<?php

namespace Artesaos\Restinga\Contracts\Data;

interface ReceiveAndSendData
{
    /**
     * @param string $data
     *
     * @return array
     */
    public function factoryCollection($data);

    /**
     * @param string $data
     */
    public function factory($data);

    /**
     * @return string
     */
    public function getAcceptHeader();

    /**
     * @return string
     */
    public function encode();

    /**
     * @return string
     */
    public function getContentTypeHeader();
}
