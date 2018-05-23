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

class InternalServerErrorFormatter extends ExceptionFormatter {
    public function format(JsonResponse $response, Exception $e, array $reporterResponses)
    {
        $this->responseCode = ApiResponse::INTERNAL_SERVER_ERROR;
        parent::format($response, $e, $reporterResponses);
    }
}