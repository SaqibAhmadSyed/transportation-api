<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Vanier\Api\Controllers\AboutController;

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

//Routing For TripsController
$app->get('/trips', [TripsController::class, 'getAllTrips']);
$app->get('/trips/{trip_id}', [TripsController::class , 'getTripInfo']);

//Routing For StopsController
$app->get('/stops', [StopsController::class, 'getAllStops']);
$app->get('/stops/{stop_id}', [StopController::class, 'getStopInfo']);