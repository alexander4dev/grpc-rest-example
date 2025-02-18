<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: service.proto

namespace Autorus\CarService\Grpc;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>CarService.CarModelDeleteRequest</code>
 */
class CarModelDeleteRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * UUID модели
     *
     * Generated from protobuf field <code>string uuid = 1;</code>
     */
    private $uuid = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $uuid
     *           UUID модели
     * }
     */
    public function __construct($data = NULL) {
        \Autorus\CarService\Grpc\GPBMetadata\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * UUID модели
     *
     * Generated from protobuf field <code>string uuid = 1;</code>
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * UUID модели
     *
     * Generated from protobuf field <code>string uuid = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setUuid($var)
    {
        GPBUtil::checkString($var, True);
        $this->uuid = $var;

        return $this;
    }

}

