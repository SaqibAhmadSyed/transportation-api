<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Vanier\Api\Models\TripsModel;
use Vanier\Api\Controllers\BaseController;


class TripsController extends BaseController
{
    private $trip_model = null;
    public function __construct(){
        $this->trip_model = new TripsModel();
    }

    //ROUTE: //trips(trip_id)
    public function getTripInfo(Response $response, array $uri_args){
        $trip_id = $uri_args["trip_id"];
        $data = $this->trip_model->getTripById($trip_id);
        $json_data = json_encode($data);
        $response->getBody()->write($json_data);
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        //$this->prepareOkResponse($request, $response, $data);
    }

    public function getAllTrips(Request $request, Response $response){
        $filters = $request->getQueryParams();
        $trip_model = new TripsModel();
        $data = $trip_model->getAll($filters);
        //$this->trip_model->setPaginationOptions($filters['page'], $filters['page_size']);
        $json_data = json_encode($data);
        $response->getBody()->write($json_data);
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        //$this->prepareOkResponse($response, $data, HTTP_OK);
    }
}
