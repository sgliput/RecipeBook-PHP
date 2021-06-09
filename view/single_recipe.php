<?php

use Controllers as Controller;
use Utilities as Utility;

session_start();

require_once('../controller/user_controller.php');
require_once('../controller/recipe_controller.php');
require_once('../controller/user_recipe_controller.php');
require_once('../util/security.php');

$recipe = new Controller\Recipe('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
// Retrieve userNo if user is logged in
if (isset($_SESSION['userNo'])) {
    $userNo = $_SESSION['userNo'];
    $saved_recipe = Controller\UserRecipeController::checkIfRecipeSaved($userNo, $_GET['recipeNo']);
}

// Retrieve the recipeNo from the query string and use it to create a recipe object for that recipeNo
if (isset($_GET['recipeNo'])) {
    $recipe = Controller\RecipeController::getRecipeByNo($_GET['recipeNo']);
}

if (isset($_POST['update'])) {
    // update button pressed for a recipe
    if (isset($_POST['recipeNoUpd'])) {
        header('Location: ./add_update_recipe.php?recipeNo=' . $_POST['recipeNoUpd']);
    }
    unset($_POST['update']);
    unset($_POST['recipeNoUpd']);
}

if (isset($_POST['delete'])) {
    // delete button pressed for a recipe
    if (isset($_POST['recipeNoDel'])) {
        Controller\RecipeController::deleteRecipe($_POST['recipeNoDel'], $recipe->getImgFile());
        header('Location: ./personal_recipebook.php');
    }
    unset($_POST['delete']);
    unset($_POST['recipeNoDel']);
}

if (isset($_POST['saveRecipe'])) {
    // save recipe to user's personal recipe book
    Controller\UserRecipeController::saveRecipe($userNo, $_GET['recipeNo']);
    header('Location: ./personal_recipebook.php');
}

if (isset($_POST['unsaveRecipe'])) {
    // save recipe to user's personal recipe book
    Controller\UserRecipeController::unsaveRecipe($saved_recipe);
    header('Location: ./personal_recipebook.php');
}

// user clicked the logout button
if (isset($_POST['logout'])) {
    Utility\Security::logout();
}
?>
<html>

<head>
    <title>Recipe Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body class="single_recipe_body">
    <h1 class="site_title">Recipe Book</h1>

    <nav class="navbar navbar-expand-lg navbar-light">

        <?php if (isset($_SESSION['userNo'])) { ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="personal_recipebook.php">Personal Recipe Book</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./add_update_recipe.php">Add Recipe</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login_edit.php?userNo=<?php echo $_SESSION['userNo']; ?>">Edit User Info</a>
                </li>
        <?php } else { ?>
            <ul class="navbar-nav unlogged_nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Log In </a>
                </li>
        <?php }; ?>
            </ul>
    </nav>

    <div class="single_recipe_container">
        <h1 class="recipe_title"><?php echo $recipe->getRecipeName(); ?></h1>
        <img class="recipe_img" alt="<?php echo $recipe->getRecipeName(); ?>" src="../images/200/<?php echo $recipe->getImgFile() ? $recipe->getImgFile() : 'recipeCardDefault.jpg'; ?>" />

        <?php if (isset($userNo) && $recipe->getUserNo() != $userNo) {
            if (isset($_SESSION['userNo']) && !$saved_recipe) { ?>
                <form method='POST'>
                    <input type="submit" class="btn btn-primary" value="Save Recipe" name="saveRecipe" />
                </form>
            <?php } else if (isset($_SESSION['userNo']) && $saved_recipe) { ?>
                <form method='POST'>
                    <input type="submit" class="btn btn-primary" value="Unsave Recipe" name="unsaveRecipe" />
                </form>
        <?php };
        }; ?>

        <?php if (isset($_SESSION['userNo']) && intval($userNo) === $recipe->getUserNo()) { ?>
            <form method="POST">
                <input type="hidden" name="recipeNoUpd" value="<?php echo $recipe->getRecipeNo(); ?>" />
                <input type="submit" class="btn btn-primary" value="Update" name="update" />
            </form>
            <form method="POST">
                <input type="hidden" name="recipeNoDel" value="<?php echo $recipe->getRecipeNo(); ?>" />
                <input type="submit" class="btn btn-danger" value="Delete" name="delete" />
            </form>
        <?php }; ?>

        <p><b>Posted by:</b> <?php echo Controller\UserController::getUserByNo($recipe->getUserNo())->getUsername(); ?></p>
        <p><b>Cook time:</b> <?php echo $recipe->getRecipeCookTime(); ?></p>
        <p><b>Description:</b> <?php echo $recipe->getRecipeDescription(); ?></p>
        <br>
        <span class="ingredient_list">
            <p><b><u>Ingredients</u></b></p>
            <p><?php echo $recipe->getIngredient1(); ?></p>
            <p><?php echo $recipe->getIngredient2(); ?></p>
            <p><?php echo $recipe->getIngredient3(); ?></p>
            <p><?php echo $recipe->getIngredient4(); ?></p>
            <p><?php echo $recipe->getIngredient5(); ?></p>
            <p><?php echo $recipe->getIngredient6(); ?></p>
            <p><?php echo $recipe->getIngredient7(); ?></p>
            <p><?php echo $recipe->getIngredient8(); ?></p>
            <p><?php echo $recipe->getIngredient9(); ?></p>
            <p><?php echo $recipe->getIngredient10(); ?></p>
        </span>
        <br>
        <p class="recipe_steps"><b>Directions:</b> <?php echo $recipe->getRecipeSteps(); ?></p>


    </div>
    <?php if (isset($_SESSION['userNo'])) { ?>
        <form method='POST'>
            <input type="submit" class="btn btn-warning" value="Logout" name="logout">
        </form>
    <?php }; ?>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</html>