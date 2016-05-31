<?php

namespace Artesaos\Restinga\Service;

use Artesaos\Restinga\Contracts\Service\Descriptor as DescriptorContract;

/**
 * Class Descriptor.
 */
abstract class Descriptor implements DescriptorContract
{
    /**
     * @var string
     */
    protected $service;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @return string
     */
    public function service()
    {
        return $this->service;
    }

    /**
     * @return array
     */
    public function headers()
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function prefix()
    {
        return $this->prefix;
    }
}
