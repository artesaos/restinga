<?php

namespace Artesaos\Restinga\Contracts\Data;

interface ManipulateAttributes
{
    /**
     * @param string $attribute
     * @param mixed  $value
     */
    public function __set($attribute, $value);

    /**
     * @param string $attribute
     *
     * @return mixed
     */
    public function __get($attribute);

    /**
     * @return string|null
     */
    public function getIdentifier();

    /**
     * @param string $value
     */
    public function setIdentifier($value);

    /**
     * @return string
     */
    public function getIdentifierName();

    /**
     * @return array
     */
    public function getAttributes();
}
