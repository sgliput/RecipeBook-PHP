<?php
namespace Controllers;

use Models as Model;

require_once('../model/user_db.php');
require_once('user.php');
require_once('recipe.php');

class UserController
{
    //helper function to convert a db row into a User object
    private static function rowToUser($row)
    {
        $user = new User($row['Username'],
                         $row['UserEmail'],
                         $row['UserPassword']
        );
        $user->setUserNo($row['UserNo']);
        return $user;
    }

    // function to check login credentials - return true if user is valid, false otherwise
    public static function validUser($username, $password)
    {
        $queryRes = Model\UsersDB::getUserByUsername($username);

        if ($queryRes) {
            // process the user row
            $user = self::rowToUser($queryRes);
            if ($user->getPassword() === $password) {
                return $user->getUserNo();
            } else {
                return -1;
            }
        } else {
            // either no such user or db connect failed
            // either way, can't validate the user
            return false;
        }
    }

    // function to get all users in the database
    public static function getAllUsers()
    {
        $queryRes = Model\UsersDB::getUsers();

        if ($queryRes) {
            // process the results into an array - allows the UI to not care about the DB structure
            $users = array();
            foreach ($queryRes as $row) {
                // process each row into an array of
                // User objects (i.e. "users")
                $users[] = self::rowToUser($row);
            }

            return $users;
        } else {
            return false;
        }
    }

    // function to get a specific user by their UserNo
    public static function getUserByNo($userNo)
    {
        $queryRes = Model\UsersDB::getUser($userNo);

        if ($queryRes) {
            // this query only returns a single row, so just process it
            return self::rowToUser($queryRes);
        } else {
            return false;
        }
    }

    // function to delete a user by their UserNo
    public static function deleteUser($userNo)
    {
        // no special processing needed - just use the DB function
        return Model\UsersDB::deleteUser($userNo);
    }

    // function to add a user to the DB
    public static function addUser($user)
    {
        return Model\UsersDB::addUser(
            $user->getUsername(),
            $user->getUserEmail(),
            $user->getPassword()
        );
    }

    // function to update a user's information
    public static function updateUser($user)
    {
        return Model\UsersDB::updateUser(
            $user->getUserNo(),
            $user->getUsername(),
            $user->getUserEmail(),
            $user->getPassword()
        );
    }
}
