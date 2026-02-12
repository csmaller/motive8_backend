<?php
// Quick cache clear script for IONOS
echo "<h2>Laravel Cache Clear</h2>";

try {
    require __DIR__.'/../laravel/vendor/autoload.php';
    $app = require_once __DIR__.'/../laravel/bootstrap/app.php';
    
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    // Clear config cache
    $kernel->call('config:clear');
    echo "✓ Config cache cleared<br>";
    
    // Clear route cache
    $kernel->call('route:clear');
    echo "✓ Route cache cleared<br>";
    
    // Clear application cache
    $kernel->call('cache:clear');
    echo "✓ Application cache cleared<br>";
    
    // Clear view cache
    $kernel->call('view:clear');
    echo "✓ View cache cleared<br>";
    
    echo "<br><strong>All caches cleared successfully!</strong><br>";
    echo "<br>Now try: <a href='/api/health'>/api/health</a>";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
