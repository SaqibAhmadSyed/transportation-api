<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Models\RoutesModel;
use Slim\Exception\HttpBadRequestException;
use Fig\Http\Message\StatusCodeInterface;
use Slim\Exception\HttpNotFoundException;

class RoutesController extends BaseController
{
    private $route_model;
    private $validation;
    public function __construct(){
        $this->route_model = new RoutesModel();
        $this->validation = new Input();
    }

    public function handleDeleteRoutes(Request $request, Response $response, array $uri_args)
    {
        $route_id = $uri_args["route_id"];

        //checks if the film exists
        if (!$this->route_model->getRouteById($route_id)) {
            throw new HttpNotFoundException($request, "Id was not found...NOT FOUND!");
        }
        //deletes the data with the given data in the body and the id of the data we want to delete
        $this->route_model->deleteRoute($route_id);
        
        $success_data = [
            "code" => StatusCodeInterface::STATUS_NO_CONTENT,
            "message" => "Deleted", 
            "description" => "The route was deleted successfully!"
        ];

        return $this->prepareOkResponse($response, $success_data);
    }

    public function handleUpdateRoutes(Request $request, Response $response)
    {
        $routes_data = $request->getParsedBody();

        foreach ($routes_data as $data) {
            //validates the input
            $this->isValidRoute($request, $data);
            //gets the film id from the body
            $route_id = $data["route_id"];
            if($this->route_model->getRoutebyId($route_id)){
                unset($data["route_id"]);
                $this->route_model->updateRoute($data, ["route_id" => $route_id]);
            } else {
                throw new HttpNotFoundException($request, "Id was not found...NOT FOUND!");
            }
        }

        $success_data = [
            "code" => StatusCodeInterface::STATUS_OK,
            "message" => "Updated", 
            "description" => "The route was updated successfully!"
        ];
        return $this->prepareOkResponse($response, $success_data);
    }


    public function handleCreateRoutes(Request $request, Response $response) {     
        //step 1-- retrieve the data from the request body (getParseBodyMethod)
        $data = $request->getParsedBody();

        foreach ($data as $route){
            if(empty($route["route_id"])){
                $this->isValidRoute($request, $route);
                $this->route_model->createRoute($route);
            } else {
                throw new HttpBadRequestException($request, "Value not required...BAD REQUEST!"); 
            }
            
        }

        $success_data = [
            "code" => StatusCodeInterface::STATUS_CREATED,
            "message" => "Created", 
            "description" => "The route was created successfully!"
        ];

        return $this->prepareOkResponse($response, $success_data, 201);
    }

    public function getRoutebyId(Request $request, Response $response, array $uri_args){
        $route_id = $uri_args["route_id"];
        $data = $this->route_model->getRouteById($route_id);
        return $this->prepareOkResponse($response, $data);
    }

    public function getAllRoutes(Request $request, Response $response){
        $filters = $request->getQueryParams();

        if ($this->isValidPageParams($filters)) {
            //sets up the pagination options by getting the value in the query params
            // WE set only if we have valid ....
            $this->route_model->setPaginationOptions($filters["page"], $filters["page_size"]);
        }

        $data = $this->route_model->getAll($filters); 
        return $this->prepareOkResponse($response, $data);
    }

    public function isValidRoute($request, array $route)
    {
        $type_array = ['Bus', 'Metro'];

        $required_keys = ["agency_id", "name", "type", "url"];
        foreach ($required_keys as $key) {
            if (!array_key_exists($key, $route)) {
                throw new HttpBadRequestException($request, "Missing required key '$key'...BAD REQUEST!");
            }
        }

        //gets all the row in films
        foreach ($route as $key => $value) {
            switch ($key) {
                    // each case is a key that we want to validate
                case "agency_id":
                    // check if the id is not a string
                    if ($value != 1) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "name":
                    // check if the title is only strings
                    if (!$this->validation->isValidString($value)){
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    if (empty($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "type":
                    if (!$this->validation->isInArray($value, $type_array)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    if (empty($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "url":
                    if (!$this->validation->isStmUrl($value)) {
                        throw new HttpNotFoundException($request, "This link is not available in the stm website...NOT FOUND");
                    }
                    if (empty($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                default:
                    break;
            }
        }
    }
}
