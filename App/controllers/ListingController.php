<?php

namespace App\Controllers;

use Framework\Database;

class ListingController {
    protected $db;

    //METHODS
    public function __construct() {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function index() {
        $listings = $this->db->query('SELECT * FROM listings ORDER BY created_at DESC')->fetchAll();

        loadView('/listings/index', [
            'listings' => $listings
        ]);
    }

    public function create() {
        loadView('/listings/create');
    }

    public function show($params) {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id =:id', $params)->fetch();

        //Check if listing exist
        if(!$listing) {
            ErrorController::notFound('This listing is not found');
            return;
        }

        loadView('/listings/show', [
            'listing' => $listing
        ]);
    }
}