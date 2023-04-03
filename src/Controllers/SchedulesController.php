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

    public function getScheduleById(Request $request, Response $response, array $uri_args){
        $schedule_id = $uri_args["schedule_id"];
        $data = $this->schedule_model->getScheduleById($schedule_id);
        return $this->prepareOkResponse($response, $data);
    }

    public function getAllSchedules(Request $request, Response $response){
        $filters = $request->getQueryParams();
        $data = $this->schedule_model->getAll($filters);
        //$this->schedule_model->setPaginationOptions($filters['page'], $filters['page_size']);
        return $this->prepareOkResponse($response, $data);
    }
}
