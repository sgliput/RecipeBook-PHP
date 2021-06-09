<?php
use Controllers as Controller;
use Utilities as Utility;

session_start();
require_once('../controller/user.php');
require_once('../controller/user_controller.php');
require_once('../util/security.php');

Utility\Security::checkHTTPS();

// set the message related to login/logout functionality
$login_msg = isset($_SESSION['logout_msg']) ? $_SESSION['logout_msg'] : '';

if (isset($_POST['username']) & isset($_POST['pw'])) {
    // login and password fields were set
    $userNo = Controller\UserController::validUser(
            $_POST['username'], $_POST['pw']);

    // checks $is_user to verify authorized user
    if ($userNo !== -1 && $userNo !== false) {
        $_SESSION['logged_in'] = true;
        $_SESSION['userNo'] = $userNo;
        header("Location: home.php");
        unset($_POST['username']);
        unset($_POST['password']);
        unset($_POST['login']);
    } else {
        $login_msg = 'Incorrect login credentials - try again.';
    }
}

if (isset($_POST['register'])) {
    header('Location: ./login_edit.php');
    unset($_POST['register']);
}
?>
<html>
<head>
    <title>Recipe Book Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<body class="login_body">
    <h1 class="title site_title">Recipe Book</h1>  

    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav unlogged_nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="login.php">Log In </a>
            </li>
        </ul>
    </nav>

    <div class="login_container">
    <h2>Returning User? Please Login</h2>
    <form method='POST'>
        <h6>Username: <input type="text" name="username"></h6>
        <h6>Password: <input type="password" name="pw"></h6>
        <input type="submit" value="Login" name="login">
    </form>
    <h2><?php echo $login_msg; ?></h2>
    </div>
    <form method='POST'>
        <input type="submit" class="btn btn-warning" value="New User?" name="register" />
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</html>