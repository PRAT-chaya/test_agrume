<?php
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Application\Controllers\SignupController;

require __DIR__ . '/../vendor/autoload.php';

// Create Container using PHP-DI
$container = new Container();

// Set container using PHP-DI
AppFactory::setContainer($container);

// Instantiate app
$app = AppFactory::create();

/*
// Register routes
$routes = require __DIR__ . '/../app/routes.php';
$routes($app);
*/

// Add Error Handling Middleware
$app->addErrorMiddleware(true, false, false);

//Route: /hi/{name}
$app->get('/hi/{name}', function (Request $request, Response $response, $args) {
    $name = $args['name'];
    $response->getBody()->write("Oh hi, $name");
    return $response;
});

$app->any('/signup/form', function(Request $request, Response $response, $args) {
	$controller = new SignupController('/signup/form');
	if($controller->POSTHasUB())
	{
		$controller->saveNewUser($_POST);
	} else {
		$controller->newUser();
	}
	$controller->getView()->render();
	return $response;
});

$app->run();