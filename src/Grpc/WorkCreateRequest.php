<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: service.proto

namespace Autorus\CarService\Grpc;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>CarService.WorkCreateRequest</code>
 */
class WorkCreateRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string uuid = 1;</code>
     */
    private $uuid = '';
    /**
     * Generated from protobuf field <code>string title = 2;</code>
     */
    private $title = '';
    /**
     * Generated from protobuf field <code>string work_group = 3;</code>
     */
    private $work_group = '';
    /**
     * Generated from protobuf field <code>string time = 4;</code>
     */
    private $time = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $uuid
     *     @type string $title
     *     @type string $work_group
     *     @type string $time
     * }
     */
    public function __construct($data = NULL) {
        \Autorus\CarService\Grpc\GPBMetadata\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string uuid = 1;</code>
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
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

    /**
     * Generated from protobuf field <code>string title = 2;</code>
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Generated from protobuf field <code>string title = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setTitle($var)
    {
        GPBUtil::checkString($var, True);
        $this->title = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string work_group = 3;</code>
     * @return string
     */
    public function getWorkGroup()
    {
        return $this->work_group;
    }

    /**
     * Generated from protobuf field <code>string work_group = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setWorkGroup($var)
    {
        GPBUtil::checkString($var, True);
        $this->work_group = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string time = 4;</code>
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Generated from protobuf field <code>string time = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setTime($var)
    {
        GPBUtil::checkString($var, True);
        $this->time = $var;

        return $this;
    }

}

