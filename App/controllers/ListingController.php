<?php

namespace App\Controllers;

use Framework\Database;
use App\Controllers\Validation;

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

    public function store() {
        $allowedFields = ['title', 'description', 'salary', 'tags', 'company', 'adress', 'city', 'state', 'phone', 'email', 'requirements', 'benefits'];

        //usporedi key-eve od $_POST-a i flipnute key-eve od $allowedFiels-a, koji se podudaraju šibne ih u novi array a value ostane od prvog array-a, tj. ono što je ubačeno u formu
        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

        //hardkodano za sada zbog logiranja
        $newListingData['user_id'] = 1;

        //filtriramo special karaktere i druga sranja
        $newListingData = array_map('sanitize', $newListingData);

        $requiredFields = ['title', 'description', 'email', 'salary', 'city', 'state'];

        $errors = [];

        foreach($requiredFields as $field) {
            if(empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
                $errors[$field] = ucfirst($field) . ' is Required!';
            }
        }
        
        if(!empty($errors)) {
            //Reload view with errors
            loadView('listings/create', [
                'errors' => $errors,
                'listings' => $newListingData
            ]);
        } else {
            //Submit data || we need to build dinamicaly what fields to insert, because we want only the ones that have data, u principu trebaju nam doslovno stringovi koji idu unutar SQL query-a
            //what to insert INTO listings
            $fields = [];

            foreach($newListingData as $field => $value) {
                //adding all entry fields, empty or not into fields array
                $fields[] = $field;
            }
            // turning the fields array into comma separated list
            $fields = implode(', ', $fields);

            //creating placeholders
            $values = [];

            foreach($newListingData as $field => $value) {
                //Convert empty strings to null
                if($value === '') {
                    $newListingData[$field] = null;
                }
                $values[] = ':' . $field;
            }
            $values = implode(', ', $values);

            $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";

            $this->db->query($query, $newListingData);

            //Set flash message
            $_SESSION['success_message'] = 'Listing created succesfully!';

            redirect('/listings');
        }
    }

    public function destroy($params) {
        $id = $params['id'];

        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        if(!$listing) {
            ErrorController::notFound('Listing not found!');
            return;
        }

        $this->db->query('DELETE FROM listings WHERE id = :id', $params);

        //Set flash message
        $_SESSION['success_message'] = 'Listing deleted succesfully!';

        redirect('/listings');


    }
}