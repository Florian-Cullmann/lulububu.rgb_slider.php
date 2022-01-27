<?php

// do your mysql stuff here and rename the file to "db_config.php" (for best practice: copy it!)
$db_c = [
    'host' => 'localhost',
    'user' => 'user',
    'password' => 'password',
    'database' => 'database'
];

$db = new mysqli($db_c['host'], $db_c['user'], $db_c['password'], $db_c['database']);