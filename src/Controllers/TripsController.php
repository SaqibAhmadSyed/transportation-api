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
        $this->prepareOkResponse($response, $data, HTTP_OK);
    }

    public function getAllTrips(Request $request, Response $response){
        $filters = $request->getQueryParams();
        $data = $this->trip_model->getAll($filters);
        $this->trip_model->setPaginationOptions($filters['page'], $filters['page_size']);
        $this->prepareOkResponse($response, $data, HTTP_OK);
    }
}
