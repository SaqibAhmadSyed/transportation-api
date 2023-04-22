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
$app->get('/trips/{trip_id}', [TripsController::class , 'getTripById']);
$app->post('/trips', [TripsController::class, 'handleCreateTrips']);
$app->put('/trips', [TripsController::class, 'handleUpdateTrips']);
$app->delete('/trips', [TripsController::class, 'handleDeleteTrips']);

//ROUTE: /stops
$app->get('/stops', [StopsController::class, 'getAllStops']);
$app->get('/stops/{stop_id}', [StopsController::class, 'getStopById']);
$app->post('/stops', [StopsController::class, 'handleCreateStops']);
$app->put('/stops', [StopsController::class, 'handleUpdateStops']);
$app->delete('/stops', [StopsController::class, 'handleDeleteStops']);

//ROUTE: /schedules
$app->get('/schedules', [SchedulesController::class, 'getAllSchedules']);
$app->get('/schedules/{schedule_id}', [SchedulesController::class , 'getScheduleById']);
$app->post('/schedules', [SchedulesController::class, 'handleCreateSchedules']);
$app->put('/schedules', [SchedulesController::class, 'handleUpdateSchedules']);
$app->delete('/schedules/{schedule_id}', [SchedulesController::class, 'handleDeleteSchedules']);

//ROUTE: /routes
$app->get('/routes', [RoutesController::class, 'getAllRoutes']);
$app->get('/routes/{route_id}', [RoutesController::class, 'getRouteById']);
$app->post('/routes', [RoutesController::class, 'handleCreateRoutes']);
$app->put('/routes', [RoutesController::class, 'handleUpdateRoutes']);
$app->delete('/routes/{route_id}', [RoutesController::class, 'handleDeleteRoutes']);

//ROUTE: /incidents
$app->get('/incidents', [IncidentsController::class, 'getAllIncidents']);
$app->get('/incidents/{incidents_id}', [IncidentsController::class, 'getIncidentById']);
