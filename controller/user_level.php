<?php
namespace Controllers;

// UserLevel class to represent a single entry in the User Levels table
class UserLevel {
    // class properties - match the columns in the User Levels table; 
    // control access via get/set methods and the constructor
    private $userLevelNo;
    private $levelName;

    public function __construct($userLevelNo, $levelName) {
        $this->userLevelNo = $userLevelNo;
        $this->levelName = $levelName;
    }

    // get and set the userLevelNo property
    public function getUserLevelNo() {
        return $this->userLevelNo;
    }
    public function setUserLevelNo($value) {
        $this->userLevelNo = $value;
    }

    // get and set the levelName property
    public function getLevelName() {
        return $this->levelName;
    }
    public function setLevelName($value) {
        $this->levelName = $value;
    }
}