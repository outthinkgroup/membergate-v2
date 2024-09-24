<?php
// Files with lots of small classes
spl_autoload_register(function ($class) {
    // namespace ends with directory where a DTO file with all classes in it 
    $classMap = [
        'Membergate\\DTO\\Rules' => __DIR__ . '/src/DTO/Rules/DTO.php',
    ];

    // Check if the class is in the map
    $parts = explode("\\", $class);
    $dir = join("\\",array_slice($parts, 0, -1));
    
    if (isset($classMap[$dir])) {
        require_once $classMap[$dir];
    }
});
