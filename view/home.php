<?php
// errors occur if I don't alias these namespaces
use Controllers as Controller;
use Utilities as Utility;

session_start();
require_once('../controller/user.php');
require_once('../controller/user_controller.php');
require_once('../controller/recipe.php');
require_once('../controller/recipe_controller.php');
require_once('../util/security.php');

$recipes = Controller\RecipeController::getAllPublicRecipes();

// user clicked the logout button
if (isset($_POST['logout'])) {
    Utility\Security::logout();
}

if (isset($_POST['search'])) {
    $recipes = Controller\RecipeController::getPublicRecipesBySearchTerm($_POST['searchTerm']);
}

if (isset($_POST['goToRecipe'])) {
    if (isset($_POST['recipeNo'])) {
        header('Location: ./single_recipe.php?recipeNo=' . $_POST['recipeNo']);
    }
    unset($_POST['goToRecipe']);
    unset($_POST['recipeNo']);
}

if (isset($_POST['userEdit'])) {
    header('Location: ./login_edit.php?userNo=' . $_SESSION['userNo']);

    unset($_POST['userEdit']);
}
?>
<html>

<head>
    <title>Recipe Book</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body class= "home_body">
    <h1 class="title">Recipe Book</h1>
    <h2><a href="./add_update_recipe.php">Add Recipe</a></h2>

    <h1 class="title">Public Recipes</h1>
    <form method='POST' class="searchField">
        <h3>Search: <input type="text" name="searchTerm" value="">
            <input type="submit" value="Search" name="search">
        </h3>
    </form>
    <table>
        <?php foreach ($recipes as $recipe) {
            $index = array_search($recipe, $recipes); ?>
            <?php if ($index % 2 == 0) { ?>
                <tr>
                    <td class="recipeBlock">
                        <h2><?php echo $recipe->getRecipeName(); ?></h2>
                        <p><b>Posted by:</b> <?php echo Controller\UserController::getUserByNo($recipe->getUserNo())->getUsername(); ?></p>
                        <p><b>Cook Time:</b> <?php echo $recipe->getRecipeCookTime(); ?></p>
                        <p><b>Description:</b> <?php echo $recipe->getRecipeDescription(); ?></p>

                        <form method="POST">
                            <input type="hidden" name="recipeNo" value="<?php echo $recipe->getRecipeNo(); ?>" />
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
                            <input type="hidden" name="recipeNo" value="<?php echo $recipe->getRecipeNo(); ?>" />
                            <input type="submit" value="See Recipe" name="goToRecipe" />
                        </form>

                    </td>
                </tr>
            <?php } ?>

        <?php }; ?>
    </table>
    <h3><a href="personal_recipebook.php">Personal Recipe Book</a></h3>
    <h3><a href="home.php">Home</a></h3>
    <?php if ($_SESSION['userNo'] !== null) { ?>
    <form method='POST'>
        <input type="submit" value="Edit User Info" name="userEdit">
    </form>
    <?php }; ?>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>

</html>