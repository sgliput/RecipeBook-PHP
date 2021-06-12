<?php

namespace Controllers;

use Models as Model;
use Utilities as Utility;

include_once('recipe.php');
include_once('../model/recipe_db.php');
require_once('../util/image_utilities.php');

class RecipeController
{

    //helper function to convert a db row into a Recipe object
    private static function rowToRecipe($row)
    {
        $recipe = new Recipe(
            $row['RecipeNo'],
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
            $row['UserNo']
        );
        $recipe->setRecipeNo($row['RecipeNo']);
        return $recipe;
    }

    public static function getAllPublicRecipes()
    {
        $queryRes = Model\RecipeDB::getPublicRecipes();

        if ($queryRes) {
            // process the results into an array of Recipe objects
            $recipes = array();
            foreach ($queryRes as $row) {
                $recipes[] = new Recipe(
                    $row['RecipeNo'],
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
                    $row['UserNo']
                );
            }

            // return the array of Recipe information
            return $recipes;
        } else {
            return false;
        }
    }

    public static function getAllRecipesForUser($userNo)
    {
        $queryRes = Model\RecipeDB::getRecipesForUser($userNo);

        if ($queryRes) {
            // process the results into an array of Recipe objects
            $recipes = array();
            foreach ($queryRes as $row) {
                $recipes[] = new Recipe(
                    $row['RecipeNo'],
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
                    $row['UserNo']
                );
            }

            // return the array of Recipe information
            return $recipes;
        } else {
            return false;
        }
    }

    // function to get a specific recipe by their RecipeNo
    public static function getRecipeByNo($recipeNo)
    {
        $queryRes = Model\RecipeDB::getRecipe($recipeNo);

        if ($queryRes) {
            // this query only returns a single row, so just process it
            return self::rowToRecipe($queryRes);
        } else {
            return false;
        }
    }

    // function to get recipes by search term
    public static function getPublicRecipesBySearchTerm($searchTerm) {
        $queryRes = Model\RecipeDB::searchPublicRecipes($searchTerm);

        if ($queryRes) {
            // process the results into an array of Recipe objects
            $recipes = array();
            foreach ($queryRes as $row) {
                $recipes[] = new Recipe(
                    $row['RecipeNo'],
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
                    $row['UserNo']
                );
            }

            // return the array of Recipe information
            return $recipes;
        } else {
            return false;
        }
    }

    public static function checkImageNotPresent($imgName, $recipeNo) {
        $imageNameNotPresent = Model\RecipeDB::checkSavedImages($imgName, $recipeNo);

        return $imageNameNotPresent;
    }

    // function to delete a recipe by their RecipeNo
    public static function deleteRecipe($recipeNo, $recipeImg)
    {
        // no special processing needed - just use the DB function
        return Model\RecipeDB::deleteRecipe($recipeNo, $recipeImg);
    }

    // function to add a recipe to the DB
    public static function addRecipe($recipe)
    {
        return Model\RecipeDB::addRecipe(
            $recipe->getRecipeName(),
            $recipe->getRecipeDescription(),
            $recipe->getRecipeSteps(),
            $recipe->getRecipeCookTime(),
            $recipe->getIngredient1(),
            $recipe->getIngredient2(),
            $recipe->getIngredient3(),
            $recipe->getIngredient4(),
            $recipe->getIngredient5(),
            $recipe->getIngredient6(),
            $recipe->getIngredient7(),
            $recipe->getIngredient8(),
            $recipe->getIngredient9(),
            $recipe->getIngredient10(),
            $recipe->getIsPublic(),
            $recipe->getImgFile(),
            $recipe->getUserNo()
        );
    }

    // function to update a recipe's information
    public static function updateRecipe($recipe)
    {
        $queryRes = Model\RecipeDB::getRecipe($recipe->getRecipeNo());

        if ($queryRes) {
            // this query only returns a single row, so just process it
            $origRecipe = self::rowToRecipe($queryRes);
            if ($origRecipe->getImgFile() != $recipe->getImgFile()) {
                // get images directory above current working directory (views)
                $dir = getcwd() . '/../images/';
                Utility\ImageUtilities::DeleteImageFiles($dir, $origRecipe->getImgFile());
            }
        } else {
            return false;
        }
        return Model\RecipeDB::updateRecipe(
            $recipe->getRecipeNo(),
            $recipe->getRecipeName(),
            $recipe->getRecipeDescription(),
            $recipe->getRecipeSteps(),
            $recipe->getRecipeCookTime(),
            $recipe->getIngredient1(),
            $recipe->getIngredient2(),
            $recipe->getIngredient3(),
            $recipe->getIngredient4(),
            $recipe->getIngredient5(),
            $recipe->getIngredient6(),
            $recipe->getIngredient7(),
            $recipe->getIngredient8(),
            $recipe->getIngredient9(),
            $recipe->getIngredient10(),
            $recipe->getIsPublic(),
            $recipe->getImgFile(),
            $recipe->getUserNo()
        );
    }
}
