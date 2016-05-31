<?php

namespace Artesaos\Restinga\Contracts\Data;

use Artesaos\Restinga\Contracts\Data\Resource as ResourceContract;

/**
 * interface ManipulateNestedResources.
 */
interface ManipulateNestedResources
{
    /**
     * @param \Artesaos\Restinga\Contracts\Data\Resource $resource
     *
     * @return \Artesaos\Restinga\Contracts\Data\Resource
     */
    public function childResource(ResourceContract $resource);

    /**
     * @param \Artesaos\Restinga\Contracts\Data\Resource $resource
     */
    public function setParentResource(ResourceContract $resource);

    /**
     * @return \Artesaos\Restinga\Contracts\Data\Resource
     */
    public function getParentResource();

    /**
     * @return bool
     */
    public function hasParentResource();
}
