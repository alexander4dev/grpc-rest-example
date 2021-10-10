<?php

declare(strict_types=1);

namespace Autorus\CarService\Domain;

use Autorus\CarService\Exception\ServiceException;
use Autorus\CarService\Exception\ServiceViolationsException;
use Autorus\CarService\Grpc\{
    CarBrandCreateRequest,
    CarBrandCreateResponse,
    CarBrandDeleteRequest,
    CarBrandDeleteResponse,
    CarBrandListRequest,
    CarBrandListResponse,
    CarBrandListResponse\CarBrandItem,
    CarBrandListResponse\Data as CarBrandListResponseData,
    CarBrandReadRequest,
    CarBrandReadResponse,
    CarBrandReadResponse\Data as CarBrandReadResponseData,
    CarBrandUpdateRequest,
    CarBrandUpdateResponse,
    CarClassCreateRequest,
    CarClassCreateResponse,
    CarClassDeleteRequest,
    CarClassDeleteResponse,
    CarClassListRequest,
    CarClassListResponse,
    CarClassListResponse\CarClassItem,
    CarClassListResponse\Data as CarClassListResponseData,
    CarClassReadRequest,
    CarClassReadResponse,
    CarClassReadResponse\Data as CarClassReadResponseData,
    CarClassUpdateRequest,
    CarClassUpdateResponse,
    CarModelCreateRequest,
    CarModelCreateResponse,
    CarModelDeleteRequest,
    CarModelDeleteResponse,
    CarModelListRequest,
    CarModelListResponse,
    CarModelListResponse\CarModelItem,
    CarModelListResponse\Data as CarModelListResponseData,
    CarModelReadRequest,
    CarModelReadResponse,
    CarModelReadResponse\Data as CarModelReadResponseData,
    CarModelUpdateRequest,
    CarModelUpdateResponse,
    CarServiceInterface,
    Violation,
    WorkCreateRequest,
    WorkCreateResponse,
    WorkDeleteRequest,
    WorkDeleteResponse,
    WorkListRequest,
    WorkListResponse,
    WorkListResponse\WorkItem,
    WorkListResponse\Data as WorkListResponseData,
    WorkReadRequest,
    WorkReadResponse,
    WorkReadResponse\Data as WorkReadResponseData,
    WorkUpdateRequest,
    WorkUpdateResponse,
    WorkGroupCreateRequest,
    WorkGroupCreateResponse,
    WorkGroupDeleteRequest,
    WorkGroupDeleteResponse,
    WorkGroupListRequest,
    WorkGroupListResponse,
    WorkGroupListResponse\WorkGroupItem,
    WorkGroupListResponse\Data as WorkGroupListResponseData,
    WorkGroupReadRequest,
    WorkGroupReadResponse,
    WorkGroupReadResponse\Data as WorkGroupReadResponseData,
    WorkGroupUpdateRequest,
    WorkGroupUpdateResponse,
};
use Autorus\CarService\Traits\Container\ContainerInjectableTrait;
use Autorus\CarService\Traits\Container\ServiceAwareTrait;
use Spiral\GRPC\ContextInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

use function array_map;
use function iterator_to_array;

class CarService implements CarServiceInterface
{
    use ContainerInjectableTrait;

    use ServiceAwareTrait;

    private const RESPONSE_STATUS_OK = 'ok';
    private const RESPONSE_STATUS_ERROR = 'error';
    private const RESPONSE_STATUS_VIOLATIONS = 'violations';

    private const LIST_METHOD_DEFAULT_PAGE = 1;
    private const LIST_METHOD_DEFAULT_LIMIT = 50;

