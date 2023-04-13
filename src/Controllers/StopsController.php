<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Vanier\Api\Models\StopsModel;
use Vanier\Api\Controllers\BaseController;
use Vanier\Api\Helpers\Input;
use Slim\Exception\HttpBadRequestException;
use Fig\Http\Message\StatusCodeInterface;
use Slim\Exception\HttpNotFoundException;

class StopsController extends BaseController
{
    private $stop_model;
    private $validation;
    public function __construct(){
        $this->stop_model = new StopsModel();
        $this->validation = new Input();
    }
    
    //ROUTE: //stops(stop_id)
    public function getStopInfo(Request $request, Response $response, array $uri_args){
        $stop_id = $uri_args["stop_id"];
        $data = $this->stop_model->getStopById($stop_id);
        return $this->prepareOkResponse($response, $data);
    }

    public function getAllStops(Request $request, Response $response){
        $filters = $request->getQueryParams();
        if($this->isValidPageParams($filters)){
            $this->stop_model->setPaginationOptions($filters["page"], $filters["page_size"]);
        }
        $data = $this->stop_model->getAll($filters);
        return $this->prepareOkResponse($response, $data);
    }
}
