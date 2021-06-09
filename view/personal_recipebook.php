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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body class="personal_recipebook_body">
    <h1 class="site_title" style="font-family:Brush Script MT;">Recipe Book</h1>

    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <?php if (isset($_SESSION['userNo'])) { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="personal_recipebook.php">Personal Recipe Book</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./add_update_recipe.php">Add Recipe</a>
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

    <div class="personal_recipebook_container">
        <h1 class="title" style="font-family:Courier New;">Your Personal Recipe Book</h1>

        <table>
            <?php if ($recipes) {
                foreach ($recipes as $recipe) {
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
                                    <input type="submit" class="btn btn-primary" value="See Recipe" name="goToRecipe" />
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
                                    <input type="submit" class="btn btn-primary" value="See Recipe" name="goToRecipe" />
                                </form>

                            </td>
                        </tr>
                <?php };
                }; ?>

            <?php } else { ?>
                <tr>
                    <td class="noRecipesBlock">
                        <h2>You have no saved recipes.</h2>
                        <h3>Check out the public recipes on the Home page and save some to build your own private Recipe Book!</h3>
                    </td>
                </tr>

            <?php }; ?>
        </table>
    </div>
    <form method='POST'>
        <input type="submit" class="btn btn-warning" value="Logout" name="logout">
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</html>