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
    if ($userNo !== -1) {
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
</head>

<body>
    <h1>Recipe Book</h1>  
    <h2>Returning User? Please Login</h2>
    <form method='POST'>
        <h3>Username: <input type="text" name="username"></h3>
        <h3>Password: <input type="password" name="pw"></h3>
        <input type="submit" value="Login" name="login">
    </form>
    <h2><?php echo $login_msg; ?></h2>
    <form method='POST'>
        <input type="submit" value="New User?" name="register" />
    </form>
</body>
</html>