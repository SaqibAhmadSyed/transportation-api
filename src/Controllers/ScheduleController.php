<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Vanier\Api\Models\SchedulesModel;

class SchedulesController extends BaseController
{
    private $schedule_model;
    public function __construct(){
        $this->schedule_model = new SchedulesModel();
    }

    //ROUTE: //trips(trip_id)
    public function getScheduleInfo(Response $response, array $uri_args){
        $schedule_id = $uri_args["schedule_id"];
        $data = $this->schedule_model->getScheduleById($schedule_id);
        $this->prepareOkResponse($response, $data, HTTP_OK);
    }

    public function getAllSchedules(Request $request, Response $response){
        $filters = $request->getQueryParams();
        $data = $this->schedule_model->getAll($filters);
        $this->schedule_model->setPaginationOptions($filters['page'], $filters['page_size']);
        $this->prepareOkResponse($response, $data, HTTP_OK);
    }
}
