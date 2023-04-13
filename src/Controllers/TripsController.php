<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Vanier\Api\Models\TripsModel;
use Vanier\Api\Helpers\Input;
use Slim\Exception\HttpBadRequestException;
use Fig\Http\Message\StatusCodeInterface;
use Slim\Exception\HttpNotFoundException;


class TripsController extends BaseController
{
    private $trip_model;
    private $validation;
    public function __construct(){
        $this->trip_model = new TripsModel();
        $this->validation = new Input();    
    }

    //ROUTE: //trips(trip_id)
    public function getTripById(Request $request, Response $response, array $uri_args){
        $trip_id = $uri_args["trip_id"];
        $data = $this->trip_model->getTripById($trip_id);
        return $this->prepareOkResponse($response, $data);
    }

    public function getAllTrips(Request $request, Response $response){
        $filters = $request->getQueryParams();
        if($this->isValidPageParams($filters)){
            $this->trip_model->setPaginationOptions($filters["page"], $filters["page_size"]);
        }
        $data = $this->trip_model->getAll($filters);
        return $this->prepareOkResponse($response, $data);
    }

    public function isValidTrip($request, array $trip)
    {
        $required_keys = ["route_id", "service_id", "headsign", "shape_id"];
        foreach ($required_keys as $key) {
            if (!array_key_exists($key, $trip)) {
                throw new HttpBadRequestException($request, "Missing required key '$key'...BAD REQUEST!");
            }
        }

        //gets all the row in films
        foreach ($trip as $key => $value) {
            switch ($key) {
                    // each case is a key that we want to validate
                case "trip_id":
                    // auto increment. therefore, no need to set id
                    if (isset($value)) {
                        throw new HttpBadRequestException($request, "Value not required...BAD REQUEST!");
                    }
                    break;
                case "route_id":
                    // check if the id is not a string
                    if ($value < 1) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "service_id":
                    // check if the id is not a string
                    if ($value < 1) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "headsign":
                    // check if the title is only strings
                    if (!$this->validation->isOnlyAlpha($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    if (empty($value)) {
                        throw new HttpBadRequestException($request, "One or more data is empty...BAD REQUEST!");
                    }
                    break;
                case "shape_id":
                    // check if the id is not a string
                    if ($value < 1) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                default:
                    break;
            }
        }
    }

    public function handleCreateTrips(Request $request, Response $response){
        $trip_data = $request->getParsedBody();
        foreach($trip_data as $data){
            $this->isValidTrip($request, $data);
            $this->trip_model->createTrip($data);
        }
        $success_data = [
            "code" => StatusCodeInterface::STATUS_CREATED,
            "message" => "Created",
            "description" => "The trip was created successfully!"
        ];
        return $this->prepareOkResponse($response, $success_data, 201);

    }

    public function handleUpdateTrips(Request $request, Response $response){
        $trips_data = $request->getParsedBody();
        foreach($trips_data as $data){
            $this->isValidTrip($request, $data);
            $trip_id = $data["trip_id"];
            unset($data["trip_id"]);
            $this->trip_model->updateTrip($data, ["trip_id" => $trip_id]);
        }
        $success_data = [
            "code" => StatusCodeInterface::STATUS_OK,
            "message" => "Updated",
            "description" => "The trip was updated successfully!"
        ];
        return $this->prepareOkResponse($response, $success_data);
    }

    public function handleDeleteTrips(Request $request, Response $response){
        $trips_data = $request->getParsedBody();
        foreach($trips_data as $data){
            if(!$this->trip_model->getTripById($data)){
                throw new HttpNotFoundException($request, "ID was not found");
            }
            $this->trip_model->deleteTrip($data);
        }
        $success_data = [
            "code" => StatusCodeInterface::STATUS_NO_CONTENT,
            "message" => "Deleted",
            "description" => "The trip was updated successfully!"
        ];
        return $this->prepareOkResponse($response, $success_data);
    }
}
