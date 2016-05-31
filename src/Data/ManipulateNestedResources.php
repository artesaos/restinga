<?php

namespace Artesaos\Restinga\Data;

use Artesaos\Restinga\Contracts\Data\Resource as ResourceContract;

/**
 * Trait ManipulateNestedResources.
 */
trait ManipulateNestedResources
{
    /**
     * @var \Artesaos\Restinga\Contracts\Data\Resource
     */
    protected $parent = null;

    /**
     * @param \Artesaos\Restinga\Contracts\Data\Resource $resource
     *
     * @return \Artesaos\Restinga\Contracts\Data\Resource
     */
    public function childResource(ResourceContract $resource)
    {
        $resource->setParentResource($this);

        return $resource;
    }

    /**
     * @param \Artesaos\Restinga\Contracts\Data\Resource $resource
     */
    public function setParentResource(ResourceContract $resource)
    {
        $this->parent = $resource;
    }

    /**
     * @return \Artesaos\Restinga\Contracts\Data\Resource
     */
    public function getParentResource()
    {
        return $this->parent;
    }

    /**
     * @return bool
     */
    public function hasParentResource()
    {
        return !empty($this->parent);
    }
}
