<?php
require "../auth_class/RAQ.php";

$command = $_GET['command'];

switch ($command) {
    case "Auth":
        $login = $_GET['login'];
        $password = $_GET['password'];

        if ($login != "" && $password != "") {
            echo Auth($login, $password);
        }
        break;
    default:
        echo "failed command";
        break;
}