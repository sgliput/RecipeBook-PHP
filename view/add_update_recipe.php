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

    // default user for add - empty strings
    $user = new Controller\User('', '', '');
    $user_levels = Controller\UserLevelController::getAllLevels();
    $user->setUserNo(-1);
    $pageTitle = "Add a New Recipe";

    // Declare and clear variables for error messages
    $username_error = '';
    $password_error = '';
    $first_name_error = '';
    $last_name_error = '';
    $hire_date_error = '';
    $email_error = '';
    $extension_error = '';

    // Retrieve the userNo from the query string and use it to create a user object for that userNo
    if (isset($_GET['userNo'])) {
        $user = Controller\UserController::getUserByNo($_GET['userNo']);
        $pageTitle = "Update an Existing Recipe";
    }
    
    // Retrieve values from query string and store in user object
    // as long as the query string exists (which it does not on first load of a page).
    if (isset($_POST['username']))
        $user->setUsername($_POST['username']);
    if (isset($_POST['password']))
        $user->setUserPassword($_POST['password']);
    // if (isset($_POST['fName']))
    //     $user->setFirstName($_POST['fName']);
    // if (isset($_POST['lName']))
    //     $user->setLastName($_POST['lName']);
    // if (isset($_POST['hireDate']))
    //     $user->setHireDate($_POST['hireDate']);
    // if (isset($_POST['email']))
    //     $user->setEMail($_POST['email']);
    // if (isset($_POST['extension']))
    //     $user->setExtension($_POST['extension']);
    // if (isset($_POST['userLevelOption']))
    //     $user->setUserLevel(new Controller\UserLevel($user_levels[$_POST['userLevelOption']-1], $user_levels[$_POST['userLevelOption']-1]->getLevelName()));
    
    // when save button is clicked
    if (isset($_POST['save'])) {
        // Validate the values entered
        // Call nameValid from the validator namespace for first and last name
        // $first_name_error = validator\nameValid($user->getFirstName());
        // $last_name_error = validator\nameValid($user->getLastName());

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
            $user = new Controller\User($_POST['username'], $_POST['password'], $_POST['fName'], $_POST['lName'],
                $_POST['hireDate'], $_POST['email'], $_POST['extension'], $user_levels[$_POST['userLevelOption']-1]);
            $user->setUserNo($_POST['userNo']);

            if ($user->getUserNo() === '-1') {
                // add user
                Controller\UserController::addUser($user);
            } else {
                // update user
                Controller\UserController::updateUser($user);
            }

            // return to users list
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
        <h3>Recipe Name: <input type="text" name="username"
            value="<?php echo $user->getUsername(); ?>">
            <?php if (strlen($username_error) > 0)
                echo "<span style='color: red;'>{$username_error}</span>"; ?>
        </h3>
        <h3>Prep Time: <input type="text" name="password"
            value="<?php echo $user->getUserPassword(); ?>">
            <?php if (strlen($password_error) > 0)
                echo "<span style='color: red;'>{$password_error}</span>"; ?>
        </h3>
        <h3>Description: <input type="text" name="fName"
            value="<?php echo $user->getUsername(); ?>">
            <?php if (strlen($first_name_error) > 0)
                echo "<span style='color: red;'>{$first_name_error}</span>"; ?>
        </h3>
        <h3>Ingredient 1: <input type="text" name="lName"
            value="<?php echo $user->getUsername(); ?>">
            <?php if (strlen($last_name_error) > 0)
                echo "<span style='color: red;'>{$last_name_error}</span>"; ?>
        </h3>
        <h3>Ingredient 2: <input type="text" name="email"
            value="<?php echo $user->getUsername(); ?>">
            <?php if (strlen($email_error) > 0)
                echo "<span style='color: red;'>{$email_error}</span>"; ?>
        </h3>
        <h3>Ingredient 3: <input type="text" name="extension"
            value="<?php echo $user->getUsername(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Ingredient 4: <input type="text" name="extension"
            value="<?php echo $user->getUsername(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Ingredient 5: <input type="text" name="extension"
            value="<?php echo $user->getUsername(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Ingredient 6: <input type="text" name="extension"
            value="<?php echo $user->getUsername(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Ingredient 7: <input type="text" name="extension"
            value="<?php echo $user->getUsername(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Ingredient 8: <input type="text" name="extension"
            value="<?php echo $user->getUsername(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Ingredient 9: <input type="text" name="extension"
            value="<?php echo $user->getUsername(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Ingredient 10: <input type="text" name="extension"
            value="<?php echo $user->getUsername(); ?>">
            <?php if (strlen($extension_error) > 0)
                echo "<span style='color: red;'>{$extension_error}</span>"; ?>
        </h3>
        <h3>Directions:</h3> <textarea rows="5" columns="10" type="text" name="extension"
            value="<?php echo $user->getUsername(); ?>"></textarea>
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
            value="<?php echo $user->getUserNo(); ?>" name="userNo">
        <input type="submit" value="Save" name="save">
        <input type="submit" value="Cancel" name="cancel">
    </form>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>