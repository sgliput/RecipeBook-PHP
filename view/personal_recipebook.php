<?php
use Controllers as Controller;
use Utilities as Utility;

session_start();
require_once('../controller/user.php');
require_once('../controller/user_controller.php');
require_once('../controller/recipe.php');
require_once('../controller/recipe_controller.php');
require_once('../util/security.php');

// confirm user is authorized for the page
Utility\Security::checkAuthority('logged_in');

$recipes = Controller\RecipeController::getAllRecipesForUser($_SESSION['userNo']);

// user clicked the logout button
if (isset($_POST['logout'])) {
    Utility\Security::logout();
}

if (isset($_POST['goToRecipe'])) {
    if (isset($_POST['recipeNo'])) {
        header('Location: ./single_recipe.php?recipeNo=' . $_POST['recipeNo']);
    }
    unset($_POST['goToRecipe']);
    unset($_POST['recipeNo']);
}
?>
<html>
<head>
    <title>Your Personal Recipe Book</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body>
    <h1 class="title site_title">Recipe Book</h1>

    <h1 class="title">Your Personal Recipe Book</h1>
    <h2><a href="./add_update_recipe.php">Add Recipe</a></h2>

    <table>
    <?php if ($recipes) { 
        foreach ($recipes as $recipe) {
        $index = array_search($recipe, $recipes); ?>
        <?php if($index % 2 == 0) { ?>
        <tr>
        <td class="recipeBlock">
            <h2><?php echo $recipe->getRecipeName(); ?></h2>
            <p><b>Posted by:</b> <?php echo Controller\UserController::getUserByNo($recipe->getUserNo())->getUsername(); ?></p>
            <p><b>Cook Time:</b> <?php echo $recipe->getRecipeCookTime(); ?></p>
            <p><b>Description:</b> <?php echo $recipe->getRecipeDescription(); ?></p>
            <form method="POST">
                <input type="hidden" name="recipeNo"
                    value="<?php echo $recipe->getRecipeNo(); ?>" />
                <input type="submit" value="See Recipe" name="goToRecipe" />
            </form>

        </td>
        <?php } else { ?>
        <td class="recipeBlock">
            <h2><?php echo $recipe->getRecipeName(); ?></h2>
            <p><b>Posted by:</b> <?php echo Controller\UserController::getUserByNo($recipe->getUserNo())->getUsername(); ?></p>
            <p><b>Cook Time:</b> <?php echo $recipe->getRecipeCookTime(); ?></p>
            <p><b>Description:</b> <?php echo $recipe->getRecipeDescription(); ?></p>
            <form method="POST">
                <input type="hidden" name="recipeNo"
                    value="<?php echo $recipe->getRecipeNo(); ?>" />
                <input type="submit" value="See Recipe" name="goToRecipe" />
            </form>

        </td>
        </tr>
        <?php }; }; ?>

    <?php } else { ?>
        <tr>
            <td class="noRecipesBlock">
                <h2>You have no saved recipes.</h2>
                <h3>Check out the public recipes on the Home page and save some to build your own private Recipe Book!</h3>
            </td>
        </tr>

    <?php }; ?>
    </table>
    <h3><a href="home.php">Home</a></h3>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>