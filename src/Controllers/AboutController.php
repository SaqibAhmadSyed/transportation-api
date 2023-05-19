<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Validations\Input;
use Slim\Exception\HttpBadRequestException;
use Vanier\Api\Helpers\Input as HelpersInput;

class AboutController extends BaseController
{
    private $validation;

    public function __construct() {
        $this->validation = new HelpersInput();
    }

    public function handleAboutApi(Request $request, Response $response, array $uri_args)
    {
        $data = array(
            'about' => 'Welcome, this is a Web services that provides this and that...',
            'resources' => 'Blah'
        );                
        return $this->prepareOkResponse($response, $data);
    }
}
