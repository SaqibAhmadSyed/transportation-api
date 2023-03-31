<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Models\RoutesModel;

class RoutesController extends BaseController
{
    private $route_model;
    public function __construct(){
        $this->route_model = new RoutesModel();
    }

    public function getRoutebyId(Request $request, Response $response, array $uri_args){
        $route_id = $uri_args["route_id"];
        $data = $this->route_model->getRouteById($route_id);
        $json_data = json_encode($data);
        $response->getBody()->write($json_data);
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        //$this->prepareOkResponse($request, $response, $data);
    }

    public function getAllRoutes(Request $request, Response $response){
        $filters = $request->getQueryParams();
        $route_model = new RoutesModel();
        // $this->route_model->setPaginationOptions($filters['page'], $filters['page_size']);
        $data = $route_model->getAll($filters);
        //$route_model->setPaginationOptions($filters['page'], $filters['page_size']);
        $json_data = json_encode($data);
        $response->getBody()->write($json_data);
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        //$this->prepareOkResponse($request, $response, $data);
    }
}
