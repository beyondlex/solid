<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/11/15
 * Time: 下午9:16
 */
namespace App\Exceptions\Formatters;

use App\Http\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class InvalidRequestExceptionFormatter extends ExceptionFormatter {

    public function format(JsonResponse $response, Exception $e, array $reporterResponses)
    {
        $response->setStatusCode(200);

        $this->responseCode = ApiResponse::INVALID_REQUEST;


        // Laravel validation errors will return JSON string
        $decoded = json_decode($e->getMessage(), true);
        // Message was not valid JSON
        // This occurs when we throw UnprocessableEntityHttpExceptions
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Mimick the structure of Laravel validation errors
            $decoded = [[$e->getMessage()]];
        }

        // Laravel errors are formatted as {"field": [/*errors as strings*/]}
        $data = array_reduce($decoded, function ($carry, $item) use ($e) {
            return array_merge($carry, array_map(function ($current) use ($e) {
                return [
//                    'status' => '422',
//                    'code' => $e->getCode(),
                    'title' => 'Validation error',
                    'detail' => $current
                ];
            }, $item));
        }, []);


        $return = $response->getData(true);
        if ($this->debug) {
            $return = array_merge($return, [
                'code'   => $this->responseCode,
                'message'   => 'Invalid request.',
                'errors' => $data,
                'exception' => (string) $e,
                'line'   => $e->getLine(),
                'file'   => $e->getFile()
            ]);
        } else {
            $return['code'] = $e->getCode();
            $return['message'] = $this->config['server_error_production'];
            $return['errors'] = $data;
        }

        $response->setData($return);

        return $response;


    }
}