<?php
use Controllers as Controller;
use Utilities as Utility;

session_start();

require_once('../controller/user_controller.php');
require_once('../util/security.php');

$recipe = new Controller\User('', '', '');


// user clicked the logout button
if (isset($_POST['logout'])) {
    Utility\Security::logout();
}

// Retrieve the recipeNo from the query string and use it to create a recipe object for that recipeNo
if (isset($_GET['recipeNo'])) {
    $recipe = Controller\UserController::getUserByNo($_GET['recipeNo']);
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
        <h2>Recipe name: <?php echo $recipe->getUsername(); ?></h2>
        <p>Posted by: <?php echo $recipe->getUserEmail(); ?></p>
        <p>Prep time: <?php echo $recipe->getUserPassword(); ?></p>
        <p>Description: <?php echo $recipe->getUserNo(); ?></p>


    </div>
    <h3><a href="home.php">Home</a></h3>
    <h3><a href="personal_recipebook.php">Personal Recipe Book</a></h3>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>