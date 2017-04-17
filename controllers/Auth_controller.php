<?php
require "../auth_class/RAQ.php";


$command = $_REQUEST['command'];

switch ($command) {
    case "auth": //http://37.57.92.40/trustme/controllers/auth_controller.php?command=auth&login=bodunjo855@gmail.com&password=rootttt
        $login = $_REQUEST['email'];
        $password = $_REQUEST['password'];

        if ($login != "" && $password != "") {
            $ans = Auth($login, $password);
            logging($login . " ".$password, "User ofline","Quit");
            echo $ans;
        } else {
            logging($login . " ". $password,"null field",$command);
                        echo "null field";
        }
        break;
    case "registration_min": //http://37.57.92.40/trustme/controllers/auth_controller.php?command=reg_min&email=&phone=809503856636616&password1=rootttt&password2=rootttt
        $email     = $_REQUEST['email'];
        $phone     = $_REQUEST['phone'];
        $password1 = $_REQUEST['password'];
        //$password2 = $_REQUEST['password2'];

        if ($email != "" && $phone != "" && $password1 != "") {
            $ans = Registration_min($email, $phone, $password1);
            logging($email." ".$phone." ".$password1,$ans,"Registration_min");
            echo  $ans;
        } else {
            logging($email." ".$phone,"null field", $command);
            echo "null field";
        }
        break;
    case "registration_full": //http://37.57.92.40/trustme/controllers/auth_controller.php?command=reg_full&id=1&email_2=fsdfsd@mads.ru&name=dasdasd&surname=fsdfsdfsdf&birth_day=14&birth_month=3&birth_year=1996&sex=1&country=Ucraine&city=Dnepro
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
            $ans = Registration_full($id, $email_2, $name, $surname, $birth_day, $birth_month, $birth_year, $sex, $country, $city);
            logging($id." ".$email_2." ".$name." ".$surname." ".$birth_day." "
                .$birth_month." ".$birth_year." ".$sex." ".$country." ".$city,$ans,"Registration_full");
            echo $ans;
        } else {
            logging($id." ".$email_2." ".$name." ".$surname." ".$birth_day." ".$birth_month." ".$birth_year." ".$sex." ".$country." ".$city,"null field",$command);
            echo "null field";
        }
        break;
    case "quit":  //http://37.57.92.40/trustme/controllers/auth_controller.php?command=quit&id=1
        $id = $_REQUEST['id'];
        if($id != ""){
            logging($id . " ", "User ofline","Quit");
            echo Quit($id);
        } else {
            logging($id . " ", "null field",$command);
            echo "null field";
        }
        break;
    default:
        logging($command." ","failed command",$command);
        echo "failed command";
        break;
}