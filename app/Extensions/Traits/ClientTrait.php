<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/19
 * Time: 下午9:34
 */
namespace App\Extensions\Traits;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

trait ClientTrait {

	public function getClientId() {
		static $clientId;
		if ($clientId) return $clientId;
		$curato = app('curato');
		if (!$curato->client) throw new UnauthorizedHttpException('unauthorized.');
		return $curato->client->id;
	}
}