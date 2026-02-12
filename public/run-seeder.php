<?php
// SECURITY: Remove this file after running!
$password = 'TomBradyIsGod12'; // Change this!

if (!isset($_GET['password']) || $_GET['password'] !== $password) {
    die('Unauthorized');
}

echo "<h2>Running Product Seeder</h2>";

try {
    require __DIR__.'/../laravel/vendor/autoload.php';
    $app = require_once __DIR__.'/../laravel/bootstrap/app.php';
    
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    // Run seeder
    $exitCode = $kernel->call('db:seed', [
        '--class' => 'ProductSeeder',
        '--force' => true,
    ]);
    
    echo "<pre>";
    echo $kernel->output();
    echo "</pre>";
    
    if ($exitCode === 0) {
        echo "<br><strong style='color: green;'>✓ Seeder completed successfully!</strong>";
    } else {
        echo "<br><strong style='color: red;'>✗ Seeder failed with exit code: $exitCode</strong>";
    }
    
} catch (Exception $e) {
    echo "<strong style='color: red;'>✗ Error:</strong> " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<br><br><strong style='color: red;'>IMPORTANT: Delete this file after running!</strong>";
