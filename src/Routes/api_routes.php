<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Vanier\Api\Controllers\IncidentsController;
use Vanier\Api\Controllers\TripsController;
use Vanier\Api\Controllers\RoutesController;
use Vanier\Api\Controllers\StopsController;
use Vanier\Api\Controllers\SchedulesController;

// Import the app instance into this file's scope.
global $app;

// NOTE: Add your app routes here.
// The callbacks must be implemented in a controller class.
// The Vanier\Api must be used as namespace prefix. 

// ROUTE: /
// $app->get('/', [AboutController::class, 'handleAboutApi']); 

// ROUTE: /hello
$app->get('/hello', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Reporting! Hello there!");    
    return $response;
});

//ROUTE: /trips
$app->get('/trips', [TripsController::class, 'getAllTrips']);
$app->get('/trips/{trip_id}', [TripsController::class , 'getTripInfo']);

//ROUTE: /stops
$app->get('/stops', [StopsController::class, 'getAllStops']);
$app->get('/stops/{stop_id}', [StopsController::class, 'getStopInfo']);

//ROUTE: /schedules
$app->get('/schedules', [SchedulesController::class, 'getAllSchedules']);
$app->get('/schedules/{schedule_id}', [SchedulesController::class , 'getScheduleById']);

//ROUTE: /routes
$app->get('/routes', [RoutesController::class, 'getAllRoutes']);
$app->get('/routes/{route_id}', [RoutesController::class, 'getRouteById']);

//Routing For IncidentController 
$app->get('/incidents', [IncidentsController::class, 'getAll']);