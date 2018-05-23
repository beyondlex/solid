<?php

use Symfony\Component\HttpKernel\Exception as SymfonyException;
use Optimus\Heimdal\Formatters;

use App\Exceptions as BaseException;
use App\Exceptions\Formatters as BaseFormatters;

return [
    'add_cors_headers' => false,

    // Has to be in prioritized order, e.g. highest priority first.
	'formatters' => [
		//        SymfonyException\UnprocessableEntityHttpException::class => Formatters\UnprocessableEntityHttpExceptionFormatter::class,

		BaseException\UnprocessableEntityHttpException::class => BaseFormatters\UnprocessableEntityHttpExceptionFormatter::class,
		BaseException\NotFoundException::class => BaseFormatters\NotFoundExceptionFormatter::class,
		BaseException\UnauthorizedException::class => BaseFormatters\UnauthorizedExceptionFormatter::class,
		BaseException\UnauthenticatedException::class => BaseFormatters\UnauthenticatedExceptionFormatter::class,
		\Illuminate\Auth\AuthenticationException::class => BaseFormatters\UnauthenticatedExceptionFormatter::class,//系统默认未认证异常
		SymfonyException\UnauthorizedHttpException::class => BaseFormatters\UnauthenticatedExceptionFormatter::class,
		BaseException\InvalidRequestException::class => BaseFormatters\InvalidRequestExceptionFormatter::class,
		BaseException\InternalServerError::class => BaseFormatters\InternalServerErrorFormatter::class,

		\Illuminate\Database\Eloquent\ModelNotFoundException::class => BaseFormatters\NotFoundExceptionFormatter::class,
        SymfonyException\NotFoundHttpException::class => BaseFormatters\NotFoundExceptionFormatter::class,
		PDOException::class => BaseFormatters\PDOExceptionFormatter::class,
		\Illuminate\Validation\ValidationException::class => BaseFormatters\InvalidRequestExceptionFormatter::class,

		\Illuminate\Validation\UnauthorizedException::class => BaseFormatters\UnauthorizedExceptionFormatter::class,

		SymfonyException\HttpExceptionInterface::class => BaseFormatters\ExceptionFormatter::class,
		Exception::class => BaseFormatters\ExceptionFormatter::class,


		//        SymfonyException\HttpException::class => Formatters\HttpExceptionFormatter::class,
		//        Exception::class => Formatters\ExceptionFormatter::class,
	],

    'response_factory' => \Optimus\Heimdal\ResponseFactory::class,

    'reporters' => [
        /*'sentry' => [
            'class'  => \Optimus\Heimdal\Reporters\SentryReporter::class,
            'config' => [
                'dsn' => '',
                // For extra options see https://docs.sentry.io/clients/php/config/
                // php version and environment are automatically added.
                'sentry_options' => []
            ]
        ]*/
    ],

    'server_error_production' => 'An error occurred.'
];
