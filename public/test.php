<?php
echo "PHP is working!<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";

// Check if Laravel paths exist
$laravelPath = __DIR__.'/../laravel';
echo "<br>Laravel folder exists: " . (is_dir($laravelPath) ? 'YES' : 'NO') . "<br>";
echo "Laravel path: " . realpath($laravelPath) . "<br>";

// Check if vendor exists
$vendorPath = __DIR__.'/../laravel/vendor';
echo "Vendor folder exists: " . (is_dir($vendorPath) ? 'YES' : 'NO') . "<br>";

// Check if bootstrap exists
$bootstrapPath = __DIR__.'/../laravel/bootstrap/app.php';
echo "Bootstrap file exists: " . (file_exists($bootstrapPath) ? 'YES' : 'NO') . "<br>";

// Try to load Laravel
try {
    require __DIR__.'/../laravel/vendor/autoload.php';
    echo "<br>✓ Autoload successful<br>";
    
    $app = require_once __DIR__.'/../laravel/bootstrap/app.php';
    echo "✓ Laravel app loaded<br>";
    
    echo "✓ App environment: " . $app->environment() . "<br>";
} catch (Exception $e) {
    echo "<br>✗ Error: " . $e->getMessage() . "<br>";
}
