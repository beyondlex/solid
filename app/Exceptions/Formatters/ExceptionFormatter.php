<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/11/15
 * Time: 下午9:07
 */
namespace App\Exceptions\Formatters;

use Exception;
use Illuminate\Http\JsonResponse;
use Optimus\Heimdal\Formatters\ExceptionFormatter as BaseExceptionFormatter;

class ExceptionFormatter extends BaseExceptionFormatter {

    protected $responseCode = 0;

    public function format(JsonResponse $response, Exception $e, array $reporterResponses)
    {
        $response->setStatusCode(200);
        $data = $response->getData(true);

        if ($this->debug) {
            $data = array_merge($data, [
                'code'   => $this->responseCode ? : ($e->getCode() ? : 500),
                'message'   => $e->getMessage(),
				'file'   => $e->getFile(),
				'line'   => $e->getLine(),
				'exception' => (string) $e,
            ]);
        } else {
            $data['code'] = $this->responseCode;
            $data['message'] = $e->getMessage();
            //$data['message'] = $this->config['server_error_production'];
        }

        $response->setData($data);
    }
}