<?php
require "../model/User.php";
include_once("../class/Samfuu.php");

$command = $_REQUEST['command'];
$user_id = $_REQUEST['user_id'];
$query = "";
$user_id_select = "";
$user_id_friend = "";
$User = new User();

switch ($command)
{
    case "multi_view_users"://Полный список пользователей
        $response = $User->Multi_View_users($user_id);
        break;
    case "multi_view_friends"://Полный список друзей
        $response = $User->Multi_View_friends($user_id);
        break;
    case "multi_view_friends_online"://Полный список друзей онлайн
        $response = $User->Multi_View_friends_online($user_id);
        break;
    case "multi_view_requests"://Полный список заявок в друзья
        $response = $User->Multi_View_Requests($user_id);
        break;
    case "search"://Поиск
        $query = $_REQUEST['query'];
        $response = $User->Search($user_id, $query);
        break;
    case "single_view_user"://Посмотреть полную информацию о пользователе
        $user_id_select = $_REQUEST['user_id_select'];
        $response = $User->Single_View_user($user_id, $user_id_select);
        break;
    case "friendship"://Добавление в друзья, либо удаление из друзей(перенос в список заявок)(В обоих случаях указать только свой айди и айди друга)
        $user_id_friend = $_REQUEST['user_id_friend'];
        $response = $User->Friendship($user_id, $user_id_friend);
        break;
    case "friendship_cancel"://Удаление из списка заявок
        $user_id_friend = $_REQUEST['user_id_friend'];
        $response = $User->Friendship_Cancel($user_id, $user_id_friend);
        break;
    default:
        $response = "Incorrect command";
        break;
}
logging($user_id." ".$query . " ". $user_id_select. " " .$user_id_friend, json_encode($response), $command);
echo json_encode($response);

/*
 * http://localhost/trustme/controllers/User_controller.php?command=Multi_View_Users&user_id=1
 * http://localhost/trustme/controllers/User_controller.php?command=Single_View_User&user_id=1&user_id_select=2
 * http://localhost/trustme/controllers/User_controller.php?command=Multi_View_friends&user_id=1
 * http://localhost/trustme/controllers/User_controller.php?command=Multi_View_Requests&user_id=1
 * http://localhost/trustme/controllers/User_controller.php?command=Search&user_id=1&query=zafezfe
 * http://localhost/trustme/controllers/User_controller.php?command=Friendship&user_id=1&user_id_friend=2
 * http://localhost/trustme/controllers/User_controller.php?command=Friendship_Cancel&user_id=1&user_id_friend=2
*/