<?php
require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "<h2>Registered Routes</h2>";

try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Method</th><th>URI</th><th>Name</th><th>Action</th></tr>";
    
    foreach ($routes as $route) {
        $methods = implode('|', $route->methods());
        if (strpos($route->uri(), 'auth') !== false || strpos($route->uri(), 'admin') !== false || strpos($route->uri(), 'login') !== false) {
            echo "<tr>";
            echo "<td>{$methods}</td>";
            echo "<td>{$route->uri()}</td>";
            echo "<td>{$route->getName()}</td>";
            echo "<td>{$route->getActionName()}</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    
    echo "<br><h3>All Routes Count: " . count($routes) . "</h3>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
