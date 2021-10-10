<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Autorus\CarService\Grpc;

/**
 */
class CarServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Создание бренда
     * @param \Autorus\CarService\Grpc\CarBrandCreateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CarBrandCreate(\Autorus\CarService\Grpc\CarBrandCreateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/CarBrandCreate',
        $argument,
        ['\Autorus\CarService\Grpc\CarBrandCreateResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Чтение бренда
     * @param \Autorus\CarService\Grpc\CarBrandReadRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CarBrandRead(\Autorus\CarService\Grpc\CarBrandReadRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/CarBrandRead',
        $argument,
        ['\Autorus\CarService\Grpc\CarBrandReadResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Изменение бренда
     * @param \Autorus\CarService\Grpc\CarBrandUpdateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CarBrandUpdate(\Autorus\CarService\Grpc\CarBrandUpdateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/CarBrandUpdate',
        $argument,
        ['\Autorus\CarService\Grpc\CarBrandUpdateResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Удаление бренда
     * @param \Autorus\CarService\Grpc\CarBrandDeleteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CarBrandDelete(\Autorus\CarService\Grpc\CarBrandDeleteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/CarBrandDelete',
        $argument,
        ['\Autorus\CarService\Grpc\CarBrandDeleteResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Список брендов
     * @param \Autorus\CarService\Grpc\CarBrandListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CarBrandList(\Autorus\CarService\Grpc\CarBrandListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/CarBrandList',
        $argument,
        ['\Autorus\CarService\Grpc\CarBrandListResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Создание класса
     * @param \Autorus\CarService\Grpc\CarClassCreateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CarClassCreate(\Autorus\CarService\Grpc\CarClassCreateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/CarClassCreate',
        $argument,
        ['\Autorus\CarService\Grpc\CarClassCreateResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Чтение класса
     * @param \Autorus\CarService\Grpc\CarClassReadRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CarClassRead(\Autorus\CarService\Grpc\CarClassReadRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/CarClassRead',
        $argument,
        ['\Autorus\CarService\Grpc\CarClassReadResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Изменение класса
     * @param \Autorus\CarService\Grpc\CarClassUpdateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CarClassUpdate(\Autorus\CarService\Grpc\CarClassUpdateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/CarClassUpdate',
        $argument,
        ['\Autorus\CarService\Grpc\CarClassUpdateResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Удаление класса
     * @param \Autorus\CarService\Grpc\CarClassDeleteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CarClassDelete(\Autorus\CarService\Grpc\CarClassDeleteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/CarClassDelete',
        $argument,
        ['\Autorus\CarService\Grpc\CarClassDeleteResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Список классов
     * @param \Autorus\CarService\Grpc\CarClassListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CarClassList(\Autorus\CarService\Grpc\CarClassListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/CarClassList',
        $argument,
        ['\Autorus\CarService\Grpc\CarClassListResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Создание модели
     * @param \Autorus\CarService\Grpc\CarModelCreateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CarModelCreate(\Autorus\CarService\Grpc\CarModelCreateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/CarModelCreate',
        $argument,
        ['\Autorus\CarService\Grpc\CarModelCreateResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Чтение модели
     * @param \Autorus\CarService\Grpc\CarModelReadRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CarModelRead(\Autorus\CarService\Grpc\CarModelReadRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/CarModelRead',
        $argument,
        ['\Autorus\CarService\Grpc\CarModelReadResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Изменение модели
     * @param \Autorus\CarService\Grpc\CarModelUpdateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CarModelUpdate(\Autorus\CarService\Grpc\CarModelUpdateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/CarModelUpdate',
        $argument,
        ['\Autorus\CarService\Grpc\CarModelUpdateResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Удаление модели
     * @param \Autorus\CarService\Grpc\CarModelDeleteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CarModelDelete(\Autorus\CarService\Grpc\CarModelDeleteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/CarModelDelete',
        $argument,
        ['\Autorus\CarService\Grpc\CarModelDeleteResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Список моделей
     * @param \Autorus\CarService\Grpc\CarModelListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CarModelList(\Autorus\CarService\Grpc\CarModelListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/CarModelList',
        $argument,
        ['\Autorus\CarService\Grpc\CarModelListResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Создание работы
     * @param \Autorus\CarService\Grpc\WorkCreateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function WorkCreate(\Autorus\CarService\Grpc\WorkCreateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/WorkCreate',
        $argument,
        ['\Autorus\CarService\Grpc\WorkCreateResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Чтение работы
     * @param \Autorus\CarService\Grpc\WorkReadRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function WorkRead(\Autorus\CarService\Grpc\WorkReadRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/WorkRead',
        $argument,
        ['\Autorus\CarService\Grpc\WorkReadResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Изменение работы
     * @param \Autorus\CarService\Grpc\WorkUpdateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function WorkUpdate(\Autorus\CarService\Grpc\WorkUpdateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/WorkUpdate',
        $argument,
        ['\Autorus\CarService\Grpc\WorkUpdateResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Удаление работы
     * @param \Autorus\CarService\Grpc\WorkDeleteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function WorkDelete(\Autorus\CarService\Grpc\WorkDeleteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/WorkDelete',
        $argument,
        ['\Autorus\CarService\Grpc\WorkDeleteResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Список работ
     * @param \Autorus\CarService\Grpc\WorkListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function WorkList(\Autorus\CarService\Grpc\WorkListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/WorkList',
        $argument,
        ['\Autorus\CarService\Grpc\WorkListResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Создание группы
     * @param \Autorus\CarService\Grpc\WorkGroupCreateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function WorkGroupCreate(\Autorus\CarService\Grpc\WorkGroupCreateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/WorkGroupCreate',
        $argument,
        ['\Autorus\CarService\Grpc\WorkGroupCreateResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Чтение группы
     * @param \Autorus\CarService\Grpc\WorkGroupReadRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function WorkGroupRead(\Autorus\CarService\Grpc\WorkGroupReadRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/WorkGroupRead',
        $argument,
        ['\Autorus\CarService\Grpc\WorkGroupReadResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Изменение группы
     * @param \Autorus\CarService\Grpc\WorkGroupUpdateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function WorkGroupUpdate(\Autorus\CarService\Grpc\WorkGroupUpdateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/WorkGroupUpdate',
        $argument,
        ['\Autorus\CarService\Grpc\WorkGroupUpdateResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Удаление группы
     * @param \Autorus\CarService\Grpc\WorkGroupDeleteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function WorkGroupDelete(\Autorus\CarService\Grpc\WorkGroupDeleteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/WorkGroupDelete',
        $argument,
        ['\Autorus\CarService\Grpc\WorkGroupDeleteResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Список групп
     * @param \Autorus\CarService\Grpc\WorkGroupListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function WorkGroupList(\Autorus\CarService\Grpc\WorkGroupListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/CarService.CarService/WorkGroupList',
        $argument,
        ['\Autorus\CarService\Grpc\WorkGroupListResponse', 'decode'],
        $metadata, $options);
    }

}
