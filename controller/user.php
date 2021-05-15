<?php
namespace Controllers;

// Class to represent an entry in the users table
class User {
    // properties - match the columns in the users table
    private $userNo;
    private $userId;
    private $password;
    private $firstName;
    private $lastName;
    private $hireDate;
    private $eMail;
    private $extension;
    private $userLevel;

    public function __construct($userId = null, $password, $firstName, $lastName, $hireDate, 
        $eMail, $extension, $userLevel)
    {
        $this->userId = $userId;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->hireDate = $hireDate;
        $this->eMail = $eMail;
        $this->extension = $extension;
        $this->userLevel = $userLevel;
    }

    // get and set the user properties
    public function getUserNo() {
        return $this->userNo;
    }
    public function setUserNo($value) {
        $this->userNo = $value;
    }

    public function getUserId() {
        return $this->userId;
    }
    public function setUserId($value) {
        $this->userId = $value;
    }

    public function getPassword() {
        return $this->password;
    }
    public function setPassword($value) {
        $this->password = $value;
    }

    public function getFirstName() {
        return $this->firstName;
    }
    public function setFirstName($value) {
        $this->firstName = $value;
    }

    public function getLastName() {
        return $this->lastName;
    }
    public function setLastName($value) {
        $this->lastName = $value;
    }

    public function getHireDate() {
        return $this->hireDate;
    }
    public function setHireDate($value) {
        $this->hireDate = $value;
    }

    public function getEMail() {
        return $this->eMail;
    }
    public function setEMail($value) {
        $this->eMail = $value;
    }

    public function getExtension() {
        return $this->extension;
    }
    public function setExtension($value) {
        $this->extension = $value;
    }

    // get and set the user level property
    public function getUserLevel() {
        return $this->userLevel;
    }
    public function setUserLevel($value) {
        $this->userLevel = $value;
    }
}