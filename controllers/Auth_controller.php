<?php
require "../auth_class/RAQ.php";

$command = $_GET['command'];

switch ($command) {
    case "auth":
        $login = $_GET['login'];
        $password = $_GET['password'];

        if ($login != "" && $password != "") {
            echo Auth($login, $password);
        } else {
            echo "failed feild";
        }
        break;
    case "reg_min":
        $email = $_GET['email'];
        $phone = $_GET['phone'];
        $password1 = $_GET['password1'];
        $password2 = $_GET['password2'];

        if ($email != "" && $phone != "" && $password1 != "" && $password1 != "") {
            echo Registration_min($email, $phone, $password1, $password2);
        } else {
            echo "failed feild";
        }
        break;
    case "reg_full":
        $id = $_GET['id'];
        $email_2 = $_GET['email_2'];
        $name = $_GET['name'];
        $surname = $_GET['surname'];
        $birth_day = $_GET['birth_day'];
        $birth_month = $_GET['birth_month'];
        $birth_year = $_GET['birth_year'];
        $sex = $_GET['sex'];
        $country = $_GET['country'];
        $city = $_GET['city'];

        if ($id != "" && $email_2 != "" && $name != "" && $surname != "" && $birth_day != ""
            && $birth_month != "" && $birth_year != "" && $sex != "" && $country != "" && $city != "") {
            //&id=1&email_2=fsdfsd@mads.ru&name=dasdasd&surname=fsdfsdfsdf&birth_day=14&birth_month=3&birth_year=1996&sex=1&country=Ukraine&city=Dnepro
            echo Registration_full($id, $email_2, $name, $surname, $birth_day, $birth_month, $birth_year, $sex, $country, $city);
        } else {
            echo "failed feild";
        }
        break;
    default:
        echo "failed command";
        break;
}