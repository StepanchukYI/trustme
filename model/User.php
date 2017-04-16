<?php
require "../class/sqldb_connection.php";
include_once ("../class/Samfuu.php");

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
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        else {
            $tmp_db_row = sqldb_connection::Select_Multi_View_users($user_id);   // достаем строки из БД
        }

        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }
        if (count($tmp_db_row) > 0) {
            //sqldb_connection::Update_Last_user_id($user_id, $tmp_db_row[49]['user_id']);// обновляем наш последний id
            return json_encode($tmp_db_row);
        } else {
            return $errorArr[0];
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
            return json_encode($tmp_db_row);
        } else {
            return $errorArr[0];
        }
    }

//Принимаем id user-a, для которого нужно вывести список всех его friends
    function Multi_View_friends($user_id)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        else {
            $tmp_db_row = sqldb_connection::Select_Multi_View_friends($user_id);   // достаем строки из БД
        }


        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }
        if (count($tmp_db_row) > 0) {
            return json_encode($tmp_db_row);
        } else {
            return $errorArr[0];
        }
    }

//Принимаем id user-a, для которого нужно вывести список всех его друзей которые онлайн
    function Multi_View_friends_online($user_id)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        else {
            //$last_user_id = sqldb_connection::Select_Last_user_id($user_id); // забираем последний id, который просмотрели
            $tmp_db_row = sqldb_connection::Select_Multi_View_friends_online($user_id);   // достаем строки из БД
            //sqldb_connection::Update_Last_user_id($user_id, $tmp_db_row[49]['user_id']); // обновляем наш последний id
        }

        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }
        if (count($tmp_db_row) > 0) {
            return json_encode($tmp_db_row);
        } else {
            return $errorArr[0];
        }
    }

//Принимаем id user-a и его поисковый запрос, возвращаем все возможные варианты совпадений
    function Search($user_id, $query)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        if ($query == "") $tmp_db_row = sqldb_connection::Select_Multi_View_users($user_id);
        if (strlen($query) > 0) {
            $query = trim($query);

            $tmp_db_row = sqldb_connection::Select_Search($user_id, $query);   // достаем строки из БД
        }
        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }

        if (count($tmp_db_row) > 0) {
            return json_encode($tmp_db_row);
        } else {
            return $errorArr[0];
        }
    }

//Принимаем id user-a и id user-a с которым хочет дружить или разорвать дружбу
    function Friendship($user_id, $user_id_friend)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        if ($user_id_friend == null) array_push($errorArr, "Failed id friend");
        else{
            $flag = sqldb_connection::Select_Check_Friendship($user_id, $user_id_friend);
            echo "check ";
            echo $flag;
            if($flag == true || $flag == false) {
                echo " update ";
                $tmp_db_row = sqldb_connection::Update_Friendship($user_id, $user_id_friend, !$flag);   // достаем строки из БД
            }
            else{
                echo " insert ";
                $tmp_db_row = sqldb_connection::Insert_Friendship($user_id, $user_id_friend, false);
            }

        }
        if ($tmp_db_row == true || $tmp_db_row == false) {
            return json_encode($tmp_db_row);
        }else {
            return $errorArr[0];
        }
    }

//Принимаем id user-a и id user-a заявку котрого он не хочет принимать
    function Friendship_Cancel($user_id, $user_id_friend)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        if ($user_id_friend == null) array_push($errorArr, "Failed id friend");
        else{
            sqldb_connection::Delete_Friendship($user_id, $user_id_friend);
        }
        if (count($errorArr) > 0) {
            return $errorArr[0];
        }
    }

//Принимаем id user-a, для которого нужно вывести список всех его заявок в друзья
    function Multi_View_Requests($user_id)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        else {
            $tmp_db_row = sqldb_connection::Select_Multi_View_Requests($user_id);   // достаем строки из БД
        }


        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }
        if (count($tmp_db_row) > 0) {
            return json_encode($tmp_db_row);
        } else {
            return $errorArr[0];
        }
    }




//Принимаем id user-a и возвращаем ему список следующих 50-ти заявок
    function See_More_Requests($user_id, $last_user_id)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        else{
            $last_user_id = sqldb_connection::Select_Last_user_id($user_id); // забираем последний id, который просмотрели
            $tmp_db_row = sqldb_connection::Select_See_More_Requests($user_id, $last_user_id);   // достаем строки из БД
            sqldb_connection::Update_Last_user_id($user_id, $tmp_db_row[49]['user_id']); // обновляем наш последний id
        }
        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }

        if (count($tmp_db_row) > 0) {
            return json_encode($tmp_db_row);
        } else {
            return $errorArr[0];
        }
    }
//Принимаем id user-a и возвращаем ему список следующих 50-ти user-ов
    function See_More($user_id)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        else{
            $last_user_id = sqldb_connection::Select_Last_user_id($user_id); // забираем последний id, который просмотрели
            $tmp_db_row = sqldb_connection::Select_See_More($user_id, $last_user_id);   // достаем строки из БД
            sqldb_connection::Update_Last_user_id($user_id, $tmp_db_row[49]['user_id']); // обновляем наш последний id
        }
        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }

        if (count($tmp_db_row) > 0) {
            return json_encode($tmp_db_row);
        } else {
            return $errorArr[0];
        }
    }
//Принимаем id user-a, поисковый запрос и возвращаем ему список следующих 50-ти ответов
    function See_More_Search($user_id, $query)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        else{
            $last_user_id = sqldb_connection::Select_Last_user_id($user_id); // забираем последний id, который просмотрели
            $tmp_db_row = sqldb_connection::Select_See_More_Search($user_id, $last_user_id, $query);   // достаем строки из БД
            sqldb_connection::Update_Last_user_id($user_id, $tmp_db_row[49]['user_id']); // обновляем наш последний id
        }
        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }

        if (count($tmp_db_row) > 0) {
            return json_encode($tmp_db_row);
        } else {
            return $errorArr[0];
        }
    }
//Принимаем id user-a и возвращаем ему список следующих 50-ти friends online
    function See_More_Friends_online($user_id)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        else{
            $last_user_id = sqldb_connection::Select_Last_user_id($user_id); // забираем последний id, который просмотрели
            $tmp_db_row = sqldb_connection::Select_See_More_friends_online($user_id, $last_user_id);   // достаем строки из БД
            sqldb_connection::Update_Last_user_id($user_id, $tmp_db_row[49]['user_id']); // обновляем наш последний id
        }
        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }

        if (count($tmp_db_row) > 0) {
            return json_encode($tmp_db_row);
        } else {
            return $errorArr[0];
        }
    }
//Принимаем id user-a и возвращаем ему список следующих 50-ти friends
    function See_More_Friends($user_id)
    {
        $errorArr = array();    //создание массива ошибок.

        if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id
        else{
            $last_user_id = sqldb_connection::Select_Last_user_id($user_id); // забираем последний id, который просмотрели
            $tmp_db_row = sqldb_connection::Select_See_More_friends($user_id, $last_user_id);   // достаем строки из БД
            sqldb_connection::Update_Last_user_id($user_id, $tmp_db_row[49]['user_id']); // обновляем наш последний id
        }
        if (count($tmp_db_row) == 0) {
            return "NOTHING";
        }

        if (count($tmp_db_row) > 0) {
            return json_encode($tmp_db_row);
        } else {
            return $errorArr[0];
        }
    }
}