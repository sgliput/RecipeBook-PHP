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
    $recipes = Controller\RecipeController::getAllRecipes();


    // Declare and clear variables for error messages
    $username_error = '';
    $password_error = '';
    $first_name_error = '';
    $last_name_error = '';
    $hire_date_error = '';
    $email_error = '';
    $extension_error = '';

    // Retrieve the recipeNo from the query string and use it to create a recipe object for that recipeNo
    if (isset($_GET['recipeNo'])) {
        $recipe = Controller\RecipeController::getRecipeByNo($_GET['recipeNo']);
        $pageTitle = "Update an Existing Recipe";
    }
    
    // Retrieve values from query string and store in recipe object
    // as long as the query string exists (which it does not on first load of a page).
    if (isset($_POST['recipeName']))
        $recipe->setRecipeName($_POST['recipeName']);
    if (isset($_POST['password']))
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
    
    // when save button is clicked
    if (isset($_POST['save'])) {
        // Validate the values entered
        // Call nameValid from the validator namespace for first and last name
        // $first_name_error = validator\nameValid($recipe->getFirstName());
        // $last_name_error = validator\nameValid($recipe->getLastName());

        // Call validation methods for other values
        $username_error = validator\usernameValid($user->getUsername());
        $password_error = validator\passwordValid($user->getUserPassword());
        // $hire_date_error = validator\requiredValid($user->getHireDate());
        // $extension_error = validator\extensionValid($user->getExtension());

        // Use validator namespace emailValid method; passing the error message by reference
        // validator\emailValid($user->getEMail(), $email_error);
        
        // verify no errors exist before submitting form
        if (strlen($username_error) === 0 && strlen($password_error) === 0 && strlen($first_name_error) === 0 && strlen($last_name_error) === 0 
            && strlen($hire_date_error) === 0 && strlen($extension_error) === 0 && strlen($email_error) === 0) {
            // save button - perform add or update
            $recipe = new Controller\Recipe($_POST['recipeNo'], $_POST['recipeName'], $_POST['recipeDescription'], $_POST['recipeSteps'], $_POST['recipeCookTime'],
                $_POST['ingredient1'], $_POST['ingredient2'], $_POST['ingredient3'], $_POST['ingredient4'], $_POST['ingredient5'], $_POST['ingredient6'],
                $_POST['ingredient7'], $_POST['ingredient8'], $_POST['ingredient9'], $_POST['ingredient10'], $_POST['isPublic'], $_POST['imgFile'], $userNo);
            $recipe->setRecipeNo($_POST['recipeNo']);

            if ($recipe->getRecipeNo() === '-1') {
                // add recipe
                Controller\RecipeController::addRecipe($recipe);
            } else {
                // update recipe
                Controller\RecipeController::updateRecipe($recipe);
            }

            // return to recipes list
            header('Location: ./home.php');
        }
    }

    if (isset($_POST['cancel'])) {
        // cancel button - just go back to list
        header('Location: ./home.php');
    }
?>
<html>
<head>
    <title>Recipe Book</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body>
    <h1 class="title">Recipe Book</h1>
    <h2 class="title"><?php echo $pageTitle; ?></h2>
    <form method='POST'>
        <h3>Recipe Name: <input type="text" name="recipeName"
            value="<?php echo $recipe->getRecipeName(); ?>">
            <?php if (strlen($username_error) > 0)
                echo "<span style='color: red;'>{$username_error}</span>"; ?>
        </h3>
        <h3>Description: <input type="text" name="recipeDescription"
            value="<?php echo $recipe->getRecipeDescription(); ?>">
            <?php if (strlen($password_error) > 0)
                echo "<span style='color: red;'>{$password_error}</span>"; ?>
        </h3>
        <h3>Cook Time: <input type="text" name="recipeCookTime"
            value="<?php echo $recipe->getRecipeCookTime(); ?>">
            <?php if (strlen($last_name_error) > 0)
                echo "<span style='color: red;'>{$last_name_error}</span>"; ?>
        </h3>
        <h3>Ingredient 1: <input type="text" name="ingredient1"
            value="<?php echo $recipe->getIngredient1(); ?>">
            <?php if (strlen($email_error) > 0)
                echo "<span style='color: red;'>{$email_error}</span>"; ?>
        </h3>
        <h3>Ingredient 2: <input type="text" name="ingredient2"
            value="<?php echo $recipe->getIngredient2(); ?>">
            <?php if (strlen($email_error) > 0)
                echo "<span style='color: red;'>{$email_error}</span>"; ?>
        </h3>
        <h3>Ingredient 3: <input type="text" name="ingredient3"
            value="<?php echo $recipe->getIngredient3(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Ingredient 4: <input type="text" name="ingredient4"
            value="<?php echo $recipe->getIngredient4(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Ingredient 5: <input type="text" name="ingredient5"
            value="<?php echo $recipe->getIngredient5(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Ingredient 6: <input type="text" name="ingredient6"
            value="<?php echo $recipe->getIngredient6(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Ingredient 7: <input type="text" name="ingredient7"
            value="<?php echo $recipe->getIngredient7(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Ingredient 8: <input type="text" name="ingredient8"
            value="<?php echo $recipe->getIngredient8(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Ingredient 9: <input type="text" name="ingredient9"
            value="<?php echo $recipe->getIngredient9(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Ingredient 10: <input type="text" name="ingredient10"
            value="<?php echo $recipe->getIngredient10(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Do you want this recipe to be public? <input type="text" name="isPublic"
            value="<?php echo $recipe->getIsPublic(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Image File: <input type="text" name="imgFile"
            value="<?php echo $recipe->getImgFile(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Directions:</h3> <textarea rows="5" columns="10" type="text" name="recipeSteps"
            value="<?php echo $recipe->getRecipeSteps(); ?>"></textarea>
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        <br /><br />
        <!-- <h3>Level: <select name="userLevelOption">
            <//?php foreach($user_levels as $user_level) : ?>
                <option value="<//?php echo $user_level->getUserLevelNo(); ?>"
                    <//?php if ($user_level->getUserLevelNo() === $user->getUserLevel()->getUserLevelNo()) {
                        echo 'selected'; }?>>
                <//?php echo $user_level->getLevelName(); ?></option>
            <//?php endforeach ?>
            </select>
        </h3>         -->
        <input type="hidden"
            value="<?php echo $recipe->getRecipeNo(); ?>" name="recipeNo">
        <input type="submit" value="Save" name="save">
        <input type="submit" value="Cancel" name="cancel">
    </form>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>