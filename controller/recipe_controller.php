<?php
namespace Controllers;

use Models as Model;

include_once('recipe.php');
include_once('../model/recipe_db.php');

class UserLevelController {
    public static function getAllLevels() {
        $queryRes = Model\UserLevelDB::getUserLevels();

        if ($queryRes) {
            // process the results into an array of User Level objects
            $userLevels = array();
            foreach ($queryRes as $row) {
                $userLevels[] = new UserLevel($row['UserLevelNo'], $row['LevelName']);
            }

            // return the array of User Level information
            return $userLevels;
        } else {
            return false;
        }
    }
}