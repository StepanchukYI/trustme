<?php

require "../class/sqldb_connection.php";
require "../class/photo_parser.php";

include_once("../class/Samfuu.php");

/*
 * Product модель( верность написанного ниже нахожу под БОЛЬШИМ СОМНЕНИЕМ, ЖЕНЯ ПОСМОТРИ И ПРОКОНСУЛЬТИРУЙ ПЛЕЗ)
 * Содержит все нужные для пользователя методы( для подачи запросов в БД и приема и групировки данных)
 */


/*
 * Функция для ДОБАВЛЕНИЯ ТОВАРА пользователем
 * */
class Product {
    function Add_product( $user_id, $product_name, $category, $price, $made_in, $description, $product_country, $product_city, $product_photo )
    {
        $errorArr = array();//создание массива ошибок.

        if ($product_name == "" && strlen($product_name) < 2 && strlen($product_name) > 30) {
            array_push($errorArr, "Incorrect product_photo name");
        }
        if ($category == "" && strlen($category) < 5 && strlen($category) > 15) {
            array_push($errorArr, "Incorrect product_photo category");
        }
        if ($made_in == "" && strlen($made_in) < 2 && strlen($made_in) > 15) {
            array_push($errorArr, "Incorrect product_photo manufacturer");
        }
        if ($description == "" && strlen($description) < 20 && strlen($description) > 200) {
            array_push($errorArr, "Incorrect product_photo description");
        }
        if ($product_country == "" && strlen($product_country) < 3 && strlen($product_country) > 60) {
            array_push($errorArr, "Incorrect product_photo country");
        }
        if ($product_city == "" && strlen($product_city) < 2 && strlen($product_city) > 20) {
            array_push($errorArr, "Incorrect product_photo city");
        }
        if ($price == "" && strlen($price) < 1 ) {
            array_push($errorArr, "Incorrect product_photo price");
        }

        if (count($errorArr) == 0) {

            $product_id = sqldb_connection::Add_product( $product_name, $category, $price, $user_id,
                0,"disable", $made_in, $description, date('Y-m-d H:i:s'),
                $product_country, $product_city);

            if($product_photo != ""){
                photo_parser::Getpicture_from_product($product_photo,$product_id);

            }

            sqldb_connection::Product_photo($product_id);

            $tmp_array = sqldb_connection::Show_product_singleview($product_id);
            //array_push($tmp_array, sqldb_connection::Show_product_multiview($product_id));
            return $tmp_array;
        } else {
            return $errorArr;
        }
    }
    /*
     * Выставляем товар на лот
     * */
    function Product_to_lot($product_id)
    {
        $errorArr = array();
        $bid_date = date('Y-m-d H:i:s');
        $tmp_db_row = sqldb_connection::Lot_Helper($product_id); // чтобы получить ид юзера и прайс

        sqldb_connection::Product_to_auction($product_id, $tmp_db_row['owner_id'], $tmp_db_row['price'], $bid_date);

        if($tmp_db_row != null){
            sqldb_connection::Update_product_status($product_id, "active");   // обновляем статус на active, если мы успешно выставили товар на аукцион
            return sqldb_connection::Show_product_singleview($product_id);
        }
        else{
            array_push($errorArr, "Failed to up product_photo in auction");
            return $errorArr;
        }
    }

    /*
     * Удаление продукта
     * */
    function Product_delete($product_id)
    {
        $errorArr = array();
        if($product_id != null){
            sqldb_connection::Delete_product($product_id); // удаляем продукт из базы данных
            return "Product successfully deleted";
        }
        else{
            array_push($errorArr, "Failed product_photo delete");
            return $errorArr;
        }
    }

    /*
     * Редактирование продукта
     * */
    function Product_edit($user_id,$product_id, $product_name, $category, $price, $made_in, $description, $product_country, $product_city, $product_photo)
    {
        $errorArr = array();//создание массива ошибок.

        if ($product_name == "" && strlen($product_name) < 2 && strlen($product_name) > 30) {
            array_push($errorArr, "Incorrect product_photo name");
        }
        if ($category == "" && strlen($category) < 5 && strlen($category) > 15) {
            array_push($errorArr, "Incorrect product_photo category");
        }
        if ($made_in == "" && strlen($made_in) < 2 && strlen($made_in) > 15) {
            array_push($errorArr, "Incorrect product_photo manufacturer");
        }
        if ($description == "" && strlen($description) < 20 && strlen($description) > 200) {
            array_push($errorArr, "Incorrect product_photo description");
        }
        if ($product_country == "" && strlen($product_country) < 3 && strlen($product_country) > 60) {
            array_push($errorArr, "Incorrect product_photo country");
        }
        if ($product_city == "" && strlen($product_city) < 2 && strlen($product_city) > 20) {
            array_push($errorArr, "Incorrect product_photo city");
        }
        if ($price == "" && strlen($price) < 1 ) {
            array_push($errorArr, "Incorrect product_photo price");
        }


        if (count($errorArr) == 0) {
            sqldb_connection::Product_Edit($product_id, $product_name, $category, $price,
                $made_in, $description, date("Y-m-d h:m:s"), $product_country,
                $product_city);

            if($product_photo != ""){
                photo_parser::Getpicture_from_product($product_photo,$product_id);
                sqldb_connection::Product_photo_update($product_id);
            }
            return "Product_update";//sqldb_connection::Show_product_singleview($product_id);
        } else {
            return $errorArr;
        }
    }

