<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: service.proto

namespace Autorus\CarService\Grpc\WorkGroupListResponse;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>CarService.WorkGroupListResponse.Data</code>
 */
class Data extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>repeated .CarService.WorkGroupListResponse.WorkGroupItem items = 1;</code>
     */
    private $items;
    /**
     * Generated from protobuf field <code>int32 total_count = 2;</code>
     */
    private $total_count = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Autorus\CarService\Grpc\WorkGroupListResponse\WorkGroupItem[]|\Google\Protobuf\Internal\RepeatedField $items
     *     @type int $total_count
     * }
     */
    public function __construct($data = NULL) {
        \Autorus\CarService\Grpc\GPBMetadata\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>repeated .CarService.WorkGroupListResponse.WorkGroupItem items = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Generated from protobuf field <code>repeated .CarService.WorkGroupListResponse.WorkGroupItem items = 1;</code>
     * @param \Autorus\CarService\Grpc\WorkGroupListResponse\WorkGroupItem[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setItems($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Autorus\CarService\Grpc\WorkGroupListResponse\WorkGroupItem::class);
        $this->items = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 total_count = 2;</code>
     * @return int
     */
    public function getTotalCount()
    {
        return $this->total_count;
    }

    /**
     * Generated from protobuf field <code>int32 total_count = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setTotalCount($var)
    {
        GPBUtil::checkInt32($var);
        $this->total_count = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Data::class, \Autorus\CarService\Grpc\WorkGroupListResponse_Data::class);

