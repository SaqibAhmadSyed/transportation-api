<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Models\RoutesModel;
use Slim\Exception\HttpBadRequestException;

class RoutesController extends BaseController
{
    private $route_model;
    private $validation;
    public function __construct(){
        $this->route_model = new RoutesModel();
        $this->validation = new Input();
    }

    public function getRoutebyId(Request $request, Response $response, array $uri_args){
        $route_id = $uri_args["route_id"];
        $data = $this->route_model->getRouteById($route_id);
        return $this->prepareOkResponse($response, $data);
    }

    public function getAllRoutes(Request $request, Response $response){
        $filters = $request->getQueryParams();
        $route_model = new RoutesModel();
        $filter_params = [];
        $type_array = ['Bus', 'Metro'];

        if (!$this->validation->isIntOrGreaterThan($filters["page"], 0) || !$this->validation->isIntOrGreaterThan($filters["page_size"], 0)) {
            throw new HttpBadRequestException($request, "Invalid pagination input!");
        }

        // stores in filter_params all the filters that are not pagination filters for validation
        // Filters the value inside the foreach loops
        foreach ($filters as $key => $value) {
            if ($key !== 'page' && $key !== 'page_size') {
                if (!$this->validation->isAlpha($value)) {
                    throw new HttpBadRequestException($request, "Only string are accepted!");
                }
                if ($key === 'type' && !$this->validation->isInArray($value, $type_array)) {
                    throw new HttpBadRequestException($request, "Only specific types (Bus or Metro) are accepted");
                }
            }
        }
       
        $route_model->setPaginationOptions($filters['page'], $filters['page_size']);
        $data = $route_model->getAll($filter_params); 
        $this->validateRoute($request, $data);
        return $this->prepareOkResponse($response, $data);
    }

        
    

    public function validateRoute($request, array $route)
    {
        $type_array = ['Bus', 'Metro'];

        //gets all the row in films
        foreach ($route as $key => $value) {
            switch ($key) {
                    // each case is a key that we want to validate
                case "route_id":
                    // check if the id is not a string
                    if ($this->validation->isAlpha($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "name":
                    // check if the title is only strings
                    if (!$this->validation->isOnlyAlpha($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    if (empty($value)) {
                        throw new HttpBadRequestException($request, "One or more data is empty...BAD REQUEST!");
                    }
                    break;
                case "type":
                    if (!$this->validation->isInArray($value, $type_array)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    if (empty($value)) {
                        throw new HttpBadRequestException($request, "One or more data is empty...BAD REQUEST!");
                    }
                    break;
                default:
                    break;
            }
        }
    }
}
