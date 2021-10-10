<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: service.proto

namespace Autorus\CarService\Grpc;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>CarService.WorkGroupReadResponse</code>
 */
class WorkGroupReadResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string status = 1;</code>
     */
    private $status = '';
    /**
     * Generated from protobuf field <code>.CarService.WorkGroupReadResponse.Data data = 2;</code>
     */
    private $data = null;
    /**
     * Generated from protobuf field <code>string message = 3;</code>
     */
    private $message = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $status
     *     @type \Autorus\CarService\Grpc\WorkGroupReadResponse\Data $data
     *     @type string $message
     * }
     */
    public function __construct($data = NULL) {
        \Autorus\CarService\Grpc\GPBMetadata\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string status = 1;</code>
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Generated from protobuf field <code>string status = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkString($var, True);
        $this->status = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.CarService.WorkGroupReadResponse.Data data = 2;</code>
     * @return \Autorus\CarService\Grpc\WorkGroupReadResponse\Data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Generated from protobuf field <code>.CarService.WorkGroupReadResponse.Data data = 2;</code>
     * @param \Autorus\CarService\Grpc\WorkGroupReadResponse\Data $var
     * @return $this
     */
    public function setData($var)
    {
        GPBUtil::checkMessage($var, \Autorus\CarService\Grpc\WorkGroupReadResponse_Data::class);
        $this->data = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string message = 3;</code>
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Generated from protobuf field <code>string message = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setMessage($var)
    {
        GPBUtil::checkString($var, True);
        $this->message = $var;

        return $this;
    }

}

