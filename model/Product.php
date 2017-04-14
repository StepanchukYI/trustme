<?php
require "../class/sqldb_connection.php";
/*
 * Product модель( верность написанного ниже нахожу под БОЛЬШИМ СОМНЕНИЕМ, ЖЕНЯ ПОСМОТРИ И ПРОКОНСУЛЬТИРУЙ ПЛЕЗ)
 * Содержит все нужные для пользователя методы( для подачи запросов в БД и приема и групировки данных)
 */
class Product
{

    /*
     * Функция для ДОБАВЛЕНИЯ ТОВАРА пользователем
     * */
    function Add_product( $user_id, $product_id, $product_name, $category, $price, $made_in, $description, $product_country, $product_city, $product_photo )
    {
        $errorArr = array();//создание массива ошибок.

        if ($product_name == "" && strlen($product_name) < 2 && strlen($product_name) > 30) {
            array_push($errorArr, "Incorrect product name");
        }
        if ($category == "" && strlen($category) < 5 && strlen($category) > 15) {
            array_push($errorArr, "Incorrect product category");
        }
        if ($made_in == "" && strlen($made_in) < 2 && strlen($made_in) > 15) {
            array_push($errorArr, "Incorrect product manufacturer");
        }
        if ($description == "" && strlen($description) < 20 && strlen($description) > 200) {
            array_push($errorArr, "Incorrect product description");
        }
        if ($product_country == "" && strlen($product_country) < 3 && strlen($product_country) > 60) {
            array_push($errorArr, "Incorrect product country");
        }
        if ($product_city == "" && strlen($product_city) < 2 && strlen($product_city) > 20) {
            array_push($errorArr, "Incorrect product city");
        }
        if ($price == "" && strlen($price) < 1 ) {
            array_push($errorArr, "Incorrect product price");
        }

        if (count($errorArr) == 0) {
            sqldb_connection::Add_product($product_id, $product_name, $category, $price, $user_id, "","disable", $made_in, $description, date('Y-m-d H:i:s'), $product_country, $product_city, $product_photo);
            return "Product created";
        } else {
            return json_encode($errorArr);
        }
    }

    /*
     * Выставляем товар на лот
     * */
    function Product_to_lot( $product_id)
    {
        $errorArr = array();
        $bid_date = date('Y-m-d H:i:s');
        $tmp_db_row = sqldb_connection::Lot_Helper($product_id); // чтобы получить ид юзера и прайс

        $tempArr = sqldb_connection::Product_to_auction($product_id, $tmp_db_row[0]['user_id'], $tmp_db_row[0]['price'], $bid_date);

        if($tempArr != null ){
            sqldb_connection::Update_product_status($product_id, "active");   // обновляем статус на active, если мы успешно выставили товар на аукцион
            return "Product status is Active";
        }
        else{
            array_push($errorArr, "Failed to up product in auction");
            return json_encode($errorArr);
        }

    }

    /*
     * Удаление продукта
     * */
    function Product_delete($product_id)
    {
        if($product_id != null){
            sqldb_connection::Delete_product($product_id); // удаляем продукт из базы данных
            return "Product successfully deleted";
        }
        else{
            return "Product doesnt exist";
        }
    }

    /*
     * Редактирование продукта
     * */
    function Product_edit($user_id,$product_id, $product_name, $category, $price, $made_in, $description, $product_country, $product_city, $product_photo)
    {
        $errorArr = array();//создание массива ошибок.

        if ($product_name == "" && strlen($product_name) < 2 && strlen($product_name) > 30) {
            array_push($errorArr, "Incorrect product name");
        }
        if ($category == "" && strlen($category) < 5 && strlen($category) > 15) {
            array_push($errorArr, "Incorrect product category");
        }
        if ($made_in == "" && strlen($made_in) < 2 && strlen($made_in) > 15) {
            array_push($errorArr, "Incorrect product manufacturer");
        }
        if ($description == "" && strlen($description) < 20 && strlen($description) > 200) {
            array_push($errorArr, "Incorrect product description");
        }
        if ($product_country == "" && strlen($product_country) < 3 && strlen($product_country) > 60) {
            array_push($errorArr, "Incorrect product country");
        }
        if ($product_city == "" && strlen($product_city) < 2 && strlen($product_city) > 20) {
            array_push($errorArr, "Incorrect product city");
        }
        if ($price == "" && strlen($price) < 1 ) {
            array_push($errorArr, "Incorrect product price");
        }

        if (count($errorArr) == 0) {
            sqldb_connection::Update_product($product_id, $product_name, $category, $price, $user_id, "","disable", $made_in, $description, date('Y-m-d H:i:s'), $product_country, $product_city, $product_photo);
            return "Product update";
        } else {
            return json_encode($errorArr);
        }
    }

    /*
     * Поиск продукта по критериям , см выборку, возвращает первые 50
     * */
    function Product_search($product_id, $query)
    {
        $errorArr = array();

        if($product_id == null){
            array_push($errorArr, "Failer id");
        }
        if($query == ""){
            $tmp_db_row = sqldb_connection::Show_product_multiview($product_id);
        }
        if(strlen($query)>0){
            $query = trim($query);
            $tmp_db_row = sqldb_connection::Product_Search($product_id,$query);
        }
        if(count($tmp_db_row) == 0){
            return "NOTHING";
        }
        if(count($tmp_db_row)>0){
            return json_encode($tmp_db_row);
        }
        else{
            return json_encode($errorArr);
        }
    }

    /*
     * Функция на проверку является ли юзер овнером или байером
     * */
    function Owner_buyer_status($user_id)
    {
        $tmp_db_row = sqldb_connection::Get_owner_buyer($user_id); // чтобы получить ид овнера и байера

        if($tmp_db_row[0]['owner_id'] == $user_id ){
            $status = "owner";
        }
        if($tmp_db_row[0]['buyer_id'] == $user_id){
            $status = "buyer";
        }
        return $status;
    }

    /*
     *Синглвью продукта
     * */
    function Product_singleview($user_id, $product_id)
    {
        if($product_id != null){
            $tmp_db_row = sqldb_connection::Show_product_singleview($product_id);
            array_push($tmp_db_row,Owner_buyer_status($user_id));
            return json_decode($tmp_db_row);
        }
        else{
            return "Product not found";
        }
    }
    /*
     * Мультивью продукта
     * */
    function Product_multiview($user_id, $product_id)
    {
        if($product_id != null){
            $tmp_db_row = sqldb_connection::Show_product_multiview($product_id);
            array_push($tmp_db_row,Owner_buyer_status($user_id));
            return json_decode($tmp_db_row);
        }
        else{
            return "Product not found";
        }
    }

    /*
     * что тут ещё должно быть?
     * */


}