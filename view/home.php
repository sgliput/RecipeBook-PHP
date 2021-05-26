<?php
// errors occur if I don't alias these namespaces
use Controllers as Controller;
use Utilities as Utility;

session_start();
require_once('../controller/user.php');
require_once('../controller/user_controller.php');
require_once('../util/security.php');

// user clicked the logout button
if (isset($_POST['logout'])) {
    Utility\Security::logout();
}

if (isset($_POST['update'])) {
    // update button pressed for a user
    if (isset($_POST['userNoUpd'])) {
        header('Location: ./add_update_recipe.php?userNo=' . $_POST['userNoUpd']);
    }
    unset($_POST['update']);
    unset($_POST['userNoUpd']);
}

if (isset($_POST['delete'])) {
    // delete button pressed for a use
    if (isset($_POST['userNoDel'])) {
        Controller\UserController::deleteUser($_POST['userNoDel']);
    }
    unset($_POST['delete']);
    unset($_POST['userNoDel']);
}

if (isset($_POST['goToRecipe'])) {
    if (isset($_POST['recipeNo'])) {
        header('Location: ./single_recipe.php?recipeNo=' . $_POST['recipeNo']);
    }
    unset($_POST['goToRecipe']);
    unset($_POST['recipeNo']);
}
// <td><form method="POST">
//    <input type="hidden" name="userNoDel"
//       value="<?php echo $user->getUserNo(); " close php here />
//    <input type="submit" value="Delete" name="delete" />
// </form></td>
?>
<html>

<head>
    <title>Recipe Book</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body>
    <h1 class="title">Recipe Book</h1>
    <h2><a href="./add_update_recipe.php">Add Recipe</a></h2>

    <h1 class="title">Public Recipes</h1>
    <table>
        <?php foreach (Controller\UserController::getAllUsers() as $user) {
            $index = array_search($user, Controller\UserController::getAllUsers()); ?>
            <?php if ($index % 2 == 0) { ?>
                <tr>
                    <td class="recipeBlock">
                        <h2><?php echo $user->getUsername(); ?></h2>
                        <p><?php echo $user->getUserPassword(); ?></p>
                        <form method="POST">
                            <input type="hidden" name="recipeNo" value="<?php echo $user->getUserNo(); ?>" />
                            <input type="submit" value="See Recipe" name="goToRecipe" />
                        </form>

                    </td>
                <?php } else { ?>
                    <td class="recipeBlock">
                        <h2><?php echo $user->getUsername(); ?></h2>
                        <p><?php echo $user->getUserEmail(); ?></p>
                        <form method="POST">
                            <input type="hidden" name="recipeNo" value="<?php echo $user->getUserNo(); ?>" />
                            <input type="submit" value="See Recipe" name="goToRecipe" />
                        </form>

                    </td>
                </tr>
            <?php } ?>

        <?php }; ?>
    </table>
    <h3><a href="personal_recipebook.php">Personal Recipe Book</a></h3>
    <h3><a href="home.php">Home</a></h3>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>

</html>