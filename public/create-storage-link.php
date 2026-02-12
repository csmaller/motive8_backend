<?php
echo "<h2>Creating Storage Symlink</h2>";

$target = __DIR__ . '/../laravel/storage/app/public';
$link = __DIR__ . '/storage';

// Check what exists at the link location
if (file_exists($link)) {
    if (is_link($link)) {
        echo "Existing symlink found<br>";
        unlink($link);
        echo "Removed existing symlink<br>";
    } elseif (is_dir($link)) {
        echo "Regular directory found at storage location<br>";
        // Try to remove it (only if empty)
        if (@rmdir($link)) {
            echo "Removed empty directory<br>";
        } else {
            echo "⚠ Directory is not empty. Please manually delete/rename: $link<br>";
            echo "<br><strong>Manual fix:</strong><br>";
            echo "1. Rename or delete the 'storage' folder in public_html/api/<br>";
            echo "2. Run this script again<br>";
            exit;
        }
    } else {
        echo "File exists at storage location<br>";
        unlink($link);
        echo "Removed existing file<br>";
    }
}

// Create symlink
if (symlink($target, $link)) {
    echo "✓ Symlink created successfully!<br>";
    echo "Target: $target<br>";
    echo "Link: $link<br>";
    
    // Check if target directory exists
    if (is_dir($target)) {
        echo "✓ Target directory exists<br>";
        
        // List files in person_images
        $personImagesDir = $target . '/person_images';
        if (is_dir($personImagesDir)) {
            echo "<br><strong>Files in person_images:</strong><br>";
            $files = scandir($personImagesDir);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    echo "- $file<br>";
                }
            }
        } else {
            echo "⚠ person_images directory doesn't exist<br>";
        }
    } else {
        echo "✗ Target directory doesn't exist!<br>";
    }
} else {
    echo "✗ Failed to create symlink<br>";
    echo "Error: " . error_get_last()['message'] . "<br>";
}

echo "<br><strong>Delete this file after running!</strong>";
