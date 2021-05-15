<?php
namespace Models;

require_once('database.php');

// class for doing user_levels table queries; only gets all existing user levels for now
class UserLevelDB {
    // Get all user levels in the DB; returns false if the database connection fails
    public static function getUserLevels() {
        // get the DB connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // create the query string
            $query = 'SELECT * FROM user_levels';

            // execute the query
            return $dbConn->query($query);
        } else {
            return false;
        }
    }
}