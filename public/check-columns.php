<?php
require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

echo "<h2>News Table Structure</h2>";

try {
    $columns = DB::select("SHOW COLUMNS FROM news");
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>{$column->Field}</td>";
        echo "<td>{$column->Type}</td>";
        echo "<td>{$column->Null}</td>";
        echo "<td>{$column->Key}</td>";
        echo "<td>{$column->Default}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<br><h2>Users Table ID Type</h2>";
    $userColumns = DB::select("SHOW COLUMNS FROM users WHERE Field = 'id'");
    echo "<pre>" . print_r($userColumns, true) . "</pre>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
