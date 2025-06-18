<?php


//        ini_set('display_errors', 1);
//        ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
class User {
    private $username;

    public function __construct() {
//        session_start();
//        ini_set('display_errors', 1);
//        ini_set('display_startup_errors', 1);
//        error_reporting(E_ALL);

        if (!empty($_SERVER['REMOTE_USER'])) {
            $this->username = strtolower(str_replace('DOMAINE\\', '', $_SERVER['REMOTE_USER']));
            $_SESSION['username'] = $this->username;
            echo "remote user : { $this->username}";
        } elseif (!empty($_SESSION['username'])) {
    $this->username = $_SESSION['username'];
//            echo "Session utilisée : { $this->username}";
        } else {




            $this->username = 'raoult';

            echo "aucune sesiion detectée ni de  remote user";
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