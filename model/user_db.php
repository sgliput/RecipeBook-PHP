<?php
namespace Models;

require_once('database.php');

// class for users table queries
class UsersDB {
    // Get all users in the DB; returns false if the database connection fails
    public static function getUsers()
    {
        // get the DB connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // create the query string
            $query = 'SELECT *
                      FROM users
                      INNER JOIN user_levels
                      ON users.UserLevelNo = user_levels.UserLevelNo';

            // execute the query
            return $dbConn->query($query);
        } else {
            return false;
        }
    }

    // function to get a user by their userId
    public static function getUserByUserId($userId)
    {
        // get the DB connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // create the query string
            $query = "SELECT *
                      FROM users
                      INNER JOIN user_levels
                      ON users.UserLevelNo = user_levels.UserLevelNo
                      WHERE users.userId = '$userId'";

            // execute the query - returns false if no such email found
            $result = $dbConn->query($query);
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    // function to get a specific user by their UserNo
    public static function getUser($userNo) {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // create the query string
            $query = "SELECT *
                      FROM users
                      INNER JOIN user_levels
                      ON users.UserLevelNo = user_levels.UserLevelNo
                      WHERE users.userNo = '$userNo'";
            
            // execute the query
            $result = $dbConn->query($query);
            // return the associative array
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    // function to get all users in a specific user level;
    // returns false if the database connection fails
    public static function getUsersByLevel($userLevelNo) {
        // get the DB connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // create the query string
            $query = "SELECT * FROM users
                      INNER JOIN user_levels
                      ON users.UserLevelNo = user_levels.UserLevelNo'
                      WHERE users.UserLevelNo = '$userLevelNo'";
            
            // execute the query
            return $dbConn->query($query);
        } else {
            return false;
        }
    }


    // function to delete a user by their UserNo returns true on success, false on failure or database connection failure
    public static function deleteUser($userNo)
    {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // create the query string
            $query = "DELETE FROM users
                      WHERE UserNo = '$userNo'";

            // execute the query, returning status
            return $dbConn->query($query) === TRUE;
        } else {
            return false;
        }
    }

    // function to add a user to the DB; returns true on success, false on failure or DB connection failure
    public static function addUser(
        $userId,
        $password,
        $fName,
        $lName,
        $hireDate,
        $eMail,
        $extension,
        $userLevelNo
    ) {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {

            // create the query string - UserNo is an auto-increment field, so no need to specify it
            $query = "INSERT INTO users (UserId, Password, FirstName, LastName, HireDate, EMail, Extension, UserLevelNo)
                      VALUES ('$userId', '$password', '$fName', '$lName', '$hireDate', '$eMail', '$extension', '$userLevelNo')";

            // execute the query, returning status
            return $dbConn->query($query) === TRUE;
        } else {
            return false;
        }
    }

    // function to update a user's information; returns true on success, false on failure or DB connection failure
    public static function updateUser(
        $userNo,
        $userId,
        $password,
        $fName,
        $lName,
        $hireDate,
        $eMail,
        $extension,
        $userLevelNo
    ) {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // create the query string
            $query = "UPDATE users SET
                            UserId = '$userId',
                            Password = '$password',
                            FirstName = '$fName',
                            LastName = '$lName',
                            HireDate = '$hireDate',
                            EMail = '$eMail',
                            Extension = '$extension',
                            UserLevelNo = '$userLevelNo'
                          WHERE UserNo = '$userNo'";
            // execute the query, returning status
            return $dbConn->query($query) === TRUE;
        } else {
            return false;
        }
    }
}
