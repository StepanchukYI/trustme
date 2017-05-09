<?php
require "../auth_class/RAQ.php";


$command = $_REQUEST['command'];
$login = "";
$password = "";
$id  = "";
$email_2  = "";
$name  = "";
$surname  = "";
$birth_day  = "";
$birth_month  = "";
$birth_year  = "";
$sex  = "";
$country  = "";
$city = "";

switch ($command) {
    case "auth": //http://37.57.92.40/trustme/controllers/auth_controller.php?command=auth&login=bodunjo855@gmail.com&password=rootttt
        $login = $_REQUEST['email'];
        $password = $_REQUEST['password'];

        if ($login != "" && $password != "") {
            $response = Auth($login, $password);
        } else {
            $response ="null field";
        }
        break;
    case "registration_min": //http://37.57.92.40/trustme/controllers/auth_controller.php?command=reg_min&email=&phone=809503856636616&password1=rootttt&password2=rootttt
        $email = $_REQUEST['email'];
        $phone = $_REQUEST['phone'];
        $password = $_REQUEST['password'];
        //$password2 = $_REQUEST['password2'];

        if ($email != "" && $phone != "" && $password != "") {
            $response = Registration_min($email, $phone, $password);

        } else {
            $response = "null field";
        }
        break;
    case "registration_full": //http://37.57.92.40/trustme/controllers/auth_controller.php?command=reg_full&id=1&email_2=fsdfsd@mads.ru&name=dasdasd&surname=fsdfsdfsdf&birth_day=14&birth_month=3&birth_year=1996&sex=1&country=Ucraine&city=Dnepro&photo
        $id = $_REQUEST['user_id'];
        $email_2 = $_REQUEST['email_2'];
        $name = $_REQUEST['name'];
        $surname = $_REQUEST['surname'];
        $birth_day = $_REQUEST['birth_day'];
        $birth_month = $_REQUEST['birth_month'];
        $birth_year = $_REQUEST['birth_year'];
        $sex = $_REQUEST['sex'];
        $country = $_REQUEST['country'];
        $city = $_REQUEST['city'];
        $user_photo = $_REQUEST['user_photo'];

        if ($id != "" && $email_2 != "" && $name != "" && $surname != "" && $birth_day != ""
            && $birth_month != "" && $birth_year != "" && $sex != "" && $country != "" && $city != ""
        ) {
            $response = Registration_full($id, $email_2, $name, $surname, $birth_day,
                $birth_month, $birth_year, $sex, $country, $city, $user_photo);
        } else {
            $response = "null field";
        }
        break;
    case "quit":  //http://37.57.92.40/trustme/controllers/auth_controller.php?command=quit&id=1
        $id = $_REQUEST['user_id'];
        if ($id != "") {
            $response = Quit($id);
        } else {
            $response = "null field";
        }
        break;
    case "forgot_pass":
        $login = $_REQUEST['email'];
        $response = Password_forgot($login);
        break;
    default:
        $response = "failed command";
        break;
}
logging($login." ".$password." ".$id." ".$email_2." ".$name." ".$surname." ".$birth_day
    ." ".$birth_month." ".$birth_year." ".$sex." ".$country." ".$city, json_encode($response), $command);

if(gettype($response) == "string"){
    $request = array('error' => $response);
    echo json_encode($request);
}else{
    echo json_encode($response);
}
