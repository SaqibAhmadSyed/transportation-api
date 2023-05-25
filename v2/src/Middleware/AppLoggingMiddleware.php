<?php

namespace Vanier\Api\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


/**
 * Summary of AppLoggingMiddleware
 */
class AppLoggingMiddleware implements MiddlewareInterface
{


    /**
     * logs info in the file for every event that occurred
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     */
    public function process(Request $request, RequestHandler $handler): Response{
 
        $http_method = $request->getMethod();
        $body = $request->getParsedBody();
        $test = 
        $filters = $request->getQueryParams();       
        $resource_info = $http_method. ' '.$request->getUri()->getPath();

        // TODO: log the POST|PUT|DELETE requests to write.log?
        switch ($http_method) {
        case "GET":
            $logger = new Logger('access');
            $logger->pushHandler(new StreamHandler(APP_LOG_DIR.'/access.log', Logger::DEBUG)); 
            $logger->info('GET REQUEST: '. $resource_info, $filters);
            break;
        case "POST":
            $logger = new Logger('write');
            $logger->pushHandler(new StreamHandler(APP_LOG_DIR.'/write.log', Logger::DEBUG)); 
            $logger->info('POST REQUEST: '. $resource_info, $body);
            break;
        case "PUT":
            $logger = new Logger('write');
            $logger->pushHandler(new StreamHandler(APP_LOG_DIR.'/write.log', Logger::DEBUG)); 
            $logger->info('PUT REQUEST: '. $resource_info, $body, );
            break;
        case "DELETE":
            $logger = new Logger('write');
            $logger->pushHandler(new StreamHandler(APP_LOG_DIR.'/write.log', Logger::DEBUG)); 
            $logger->info('DELETE REQUEST: '. $resource_info);
            break;
        default:
            break;
    }

        //-- DO NOT REMOVE THE FOLLOWING:
        $response = $handler->handle($request);
        return $response;
    }
}
