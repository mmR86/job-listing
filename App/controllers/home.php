<?php

use Framework\Database;

$config = require basePath('config/db.php');
$db = new Database($config);

$listings = $db->query('SELECT * FROM listings ORDER BY created_at DESC LIMIT 6')->fetchAll();

loadView('home', [
    'listings' => $listings
]);