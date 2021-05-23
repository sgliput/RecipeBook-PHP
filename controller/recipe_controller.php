<?php
namespace Controllers;

use Models as Model;

include_once('recipe.php');
include_once('../model/recipe_db.php');

class UserLevelController {
    public static function getAllLevels() {
        $queryRes = Model\RecipeDB::getRecipes();

        if ($queryRes) {
            // process the results into an array of Recipe objects
            $recipes = array();
            foreach ($queryRes as $row) {
                $recipes[] = new Recipe($row['RecipeNo'], 
                                        $row['RecipeName'],
                                        $row['RecipeDescription'],
                                        $row['RecipeSteps'],
                                        $row['RecipeCookTime'],
                                        $row['Ingredient1'],
                                        $row['Ingredient2'],
                                        $row['Ingredient3'],
                                        $row['Ingredient4'],
                                        $row['Ingredient5'],
                                        $row['Ingredient6'],
                                        $row['Ingredient7'],
                                        $row['Ingredient8'],
                                        $row['Ingredient9'],
                                        $row['Ingredient10'],
                                        $row['IsPublic'],
                                        $row['ImgFile'],
                                        $row['UserNo']);
            }

            // return the array of Recipe information
            return $recipes;
        } else {
            return false;
        }
    }
}