    /*
     * Поиск продукта по критериям , см выборку, возвращает первые 50
     * */
    function Product_search($product_id, $query)
    {
        $errorArr = array();

        if($product_id == null){array_push($errorArr, "Failed id");}
        if($query == ""){$tmp_db_row = sqldb_connection::Show_product_multiview($product_id);}
        if(strlen($query)>0){
            $query = trim($query);
            $tmp_db_row = sqldb_connection::Product_Search($product_id,$query);
        }
        if(count($tmp_db_row) == 0){
            return "NOTHING";
        }
        if(count($tmp_db_row)>0){
            return $tmp_db_row;
        }
        else{
            return $errorArr;
        }
    }

    /*
     * Функция на проверку является ли юзер овнером или байером
     * */
    function Owner_buyer_status($user_id)
    {
        $errorArr = array();

        if ($user_id != null)
        {
            $tmp_db_row = sqldb_connection::Get_owner_buyer($user_id); // чтобы получить ид овнера и байера

            if($tmp_db_row['owner_id'] == $user_id ){
                $status = "owner";
            }
            if($tmp_db_row['buyer_id'] == $user_id){
                $status = "buyer";
            }
            return $status;
        }
        else{
            array_push($errorArr, "Failed to get owner/buyer status");
            return $errorArr;
        }
    }

    /*
     *Синглвью продукта
     * */
    function Product_singleview($user_id, $product_id)
    {
        $errorArr = array();

        if($product_id != null){
            $tmp_db_row = sqldb_connection::Show_product_singleview($product_id);
            array_push($tmp_db_row,Owner_buyer_status($user_id));
            return $tmp_db_row;
        }
        else{
            array_push($errorArr, "Failed to singleview product_photo");
            return $errorArr;
        }
    }


    /*
     * Мультивью продукта
     * */
    function Product_multiview($user_id, $product_id)
    {
        $errorArr = array();

        if($product_id != null){
            $tmp_db_row = sqldb_connection::Show_product_multiview($product_id);
            array_push($tmp_db_row,Owner_buyer_status($user_id));
            return json_decode($tmp_db_row);
        }
        else{
            array_push($errorArr,"Failed to multiview product_photo");
            return $errorArr;
        }
    }

    /*
     * что тут ещё должно быть?
     * */
    function List_product($category)
    {
        $errorArr = array();

        if($category != null){
            $tmp_db_row = sqldb_connection::Get_list_product($category);
            return $tmp_db_row;
        }
        else{
            array_push($errorArr,"Failed to show list product_photo");
            return $errorArr;
        }

    }

    function List_my_product($user_id)
    {
        $errorArr = array();

        if($user_id != null){
            $tmp_db_row = sqldb_connection::Get_list_my_product($user_id);
            return $tmp_db_row;
        }
        else{
            array_push($errorArr,"Failed to show list product_photo");
            return $errorArr;
        }
    }

    function List_orders($user_id)
    {
        $errorArr = array();

        if($user_id != null){
            $tmp_db_row = sqldb_connection::Get_list_orders($user_id);
            return $tmp_db_row;
        }
        else{
            array_push($errorArr,"Failed to show list product_photo");
            return $errorArr;
        }
    }

    function Add_to_favourite_product($user_id, $product_id)
    {
        $errorArr = array();
        $add_date = date('Y-m-d H:i:s');

        if($user_id != null && $product_id != null){
            sqldb_connection::Add_favourite_product($user_id, $product_id, $add_date);
            return sqldb_connection::Show_product_singleview($product_id);
        }
        else{
            array_push($errorArr,"Failed to add favourite product_photo");
            return $errorArr;
        }
    }

    function List_favourite_product($user_id){
        $errorArr = array();

        if($user_id != null){
            $tmp_db_row = sqldb_connection::Get_list_favourite($user_id);
            return $tmp_db_row;
        }
        else{
            array_push($errorArr,"Failed to show list product_photo");
            return $errorArr;
        }
    }
}