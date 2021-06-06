<?php

namespace Controllers;

use Models as Model;

include_once('user_recipe.php');
include_once('../model/user_recipe_db.php');

class UserRecipeController
{

    // function to save a recipe to a user's personal recipe book
    public static function saveRecipe($userNo, $recipeNo) {
        return Model\UserRecipeDB::saveRecipeToPrivateRecipeBook($userNo, $recipeNo);
    }

    public static function checkIfRecipeSaved($userNo, $recipeNo) {
        return Model\UserRecipeDB::checkIfRecipeAlreadySaved($userNo, $recipeNo);
    }

    // function to unsave a recipe from a user's personal recipe book
    public static function unsaveRecipe($savedRecipeNo) {
        return Model\UserRecipeDB::unsaveRecipeFromPrivateRecipeBook($savedRecipeNo);
    }
}