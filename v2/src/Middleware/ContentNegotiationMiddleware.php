<?php

namespace Vanier\Api\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class ContentNegotiationMiddleware implements MiddlewareInterface
{
    private $supported_types = [APP_MEDIA_TYPE_XML];

    public function __construct(array $options = []){
        $this->supported_types = array_merge($options, $this->supported_types);
    }

    public function process(Request $request, RequestHandler $handler): Response{
        $accept = $request->getHeaderLine("Accept");
        if(!str_contains(APP_MEDIA_TYPE_JSON, $accept)){
            $response = new \Slim\Psr7\Response();

            $error_data = [
                "code" => StatusCodeInterface::STATUS_NOT_ACCEPTABLE,
                "message" => "NOT ACCEPTABLE",
                "description" => "The server does not like formats other than json or xml"
            ];

            $response->getBody()->write(json_encode($error_data));
            return $response
                    ->withStatus(StatusCodeInterface::STATUS_NOT_ACCEPTABLE)
                    ->withAddedHeader("Content_type", APP_MEDIA_TYPE_JSON);
        }

        $response = $handler->handle($request);
        return $response;
    }
}
