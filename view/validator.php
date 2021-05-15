<?php
namespace validator;

// Validate the length of the userId; parameter passed by value
function userIdValid($name) {
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
function passwordValid($password) {
    $regex = '/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@*#$])/';
    if (strlen($password) > 0) {
        if (!preg_match($regex, $password) || strlen($password) < 4 || strlen($password) > 20)
            return "Password must be 4-20 chars including at least one upper, one lower, one digit, and a special char in the set $!@*#";
        else
            return '';
    } else {
        return "Required";
    }
}

// Validate the length of the name; parameter passed by value
function nameValid($name) {
    if (strlen($name) > 0) {
        if (strlen($name) < 2)
            return "Must be at least 2 characters.";
        else
            return '';
    } else {
        return "Required";
    }
}

// Validate the presence of a value or default date value
function requiredValid($value) {
    if (strlen($value) === 0 || $value === '0000-00-00')
        return "Required";
    else
        return '';
}

// Validate that extension is five digits with regex
function extensionValid($extension) {
    $regex="/^\d{5}$/";
    if (strlen($extension) > 0) {
        if (!preg_match($regex, $extension))
            return "Invalid Extension - 5 digits only";
        else
            return '';
    } else {
        return "Required";
    }
}

// Validate an email address using the built-in PHP e-mail format validator; 
// passing a message back through the $msg parameter passed by reference
function emailValid($email, &$msg) {
    if (strlen($email) > 0) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $msg = 'Not a valid email address.';
        else
            $msg = '';
    }
    else {
        $msg = 'Required';
    }
}
