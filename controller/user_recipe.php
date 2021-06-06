<?php
namespace Controllers;

// Class to represent an entry in the users table
class UserRecipe {
    // properties - match the columns in the user_recipes table
    private $recipeNo;
    private $userNo;

    public function __construct($recipeNo, $userNo)
    {
        $this->recipeNo = $recipeNo;
        $this->userNo = $userNo;
    }

    // get and set the user_recipe properties
    public function getRecipeNo() {
        return $this->recipeNo;
    }
    public function setRecipeNo($value) {
        $this->recipeNo = $value;
    }

    public function getUserNo() {
        return $this->userNo;
    }
    public function setUserNo($value) {
        $this->userNo = $value;
    }

    
}