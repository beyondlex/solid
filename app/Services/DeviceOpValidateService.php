<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2018/2/8
 * Time: 14:25
 */
namespace App\Services;

use App\Exceptions\UnprocessableEntityHttpException;
use App\Extensions\Traits\ClientTrait;

class DeviceOpValidateService
{
	use ClientTrait;

	function validate($device) {
		if ($this->getClientId() != $device->client_id) {
			throw new UnprocessableEntityHttpException('无法操作该设备');
		}
	}

}