<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Validations\Input;
use Slim\Exception\HttpBadRequestException;

/**
 * Base controller that handled redundant code here
 */
class BaseController
{
    private $validation;

    public function __construct() {
        $this->validation = new Input();
    }
    protected function prepareOkResponse(Response $response, $data)
    {
        // takes the data from the parameter and converts it to JSON
        $json_data = json_encode($data); 
        // Writes in the body the data in json format
        $response->getBody()->write($json_data);
        // returns the prepared response
        return $response->withStatus(HTTP_OK)->withHeader('Content-Type', 'application/json');
    }
}

