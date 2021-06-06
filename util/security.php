<?php
namespace Utilities;

// helper functions for dealing with security
class Security {
    public static function checkHTTPS() {
        // if not HTTPS, post a message and exit
        if (!isset($_SERVER['HTTPS'])
            || $_SERVER['HTTPS'] != 'on')
        {
            // for demonstration - normally just redirect to your https:// url
            echo "<h1>HTTPS is Required!</h1>";
            exit();
        }
    }

    // perform any needed clean-up for logging out
    public static function logout() {
        session_unset(); // clear the session info

        // clear any post info to prevent back button
        // from allowing user to breach security
        unset($_POST);
        
        // set a logout message and return to login page
        $_SESSION['logout_msg'] = 'Successfully logged out.';
        header('Location: ../view/login.php');
        exit();
    }

    public static function checkAuthority($auth) {
        // check to see if user is authorized - if not, set a message and return to login page
        if (!isset($_SESSION[$auth]) || !$_SESSION[$auth]) {
            $_SESSION['logout_msg'] = 'Current login unauthorized for this page.';
            header("Location: ../view/home.php");
            exit();
        }
    }
}