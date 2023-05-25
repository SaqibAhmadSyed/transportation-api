<?php

namespace Vanier\Api\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Vanier\Api\Models\StopsModel;
use Vanier\Api\Helpers\Input;
use Slim\Exception\HttpBadRequestException;
use Fig\Http\Message\StatusCodeInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\ResponseEmitter;

class StopsController extends BaseController
{
    private $stop_model;
    private $validation;
    public function __construct()
    {
        $this->stop_model = new StopsModel();
        $this->validation = new Input();
    }

    public function handleCreateStops(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        foreach ($data as $stop) {
            if (empty($stop["stop_id"])) {
                $this->isValidStops($request, $stop);
                $this->stop_model->createStop($stop);
            } else {
                throw new HttpBadRequestException($request, "Value not required...BAD REQUEST!");
            }
        }

        $success_data = [
            "code" => StatusCodeInterface::STATUS_CREATED,
            "message" => "Created",
            "description" => "The stop was created successfully!"
        ];
        return $this->prepareOkResponse($response, $success_data, 201);
    }

    public function handleUpdateStops(Request $request, Response $response)
    {
        $stop_data = $request->getParsedBody();
        foreach ($stop_data as $data) {
            $this->isValidStops($request, $data);
            $stop_id = $data["stop_id"];
            if ($this->stop_model->getStopById($stop_id)) {
                unset($data["stop_id"]);
                $this->stop_model->updateStop($data, ["stop_id" => $stop_id]);
            } else {
                throw new HttpBadRequestException($request, "Id was not found...NOT FOUND!");
            }
        }

        $success_data = [
            "code" => StatusCodeInterface::STATUS_OK,
            "message" => "Updated",
            "description" => "The stop was updated successfully!"
        ];
        return $this->prepareOkResponse($response, $success_data, 201);
    }

    public function handleDeleteStops(Request $request, Response $response, array $uri_args)
    {
        $stop_id = $uri_args["stop_id"];
        if (!$this->stop_model->getStopById($stop_id)) {
            throw new HttpNotFoundException($request, "Id not found...NOT FOUND");
        }
        $this->stop_model->deleteStop($stop_id);

        $success_data = [
            "code" => StatusCodeInterface::STATUS_NO_CONTENT,
            "messages" => "Deleted",
            "description" => "The stop was deleted successfully!"
        ];
        return $this->prepareOkResponse($response, $success_data);
    }

    //ROUTE: //stops(stop_id)
    public function getStopById(Request $request, Response $response, array $uri_args)
    {
        $stop_id = $uri_args["stop_id"];
        $data = $this->stop_model->getStopById($stop_id);
        return $this->prepareOkResponse($response, $data);
    }

    public function getAllStops(Request $request, Response $response)
    {
        $filters = $request->getQueryParams();
        if ($this->isValidPageParams($filters)) {
            $this->stop_model->setPaginationOptions($filters["page"], $filters["page_size"]);
        }
        $data = $this->stop_model->getAll($filters);
        return $this->prepareOkResponse($response, $data);
    }

    public function isValidStops($request, array $stop)
    {
        $required_keys = ["code", "name", "lat", "lon", "url"];
        foreach ($required_keys as $key) {
            if (!array_key_exists($key, $stop)) {
                throw new HttpBadRequestException($request, "Missing required key '$key'...BAD REQUEST!");
            }
        }

        foreach ($stop as $key => $value) {

            switch ($key) {
                case "code":
                    if ($value < 1) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "name":
                    if (!$this->validation->isValidString($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    if (empty($value)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "lon":
                    if (!(-180 < $value && $value < 180)) {
                        throw new HttpBadRequestException($request, "One or more data is malformed...BAD REQUEST!");
                    }
                    break;
                case "lat":
                    if (!(-90 < $value && $value < 90)) {
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
