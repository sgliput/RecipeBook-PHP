<?php

namespace validator;

// Validate the length of the username; parameter passed by value
function recipeNameValid($name)
{
    if (strlen($name) > 0) {
        if (strlen($name) < 4)
            return "Must be at least 4 characters.";
        else
            return '';
    } else {
        return "Required";
    }
}

// Validate that state is two uppercase letters with regex
function passwordValid($password)
{
    $regex = '/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@*#$])/';
    if (!preg_match($regex, $password) || strlen($password) < 4 || strlen($password) > 20)
        return "Password must be 4-20 chars including at least one upper, one lower, one digit, and a special char in the set $!@*#";
    else
        return '';
}

// Validate the length of the name; parameter passed by value
function usernameValid($name)
{
    if (strlen($name) > 0) {
        if (strlen($name) < 2)
            return "Must be at least 6 characters.";
        else
            return '';
    } else {
        return "Required";
    }
}

// Validate the presence of a value or default date value
function requiredValid($value)
{
    if (strlen(trim($value)) == 0 || $value === '0000-00-00')
        return "Required";
    else
        return '';
}

// Validate an email address using the built-in PHP e-mail format validator; 
// passing a message back through the $msg parameter passed by reference
function emailValid($email, &$msg)
{
    if (strlen($email) > 0) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $msg = 'Not a valid email address.';
        else
            $msg = '';
    } else {
        $msg = 'Required';
    }
}
