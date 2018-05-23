<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalServerError;
use App\Exceptions\InvalidRequestException;
use App\Exceptions\UnauthorizedException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Token;
use Lcobucci\JWT\Parser;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
	{

	    $this->setDataByToken();

	}

	protected function setDataByToken()
    {
        $request = app('request');
        $bearerToken=$request->bearerToken();

        if ($bearerToken) {
            $token = (new Parser())->parse($bearerToken);
            $tokenId= $token->getHeader('jti');
            $token = Token::find($tokenId);
            if (!$token) throw new UnauthorizedException('authenticate failed');
            $client = $token->client;

            \App::singleton('curato', function() use ($client, $token) {
                $curato = new \stdClass();
                $curato->client = $client;
                $curato->token = $token;
                return $curato;
            });
        }
    }

    /**
     *  {
     *      "code": 0,
     *      "data": {
     *          "list": []
     *      }
     *  }
     * @param array $data
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
	public function listResponse($data=[], $statusCode = 200, array $headers = []) {
		$data = [
		    'list' => $data,
        ];
        return $this->response($data, $statusCode, $headers);
	}

	public function pageResponse($data=[], $statusCode = 200, array $headers = []) {
	    if (!isset($data['meta'])) {
	        throw new InternalServerError('Unable to use pageResponse without a `meta` key for data');
        }
	    $meta = $data['meta'];
	    unset($data['meta']);

	    $resp = [
	        'list' => $data,
            'meta' => $meta,
        ];
	    return $this->response($resp, $statusCode, $headers);
    }

    /**
     *  {
     *      "code": 0,
     *      "data": {
     *
     *      }
     *  }
     * @param array $data
     * @param int $statusCode
     * @param array $headers
     * @return JsonResponse
     */
	public function objResponse($data=[], $statusCode = 200, array $headers = []) {
		if (empty($data)) {
		    $data = new \ArrayObject();
        }
		return $this->response($data, $statusCode, $headers);
	}

    /**
     *  {
     *      "code": 0
     *  }
     * @return JsonResponse
     */
	public function ok() {
        $return = [
            'code'=>0,
        ];
        return new JsonResponse($return);
    }

    /**
     *  {
     *      "code": 500
     *  }
     * @param int $code
     * @return JsonResponse
     */
    public function err($code=500) {
        $return = [
            'code'=>$code,
        ];
        return new JsonResponse($return);
    }

	private function response($data=[], $statusCode = 200, array $headers = []) {
        $return = [
            'code'=>0,
        ];

        $return['data'] = $data;

        if ($return instanceof Arrayable && !$return instanceof \JsonSerializable) {
            $return = $return->toArray();
        }

        return new JsonResponse($return, $statusCode, $headers);
    }

    protected function checkPermission($permissionCode)
    {
        $user = Auth::user();

        if ($user and $user->isSuperAdmin()) {
            return;
        }

        if (!$user or $user->cant($permissionCode)) {
            throw new UnauthorizedException('Permission denied.');
        }
    }


	public function validate(Request $request, array $rules,
							 array $messages = [], array $customAttributes = [])
	{
		$validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
		if ($validator->fails()) {
			throw new InvalidRequestException($validator->errors());
//			throw new InvalidRequestException('Bad Request');
//			throw new ResourceException('Bad Request', $validator->errors());
		}
	}
}
