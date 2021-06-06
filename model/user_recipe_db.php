<?php
namespace Models;

require_once('database.php');

// class for doing recipe table queries; only gets all existing recipes for now
class UserRecipeDB {

    // function to add an entry to user_recipe table (recipe saved to user's recipe book); 
    // returns true on success, false on failure or DB connection failure
    public static function saveRecipeToPrivateRecipeBook($userNo, $recipeNo) {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // prepare statement to avoid SQL injection
            $stmt = $dbConn->prepare('INSERT INTO user_recipes (UserNo, RecipeNo)
                                      VALUES (?, ?)');

            $stmt->bind_param('ii', $userNo, $recipeNo); // 'i' specifies the variable type => 'integer'

            // execute the prepared statement
            $stmt->execute();
            // return query status
            return $stmt->get_result() === TRUE;
        } else {
            return false;
        }
    }

    public static function checkIfRecipeAlreadySaved($userNo, $recipeNo) {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // prepare statement to avoid SQL injection
            $stmt = $dbConn->prepare('SELECT *
                                      FROM user_recipes
                                      WHERE UserNo = ?
                                      AND RecipeNo = ?');

            $stmt->bind_param('ii', $userNo, $recipeNo); // 'i' specifies the variable type => 'integer'

            // execute the prepared statement
            $stmt->execute();

            // store query result and array
            $result = $stmt->get_result();
            $result_array = $result->fetch_assoc();

            // return either the existing recipe's SavedRecipeNo or false if not present
            return (mysqli_num_rows($result) > 0) ? $result_array['SavedRecipeNo'] : false;
        } else {
            return false;
        }
    }

    public static function unsaveRecipeFromPrivateRecipeBook($savedRecipeNo) {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // prepare statement to avoid SQL injection
            $stmt = $dbConn->prepare('DELETE FROM user_recipes
                                      WHERE SavedRecipeNo = ?');

            $stmt->bind_param('i', $savedRecipeNo); // 'i' specifies the variable type => 'integer'

            // execute the prepared statement
            $stmt->execute();
            // return query status
            return $stmt->get_result() === TRUE;
        } else {
            return false;
        }
    }
}