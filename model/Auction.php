<?php
require "../class/sqldb_connection.php";
include_once ("../class/Samfuu.php");

/*
 * Данные для групировки списков Аукционных товаров, для всех видов пользователей
 * Содержит все нужные для пользователя методы( для подачи запросов в БД и приема и групировки данных)
 */

/*
 * Функция для добавлнеии ставки по лоту либо выставления товара на аукцион
 */

function makeBid($product_id, $user_id, $user_bid)
{
    $errorArr = array();//создание массива ошибок.

    if ($user_bid == "" && strlen($user_bid) < 1 ) {
        array_push($errorArr, "Incorrect bid amount");
    }

    if (count($errorArr) == 0) {
        sqldb_connection::bid_create($product_id, $user_id, $user_bid, date("Y-m-d h:m:s"));
        return "Lot created";
    } else {
        return $errorArr;
    }
}

/*
 * Функция для удаления лота с аукциона
 */

function removeBid($product_id)
{
    if($product_id != null){
        sqldb_connection::bid_remove($product_id); // удаляем лот из базы данных
        return "Lot successfully deleted";
    }
    else{
        return "Wrong lot id";
    }
}

/*
 * Принимаем user_id и возвращаем список ставок этого пользователя
 */

function showBidsByUser($user_id)
{
    $errorArr = array();//создание массива ошибок.
    if ($user_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id

    $tmp_db_row = sqldb_connection::select_multi_view_bids_by_user($user_id);   // достаем строки из БД

    if (count($tmp_db_row) == 0) {
        return "NOTHING";
    }
    if (count($tmp_db_row) > 0) {
        return $tmp_db_row;
    } else {
        return $errorArr[0];
    }
}


/*
* Принимаем product_id и возвращаем список ставок по этому товару
*/

function showBidsByProduct($product_id)
{
    //return $product_id;
    $errorArr = array();//создание массива ошибок.

    if ($product_id == null) array_push($errorArr, "Failed id");  // проверка на пустой id

    $tmp_db_row = sqldb_connection::select_multi_view_bids_by_lot($product_id);   // достаем строки из БД


    if (count($tmp_db_row) == 0) {
        return "NOTHING";
    }
    if (count($tmp_db_row) > 0) {
        return $tmp_db_row;
    } else {
        return $errorArr[0];
    }
}


/*
 * Принимаем bid_id и проверяем ставку на актуальность и актиность товара
 */

function ifBidValid()
{


}