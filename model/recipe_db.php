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

    // function to get a specific recipe by their RecipeNo
    public static function getRecipe($recipeNo) {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // create the query string
            $query = "SELECT *
                      FROM recipes
                      WHERE recipeNo = '$recipeNo'";
            
            // execute the query
            $result = $dbConn->query($query);
            // return the associative array
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    // function to delete a recipe by their RecipeNo returns true on success, false on failure or database connection failure
    public static function deleteRecipe($recipeNo)
    {
        // get the database connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            // create the query string
            $query = "DELETE FROM recipes
                      WHERE RecipeNo = '$recipeNo'";

            // execute the query, returning status
            return $dbConn->query($query) === TRUE;
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

            // create the query string - RecipeNo is an auto-increment field, so no need to specify it
            $query = "INSERT INTO recipes (RecipeName, RecipeDescription, RecipeSteps, RecipeCookTime, Ingredient1, Ingredient2, 
                                           Ingredient3, Ingredient4, Ingredient5, Ingredient6, Ingredient7, Ingredient8, Ingredient9, 
                                           Ingredient10, IsPublic, ImgFile, UserNo)
                      VALUES ('$recipeName', '$recipeDescription', '$recipeSteps', '$recipeCookTime', '$ingredient1', '$ingredient2', 
                              '$ingredient3', '$ingredient4', '$ingredient5', '$ingredient6', '$ingredient7', '$ingredient8', '$ingredient9',
                              '$ingredient10', '$isPublic', '$imgFile', '$userNo)";

            // execute the query, returning status
            return $dbConn->query($query) === TRUE;
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
            // create the query string
            $query = "UPDATE recipes SET
                            RecipeName = '$recipeName',
                            RecipeDescription = '$recipeDescription',
                            RecipeSteps = '$recipeSteps',
                            RecipeCookTime = '$recipeCookTime',
                            Ingredient1 = '$ingredient1',
                            Ingredient2 = '$ingredient2',
                            Ingredient3 = '$ingredient3',
                            Ingredient4 = '$ingredient4',
                            Ingredient5 = '$ingredient5',
                            Ingredient6 = '$ingredient6',
                            Ingredient7 = '$ingredient7',
                            Ingredient8 = '$ingredient8',
                            Ingredient9 = '$ingredient9',
                            Ingredient10 = '$ingredient10',
                            IsPublic = '$isPublic',
                            ImgFile = '$imgFile',
                            UserNo = '$userNo'
                          WHERE RecipeNo = '$recipeNo'";
            // execute the query, returning status
            return $dbConn->query($query) === TRUE;
        } else {
            return false;
        }
    }
}