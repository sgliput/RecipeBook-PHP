<?php

namespace Models;
use Utilities as Utility;

require_once('database.php');
require_once('../util/image_utilities.php');

// class for doing recipe table queries; only gets all existing recipes for now
class RecipeDB
{
    // Get all recipes in the DB; returns false if the database connection fails
    public static function getPublicRecipes()
    {
        // get the DB connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {

            // create the query string
            $query = "SELECT *
                      FROM recipes
                      WHERE isPublic = true";

            // execute the query
            return $dbConn->query($query);
        } else {
            return false;
        }
    }

    // Get all recipes in the DB for a specific user; returns false if the database connection fails
    public static function getRecipesForUser($userNo)
    {
        // get the DB connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // prepare statement to avoid SQL injection
            $stmt = $dbConn->prepare('SELECT recipes.*
                                      FROM recipes
                                      INNER JOIN user_recipes
                                      ON recipes.recipeNo = user_recipes.recipeNo
                                      WHERE user_recipes.userNo = ?');

            $stmt->bind_param('i', $userNo); // 'i' specifies the variable type => 'integer'

            // execute the prepared statement
            $stmt->execute();

            return $stmt->get_result();
        } else {
            return false;
        }
    }

    // function to search public recipes by search term
    public static function searchPublicRecipes($searchTerm)
    {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            $searchWithWildcard = '%' . $searchTerm . '%';
            // prepare statement to avoid SQL injection
            $stmt = $dbConn->prepare("SELECT *
                                      FROM recipes
                                      WHERE (recipeName LIKE ?
                                             OR recipeDescription LIKE ?
                                             OR recipeSteps LIKE ?
                                             OR Ingredient1 LIKE ?
                                             OR Ingredient2 LIKE ?
                                             OR Ingredient3 LIKE ?
                                             OR Ingredient4 LIKE ?
                                             OR Ingredient5 LIKE ?
                                             OR Ingredient6 LIKE ?
                                             OR Ingredient7 LIKE ?
                                             OR Ingredient8 LIKE ?
                                             OR Ingredient9 LIKE ?
                                             OR Ingredient10 LIKE ?
                                            )
                                      AND isPublic = 1");

            $stmt->bind_param("sssssssssssss", $searchWithWildcard, // 's' specifies the variable type => 'string'
                                               $searchWithWildcard, 
                                               $searchWithWildcard, 
                                               $searchWithWildcard, 
                                               $searchWithWildcard, 
                                               $searchWithWildcard, 
                                               $searchWithWildcard, 
                                               $searchWithWildcard, 
                                               $searchWithWildcard, 
                                               $searchWithWildcard, 
                                               $searchWithWildcard, 
                                               $searchWithWildcard, 
                                               $searchWithWildcard); 

            // execute the prepared statement
            $stmt->execute();

            return $stmt->get_result();
        } else {
            return false;
        }
    }

    // function to get a specific recipe by their RecipeNo
    public static function getRecipe($recipeNo)
    {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // prepare statement to avoid SQL injection
            $stmt = $dbConn->prepare('SELECT *
                                      FROM recipes
                                      WHERE recipeNo = ?');

            $stmt->bind_param('i', $recipeNo); // 'i' specifies the variable type => 'integer'

            // execute the prepared statement
            $stmt->execute();
            // return the associative array
            return $stmt->get_result()->fetch_assoc();
        } else {
            return false;
        }
    }

    public static function checkSavedImages($imgName, $recipeNo)
    {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // prepare statement to avoid SQL injection
            $stmt = $dbConn->prepare('SELECT *
                                      FROM recipes
                                      WHERE ImgFile = ?
                                      AND RecipeNo != ?');

            $stmt->bind_param('si', $imgName, $recipeNo); // 'si' specifies two variable types => 'string' and 'integer'

            // execute the prepared statement
            $stmt->execute();
            $result = $stmt->get_result();

            // return boolean for whether rows were returned by query
            return (mysqli_num_rows($result) == 0) ? true : false;
        } else {
            return false;
        }
    }

    // function to delete a recipe by their RecipeNo returns true on success, false on failure or database connection failure
    // also deletes user_recipes records of users who saved that recipe
    public static function deleteRecipe($recipeNo, $recipeImg)
    {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // prepare statement to avoid SQL injection
            $stmt = $dbConn->prepare('DELETE FROM recipes
                                      WHERE RecipeNo = ?');

            $stmt->bind_param('i', $recipeNo); // 'i' specifies the variable type => 'integer'
            
            // new statement to delete record of deleted recipe from user's personal recipe book as well
            $stmt2 = $dbConn->prepare('DELETE FROM user_recipes
                                       WHERE RecipeNo = ?');
            $stmt2->bind_param('i', $recipeNo);
            // execute the prepared statements
            $stmt2->execute();
            $stmt->execute();
            
            if ($stmt->affected_rows == 1 && $stmt2->affected_rows == 1) {
                // get images directory above current working directory (views)
                $dir = getcwd() . '/../images/';
                $deleteImage = Utility\ImageUtilities::DeleteImageFiles($dir, $recipeImg);
            }

            // return query status
            return $stmt->affected_rows == 1 && $stmt2->affected_rows >= 1 && $deleteImage;
        } else {
            return false;
        }
    }

    // function to add a recipe to the DB; returns true on success, false on failure or DB connection failure
    public static function addRecipe(
        $recipeName,
        $recipeDescription,
        $recipeSteps,
        $recipeCookTime,
        $ingredient1,
        $ingredient2,
        $ingredient3,
        $ingredient4,
        $ingredient5,
        $ingredient6,
        $ingredient7,
        $ingredient8,
        $ingredient9,
        $ingredient10,
        $isPublic,
        $imgFile,
        $userNo
    ) {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // prepare statement to avoid SQL injection
            $stmt = $dbConn->prepare('INSERT INTO recipes (RecipeName, RecipeDescription, RecipeSteps, RecipeCookTime, Ingredient1, Ingredient2, 
                                                           Ingredient3, Ingredient4, Ingredient5, Ingredient6, Ingredient7, Ingredient8, Ingredient9, 
                                                           Ingredient10, IsPublic, ImgFile, UserNo)
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

            $stmt->bind_param('ssssssssssssssisi', $recipeName,         // 's' specifies the variable type => 'string'
                                                   $recipeDescription,  // 'i' specifies the variable type => 'integer'
                                                   $recipeSteps, 
                                                   $recipeCookTime, 
                                                   $ingredient1, 
                                                   $ingredient2, 
                                                   $ingredient3, 
                                                   $ingredient4, 
                                                   $ingredient5, 
                                                   $ingredient6, 
                                                   $ingredient7, 
                                                   $ingredient8, 
                                                   $ingredient9,
                                                   $ingredient10, 
                                                   $isPublic, 
                                                   $imgFile, 
                                                   $userNo); 

            // execute the prepared statement
            $stmt->execute();

            // new statement to add newly created recipe to user's personal recipe book
            $new_recipe_id = $stmt->insert_id;
            $stmt2 = $dbConn->prepare('INSERT INTO user_recipes (UserNo, RecipeNo)
                                       VALUES (?, ?)');
            $stmt2->bind_param('ii', $userNo, $new_recipe_id);
            // execute the prepared statement
            $stmt2->execute();
            
            // return boolean representing both queries' success
            return $stmt->affected_rows == 1 && $stmt2->affected_rows == 1;
        } else {
            return false;
        }
    }

    // function to update a recipe's information; returns true on success, false on failure or DB connection failure
    public static function updateRecipe(
        $recipeNo,
        $recipeName,
        $recipeDescription,
        $recipeSteps,
        $recipeCookTime,
        $ingredient1,
        $ingredient2,
        $ingredient3,
        $ingredient4,
        $ingredient5,
        $ingredient6,
        $ingredient7,
        $ingredient8,
        $ingredient9,
        $ingredient10,
        $isPublic,
        $imgFile,
        $userNo
    ) {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // prepare statement to avoid SQL injection
            $stmt = $dbConn->prepare('UPDATE recipes SET RecipeName = ?,
                                                         RecipeDescription = ?,
                                                         RecipeSteps = ?,
                                                         RecipeCookTime = ?,
                                                         Ingredient1 = ?,
                                                         Ingredient2 = ?,
                                                         Ingredient3 = ?,
                                                         Ingredient4 = ?,
                                                         Ingredient5 = ?,
                                                         Ingredient6 = ?,
                                                         Ingredient7 = ?,
                                                         Ingredient8 = ?,
                                                         Ingredient9 = ?,
                                                         Ingredient10 = ?,
                                                         IsPublic = ?,
                                                         ImgFile = ?,
                                                         UserNo = ?
                                      WHERE RecipeNo = ?');

            $stmt->bind_param('ssssssssssssssisii', $recipeName,        // 's' specifies the variable type => 'string'
                                                    $recipeDescription,  // 'i' specifies the variable type => 'integer'
                                                    $recipeSteps, 
                                                    $recipeCookTime, 
                                                    $ingredient1, 
                                                    $ingredient2, 
                                                    $ingredient3, 
                                                    $ingredient4, 
                                                    $ingredient5, 
                                                    $ingredient6, 
                                                    $ingredient7, 
                                                    $ingredient8, 
                                                    $ingredient9,
                                                    $ingredient10, 
                                                    $isPublic, 
                                                    $imgFile, 
                                                    $userNo,
                                                    $recipeNo); 

            // execute the prepared statement
            $stmt->execute();
            // return query status
            return $stmt->get_result() === TRUE;
        } else {
            return false;
        }
    }
}
