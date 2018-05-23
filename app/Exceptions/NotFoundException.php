<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/11/15
 * Time: 下午9:30
 */

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundException extends NotFoundHttpException {
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct($message, $previous, $code);
    }
}