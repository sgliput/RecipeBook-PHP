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
                      FROM users';

            // execute the query
            return $dbConn->query($query);
        } else {
            return false;
        }
    }

    // function to get a user by their username
    public static function getUserByUsername($username)
    {
        // get the DB connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
             // prepare statement to avoid SQL injection
             $stmt = $dbConn->prepare('SELECT *
                                       FROM users
                                       WHERE users.username = ?');

            $stmt->bind_param('s', $username); // 's' specifies the variable type => 'string'

            // execute the prepared statement
            $stmt->execute();
            // return user array or false if no such user found
            return $stmt->get_result()->fetch_assoc();
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
            // prepare statement to avoid SQL injection
            $stmt = $dbConn->prepare('SELECT *
                                      FROM users
                                      WHERE users.userNo = ?');

            $stmt->bind_param('i', $userNo); // 'i' specifies the variable type => 'integer'

            // execute the prepared statement
            $stmt->execute();
            // return user array or false if no such user found
            return $stmt->get_result()->fetch_assoc();
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
            // prepare statement to avoid SQL injection
            $stmt = $dbConn->prepare('DELETE FROM users
                                      WHERE UserNo = ?');

            $stmt->bind_param('i', $userNo); // 'i' specifies the variable type => 'integer'

            // execute the prepared statement
            $stmt->execute();
            // return query status
            return $stmt->get_result() === TRUE;
        } else {
            return false;
        }
    }

    // function to add a user to the DB; returns true on success, false on failure or DB connection failure
    public static function addUser(
        $username,
        $email,
        $password
    ) {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();
        // encrypt password for storage in database
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        if ($dbConn) {
            // prepare statement to avoid SQL injection
            $stmt = $dbConn->prepare('INSERT INTO users (Username, UserEmail, UserPassword)
                                      VALUES (?, ?, ?)');

            $stmt->bind_param('sss', $username, $email, $hashed_password); // 's' specifies the variable type => 'string'

            // execute the prepared statement
            $stmt->execute();

            // return query status
            return $stmt->get_result() === TRUE;
        } else {
            return false;
        }
    }

    // function to update a user's information; returns true on success, false on failure or DB connection failure
    public static function updateUser(
        $userNo,
        $username,
        $email,
        $password
    ) {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            if (strlen($password) === 0) {
                $stmt = $dbConn->prepare('UPDATE users 
                                          SET Username = ?,
                                              UserEmail = ?
                                          WHERE UserNo = ?');

                $stmt->bind_param('ssi', $username, $email, $userNo); // 's' specifies the variable type => 'string'

            } else {
                // encrypt password for storage in database
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                // prepare statement to avoid SQL injection
                $stmt = $dbConn->prepare('UPDATE users 
                                          SET Username = ?,
                                              UserEmail = ?,
                                              UserPassword = ?
                                          WHERE UserNo = ?');

                $stmt->bind_param('sssi', $username, $email, $hashed_password, $userNo); // 's' specifies the variable type => 'string'
                                                                                         // 'i' specifies the variable type => 'integer'
            }
            // execute the prepared statement
            $stmt->execute();
            // return query status
            return $stmt->get_result() === TRUE;
        } else {
            return false;
        }
    }
}
