<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2018/2/8
 * Time: 14:04
 */

namespace App\Requests;


use App\Exceptions\InvalidRequestException;
use App\Exceptions\UnauthorizedException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ApiRequest extends FormRequest
{

	protected function failedValidation(Validator $validator)
	{
		//        throw new UnprocessableEntityHttpException($validator->errors()->toJson());
		throw new InvalidRequestException($validator->errors()->toJson());
	}

	protected function failedAuthorization()
	{
		throw new UnauthorizedException('Unauthorized.');
		//        throw new HttpException(403);
	}
}