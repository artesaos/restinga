<?php

namespace Artesaos\Restinga\Data;

use Artesaos\Restinga\Container;
use Artesaos\Restinga\Contracts\Data\Resource as ResourceContract;
use Artesaos\Restinga\Http\Request;

/**
 * Class Resource.
 */
abstract class Resource implements ResourceContract
{
    use ManipulateAttributes;
    use ManipulateNestedResources;
    use ManipulateResponses;

    /**
     * @var \Artesaos\Restinga\Contracts\Service\Descriptor
     */
    protected $descriptor;

    /**
     * @var string
     */
    protected $service = '';

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var \Artesaos\Restinga\Contracts\Http\Request
     */
    protected $request;

    /**
     * @var \Unirest\Response
     */
    protected $response;

    public function __construct()
    {
        $this->descriptor = Container::get($this->service);
    }

    /**
     * @return \Artesaos\Restinga\Contracts\Service\Descriptor|null
     */
    public function getDescriptor()
    {
        return $this->descriptor;
    }

    /**
     * @return string
     */
    public function getResourceName()
    {
        return $this->name;
    }

    /**
     * @return \Artesaos\Restinga\Contracts\Http\Request
     */
    public function request()
    {
        return $this->request ?: new Request($this);
    }

    /**
     * @return \Unirest\Response
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * @return array|bool
     */
    public function all()
    {
        if ($this->makeRequest('get')) {
            $resources = $this->factoryCollection($this->response->raw_body);
            $configuredResources = [];
            if ($this->hasParentResource()) {
                foreach ($resources as $resource) {
                    $resource->setParentResource($this->getParentResource());
                    $configuredResources[] = $resource;
                }
            } else {
                $configuredResources = $resources;
            }

            return $configuredResources;
        }

        return false;
    }

    /**
     * @param string $identifier
     *
     * @return $this|bool
     */
    public function find($identifier = '')
    {
        $this->setIdentifier($identifier);
        if ($this->makeRequest('get', true)) {
            $this->factory($this->response->raw_body);

            return $this;
        }

        return false;
    }

    /**
     * @return $this|bool
     */
    public function save()
    {
        if ($this->makeRequest('post')) {
            $this->factory($this->response->raw_body);

            return $this;
        }

        return false;
    }

    /**
     * @return $this|bool
     */
    public function update()
    {
        if ($this->makeRequest('put', true)) {
            $this->factory($this->response->raw_body);

            return $this;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function destroy()
    {
        return $this->makeRequest('delete', true);
    }

    /**
     * @param string $method
     * @param bool   $identified
     *
     * @return bool
     */
    protected function makeRequest($method, $identified = false)
    {
        $this->request = new Request($this, $identified);
        $this->response = $this->request->$method();

        return $this->checkResponse();
    }
}