    /**
     * {@inheritdoc}
     */
    public function CarBrandCreate(ContextInterface $ctx, CarBrandCreateRequest $in): CarBrandCreateResponse
    {
        try {
            $this->getCarBrandService()->create($in->getUuid(), $in->getTitle());
        } catch (ServiceViolationsException $e) {
            return new CarBrandCreateResponse([
                'status' => self::RESPONSE_STATUS_VIOLATIONS,
                'violations' => array_map(function (ConstraintViolationInterface $violation) {
                    return new Violation([
                        'message' => $violation->getMessage(),
                        'property' => $violation->getPropertyPath(),
                    ]);
                }, iterator_to_array($e->getViolations())),
            ]);
        }

        return new CarBrandCreateResponse([
            'status' => self::RESPONSE_STATUS_OK,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function CarBrandRead(ContextInterface $ctx, CarBrandReadRequest $in): CarBrandReadResponse
    {
        try {
            $carBrand = $this->getCarBrandService()->read($in->getUuid());
        } catch (ServiceException $e) {
            return new CarBrandReadResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new CarBrandReadResponse([
            'status' => self::RESPONSE_STATUS_OK,
            'data' => new CarBrandReadResponseData($carBrand),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function CarBrandUpdate(ContextInterface $ctx, CarBrandUpdateRequest $in): CarBrandUpdateResponse
    {
        try {
            $this->getCarBrandService()->update($in->getUuid(), $in->getTitle());
        } catch (ServiceViolationsException $e) {
            return new CarBrandUpdateResponse([
                'status' => self::RESPONSE_STATUS_VIOLATIONS,
                'violations' => array_map(function (ConstraintViolationInterface $violation) {
                    return new Violation([
                        'message' => $violation->getMessage(),
                        'property' => $violation->getPropertyPath(),
                    ]);
                }, iterator_to_array($e->getViolations())),
            ]);
        } catch (ServiceException $e) {
            return new CarBrandUpdateResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new CarBrandUpdateResponse([
            'status' => self::RESPONSE_STATUS_OK,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function CarBrandDelete(ContextInterface $ctx, CarBrandDeleteRequest $in): CarBrandDeleteResponse
    {
        try {
            $this->getCarBrandService()->delete($in->getUuid());
        } catch (ServiceException $e) {
            return new CarBrandDeleteResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new CarBrandDeleteResponse([
            'status' => self::RESPONSE_STATUS_OK,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function CarBrandList(ContextInterface $ctx, CarBrandListRequest $in): CarBrandListResponse
    {
        $page = 0 !== $in->getPage() ? $in->getPage() : self::LIST_METHOD_DEFAULT_PAGE;
        $limit = 0 !== $in->getLimit() ? $in->getLimit() : self::LIST_METHOD_DEFAULT_LIMIT;

        $carBrandList = $this->getCarBrandService()->getList($page, $limit);

        return new CarBrandListResponse([
            'status' => self::RESPONSE_STATUS_OK,
            'data' => new CarBrandListResponseData([
                'items' => array_map(function (array $item) { return new CarBrandItem($item); }, $carBrandList['items']),
                'total_count' => $carBrandList['totalCount'],
            ]),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function CarClassCreate(ContextInterface $ctx, CarClassCreateRequest $in): CarClassCreateResponse
    {
        try {
            $this->getCarClassService()->create($in->getUuid(), $in->getTitle(), $in->getHourCost());
        } catch (ServiceViolationsException $e) {
            return new CarClassCreateResponse([
                'status' => self::RESPONSE_STATUS_VIOLATIONS,
                'violations' => array_map(function (ConstraintViolationInterface $violation) {
                    return new Violation([
                        'message' => $violation->getMessage(),
                        'property' => $violation->getPropertyPath(),
                    ]);
                }, iterator_to_array($e->getViolations())),
            ]);
        }

        return new CarClassCreateResponse([
            'status' => self::RESPONSE_STATUS_OK,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function CarClassRead(ContextInterface $ctx, CarClassReadRequest $in): CarClassReadResponse
    {
        try {
            $carClass = $this->getCarClassService()->read($in->getUuid());
        } catch (ServiceException $e) {
            return new CarClassReadResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new CarClassReadResponse([
            'status' => self::RESPONSE_STATUS_OK,
            'data' => new CarClassReadResponseData($carClass),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function CarClassUpdate(ContextInterface $ctx, CarClassUpdateRequest $in): CarClassUpdateResponse
    {
        try {
            $this->getCarClassService()->update($in->getUuid(), $in->getTitle(), $in->getHourCost());
        } catch (ServiceViolationsException $e) {
            return new CarClassUpdateResponse([
                'status' => self::RESPONSE_STATUS_VIOLATIONS,
                'violations' => array_map(function (ConstraintViolationInterface $violation) {
                    return new Violation([
                        'message' => $violation->getMessage(),
                        'property' => $violation->getPropertyPath(),
                    ]);
                }, iterator_to_array($e->getViolations())),
            ]);
        } catch (ServiceException $e) {
            return new CarClassUpdateResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new CarClassUpdateResponse([
            'status' => self::RESPONSE_STATUS_OK,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function CarClassDelete(ContextInterface $ctx, CarClassDeleteRequest $in): CarClassDeleteResponse
    {
        try {
            $this->getCarClassService()->delete($in->getUuid());
        } catch (ServiceException $e) {
            return new CarClassDeleteResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new CarClassDeleteResponse([
            'status' => self::RESPONSE_STATUS_OK,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function CarClassList(ContextInterface $ctx, CarClassListRequest $in): CarClassListResponse
    {
        $page = 0 !== $in->getPage() ? $in->getPage() : self::LIST_METHOD_DEFAULT_PAGE;
        $limit = 0 !== $in->getLimit() ? $in->getLimit() : self::LIST_METHOD_DEFAULT_LIMIT;

        $carClassList = $this->getCarClassService()->getList($page, $limit);

        return new CarClassListResponse([
            'status' => self::RESPONSE_STATUS_OK,
            'data' => new CarClassListResponseData([
                'items' => array_map(function (array $item) { return new CarClassItem($item); }, $carClassList['items']),
                'total_count' => $carClassList['totalCount'],
            ]),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function CarModelCreate(ContextInterface $ctx, CarModelCreateRequest $in): CarModelCreateResponse
    {
        try {
            $this->getCarModelService()->create($in->getUuid(), $in->getTitle(), $in->getCarBrand(), $in->getCarClass());
        } catch (ServiceViolationsException $e) {
            return new CarModelCreateResponse([
                'status' => self::RESPONSE_STATUS_VIOLATIONS,
                'violations' => array_map(function (ConstraintViolationInterface $violation) {
                    return new Violation([
                        'message' => $violation->getMessage(),
                        'property' => $violation->getPropertyPath(),
                    ]);
                }, iterator_to_array($e->getViolations())),
            ]);
        } catch (ServiceException $e) {
            return new CarModelCreateResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new CarModelCreateResponse([
            'status' => self::RESPONSE_STATUS_OK,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function CarModelRead(ContextInterface $ctx, CarModelReadRequest $in): CarModelReadResponse
    {
        try {
            $carModel = $this->getCarModelService()->read($in->getUuid());
        } catch (ServiceException $e) {
            return new CarModelReadResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new CarModelReadResponse([
            'status' => self::RESPONSE_STATUS_OK,
            'data' => new CarModelReadResponseData($carModel),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function CarModelUpdate(ContextInterface $ctx, CarModelUpdateRequest $in): CarModelUpdateResponse
    {
        try {
            $this->getCarModelService()->update($in->getUuid(), $in->getTitle(), $in->getCarBrand(), $in->getCarClass());
        } catch (ServiceViolationsException $e) {
            return new CarModelUpdateResponse([
                'status' => self::RESPONSE_STATUS_VIOLATIONS,
                'violations' => array_map(function (ConstraintViolationInterface $violation) {
                    return new Violation([
                        'message' => $violation->getMessage(),
                        'property' => $violation->getPropertyPath(),
                    ]);
                }, iterator_to_array($e->getViolations())),
            ]);
        } catch (ServiceException $e) {
            return new CarModelUpdateResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new CarModelUpdateResponse([
            'status' => self::RESPONSE_STATUS_OK,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function CarModelDelete(ContextInterface $ctx, CarModelDeleteRequest $in): CarModelDeleteResponse
    {
        try {
            $this->getCarModelService()->delete($in->getUuid());
        } catch (ServiceException $e) {
            return new CarModelDeleteResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new CarModelDeleteResponse([
            'status' => self::RESPONSE_STATUS_OK,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function CarModelList(ContextInterface $ctx, CarModelListRequest $in): CarModelListResponse
    {
        $page = 0 !== $in->getPage() ? $in->getPage() : self::LIST_METHOD_DEFAULT_PAGE;
        $limit = 0 !== $in->getLimit() ? $in->getLimit() : self::LIST_METHOD_DEFAULT_LIMIT;

        $carModelList = $this->getCarModelService()->getList($page, $limit);

        return new CarModelListResponse([
            'status' => self::RESPONSE_STATUS_OK,
            'data' => new CarModelListResponseData([
                'items' => array_map(function (array $item) { return new CarModelItem($item); }, $carModelList['items']),
                'total_count' => $carModelList['totalCount'],
            ]),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function WorkCreate(ContextInterface $ctx, WorkCreateRequest $in): WorkCreateResponse
    {
        try {
            $this->getWorkService()->create($in->getUuid(), $in->getTitle(), $in->getWorkGroup(), $in->getTime());
        } catch (ServiceViolationsException $e) {
            return new WorkCreateResponse([
                'status' => self::RESPONSE_STATUS_VIOLATIONS,
                'violations' => array_map(function (ConstraintViolationInterface $violation) {
                    return new Violation([
                        'message' => $violation->getMessage(),
                        'property' => $violation->getPropertyPath(),
                    ]);
                }, iterator_to_array($e->getViolations())),
            ]);
        } catch (ServiceException $e) {
            return new WorkCreateResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new WorkCreateResponse([
            'status' => self::RESPONSE_STATUS_OK,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function WorkRead(ContextInterface $ctx, WorkReadRequest $in): WorkReadResponse
    {
        try {
            $work = $this->getWorkService()->read($in->getUuid());
        } catch (ServiceException $e) {
            return new WorkReadResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new WorkReadResponse([
            'status' => self::RESPONSE_STATUS_OK,
            'data' => new WorkReadResponseData($work),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function WorkUpdate(ContextInterface $ctx, WorkUpdateRequest $in): WorkUpdateResponse
    {
        try {
            $this->getWorkService()->update($in->getUuid(), $in->getTitle(), $in->getWorkGroup(), $in->getTime());
        } catch (ServiceViolationsException $e) {
            return new WorkUpdateResponse([
                'status' => self::RESPONSE_STATUS_VIOLATIONS,
                'violations' => array_map(function (ConstraintViolationInterface $violation) {
                    return new Violation([
                        'message' => $violation->getMessage(),
                        'property' => $violation->getPropertyPath(),
                    ]);
                }, iterator_to_array($e->getViolations())),
            ]);
        } catch (ServiceException $e) {
            return new WorkUpdateResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new WorkUpdateResponse([
            'status' => self::RESPONSE_STATUS_OK,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function WorkDelete(ContextInterface $ctx, WorkDeleteRequest $in): WorkDeleteResponse
    {
        try {
            $this->getWorkService()->delete($in->getUuid());
        } catch (ServiceException $e) {
            return new WorkDeleteResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new WorkDeleteResponse([
            'status' => self::RESPONSE_STATUS_OK,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function WorkList(ContextInterface $ctx, WorkListRequest $in): WorkListResponse
    {
        $page = 0 !== $in->getPage() ? $in->getPage() : self::LIST_METHOD_DEFAULT_PAGE;
        $limit = 0 !== $in->getLimit() ? $in->getLimit() : self::LIST_METHOD_DEFAULT_LIMIT;

        $workList = $this->getWorkService()->getList($page, $limit);

        return new WorkListResponse([
            'status' => self::RESPONSE_STATUS_OK,
            'data' => new WorkListResponseData([
                'items' => array_map(function (array $item) { return new WorkItem($item); }, $workList['items']),
                'total_count' => $workList['totalCount'],
            ]),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function WorkGroupCreate(ContextInterface $ctx, WorkGroupCreateRequest $in): WorkGroupCreateResponse
    {
        try {
            $this->getWorkGroupService()->create($in->getUuid(), $in->getTitle(), $in->getParentWorkGroup());
        } catch (ServiceViolationsException $e) {
            return new WorkGroupCreateResponse([
                'status' => self::RESPONSE_STATUS_VIOLATIONS,
                'violations' => array_map(function (ConstraintViolationInterface $violation) {
                    return new Violation([
                        'message' => $violation->getMessage(),
                        'property' => $violation->getPropertyPath(),
                    ]);
                }, iterator_to_array($e->getViolations())),
            ]);
        } catch (ServiceException $e) {
            return new WorkGroupCreateResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new WorkGroupCreateResponse([
            'status' => self::RESPONSE_STATUS_OK,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function WorkGroupRead(ContextInterface $ctx, WorkGroupReadRequest $in): WorkGroupReadResponse
    {
        try {
            $workGroup = $this->getWorkGroupService()->read($in->getUuid());
        } catch (ServiceException $e) {
            return new WorkGroupReadResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new WorkGroupReadResponse([
            'status' => self::RESPONSE_STATUS_OK,
            'data' => new WorkGroupReadResponseData($workGroup),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function WorkGroupUpdate(ContextInterface $ctx, WorkGroupUpdateRequest $in): WorkGroupUpdateResponse
    {
        try {
            $this->getWorkGroupService()->update($in->getUuid(), $in->getTitle(), $in->getParentWorkGroup());
        } catch (ServiceViolationsException $e) {
            return new WorkGroupUpdateResponse([
                'status' => self::RESPONSE_STATUS_VIOLATIONS,
                'violations' => array_map(function (ConstraintViolationInterface $violation) {
                    return new Violation([
                        'message' => $violation->getMessage(),
                        'property' => $violation->getPropertyPath(),
                    ]);
                }, iterator_to_array($e->getViolations())),
            ]);
        } catch (ServiceException $e) {
            return new WorkGroupUpdateResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new WorkGroupUpdateResponse([
            'status' => self::RESPONSE_STATUS_OK,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function WorkGroupDelete(ContextInterface $ctx, WorkGroupDeleteRequest $in): WorkGroupDeleteResponse
    {
        try {
            $this->getWorkGroupService()->delete($in->getUuid());
        } catch (ServiceException $e) {
            return new WorkGroupDeleteResponse([
                'status' => self::RESPONSE_STATUS_ERROR,
                'message' => $e->getMessage(),
            ]);
        }

        return new WorkGroupDeleteResponse([
            'status' => self::RESPONSE_STATUS_OK,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function WorkGroupList(ContextInterface $ctx, WorkGroupListRequest $in): WorkGroupListResponse
    {
        $page = 0 !== $in->getPage() ? $in->getPage() : self::LIST_METHOD_DEFAULT_PAGE;
        $limit = 0 !== $in->getLimit() ? $in->getLimit() : self::LIST_METHOD_DEFAULT_LIMIT;

        $workGroupList = $this->getWorkGroupService()->getList($page, $limit);

        return new WorkGroupListResponse([
            'status' => self::RESPONSE_STATUS_OK,
            'data' => new WorkGroupListResponseData([
                'items' => array_map(function (array $item) { return new WorkGroupItem($item); }, $workGroupList['items']),
                'total_count' => $workGroupList['totalCount'],
            ]),
        ]);
    }
}
