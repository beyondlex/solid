<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/11/15
 * Time: 下午9:30
 */

namespace App\Exceptions;


use App\Http\ApiResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InternalServerError extends HttpException {

    public function __construct($message = null, \Exception $previous = null, array $headers = array(), $code = 0)
    {
        parent::__construct(ApiResponse::INTERNAL_SERVER_ERROR, $message, $previous, $headers, $code);
    }
}