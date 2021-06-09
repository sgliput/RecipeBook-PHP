<?php

use Controllers as Controller;
use Utilities as Utility;

session_start();
require_once('../controller/user.php');
require_once('../controller/user_controller.php');
require_once('../controller/recipe.php');
require_once('../controller/recipe_controller.php');
require_once('validator.php');
require_once('../util/security.php');
require_once('../util/image_utilities.php');

// confirm user is authorized for the page
Utility\Security::checkAuthority('logged_in');

// user clicked the logout button
if (isset($_POST['logout'])) {
    Utility\Security::logout();
}

// default recipe for add - empty strings
$recipe = new Controller\Recipe('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
$recipe->setRecipeNo(-1);
$pageTitle = "Add a New Recipe";
$navTab = "Add Recipe";
$editMode = false;
$userNo = $_SESSION['userNo'];
$image = "";
$imgDir = getcwd() . '/../images/';

// Declare and clear variables for error messages
$recipe_name_error = '';
$recipe_description_error = '';
$recipe_cook_time_error = '';
$ingredient1_error = '';
$ingredient2_error = '';
$recipe_steps_error = '';
$is_public_error = '';
$image_error = '';

// Retrieve the recipeNo from the query string and use it to create a recipe object for that recipeNo
if (isset($_GET['recipeNo'])) {
    $recipe = Controller\RecipeController::getRecipeByNo($_GET['recipeNo']);
    $pageTitle = "Update an Existing Recipe";
    $navTab = "Edit Recipe";
    $editMode = true;
}

// Retrieve values from query string and store in recipe object
// as long as the query string exists (which it does not on first load of a page).
if (isset($_POST['recipeName']))
    $recipe->setRecipeName($_POST['recipeName']);
if (isset($_POST['recipeDescription']))
    $recipe->setRecipeDescription($_POST['recipeDescription']);
if (isset($_POST['recipeSteps']))
    $recipe->setRecipeSteps($_POST['recipeSteps']);
if (isset($_POST['recipeCookTime']))
    $recipe->setRecipeCookTime($_POST['recipeCookTime']);
if (isset($_POST['ingredient1']))
    $recipe->setIngredient1($_POST['ingredient1']);
if (isset($_POST['ingredient2']))
    $recipe->setIngredient2($_POST['ingredient2']);
if (isset($_POST['ingredient3']))
    $recipe->setIngredient3($_POST['ingredient3']);
if (isset($_POST['ingredient4']))
    $recipe->setIngredient4($_POST['ingredient4']);
if (isset($_POST['ingredient5']))
    $recipe->setIngredient5($_POST['ingredient5']);
if (isset($_POST['ingredient6']))
    $recipe->setIngredient6($_POST['ingredient6']);
if (isset($_POST['ingredient7']))
    $recipe->setIngredient7($_POST['ingredient7']);
if (isset($_POST['ingredient8']))
    $recipe->setIngredient8($_POST['ingredient8']);
if (isset($_POST['ingredient9']))
    $recipe->setIngredient9($_POST['ingredient9']);
if (isset($_POST['ingredient10']))
    $recipe->setIngredient10($_POST['ingredient10']);
if (isset($_POST['isPublic']))
    $recipe->setIsPublic($_POST['isPublic']);
if (isset($_POST['imgFile']))
    $recipe->setImgFile($_POST['imgFile']);

if (isset($_POST['clear'])) {
    $image_error = '';
    $_FILES['imgFileSelect'] = null;
}

// when save button is clicked
if (isset($_POST['save'])) {
    // Validate the values entered

    // Call validation methods for values
    $recipe_name_error = validator\recipeNameValid($recipe->getRecipeName());
    $recipe_description_error = validator\requiredValid($recipe->getRecipeDescription());
    $recipe_cook_time_error = validator\requiredValid($recipe->getRecipeCookTime());
    $ingredient1_error = validator\requiredValid($recipe->getIngredient1());
    $ingredient2_error = validator\requiredValid($recipe->getIngredient2());
    $recipe_steps_error = validator\requiredValid($_POST['recipeSteps']);

    if (!isset($_POST['isPublic'])) {
        $is_public_error = "Please choose one.";
    }

    // User wants to upload a new file
    if (!empty($_FILES['imgFileSelect']) && isset($_POST['imgFile']) && $_POST['imgFile'] != '') {
        if (Controller\RecipeController::checkImageNotPresent($_POST['imgFile'], $_POST['recipeNo'])) {
            $target = $imgDir . $_POST['imgFile'];
            if (!file_exists($target)) {
                move_uploaded_file($_FILES['imgFileSelect']['tmp_name'], $target);
            }
            try {
                @Utility\ImageUtilities::ProcessImage($target);
            } catch (Exception $e) {
                $image_error = $e->getMessage();
            }
        } else {
            $image_error = "Please rename image.";
        }
    }

    // verify no errors exist before submitting form
    if (
        strlen($recipe_name_error) === 0 && strlen($recipe_description_error) === 0 && strlen($recipe_cook_time_error) === 0 &&
        strlen($ingredient1_error) === 0 && strlen($ingredient2_error) === 0 && strlen($is_public_error) === 0 &&
        strlen($recipe_steps_error) === 0 && strlen($image_error) === 0
    ) {
        // save button - perform add or update
        $recipe = new Controller\Recipe(
            $_POST['recipeNo'],
            trim($_POST['recipeName']),
            trim($_POST['recipeDescription']),
            trim($_POST['recipeSteps']),
            trim($_POST['recipeCookTime']),
            trim($_POST['ingredient1']),
            trim($_POST['ingredient2']),
            trim($_POST['ingredient3']),
            trim($_POST['ingredient4']),
            trim($_POST['ingredient5']),
            trim($_POST['ingredient6']),
            trim($_POST['ingredient7']),
            trim($_POST['ingredient8']),
            trim($_POST['ingredient9']),
            trim($_POST['ingredient10']),
            $_POST['isPublic'],
            trim($_POST['imgFile']),
            $userNo
        );
        $recipe->setRecipeNo($_POST['recipeNo']);

        if ($recipe->getRecipeNo() === '-1') {
            // add recipe
            Controller\RecipeController::addRecipe($recipe);
            // go to personal recipe book
            header('Location: ./personal_recipebook.php');
        } else {
            // update recipe
            Controller\RecipeController::updateRecipe($recipe);
            // Go to updated recipe
            header('Location: ./single_recipe.php?recipeNo=' . $recipe->getRecipeNo());
        }
    }
}

if (isset($_POST['cancel'])) {
    // cancel button - just go back to list
    if ($editMode) {
        header('Location: ./personal_recipebook.php');
    } else {
        header('Location: ./home.php');
    }
}
?>
<html>

<head>
    <title>Recipe Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>
</head>

<body class= "add_update_recipe_body">
    <h1 class="site_title" style="font-family:Constantia">Recipe Book</h1>

    <nav class="navbar nav-fill navbar-expand-lg navbar-light">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <?php if (isset($_SESSION['userNo'])) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="personal_recipebook.php">Personal Recipe Book</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="./add_update_recipe.php"><?php echo $navTab; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login_edit.php?userNo=<?php echo $_SESSION['userNo']; ?>">Edit User Info</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Log In </a>
                </li>
            <?php }; ?>
        </ul>
    </nav>

    <div class="add_update_recipe_container">
    <h1 class="title"><?php echo $pageTitle; ?></h1>
    <form method='POST' enctype="multipart/form-data">
        <h5>Recipe Name: <input type="text" name="recipeName" value="<?php echo $recipe->getRecipeName(); ?>">
            <?php if (strlen($recipe_name_error) > 0)
                echo "<span style='color: red;'>{$recipe_name_error}</span>"; ?>
        </h5>
        <h5>Cook Time: <input type="text" name="recipeCookTime" value="<?php echo $recipe->getRecipeCookTime(); ?>">
            <?php if (strlen($recipe_cook_time_error) > 0)
                echo "<span style='color: red;'>{$recipe_cook_time_error}</span>"; ?>
        </h5>
        <h5 id="descriptionField">Description: <input type="text" name="recipeDescription" value="<?php echo $recipe->getRecipeDescription(); ?>">
            <?php if (strlen($recipe_description_error) > 0)
                echo "<span style='color: red;'>{$recipe_description_error}</span>"; ?>
        </h5>
        <h5>Ingredient 1: <input type="text" name="ingredient1" value="<?php echo $recipe->getIngredient1(); ?>">
            <?php if (strlen($ingredient1_error) > 0)
                echo "<span style='color: red;'>{$ingredient1_error}</span>"; ?>
        </h5>
        <h5>Ingredient 2: <input type="text" name="ingredient2" value="<?php echo $recipe->getIngredient2(); ?>">
            <?php if (strlen($ingredient2_error) > 0)
                echo "<span style='color: red;'>{$ingredient2_error}</span>"; ?>
        </h5>
        <h5>Ingredient 3: <input type="text" name="ingredient3" value="<?php echo $recipe->getIngredient3(); ?>">
        </h5>
        <h5>Ingredient 4: <input type="text" name="ingredient4" value="<?php echo $recipe->getIngredient4(); ?>">
        </h5>
        <h5>Ingredient 5: <input type="text" name="ingredient5" value="<?php echo $recipe->getIngredient5(); ?>">
        </h5>
        <h5>Ingredient 6: <input type="text" name="ingredient6" value="<?php echo $recipe->getIngredient6(); ?>">
        </h5>
        <h5>Ingredient 7: <input type="text" name="ingredient7" value="<?php echo $recipe->getIngredient7(); ?>">
        </h5>
        <h5>Ingredient 8: <input type="text" name="ingredient8" value="<?php echo $recipe->getIngredient8(); ?>">
        </h5>
        <h5>Ingredient 9: <input type="text" name="ingredient9" value="<?php echo $recipe->getIngredient9(); ?>">
        </h5>
        <h5 id="ingredient10Field">Ingredient 10: <input type="text" name="ingredient10" value="<?php echo $recipe->getIngredient10(); ?>">
        </h5>
        <h5>Do you want this recipe to be public?
            <input type="radio" name="isPublic" <?php if ((isset($isPublic) && $isPublic == "1") || ($recipe->getIsPublic() == "1")) echo "checked"; ?> value="1">Public
            <input type="radio" name="isPublic" <?php if ((isset($isPublic) && $isPublic == "0") || ($recipe->getIsPublic() == "0")) echo "checked"; ?> value="0">Private
            <?php if (strlen($is_public_error) > 0)
                echo "<span style='color: red;'>{$is_public_error}</span>"; ?>
        </h5>
        <h5>Image File:
            <input type="text" name="imgFile" id="imgFile" value="<?php echo $recipe->getImgFile(); ?>" readonly />
            <label for="imgFileSelect" id="imgUploadLabel">Click to select file</label>
            <input hidden type="file" name="imgFileSelect" id="imgFileSelect" accept="image/*">
            <?php if (strlen($image_error) > 0) {
                echo "<br /><span style='color: red;'>{$image_error}</span>"; ?>
                <input type="submit" id="clearImageError" name="clear" value="Clear" />
            <?php }; ?>
        </h5>
        <h5>Directions: <?php if (strlen($recipe_steps_error) > 0)
                            echo "<span style='color: red;'>{$recipe_steps_error}</span>"; ?></h5>
        <textarea rows="5" columns="10" type="text" name="recipeSteps">
            <?php echo $recipe->getRecipeSteps(); ?>
            </textarea>
        <br /><br />
        <input type="hidden" value="<?php echo $recipe->getRecipeNo(); ?>" name="recipeNo">
        <input type="submit" class="btn btn-success" value="Save" name="save">
        <input type="submit" class="btn btn-danger" value="Cancel" name="cancel">
    </form>
    </div>

    <form method='POST'>
        <input type="submit" class="btn btn-warning" value="Logout" name="logout">
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript" src="../util/form_utilities.js"></script>

</html>