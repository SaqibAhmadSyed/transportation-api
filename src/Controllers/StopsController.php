<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
Use Psr\Http\Message\ResponseInterface as Response;
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
        //Validate: the ID --> if not valid
        //throw an HttpException 404.


        //Fetch a stop by it's ID
        $data = $this->stop_model->getStopById($stop_id);
        $this->prepareOkResponse($response, $data, $status_code = 200);
    }
}
