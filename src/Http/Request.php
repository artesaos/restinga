<?php

namespace Artesaos\Restinga\Http;

use Artesaos\Restinga\Contracts\Data\Resource;
use Artesaos\Restinga\Contracts\Http\Request as RequestContract;
use Unirest;

/**
 * Class Request.
 */
class Request implements RequestContract
{
    use ManipulateHeaders;

    /**
     * @var \Artesaos\Restinga\Contracts\Service\Descriptor
     */
    protected $descriptor;

    /**
     * @var \Artesaos\Restinga\Contracts\Data\Resource
     */
    protected $resource;

    /**
     * @var \Unirest\Request
     */
    protected $request;

    /**
     * @var bool
     */
    protected $identified = false;

    /**
     * @param \Artesaos\Restinga\Contracts\Data\Resource $resource
     * @param bool                                        $identified
     */
    public function __construct(Resource $resource, $identified = false)
    {
        $this->resource = $resource;
        $this->identified = $identified;
        $this->descriptor = $this->resource->getDescriptor();
        $this->request = new Unirest\Request();
        $this->request = $this->descriptor->authorization()->setupRequest($this->request);
        $this->request->defaultHeader('Content-Type', $this->resource->getContentTypeHeader());
        $this->request->defaultHeader('Accept', $this->resource->getAcceptHeader());
    }

    /**
     * @return string
     */
    public function url()
    {
        $url = $this->resource->getResourceName();
        if ($this->identified) {
            $identifier = $this->resource->getIdentifier();
            if ($identifier) {
                $url = $url.'/'.$identifier;
            }
        }

        if ($this->resource->hasParentResource()) {
            $current = $this->resource->getParentResource();
            while ($current) {
                $url = $current->getResourceName().'/'.$current->getIdentifier().'/'.$url;
                $current = $current->getParentResource();
            }
        }

        return $this->descriptor->prefix().'/'.$url;
    }

    /**
     * @return Unirest\Response
     */
    public function get()
    {
        return $this->send('get');
    }

    /**
     * @return Unirest\Response
     */
    public function post()
    {
        return $this->send('post', true);
    }

    /**
     * @return Unirest\Response
     */
    public function put()
    {
        return $this->send('put', true);
    }

    /**
     * @return Unirest\Response
     */
    public function delete()
    {
        return $this->send('delete');
    }

    /**
     * @param string $method
     * @param bool   $hasBody
     *
     * @return \Unirest\Response
     */
    protected function send($method = 'get', $hasBody = false)
    {
        if ($hasBody) {
            $response = $this->request->$method($this->url(), $this->headers, $this->resource->encode());
        } else {
            $response = $this->request->$method($this->url(), $this->headers);
        }

        return $response;
    }
}
