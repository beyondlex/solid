<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/15
 * Time: 下午1:54
 */
namespace App\Services;


use App\Criterias\ClientCriteria;
use App\Exceptions\InternalServerError;
use App\Extensions\Traits\ClientTrait;
use App\Repositories\DeviceRepository;

class DeviceService {

	use ClientTrait;

    protected $repository;
    protected $validator;

    public function __construct(DeviceRepository $repository, DeviceOpValidateService $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    function all() {
    	$clientId = $this->getClientId();
    	return $this->repository->pushCriteria(new ClientCriteria($clientId))->all();
	}

    function find($id) {
        return $this->repository->pushCriteria(new ClientCriteria($this->getClientId()))->find($id);
    }

    function paginate($perPage) {
    	$perPage = $perPage ?? 5;
    	$clientId = $this->getClientId();
		$data = $this->repository->pushCriteria(new ClientCriteria($clientId))->paginate($perPage);
		return $data;
	}

    function create($data) {

    }


	function delete($id) {

	}

    protected function getVendorClassByCode($vendorCode)
    {
        $class = config("application.devices.locks.{$vendorCode}.api_class");

        if (!class_exists($class)) {
            throw new InternalServerError('Class Not found:'. $class);
        }

        return app($class);
	}


}