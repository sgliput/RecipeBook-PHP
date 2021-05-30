<?php
namespace Controllers;

// Class to represent an entry in the users table
class User {
    // properties - match the columns in the users table
    private $userNo;
    private $username;
    private $userEmail;
    private $password;

    public function __construct($username = null, $email, $password)
    {
        $this->username = $username;
        $this->userEmail = $email;
        $this->password = $password;
    }

    // get and set the user properties
    public function getUserNo() {
        return $this->userNo;
    }
    public function setUserNo($value) {
        $this->userNo = $value;
    }

    public function getUsername() {
        return $this->username;
    }
    public function setUsername($value) {
        $this->username = $value;
    }

    public function getUserEmail() {
        return $this->userEmail;
    }
    public function setUserEmail($value) {
        $this->userEmail = $value;
    }

    public function getPassword() {
        return $this->password;
    }
    public function setPassword($value) {
        $this->password = $value;
    }
}