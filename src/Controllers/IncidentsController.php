<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Models\IncidentsModel;

class IncidentsController extends BaseController
{
    private $incident_model;
    public function __construct(){
        $this->incident_model = new IncidentsModel();
    }

    public function getIncidentById(Request $request, Response $response, array $uri_args){
        $route_id = $uri_args["route_id"];
        $data = $this->incident_model->getIncidentById($route_id);
        $json_data = json_encode($data);
        $response->getBody()->write($json_data);
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        //$this->prepareOkResponse($request, $response, $data);
    }

    public function getAll(Request $request, Response $response){
        $filters = $request->getQueryParams();
        $incident_model = new IncidentsModel();
        // $this->route_model->setPaginationOptions($filters['page'], $filters['page_size']);
        $data = $incident_model->getAll($filters);
        //$route_model->setPaginationOptions($filters['page'], $filters['page_size']);
        $json_data = json_encode($data);
        $response->getBody()->write($json_data);
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        //$this->prepareOkResponse($request, $response, $data);
    }
}
