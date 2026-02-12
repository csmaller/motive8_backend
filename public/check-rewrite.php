<?php
echo "<h2>Apache Module Check</h2>";

// Check if mod_rewrite is loaded
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    echo "<strong>mod_rewrite enabled:</strong> " . (in_array('mod_rewrite', $modules) ? 'YES ✓' : 'NO ✗') . "<br>";
    echo "<br><strong>All loaded modules:</strong><br>";
    echo "<pre>" . print_r($modules, true) . "</pre>";
} else {
    echo "Cannot check modules (apache_get_modules not available)<br>";
    echo "This is common on IONOS shared hosting<br>";
}

echo "<br><h3>Server Info:</h3>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "PHP Version: " . phpversion() . "<br>";

// Check if .htaccess is being read
echo "<br><h3>.htaccess Test:</h3>";
echo "If you can see this file, .htaccess might not be blocking it properly.<br>";
