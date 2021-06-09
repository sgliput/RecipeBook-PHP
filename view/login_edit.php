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

    if (isset($_SESSION['userNo'])) {
        $userNo = $_SESSION['userNo'];
         // confirm user is authorized for the page's URL
        Utility\Security::enforceUser($_GET['userNo']);
    }

    // user clicked the logout button
    if (isset($_POST['logout'])) {
        Utility\Security::logout();
    }

    // default user for add - empty strings
    $user = new Controller\User('', '', '');
    $user->setUserNo(-1);
    $pageTitle = "Register as a New User";
    // Remove logout message
    $_SESSION['logout_msg'] = '';

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
        if (!isset($userNo)) {
            $password_error = validator\passwordValid($user->getPassword());
        }

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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body class="login_edit_body">
    <h1 class="site_title">Recipe Book</h1>

    <nav class="navbar nav-fill navbar-expand-lg navbar-light">

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
                <li class="nav-item active">
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
    
    <div class="login_edit_container">
    <h2 class="title"><?php echo $pageTitle; ?></h2>
    <form method='POST'>
        <h6>Username: <input type="text" name="username"
            value="<?php echo $user->getUsername(); ?>">
            <?php if (strlen($username_error) > 0)
                echo "<span style='color: red;'>{$username_error}</span>"; ?>
        </h6>
        <h6>E-mail Address: <input type="text" name="userEmail"
            value="<?php echo $user->getUserEmail(); ?>">
            <?php if (strlen($email_error) > 0)
                echo "<br /><span style='color: red;'>{$email_error}</span>"; ?>
        </h6>
        <h6>Password: <input type="password" name="password" size="30"
            value="" placeholder="<?php if (isset($userNo)) { echo "Only enter password to change it."; } ?>">
            <?php if (!isset($userNo) && strlen($password_error) > 0)
                echo "<br /><span style='color: red;'>{$password_error}</span>"; ?>
        </h6>
        <input type="hidden"
            value="<?php echo $user->getUserNo(); ?>" name="userNo">
        <?php if (isset($_GET['userNo']) && isset($_SESSION['userNo'])) { ?>
            <input type="submit" class="btn btn-success" value="Save" name="save" />
            <input type="submit" class="btn btn-danger" value="Cancel" name="cancelEdit" />
        <?php } else { ?>
            <input type="submit" class="btn btn-success" value="Register" name="save" />
            <input type="submit" class="btn btn-danger" value="Cancel" name="cancelRegistration" />
        <?php }; ?>
    </form>
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