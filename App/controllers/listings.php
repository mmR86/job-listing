<?php

$config = require basePath('config/db.php');
$db = new Database($config);

$listings = $db->query('SELECT * FROM listings ORDER BY created_at DESC')->fetchAll();

loadView('listings', [
    'listings' => $listings
]);