<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2018/3/22
 * Time: 13:50
 */

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Router;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Optimus\Heimdal\Formatters\BaseFormatter;
use ReflectionClass;

class ExceptionHandler extends \Optimus\Heimdal\ExceptionHandler {


    public function render($request, Exception $e)
    {

//        if ($e instanceof AuthenticationException) {
//            return $this->unauthenticated($request, $e);
//        }
        if (!$request->expectsJson()) {
            return $this->originRender($request, $e);
        }
        $response = $this->generateExceptionResponse($request, $e);

        if ($this->config['add_cors_headers']) {
            if (!class_exists(CorsService::class)) {
                throw new InvalidArgumentException(
                    'asm89/stack-cors has not been installed. Optimus\Heimdal needs it for adding CORS headers to response.'
                );
            }

            /** @var CorsService $cors */
            $cors = $this->container->make(CorsService::class);
            $cors->addActualRequestHeaders($response, $request);
        }

        return $response;
    }

    /**
     * Render an exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function originRender($request, $e) {
        if (method_exists($e, 'render') && $response = $e->render($request)) {
            return Router::toResponse($request, $response);
        } elseif ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        $e = $this->prepareException($e);

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof AuthenticationException) {
            return $this->unauthenticated($request, $e);
        } elseif ($e instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($e, $request);
        }

        return $request->expectsJson()
            ? $this->prepareJsonResponse($request, $e)
            : $this->prepareResponse($request, $e);
    }

    private function generateExceptionResponse($request, Exception $e)
    {
        $formatters = $this->config['formatters'];

        // :: notation will otherwise not work for PHP <= 5.6
        $responseFactoryClass = $this->config['response_factory'];

        // Allow users to have a base formatter for every response.
        $response = $responseFactoryClass::make($e);

        foreach($formatters as $exceptionType => $formatter) {
            if (!($e instanceof $exceptionType)) {
                continue;
            }

            if (
                !class_exists($formatter) ||
                !(new ReflectionClass($formatter))->isSubclassOf(new ReflectionClass(BaseFormatter::class))
            ) {
                throw new InvalidArgumentException(
                    sprintf(
                        "%s is not a valid formatter class.",
                        $formatter
                    )
                );
            }

            $formatterInstance = new $formatter($this->config, $this->debug);
            $formatterInstance->format($response, $e, $this->reportResponses);

            break;
        }

        return $response;
    }
}