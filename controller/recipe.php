<?php
namespace Controllers;

// Recipe class to represent a single entry in the recipes table
class Recipe {
    // class properties - match the columns in the recipes table; 
    // control access via get/set methods and the constructor
    private $recipeNo;
    private $recipeName;
    private $recipeDescription;
    private $recipeSteps;
    private $recipeCookTime;
    private $ingredient1;
    private $ingredient2;
    private $ingredient3;
    private $ingredient4;
    private $ingredient5;
    private $ingredient6;
    private $ingredient7;
    private $ingredient8;
    private $ingredient9;
    private $ingredient10;
    private $isPublic;
    private $imgFile;
    private $userNo;

    public function __construct($recipeNo, $recipeName, $recipeDescription, $recipeSteps, $recipeCookTime, $ingredient1, $ingredient2, 
                                $ingredient3, $ingredient4, $ingredient5, $ingredient6, $ingredient7, $ingredient8, $ingredient9, 
                                $ingredient10, $isPublic, $imgFile, $userNo ) {
        $this->recipeNo = $recipeNo;
        $this->recipeName = $recipeName;
        $this->recipeDescription = $recipeDescription;
        $this->recipeSteps = $recipeSteps;
        $this->recipeCookTime = $recipeCookTime;
        $this->ingredient1 = $ingredient1;
        $this->ingredient2 = $ingredient2;
        $this->ingredient3 = $ingredient3;
        $this->ingredient4 = $ingredient4;
        $this->ingredient5 = $ingredient5;
        $this->ingredient6 = $ingredient6;
        $this->ingredient7 = $ingredient7;
        $this->ingredient8 = $ingredient8;
        $this->ingredient9 = $ingredient9;
        $this->ingredient10 = $ingredient10;
        $this->isPublic = $isPublic;
        $this->imgFile = $imgFile;
        $this->userNo = $userNo;
    }

    // get and set the recipeNo property
    public function getRecipeNo() {
        return $this->recipeNo;
    }
    public function setRecipeNo($value) {
        $this->recipeNo = $value;
    }

    // get and set the recipeName property
    public function getRecipeName() {
        return $this->recipeName;
    }
    public function setRecipeName($value) {
        $this->recipeName = $value;
    }

    // get and set the recipeDescription property
    public function getRecipeDescription() {
        return $this->recipeDescription;
    }
    public function setRecipeDescription($value) {
        $this->recipeDescription = $value;
    }

    // get and set the recipeSteps property
    public function getRecipeSteps() {
        return $this->recipeSteps;
    }
    public function setRecipeSteps($value) {
        $this->recipeSteps = $value;
    }

    // get and set the recipeCookTime property
    public function getRecipeCookTime() {
        return $this->recipeCookTime;
    }
    public function setRecipeCookTime($value) {
        $this->recipeCookTime = $value;
    }

    // get and set the ingredient1 property
    public function getIngredient1() {
        return $this->ingredient1;
    }
    public function setIngredient1($value) {
        $this->ingredient1 = $value;
    }

    // get and set the ingredient1 property
    public function getIngredient2() {
        return $this->ingredient2;
    }
    public function setIngredient2($value) {
        $this->ingredient2 = $value;
    }

    // get and set the ingredient3 property
    public function getIngredient3() {
        return $this->ingredient3;
    }
    public function setIngredient3($value) {
        $this->ingredient3 = $value;
    }

    // get and set the ingredient4 property
    public function getIngredient4() {
        return $this->ingredient4;
    }
    public function setIngredient4($value) {
        $this->ingredient4 = $value;
    }

    // get and set the ingredient5 property
    public function getIngredient5() {
        return $this->ingredient5;
    }
    public function setIngredient5($value) {
        $this->ingredient5 = $value;
    }

    // get and set the ingredient6 property
    public function getIngredient6() {
        return $this->ingredient6;
    }
    public function setIngredient6($value) {
        $this->ingredient6 = $value;
    }

    // get and set the ingredient7 property
    public function getIngredient7() {
        return $this->ingredient7;
    }
    public function setIngredient7($value) {
        $this->ingredient7 = $value;
    }

    // get and set the ingredient5 property
    public function getIngredient8() {
        return $this->ingredient8;
    }
    public function setIngredient8($value) {
        $this->ingredient8 = $value;
    }

    // get and set the ingredient9 property
    public function getIngredient9() {
        return $this->ingredient9;
    }
    public function setIngredient9($value) {
        $this->ingredient9 = $value;
    }

    // get and set the ingredient10 property
    public function getIngredient10() {
        return $this->ingredient10;
    }
    public function setIngredient10($value) {
        $this->ingredient10 = $value;
    }

    // get and set the isPublic property
    public function getIsPublic() {
        return $this->isPublic;
    }
    public function setIsPublic($value) {
        $this->isPublic = $value;
    }

    // get and set the imgFile property
    public function getImgFile() {
        return $this->imgFile;
    }
    public function setImgFile($value) {
        $this->imgFile = $value;
    }

    // get and set the userNo property
    public function getUserNo() {
        return $this->userNo;
    }
    public function setUserNo($value) {
        $this->userNo = $value;
    }
}
