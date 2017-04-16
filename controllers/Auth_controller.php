<?php
require "../auth_class/RAQ.php";


$command = $_GET['command'];

switch ($command) {
    case "auth": //http://37.57.92.40/trustme/controllers/auth_controller.php?command=auth&login=bodunjo855@gmail.com&password=rootttt
        $login = $_REQUEST['login'];
        $password = $_REQUEST['password'];

        if ($login != "" && $password != "") {
            echo Auth($login, $password);
        } else {
            loging($login . " ". $password,"null field");
            echo "null field";
        }
        break;
    case "reg_min": //http://37.57.92.40/trustme/controllers/auth_controller.php?command=reg_min&email=&phone=809503856636616&password1=rootttt&password2=rootttt
        $email     = $_REQUEST['email'];
        $phone     = $_REQUEST['phone'];
        $password1 = $_REQUEST['password1'];
        $password2 = $_REQUEST['password2'];

        if ($email != "" && $phone != "" && $password1 != "" && $password1 != "") {
            echo Registration_min($email, $phone, $password1, $password2);
        } else {
            loging($email." ".$phone." ".$password1." ".$password2,"null field");
            echo "null field";
        }
        break;
    case "reg_full": //http://37.57.92.40/trustme/controllers/auth_controller.php?command=reg_full&id=1&email_2=fsdfsd@mads.ru&name=dasdasd&surname=fsdfsdfsdf&birth_day=14&birth_month=3&birth_year=1996&sex=1&country=Ucraine&city=Dnepro
        $id = $_REQUEST['id'];
        $email_2 = $_REQUEST['email_2'];
        $name = $_REQUEST['name'];
        $surname = $_REQUEST['surname'];
        $birth_day = $_REQUEST['birth_day'];
        $birth_month = $_REQUEST['birth_month'];
        $birth_year = $_REQUEST['birth_year'];
        $sex = $_REQUEST['sex'];
        $country = $_REQUEST['country'];
        $city = $_REQUEST['city'];

        if ($id != "" && $email_2 != "" && $name != "" && $surname != "" && $birth_day != ""
            && $birth_month != "" && $birth_year != "" && $sex != "" && $country != "" && $city != "") {
            echo Registration_full($id, $email_2, $name, $surname, $birth_day, $birth_month, $birth_year, $sex, $country, $city);
        } else {
            loging($id." ".$email_2." ".$name." ".$surname." ".$birth_day." ".$birth_month." ".$birth_year." ".$sex." ".$country." ".$city,"null field");
            echo "null field";
        }
        break;
    case "quit": //http://37.57.92.40/trustme/controllers/auth_controller.php?command=quit&id=1
        $id = $_REQUEST['id'];
        if($id != ""){
            echo Quit($id);
        } else {
            loging($id . " ", "null field");
            echo "null field";
        }
        break;

    default:
        loging($command." ","failed command");
        echo "failed command";
        break;
}