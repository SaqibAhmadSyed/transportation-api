<?php

use Slim\Factory\AppFactory;
use Vanier\Api\Helpers\JWTManager;
use Vanier\Api\Middleware\AppLoggingMiddleware;
use Vanier\Api\Middleware\JWTAuthMiddleware;

define('APP_BASE_DIR', __DIR__);
define('APP_LOG_DIR', APP_BASE_DIR.'/logs');
// IMPORTANT: This file must be added to your .ignore file. 
define('APP_ENV_CONFIG', 'config.env');

require __DIR__ . '/vendor/autoload.php';
// Include the file that contains the application's global configuration settings,
// database credentials, etc.
require_once __DIR__ . '/src/Config/app_config.php';
//--Step 1) Instantiate a Slim app.
$app = AppFactory::create();
//-- Add the routing and body parsing middleware.
$app->addRoutingMiddleware();

$jwt_secret = JWTManager::getSecretKey();

$app->add(new Vanier\Api\Middleware\JWTAuthMiddleware([
            'secret' => $jwt_secret,
            'algorithm' => 'HS256',
            'secure' => false, // only for localhost for prod and test env set true            
            "path" => $api_base_path, // the base path of the API
            "attribute" => "decoded_token_data",
            "ignore" => ["$api_base_path/token", "$api_base_path/account"],
            "error" => function ($response, $arguments) {
                $data["status"] = "error";
                $data["message"] = $arguments["message"];
                $response->getBody()->write(
                        json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
                );
                return $response->withHeader("Content-Type", "application/json;charset=utf-8");
            }
        ]));

// Routes for user account, loggin in and token generation.
$app->post("/token", "handleGetToken");
$app->post("/account", "handleCreateUserAccount");

$app->addBodyParsingMiddleware();
//-- Add error handling middleware.
// NOTE: the error middleware MUST be added last.
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->getDefaultErrorHandler()->forceContentType(APP_MEDIA_TYPE_JSON);

// TODO: change the name of the subdirectory here.
// You also need to change it in .htaccess
$app->setBasePath("/transportation-api");

// Here we include the file that contains the application routes. 
// NOTE: your routes must be managed in the api_routes.php file.
require_once __DIR__ . '/src/Routes/api_routes.php';

// This is a middleware that should be disabled/enabled later. 
//$app->add($beforeMiddleware);
// Run the app.
$app->run();

