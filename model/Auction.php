<?php
require "../class/sqldb_connection.php";

/*
 * Данные для групировки списков Аукционных товаров, для всех видов пользователей
 * Содержит все нужные для пользователя методы( для подачи запросов в БД и приема и групировки данных)
 */

class Auction
{
    /*
     * Функция для выставления товара на аукцион
     */

    function createLot($product_id, $user_id, $user_bid)
    {
        $errorArr = array();//создание массива ошибок.

        if ($user_bid == "" && strlen($user_bid) < 1 ) {
            array_push($errorArr, "Incorrect minimum bid for lot");
        }

        $bid_date = date('Y-m-d H:i:s');

        if (count($errorArr) == 0) {
            sqldb_connection::bid_create($product_id, $user_id, $user_bid, $bid_date);
            return "Lot created";
        } else {
            return json_encode($errorArr);
        }

    }

    /*
     * Функция для добавлнеии ставки по лоту
     */

    function makeBid($product_id, $user_id, $user_bid, $bid_date)
    {
        $errorArr = array();//создание массива ошибок.

        if ($user_bid == "" && strlen($user_bid) < 1 ) {
            array_push($errorArr, "Incorrect bid amount");
        }

        $bid_date = date('Y-m-d H:i:s');

        if (count($errorArr) == 0) {
            sqldb_connection::lot_create($product_id, $user_id, $user_bid, $bid_date);
            return "Lot created";
        } else {
            return json_encode($errorArr);
        }


    }

    /*
     * Принимаем user_id и возвращаем список ставок этого пользователя
     */

    function showBidsByUser()
    {



    }


    /*
    * Принимаем product_id и возвращаем список ставок по этому товару
    */

    function showBidsByproduct()
    {



    }


    /*
     * Принимаем bid_id и проверяем ставку на актуальность и актиность товара
     */

    function ifBidCorrect()
    {



    }




}