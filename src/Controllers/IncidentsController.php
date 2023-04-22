<?php

namespace Vanier\Api\Controllers;

use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Models\IncidentsModel;
use Slim\Exception\HttpBadRequestException;
use Fig\Http\Message\StatusCodeInterface;
use Slim\Exception\HttpNotFoundException;

class IncidentsController extends BaseController
{
    private $incident_model;
    private $validation;
    public function __construct(){
        $this->incident_model = new IncidentsModel();
        $this->validation = new Input();
    }

    public function handleDeleteRoutes(Request $request, Response $response, array $uri_args)
    {
        $incident_id = $uri_args["incident_id"];

        if (!$this->incident_model->getIncidentById($incident_id)) {
            throw new HttpNotFoundException($request, "Id was not found...NOT FOUND!");
        }
        //deletes the data with the given data in the body and the id of the data we want to delete
        $this->incident_model->deleteIncident($incident_id);
        
        $success_data = [
            "code" => StatusCodeInterface::STATUS_NO_CONTENT,
            "message" => "Deleted", 
            "description" => "The incident was deleted successfully!"
        ];

        return $this->prepareOkResponse($response, $success_data);
    }

    public function handleUpdateRoutes(Request $request, Response $response)
    {
        $incidents_data = $request->getParsedBody();

        foreach ($incidents_data as $data) {
            //validates the input
            $this->isValidIncident($request, $data);
            //gets the film id from the body
            $incident_id = $data["incident_id"];
            if($this->incident_model->getIncidentById($incident_id)){
                unset($data["incident_id"]);
                $this->incident_model->updateIncident($data, ["incident_id" => $incident_id]);
            } else {
                throw new HttpNotFoundException($request, "Id was not found...NOT FOUND!");
            }
        }

        $success_data = [
            "code" => StatusCodeInterface::STATUS_OK,
            "message" => "Updated", 
            "description" => "The incident was updated successfully!"
        ];
        return $this->prepareOkResponse($response, $success_data);
    }


    public function handleCreateRoutes(Request $request, Response $response) {     
        //step 1-- retrieve the data from the request body (getParseBodyMethod)
        $data = $request->getParsedBody();

        foreach ($data as $incident){
            if(empty($incident["incident_id"])){
                $this->isValidIncident($request, $incident);
                $this->incident_model->createIncident($incident);
            } else {
                throw new HttpBadRequestException($request, "Value not required...BAD REQUEST!"); 
            }
            
        }

        $success_data = [
            "code" => StatusCodeInterface::STATUS_CREATED,
            "message" => "Created", 
            "description" => "The Incident was created successfully!"
        ];

        return $this->prepareOkResponse($response, $success_data, 201);
    }

    public function getIncidentById(Request $request, Response $response, array $uri_args){
        $incident_id = $uri_args["incident_id"];

        $data = $this->incident_model->getIncidentById($incident_id);
        return $this->prepareOkResponse($response, $data);
    }

    public function getAllIncidents(Request $request, Response $response){
        $filters = $request->getQueryParams();

        if ($this->isValidPageParams($filters)) {
            //sets up the pagination options by getting the value in the query params
            // WE set only if we have valid ....
            $this->incident_model->setPaginationOptions($filters["page"], $filters["page_size"]);
        }

        $data = $this->incident_model->getAllIncidents($filters); 
        return $this->prepareOkResponse($response, $data);
    }

    function validateDate($date, $format = $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    function validatTime($date, $format = $format = 'H:i:s'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    public function isValidIncident($request, array $incident)
    {

        $required_keys = ["date", "primary_cause", "secondary_cause", "line_name, symptom, incident_time, start_time"];
        foreach ($required_keys as $key) {
            if (!array_key_exists($key, $incident)) {
                throw new HttpBadRequestException($request, "Missing required key '$key'...BAD REQUEST!");
            }
        }

        //gets all the row in films
        foreach ($incident as $key => $value) {
            switch ($key) {
                    // each case is a key that we want to validate
                case "date":
                    if (!$this->validateDate($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "primary_cause":
                    // check if the title is only strings
                    if (!$this->validation->isValidString($value)){
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    if (empty($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "secondary_cause":
                    // check if the title is only strings
                    if (!$this->validation->isValidString($value)){
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    if (empty($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "line_name":
                    // check if the title is only strings
                    if (!$this->validation->isValidString($value)){
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    if (empty($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "symptom":
                    // check if the title is only strings
                    if (!$this->validation->isValidString($value)){
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    if (empty($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "incident_time":
                    if (!$this->validatTime($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "start_time":
                    if (!$this->validatTime($value)) {
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
