<?php
require "../class/sqldb_connection.php";
require "../class/photo_parser.php";
include_once("../class/Samfuu.php");

/*
 * Файл для модуля авторизации на сервере
 * функции и методы для авторизаии(изменения данных в БД)
 */

/*
 * Функция для обновления статуса ЗАРЕГЕСТРИРОВАННОГО ПОЛЬЗОВАТЕЛЯ на онлайн
 */
function Auth($login, $password)
{

    $errorArr = array();    //создание массива ошибок.

    if ($login == "") array_push($errorArr, "Failed email or phone number");  // проверка на пустые поля.
    if ($password == "") array_push($errorArr, "Failed password");  //

    $tmp_db_row = sqldb_connection::Auth_Select($login);   // достаем строку из БД

    if (count($tmp_db_row) == 0) {
        array_push($errorArr, "Failed email or phone number");
    } else {
        if ($password != $tmp_db_row[0]['password']) array_push($errorArr, "Failed password");
    }
    if (count($errorArr) == 0) {
        sqldb_connection::Update_online_status($tmp_db_row[0]['user_ID'], 1,
            date("Y-m-d h:m:s"));// обновляем статус на онлайн
        return sqldb_connection::Auth_Select_All($login, $password);

    } else {
        return $errorArr;
    }
}

/*
 * Функция для первичной регистрации пользователя.
 */
function Registration_min($email, $phone, $password1)
{

    $errorArr = array();//создание массива ошибок.

    //Валидация мыла
    if ((strlen($email) <= 6) && (preg_match("~^([a-z0-9_\-\.])+@
    ([a-z0-9_\-\.])+\.([a-z0-9])+$~i", $email) != true)) {
        array_push($errorArr, "Incorrect email");
    }
    //валидация пароля
    if ($password1 == "" && strlen($password1) <= 6 && strlen($password1) >= 32) {
        array_push($errorArr, "Incorrect password");
    }
    //сравнение паролей пароля
    /*if ($password1 != $password2) {
        array_push($errorArr, "Passwords are different");
    }*/


    $tmp_db_row = sqldb_connection::Registration($phone, $email);

    if (count($tmp_db_row) != 0) {
        if ($tmp_db_row[0]['phone'] == $phone) array_push($errorArr, "phone already using");
        if ($tmp_db_row[0]['email'] == $email) array_push($errorArr, "email already using");
    }


    if (count($errorArr) == 0) {
        sqldb_connection::Registration_min($phone, $password1, $email, date("Y-m-d h:m:s"),
            Temp_code());
        return sqldb_connection::Auth_Select_All($email, $password1);
    } else {
        return $errorArr;
    }
}

/*
 * Функция для получения временного пароля для продолжения регистрации
 */
function Temp_code()
{
    $tempcode = "";
    for ($i = 1; $i <= 6; $i++) {
        $tempcode .= rand(0, 9);
    }
    return $tempcode;
}

/*
 * Функция для полной регистрации пользователя
 */
function Registration_full($id, $email_2, $name, $surname, $birth_day, $birth_month,
                           $birth_year, $sex, $country, $city, $photo)
{
    $errorArr = array();//создание массива ошибок.

    /*
        if ((strlen($email_2) <= 6) && (preg_match("~^([a-z0-9_\-\.])+@([a-z0-9_\-\.])
    +\.([a-z0-9])+$~i", $email_2) != true)) {
            array_push($errorArr, "Incorrect email");
        }
            * */
        if ($birth_day == "" && strlen($birth_day) < 1 && strlen($birth_day) > 31) {
            array_push($errorArr, "Incorrect birthday");
        }
        if ($birth_month == "" && strlen($birth_month) < 1 && strlen($birth_month) > 12) {
            array_push($errorArr, "Incorrect birthday month");
        }
        if ($birth_year == "" && strlen($birth_year) < 1930 && strlen($birth_year) > date('Y')) {
            array_push($errorArr, "Incorrect birthday year");
        }


    if (count($errorArr) == 0) {
        sqldb_connection::Registration_full($id, $email_2, $name, $surname, $birth_day,
            $birth_month, $birth_year, $sex, date("Y-m-d h:m:s"),
            1, $country, $city);

        photo_parser::Getpicture_from_User($photo,$id);


        return sqldb_connection::Auth_Select_All_id($id);
    } else {
        return $errorArr;
    }


}

/*
 * Функция для изменения статуса пользователя на офлайн
 */
function Quit($id)
{
    sqldb_connection::Update_online_status($id, 0, date("Y-m-d h:m:s"));   // обновляем статус на офлайн
    return sqldb_connection::Auth_Select_All_id($id);
}
