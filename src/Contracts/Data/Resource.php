<?php

namespace Artesaos\Restinga\Contracts\Data;

use Artesaos\Restinga\Contracts\Service\Descriptor;

/**
 * Interface Resource.
 */
interface Resource extends ManipulateAttributes,
                           ManipulateNestedResources,
                           ManipulateResponses,
                           ReceiveAndSendData
{
    /**
     * @return Descriptor
     */
    public function getDescriptor();

    /**
     * @return string
     */
    public function getResourceName();

    /**
     * @return array
     */
    public static function all();

    /**
     * @return array
     */
    public function getAll();

    /**
     * @param string $identifier
     *
     * @return resource
     */
    public function doFind($identifier);

    /**
     * @param string $identifier
     *
     * @return resource
     */
    public static function find($identifier);

    /**
     * @return bool
     */
    public function destroy();

    /**
     * @return \Artesaos\Restinga\Contracts\Http\Request
     */
    public function request();

    /**
     * @return \Unirest\Response
     */
    public function response();

    /**
     * @return $this|bool
     */
    public function save();

    /**
     * @return $this|bool
     */
    public function update();

    /**
     * @return array
     */
    public function toArray();
}
