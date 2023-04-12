<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Vanier\Api\Models\SchedulesModel;
use Slim\Exception\HttpBadRequestException;
use Fig\Http\Message\StatusCodeInterface;
use Slim\Exception\HttpNotFoundException;
use Vanier\Api\Helpers\Input;
use Vanier\Api\Models\StopsModel;
use Vanier\Api\Models\TripsModel;

class SchedulesController extends BaseController
{
    private $schedule_model;
    private $validation;
    public function __construct()
    {
        $this->schedule_model = new SchedulesModel();
        $this->validation = new Input();
    }

    public function handleCreateSchedules(Request $request, Response $response) {     
        //step 1-- retrieve the data from the request body (getParseBodyMethod)
        $data = $request->getParsedBody();

        foreach ($data as $schedule){
            $this->isValidSchedule($request, $schedule);
            $this->schedule_model->createSchedule($schedule);
        }

        $success_data = [
            "code" => StatusCodeInterface::STATUS_CREATED,
            "message" => "Created", 
            "description" => "The schedule was created successfully!"
        ];

        return $this->prepareOkResponse($response, $success_data, 201);
    }

    public function getScheduleById(Request $request, Response $response, array $uri_args)
    {
        $schedule_id = $uri_args["schedule_id"];
        $data = $this->schedule_model->getScheduleById($schedule_id);
        return $this->prepareOkResponse($response, $data);
    }

    public function getAllSchedules(Request $request, Response $response)
    {
        $filters = $request->getQueryParams();
        if ($this->isValidPageParams($filters)) {
            //sets up the pagination options by getting the value in the query params
            // WE set only if we have valid ....
            $this->schedule_model->setPaginationOptions($filters["page"], $filters["page_size"]);
        }
        $data = $this->schedule_model->getAll($filters);
        return $this->prepareOkResponse($response, $data);
    }

    public function isValidSchedule($request, array $schedule)
    {
        $stop_model = new StopsModel();
        $trip_model = new TripsModel();

        $required_keys = ["stop_id", "trip_id", "arrival_time", "departure_time", "stop_sequence"];
        foreach ($required_keys as $key) {
            if (!array_key_exists($key, $schedule)) {
                throw new HttpBadRequestException($request, "Missing required key '$key'...BAD REQUEST!");
            }
        }

        //gets all the row in films
        foreach ($schedule as $key => $value) {
            if (!isset($schedule) || !is_array($schedule)) {
                throw new HttpBadRequestException($request, "Invalid/malformed data...BAD REQUEST!");
            }
            switch ($key) {
                    // each case is a key that we want to validate
                case "schedule_id":
                    if (isset($value)) {
                        throw new HttpBadRequestException($request, "Value not required...BAD REQUEST!");
                    }
                case "stop_id":
                case "trip_id":
                    // check if the id is not a string
                    if (!$this->validation->isAlpha($value)) {
                        if (empty($stop_model->getStopById($value))) {
                            throw new HttpNotFoundException($request, "Id is not found...NOT FOUND!");
                        }
                        if (empty($trip_model->getTripById($value))) {
                            throw new HttpNotFoundException($request, "Id is not found...NOT FOUND!");
                        }
                    }
                    break;
                case "arrival_time":
                case "departure_time":
                    // check if the id is not a string
                    if (!$this->validation->isFormattedTime($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "stop_sequence":
                    // check if the title is only strings
                    if ($this->validation->isAlpha($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                default:
                    break;
            }
        }
    }
}
