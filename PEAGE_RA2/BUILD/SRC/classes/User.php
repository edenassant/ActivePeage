<?php
class User {
    private $username;

    public function __construct() {
        session_start();

        if (!empty($_SERVER['REMOTE_USER'])) {
            $this->username = strtolower(str_replace('DOMAINE\\', '', $_SERVER['REMOTE_USER']));
            $_SESSION['username'] = $this->username;
        } elseif (!empty($_SESSION['username'])) {
            $this->username = $_SESSION['username'];
        } else {
            header('Location: login.php');
            exit;
        }
    }

    public function getUsername() {
        return $this->username;
    }

    public function isAdmin() {
        $adminUsers = ['RAOULT', 'RAOULT2']; // à adapter à ton groupe AD
        return in_array($this->username, $adminUsers);
    }
}
?>