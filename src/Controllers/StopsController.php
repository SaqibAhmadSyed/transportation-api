<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Vanier\Api\Models\StopsModel;
use Vanier\Api\Controllers\BaseController;

class StopsController extends BaseController
{
    private $stop_model = null;
    public function __construct(){
        $this->stop_model = new StopsModel();
    }
    
    //ROUTE: //stops(stop_id)
    public function getStopInfo(Response $response, array $uri_args){
        $stop_id = $uri_args["stop_id"];
        $data = $this->stop_model->getStopById($stop_id);
        $this->prepareOkResponse($response, $data, HTTP_OK);
    }

    public function getAllStops(Request $request, Response $response){
        $filters = $request->getQueryParams();
        $this->stop_model->setPaginationOptions($filters['page'], $filters['page_size']);
        $data = $this->stop_model->getAll($filters);
        $this->prepareOkResponse($response, $data, HTTP_OK);
    }
}
