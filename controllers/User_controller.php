<?php
require "../model/User.php";

$command = $_GET['command'];
$user_id = $_GET['user_id'];

$User = new User();

switch ($command) {
    case "Multi_View_Users"://Полный список пользователей
        if ($user_id != "") {
            echo $User->Multi_View_users($user_id);//ok
        } else {
            logging($user_id, "null field",$command);
            echo "null field";
        }
        break;
    case "Multi_View_Friends"://Полный список друзей
        if ($user_id != "") {
            echo $User->Multi_View_friends($user_id);//ok
        } else {
            logging($user_id, "null field",$command);
            echo "null field";
        }
        break;
    case "Multi_View_Friends_Online"://Полный список друзей онлайн
        if ($user_id != "") {
            echo $User->Multi_View_friends_online($user_id);//ok
        } else {
            logging($user_id, "null field",$command);
            echo "null field";
        }
        break;
    case "Multi_View_Requests"://Полный список заявок в друзья
        if ($user_id != "") {
            echo $User->Multi_View_Requests($user_id);//ok
        } else {
            logging($user_id, "null field",$command);
            echo "null field";
        }
        break;
    case "Search"://Поиск
        $query = $_GET['query'];
        if ($user_id != "" && $query != "") {
            echo $User->Search($user_id, $query);//ok
        } else {
            logging($user_id . " " . $query, "null field",$command);
            echo "null field";
        }
        break;
    case "Single_View_User"://Посмотреть полную информацию о пользователе
        $user_id_select = $_GET['user_id_select'];
        if ($user_id != "" && $user_id_select != "") {
            echo $User->Single_View_user($user_id, $user_id_select);//ok
        } else {
            logging($user_id . " " . $user_id_select, "null field",$command);
            echo "null field";
        }
        break;
    case "Friendship"://Добавление в друзья, либо удаление из друзей(перенос в список заявок)(В обоих случаях указать только свой айди и айди друга)
        $user_id_friend = $_GET['user_id_friend'];
        if ($user_id != "" && $user_id_friend != "") {
            echo $User->Friendship($user_id, $user_id_friend);
        } else {
            logging($user_id . " " . $user_id_friend, "null field",$command);
            echo "null field";
        }
        break;
    case "Friendship_Cancel"://Удаление из списка заявок
        $user_id_friend = $_GET['user_id_friend'];
        if ($user_id != "" && $user_id_friend != "") {
            echo $User->Friendship_Cancel($user_id, $user_id_friend);
        } else {
            logging($user_id . " " . $user_id_friend, "null field",$command);
            echo "null field";
        }
        break;
    default:
        logging($command . " ", "failed command",$command);
        echo "failed command";
        break;
}
/*
 * http://localhost/trustme/controllers/User_controller.php?command=Multi_View_Users&user_id=1
 * http://localhost/trustme/controllers/User_controller.php?command=Single_View_User&user_id=1&user_id_select=2
 * http://localhost/trustme/controllers/User_controller.php?command=Multi_View_friends&user_id=1
 * http://localhost/trustme/controllers/User_controller.php?command=Multi_View_Requests&user_id=1
 * http://localhost/trustme/controllers/User_controller.php?command=Search&user_id=1&query=zafezfe
 * http://localhost/trustme/controllers/User_controller.php?command=Friendship&user_id=1&user_id_friend=2
 * http://localhost/trustme/controllers/User_controller.php?command=Friendship_Cancel&user_id=1&user_id_friend=2
*/