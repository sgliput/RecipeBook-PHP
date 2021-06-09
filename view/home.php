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
// Remove logout message
$_SESSION['logout_msg'] = '';

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
?>
<html>

<head>
    <title>Recipe Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body class="home_body">
    <h1 class="site_title">Recipe Book</h1>

    <nav class="navbar navbar-expand-lg navbar-light">

        <?php if (isset($_SESSION['userNo'])) { ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
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
                <li class="nav-item active">
                    <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Log In </a>
                </li>
        <?php }; ?>
            </ul>
    </nav>

    <div class="home_container">
        <h1 class="title">Public Recipes</h1>
        <form method='POST' class="searchField">
            <h5>Search: <input type="text" name="searchTerm" value="">
                <input type="submit" value="Search" name="search">
            </h5>
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
                <?php } ?>

            <?php }; ?>
        </table>
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