<?php

namespace Artesaos\Restinga\Http\Format\Receive;

/**
 * Trait ReceiveJson.
 */
trait ReceiveJson
{
    /**
     * @param string $data
     *
     * @return array
     */
    public function factoryCollection($data)
    {
        $resources_data = json_decode($data, true);
        if ($this->collection_root) {
            $resources_data = $resources_data[$this->collection_root];
        }
        $resources = [];
        foreach ($resources_data as $resource_data) {
            $resource = new $this();
            $resource->_receive_json_fill($resource_data);
            $resources[] = $resource;
        }

        return $resources;
    }

    /**
     * @param string $data
     */
    public function factory($data)
    {
        $resource_data = json_decode($data, true);
        if ($this->item_root) {
            $resource_data = $resource_data[$this->item_root];
        }
        $this->_receive_json_fill($resource_data);
    }

    /**
     * @param array $data
     */
    protected function _receive_json_fill($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $this->attributes[$key] = $value;
            }
        }
    }

    /**
     * @return string
     */
    public function getAcceptHeader()
    {
        return 'application/json';
    }
}
