<?php
namespace Models;

require_once('database.php');

// class for doing recipe table queries; only gets all existing recipes for now
class RecipeDB {
    // Get all recipes in the DB; returns false if the database connection fails
    public static function getRecipes() {
        // get the DB connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // create the query string
            $query = 'SELECT * FROM recipes';

            // execute the query
            return $dbConn->query($query);
        } else {
            return false;
        }
    }
}