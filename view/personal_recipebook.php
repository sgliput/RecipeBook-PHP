<?php
use Controllers as Controller;
use Utilities as Utility;

session_start();
require_once('../controller/user.php');
require_once('../controller/user_controller.php');
require_once('../util/security.php');

// confirm user is authorized for the page
Utility\Security::checkAuthority('logged_in');

$recipes = Controller\UserController::getAllUsers();

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
    <h1 class="title">Recipe Book</h1>

    <h1 class="title">Your Personal Recipe Book</h1>

    <table>
    <?php foreach ($recipes as $user) {
         $index = array_search($user, $recipes); ?>
        <?php if($index % 2 == 0) { ?>
        <tr>
        <td class="recipeBlock">
            <h2><?php echo $user->getUsername(); ?></h2>
            <p><?php echo $user->getUserEmail(); ?></p>
            <form method="POST">
                <input type="hidden" name="recipeNo"
                    value="<?php echo $user->getUserNo(); ?>" />
                <input type="submit" value="See Recipe" name="goToRecipe" />
            </form>

        </td>
        <?php } else { ?>
        <td class="recipeBlock">
            <h2><?php echo $user->getUsername(); ?></h2>
            <p><?php echo $user->getUserPassword(); ?></p>
            <form method="POST">
                <input type="hidden" name="recipeNo"
                    value="<?php echo $user->getUserNo(); ?>" />
                <input type="submit" value="See Recipe" name="goToRecipe" />
            </form>

        </td>
        </tr>
        <?php } ?>
        
    <?php }; ?>
    </table>
    <h3><a href="home.php">Home</a></h3>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>