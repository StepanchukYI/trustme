<?php
require "../auth_class/RAQ.php";

$command = $_POST['command'];

switch ($command) {
    case "auth": //http://37.57.92.40/trustme/controllers/auth_controller.php?command=auth&login=bodunjo855@gmail.com&password=rootttt
        $login = $_POST['login'];
        $password = $_POST['password'];

        if ($login != "" && $password != "") {
            echo Auth($login, $password);
        } else {
            echo "failed feild";
        }
        break;
    case "reg_min": //http://37.57.92.40/trustme/controllers/auth_controller.php?command=reg_min&email=&phone=809503856636616&password1=rootttt&password2=rootttt
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if ($email != "" && $phone != "" && $password1 != "" && $password1 != "") {
            echo Registration_min($email, $phone, $password1, $password2);
        } else {
            echo "failed feild";
        }
        break;
    case "reg_full": //http://37.57.92.40/trustme/controllers/auth_controller.php?command=reg_full&id=1&email_2=fsdfsd@mads.ru&name=dasdasd&surname=fsdfsdfsdf&birth_day=14&birth_month=3&birth_year=1996&sex=1&country=Ucraine&city=Dnepro
        $id = $_POST['id'];
        $email_2 = $_POST['email_2'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $birth_day = $_POST['birth_day'];
        $birth_month = $_POST['birth_month'];
        $birth_year = $_POST['birth_year'];
        $sex = $_POST['sex'];
        $country = $_POST['country'];
        $city = $_POST['city'];

        if ($id != "" && $email_2 != "" && $name != "" && $surname != "" && $birth_day != ""
            && $birth_month != "" && $birth_year != "" && $sex != "" && $country != "" && $city != "") {
            echo Registration_full($id, $email_2, $name, $surname, $birth_day, $birth_month, $birth_year, $sex, $country, $city);
        } else {
            echo "failed feild";
        }
        break;
    case "quit": //http://37.57.92.40/trustme/controllers/auth_controller.php?command=quit&id=1
        $id = $_POST['id'];
        if($id != ""){
            echo Quit($id);
        }else{
            echo "failed feild";
        }
        break;

    default:
        echo "failed command";
        break;
}