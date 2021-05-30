<?php
use Controllers as Controller;
use Utilities as Utility;

session_start();

require_once('../controller/user_controller.php');
require_once('../controller/recipe_controller.php');
require_once('../util/security.php');

$recipe = new Controller\Recipe('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
$userNo = $_SESSION['userNo'];

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
        Controller\RecipeController::deleteRecipe($_POST['recipeNoDel']);
        header('Location: ./personal_recipebook.php');
    }
    unset($_POST['delete']);
    unset($_POST['recipeNoDel']);
}

// user clicked the logout button
if (isset($_POST['logout'])) {
    Utility\Security::logout();
}
?>
<html>
<head>
    <title>Recipe Book</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body>
    <h1 class="title">Recipe Book</h1>

    <div class="container">
        <h1 class="recipe_title"><?php echo $recipe->getRecipeName(); ?></h1>
        <img class="recipe_img" alt="<?php echo $recipe->getRecipeName(); ?>" src="../images/200/<?php echo $recipe->getImgFile() ? $recipe->getImgFile() : 'recipeCardDefault.jpg'; ?>" />

        <?php if ($userNo === $recipe->getUserNo()) { ?>
        <form method="POST">
            <input type="hidden" name="recipeNoUpd"
                value="<?php echo $recipe->getRecipeNo(); ?>" />
            <input type="submit" value="Update" name="update" />
        </form>
        <form method="POST">
            <input type="hidden" name="recipeNoDel"
                value="<?php echo $recipe->getRecipeNo(); ?>" />
            <input type="submit" value="Delete" name="delete" />
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
    <h3><a href="home.php">Home</a></h3>
    <h3><a href="personal_recipebook.php">Personal Recipe Book</a></h3>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>