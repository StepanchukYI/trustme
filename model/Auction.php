<?php
require "../class/sqldb_connection.php";
require("../class/Samfuu.php");

/*
 * Данные для групировки списков Аукционных товаров, для всех видов пользователей
 * Содержит все нужные для пользователя методы( для подачи запросов в БД и приема и групировки данных)
 */

/*
 * Функция для добавлнеии ставки по лоту либо выставления товара на аукцион
 */
class Auction{
    function Make_bid($product_id, $user_id, $user_bid)
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

    function Remove_bid($product_id)
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

    function Show_bids_by_user($user_id)
    {

        if ($user_id != null) {
            $tmp_db_row = sqldb_connection::select_multi_view_bids_by_user($user_id);   // достаем строки из БД
            if (count($tmp_db_row) == 0) {
                return "NOTHING";
            } else {
                return $tmp_db_row;
            }
        }
    }


    /*
    * Принимаем product_id и возвращаем список ставок по этому товару
    */


    function Show_bids_by_product($product_id)
    {
        if ($product_id != null) {
            $tmp_db_row = sqldb_connection::select_multi_view_bids_by_lot($product_id);   // достаем строки из БД
            if (count($tmp_db_row) == 0) {
                return "NOTHING";
            } else {
                return $tmp_db_row;
            }
        }
    }


    /*
     * Принимаем bid_id и проверяем ставку на актуальность и актиность товара
     */

    function ifBidValid()
    {


    }
}