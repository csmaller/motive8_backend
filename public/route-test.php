<?php
// Test if Laravel routing works
echo "<h2>Laravel Route Test</h2>";

try {
    require __DIR__.'/../laravel/vendor/autoload.php';
    $app = require_once __DIR__.'/../laravel/bootstrap/app.php';
    
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    // Create a request for /health
    $request = Illuminate\Http\Request::create('/health', 'GET');
    
    // Handle the request
    $response = $kernel->handle($request);
    
    echo "<strong>Response Status:</strong> " . $response->getStatusCode() . "<br>";
    echo "<strong>Response Content:</strong><br>";
    echo "<pre>" . $response->getContent() . "</pre>";
    
    $kernel->terminate($request, $response);
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
