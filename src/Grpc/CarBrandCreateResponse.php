<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: service.proto

namespace Autorus\CarService\Grpc;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>CarService.CarBrandCreateResponse</code>
 */
class CarBrandCreateResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string status = 1;</code>
     */
    private $status = '';
    /**
     * Generated from protobuf field <code>repeated .google.protobuf.Empty data = 2;</code>
     */
    private $data;
    /**
     * Generated from protobuf field <code>repeated .CarService.Violation violations = 3;</code>
     */
    private $violations;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $status
     *     @type \Google\Protobuf\GPBEmpty[]|\Google\Protobuf\Internal\RepeatedField $data
     *     @type \Autorus\CarService\Grpc\Violation[]|\Google\Protobuf\Internal\RepeatedField $violations
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
     * Generated from protobuf field <code>repeated .google.protobuf.Empty data = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Generated from protobuf field <code>repeated .google.protobuf.Empty data = 2;</code>
     * @param \Google\Protobuf\GPBEmpty[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setData($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Protobuf\GPBEmpty::class);
        $this->data = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .CarService.Violation violations = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getViolations()
    {
        return $this->violations;
    }

    /**
     * Generated from protobuf field <code>repeated .CarService.Violation violations = 3;</code>
     * @param \Autorus\CarService\Grpc\Violation[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setViolations($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Autorus\CarService\Grpc\Violation::class);
        $this->violations = $arr;

        return $this;
    }

}

