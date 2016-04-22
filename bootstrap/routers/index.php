<?php
/**
 * @author Rizart Dokollar <r.dokollari@gmail.com
 * @since 4/22/16
 */
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $routerCollector) {
    $apiRoutes = require __DIR__.'/web.php';

    foreach ($apiRoutes as $route) {
        $routerCollector->addRoute($route['httpMethod'], $route['route'], $route['handler']);
    }
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars
        echo $handler;
        break;
}