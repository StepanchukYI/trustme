<?php
require "../class/sqldb_connection.php";

/*
 * User модель( как ее создавать я шарю, а что внутри пока загадка)
 * Данные для групировки списков друзей, списка сообщений.
 * Содержит все нужные для пользователя методы( для подачи запросов в БД и приема и групировки данных)
 */

class User
{
//Принимаем id user-a, для которого нужно вывести список всех user-ов
    function Multi_View_users($user_id)
    {
        if ($user_id == null) return "Failed id";  // проверка на пустой id
        else {
            $tmp_db_row = sqldb_connection::Select_Multi_View_users($user_id);   // достаем строки из БД
        }

        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }
        if (count($tmp_db_row) > 0) {
            return $tmp_db_row;
        }
    }

//Принимаем id user-a, для которого нужно вывести описание выбранного им user-a
    function Single_View_user($user_id, $user_id_select)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        if ($user_id_select == null) array_push($errorArr, "Failed id select");
        else {
            $tmp_db_row = sqldb_connection::Select_Single_View_user($user_id_select);   // достаем строки из БД
        }

        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }
        if (count($tmp_db_row) > 0) {
            return $tmp_db_row;
        } else {
            return $errorArr;
        }
    }

//Принимаем id user-a, для которого нужно вывести список всех его friends
    function Multi_View_friends($user_id)
    {
        if ($user_id == null) return "Failed id";  // проверка на пустой id
        else {
            $tmp_db_row = sqldb_connection::Select_Multi_View_friends($user_id);   // достаем строки из БД
        }


        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }
        if (count($tmp_db_row) > 0) {
            return $tmp_db_row;
        }
    }

//Принимаем id user-a, для которого нужно вывести список всех его друзей которые онлайн
    function Multi_View_friends_online($user_id)
    {
        if ($user_id == null) return "Failed id";  // проверка на пустой id

        else {
            $tmp_db_row = sqldb_connection::Select_Multi_View_friends_online($user_id);   // достаем строки из БД
        }

        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }
        if (count($tmp_db_row) > 0) {
            return $tmp_db_row;
        }
    }

//Принимаем id user-a и его поисковый запрос, возвращаем все возможные варианты совпадений
    function Search($user_id, $query)
    {
        if ($user_id == null) return "Failed id";  // проверка на пустой id
        if ($query == "") $tmp_db_row = sqldb_connection::Select_Multi_View_users($user_id);

        if (strlen($query) > 0) {

            $query = trim($query);
            $tmp_db_row = sqldb_connection::Select_Search($user_id, $query);   // достаем строки из БД
        }
        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }

        if (count($tmp_db_row) > 0) {
            return $tmp_db_row;
        }
    }
//Принимаем id user-a и id user-a которому хочет отправить заявку
    function Friendship_Request($user_id, $user_id_friend)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        if ($user_id_friend == null) array_push($errorArr, "Failed id friend");

        if(count($errorArr) == 0){
            sqldb_connection::Insert_Friendship_Request($user_id, $user_id_friend);
            return sqldb_connection::Auth_Select_All_id($user_id_friend);
        } else {
            return $errorArr;
        }
    }
//Принимаем id user-a и id user-a которого удаляешь из списка друзей
    function Friendship_Cancel($user_id, $user_id_friend)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        if ($user_id_friend == null) array_push($errorArr, "Failed id friend");

        if(count($errorArr) == 0){
            sqldb_connection::Update_Friendship($user_id, $user_id_friend);
            return sqldb_connection::Auth_Select_All_id($user_id_friend);
        } else {
            return $errorArr;
        }
    }
//Принимаем id user-a и id user-a с которым подтверждаешь заявку в друзья
    function Friendship_Request_Agree($user_id, $user_id_friend)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        if ($user_id_friend == null) array_push($errorArr, "Failed id friend");

        if(count($errorArr) == 0){
            sqldb_connection::Update_Friendship_Request_Agree($user_id, $user_id_friend);
            return sqldb_connection::Auth_Select_All_id($user_id_friend);
        } else {
            return $errorArr;
        }
    }
//Принимаем id user-a и id user-a заявку которого отменяешь
    function Friendship_Request_Cancel($user_id, $user_id_friend)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        if ($user_id_friend == null) array_push($errorArr, "Failed id friend");

        if(count($errorArr) == 0){
            sqldb_connection::Delete_Friendship_Request_Cancel($user_id, $user_id_friend);
            return sqldb_connection::Auth_Select_All_id($user_id_friend);
        } else {
            return $errorArr;
        }
    }
//Принимаем id user-a, для которого нужно вывести список всех его заявок в друзья
    function Multi_View_Requests_Input($user_id)
    {
        if ($user_id == null) return "Failed id";  // проверка на пустой id
        else {
            $tmp_db_row = sqldb_connection::Select_Multi_View_Requests_Input($user_id);   // достаем строки из БД
        }


        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }
        if (count($tmp_db_row) > 0) {
            return $tmp_db_row;
        }
    }
//Принимаем id user-a, для которого нужно вывести список всех его исходящих заявок в друзья
    function Multi_View_Requests_Output($user_id)
    {
        if ($user_id == null) return "Failed id";  // проверка на пустой id
        else {
            $tmp_db_row = sqldb_connection::Select_Multi_View_Requests_Output($user_id);   // достаем строки из БД
        }


        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }
        if (count($tmp_db_row) > 0) {
            return $tmp_db_row;
        }
    }
}