<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/11/15
 * Time: 下午9:02
 */

namespace App\Http;

class ApiResponse {
    const INVALID_REQUEST = 400;        //非法请求。如：缺少字段
    const UNAUTHENTICATED = 401;      	//未授权。（身份认证未通过）
    const UNAUTHORIZED = 403;      		//禁止访问。（身份认证通过，但该操作被禁止）
    const NOT_FOUND = 404;              //资源不存在。如：用户不存在
    const UNPROCESSABLE = 422;          //无法处理请求。如：用户名已存在，无法创建
    const INTERNAL_SERVER_ERROR = 500;  //内部错误
    const PDO_EXCEPTION = 530;          //内部错误 -- PDO异常
}