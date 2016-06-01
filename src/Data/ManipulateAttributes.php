<?php

namespace Artesaos\Restinga\Data;

/**
 * Trait ManipulateAttributes.
 */
trait ManipulateAttributes
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var string
     */
    protected $identifier = '';

    /**
     * @param string $attribute
     * @param mixed  $value
     */
    public function __set($attribute, $value)
    {
        $this->attributes[$attribute] = $value;
    }

    /**
     * @param string $attribute
     *
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->attributes[$attribute];
    }

    /**
     * @return string|null
     */
    public function getIdentifier()
    {
        return array_key_exists($this->identifier, $this->attributes) ? $this->attributes[$this->identifier] : null;
    }

    /**
     * @param string $value
     */
    public function setIdentifier($value)
    {
        $this->attributes[$this->getIdentifierName()] = $value;
    }

    /**
     * @return string
     */
    public function getIdentifierName()
    {
        return $this->identifier;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
    
    public function toArray()
    {
        return $this->attributes;
    }
}
