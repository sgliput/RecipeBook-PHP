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

    if (isset($_SESSION['userNo'])) {
        $userNo = $_SESSION['userNo'];
    }

    // user clicked the logout button
    if (isset($_POST['logout'])) {
        Utility\Security::logout();
    }

    // default user for add - empty strings
    $user = new Controller\User('', '', '');
    $user->setUserNo(-1);
    $pageTitle = "Register as a New User";

    // Declare and clear variables for error messages
    $username_error = '';
    $email_error = '';
    $password_error = '';

    // Retrieve the userNo from the query string and use it to create a user object for that userNo
    if (isset($_GET['userNo'])) {
        $user = Controller\UserController::getUserByNo($_GET['userNo']);
        $pageTitle = "Update Your Login Information";
    }
    
    // Retrieve values from query string and store in user object
    // as long as the query string exists (which it does not on first load of a page).
    if (isset($_POST['username']))
        $user->setUsername($_POST['username']);
    if (isset($_POST['userEmail']))
        $user->setUserEmail($_POST['userEmail']);
    if (isset($_POST['password']))
        $user->setPassword($_POST['password']);
    
    // when save button is clicked
    if (isset($_POST['save'])) {
        // Validate the values entered

        // Call validation methods for other values
        $username_error = validator\usernameValid($user->getUsername());
        $password_error = validator\passwordValid($user->getPassword());

        // Use validator namespace emailValid method; passing the error message by reference
        validator\emailValid($user->getUserEmail(), $email_error);
        
        // verify no errors exist before submitting form
        if (strlen($username_error) === 0 && strlen($email_error) === 0 && strlen($password_error) === 0) {
            // save button - perform add or update
            $user = new Controller\User($_POST['username'], $_POST['userEmail'], $_POST['password']);
            $user->setUserNo($_POST['userNo']);

            if ($user->getUserNo() === '-1') {
                // add user
                Controller\UserController::addUser($user);
                // return to login page
                header('Location: ./login.php');
            } else {
                // update user
                Controller\UserController::updateUser($user);
                // return to home page
                header('Location: ./home.php');
            }
        }
    }

    if (isset($_POST['cancelRegistration'])) {
        // cancel registration button - go back to login page
        header('Location: ./login.php');
    }

    if (isset($_POST['cancelEdit'])) {
        // cancel edit button - go back to home page
        header('Location: ./home.php');
    }
?>
<html>
<head>
    <title>Recipe Book</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body class= "login_edit_body">
    <h1 class="title">Recipe Book</h1>
    <h2 class="title"><?php echo $pageTitle; ?></h2>
    <form method='POST'>
        <h3>Username: <input type="text" name="username"
            value="<?php echo $user->getUsername(); ?>">
            <?php if (strlen($username_error) > 0)
                echo "<span style='color: red;'>{$username_error}</span>"; ?>
        </h3>
        <h3>E-mail Address: <input type="text" name="userEmail"
            value="<?php echo $user->getUserEmail(); ?>">
            <?php if (strlen($email_error) > 0)
                echo "<span style='color: red;'>{$email_error}</span>"; ?>
        </h3>
        <h3>Password: <input type="password" name="password"
            value="<?php echo $user->getPassword(); ?>">
            <?php if (strlen($password_error) > 0)
                echo "<span style='color: red;'>{$password_error}</span>"; ?>
        </h3>
        <input type="hidden"
            value="<?php echo $user->getUserNo(); ?>" name="userNo">
        <?php if (isset($_GET['userNo']) && isset($_SESSION['userNo'])) { ?>
            <input type="submit" value="Save" name="save" />
            <input type="submit" value="Cancel" name="cancelEdit" />
        <?php } else { ?>
            <input type="submit" value="Register" name="save" />
            <input type="submit" value="Cancel" name="cancelRegistration" />
        <?php }; ?>
    </form>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>