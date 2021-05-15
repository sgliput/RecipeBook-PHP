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

if (isset($_POST['userId']) & isset($_POST['pw'])) {
    // login and password fields were set
    $user_level = Controller\UserController::validUser(
            $_POST['userId'], $_POST['pw']);
    
    // checks $user_level to determine authorization level
    if ($user_level === '1') {
        $_SESSION['admin'] = true;
        $_SESSION['tech'] = false;
        header("Location: admin.php");
    } else if ($user_level === '2') {
        $_SESSION['admin'] = false;
        $_SESSION['tech'] = true;
        header("Location: tech.php");
    } else {
        $login_msg = 'Incorrect login credentials - try again.';
    }
}
?>
<html>
<head>
    <title>Sam Liput Final Practical</title>
</head>

<body>
    <h1>Sam Liput Final Practical</h1>  
    <h2>Sam Liput Application Login</h2>
    <form method='POST'>
        <h3>Login ID: <input type="text" name="userId"></h3>
        <h3>Password: <input type="password" name="pw"></h3>
        <input type="submit" value="Login" name="login">
    </form>
    <h2><?php echo $login_msg; ?></h2>
</body>
</html>