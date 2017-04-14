<?php

/*
 * Класс для всех запросов с сервера в SQL базу.
 * (добавление, удаление, изменение)
 */

class sqldb_connection
{
    /*
     * ИНКАПСУЛИРОВАННАЯ ФУНКЦИЯ, ДЛЯ КОДКЛЮЧЕНИЮ В БАЗЕ(ИНКАПСУЛИРОВАННАЯ!!)
     */
    private function DB_connect()
    {
        $dsn = 'mysql:dbname=trustme_db;host=127.0.0.1';
        $user = 'root';
        $password = '';

        try {
            $dbh = new PDO($dsn, $user, $password);
            return $dbh;
        } catch (PDOException $e) {
            return 'Connection failed: ' . $e->getMessage();
        }
    }

    /*
     * Выбока из баззы значения для проверки наличия пользователя в БД
     */
    public static function Auth_Select($login)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT user_ID,email,phone,password FROM user WHERE email= :login OR phone= :login");
        $sth->execute(array(':login' => $login));
        return $sth->fetchAll();
    }


    /*
     * Функция для обновления статуса ЗАРЕГЕСТРИРОВАННОГО ПОЛЬЗОВАТЕЛЯ на онлайл или офлайн
     */
    public static function Update_online_status($id, $value)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("UPDATE user SET online_status =:online_status WHERE user_ID =:id");
        $sth->execute(array(':online_status' => $value, ':id' => $id));
    }

    /*
     * Функция для выборки и сравнения данных первичной регистрации пользователя.
     */
    public static function Registration($phone, $email)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT email,phone,password FROM user WHERE phone=:phone OR email =:email ");
        $sth->execute(array(':phone' => $phone, ':email' => $email));
        return $sth->fetchAll();
    }

    /*
     * Функция для внесения в базу минимальных данных о пользователе
     *
     */
    public static function Registration_min($phone, $password, $email, $reg_date, $code)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("INSERT INTO user(name,password,email,phone,reg_date, temp_code ) 
                          VALUES(:name, :password, :email, :phone, :reg_date,:code)");
        $sth->execute(array(':name' => "someone", ':password' => $password, ':email' => $email, ':phone' => $phone,
            ':code' => $code, ':reg_date' => $reg_date));
    }


    /*
     * Функция для внесения в базу почти всех данных о пользователя
     *
     */
    public static function Registration_full($id, $email_2, $name, $surname, $birth_day, $birth_month, $birth_year, $sex, $last_visit, $online_status, $country, $city)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("UPDATE user SET email_2 = :email_2, name = :name,  surname = :surname, birth_day = :birth_day, birth_month =
        :birth_month, birth_year = :birth_year, sex = :sex, last_visit = :last_visit, online_status = :online_status, country = :country, city = :city WHERE user_id= :id");
        $sth->execute(array(':email_2' => $email_2,':name' => $name, ':surname' => $surname, ':birth_day' => $birth_day,
            ':birth_month' => $birth_month, ':birth_year' => $birth_year, ':sex' => $sex, ':last_visit' => $last_visit,
            ':online_status' => $online_status, ':country' => $country, ':city' => $city, ':id' => $id));
    }

    /*
     * Функция для выборки последнего id user-a, которого просмотрел user
     *
     */
    public static function Select_Last_user_id($user_id)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT last_user_id FROM user WHERE user_id =: user_id");
        $sth->execute(array(':user_id' => $user_id));
        return $sth->fetchAll();
    }
    /*
     * Функция для обновление последнего id user-a, которого просмотрел user
     *
     */
    public static function Update_Last_user_id($user_id, $last_user_id)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("UPDATE user SET last_user_id = :last_user_id WHERE user_id =: user_id");
        $sth->execute(array(':user_id' => $user_id, ':last_user_id' => $last_user_id));
    }
    /*
     * Функция для выбора первых 50-ти пользователей
     *
     */
    public static function Select_Multi_View_users($user_id)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT user_id, name, surname, sex, small_photo, balance, online_status, rate
        FROM user WHERE user_id != :user_id LIMIT 50");
        $sth->execute(array(':user_id' => $user_id));
        return $sth->fetchAll();
    }
    /*
     * Функция для выбора следующих 50-ти пользователей
     *
     */
    public static function Select_See_More($user_id, $last_user_id)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT user_id, name, surname, sex, small_photo, balance, online_status, rate
        FROM user WHERE user_id != :user_id LIMIT :last_user_id, 50");
        $sth->execute(array(':user_id' => $user_id, ':last_user_id' => $last_user_id));
        return $sth->fetchAll();
    }
    /*
     * Функция для выбора одиночного просмотра
     *
     */
    public static function Select_Single_View_user($user_id_select)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT user_id, name, surname, sex, large_photo, balance, online_status, rate, last_visit, country, city, reg_date
        FROM user WHERE user_id == :user_id_select");
        $sth->execute(array(':user_id' => $user_id_select));
        return $sth->fetchAll();
    }
    /*
     * Функция для выборки списка друзей
     *
     */
    public static function Select_Multi_View_friends($user_id)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT user_id, name, surname, sex, small_photo, balance, online_status, rate
        FROM user INNER JOIN friends 
        ON friends.user_id_1 = :user_id OR friends.user_id_2 = :user_id  AND friends.friend_request = true LIMIT 50");
        $sth->execute(array(':user_id' => $user_id));
        return $sth->fetchAll();
    }
    /*
     * Функция для выбора следующих 50-ти друзей
     *
     */
    public static function Select_See_More_friends($user_id, $last_user_id)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT user_id, name, surname, sex, small_photo, balance, online_status, rate
        FROM user INNER JOIN friends 
        ON friends.user_id_1 = :user_id OR friends.user_id_2 = :user_id  AND friends.friend_request = true LIMIT :last_user_id, 50");
        $sth->execute(array(':user_id' => $user_id, ':last_user_id' => $last_user_id));
        return $sth->fetchAll();
    }
    /*
     * Функция для выборки списка друзей онлайн
     *
     */
    public static function Select_Multi_View_friends_online($user_id)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT user_id, name, surname, sex, small_photo, balance, online_status, rate
        FROM user INNER JOIN friends 
        ON (friends.user_id_1 = :user_id OR friends.user_id_2 = :user_id) AND user.online_status = true AND friends.friend_request = true LIMIT 50");
        $sth->execute(array(':user_id' => $user_id));
        return $sth->fetchAll();
    }
    /*
     * Функция для выбора следующих 50-ти друзей онлайн
     *
     */
    public static function Select_See_More_friends_online($user_id, $last_user_id)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT user_id, name, surname, sex, small_photo, balance, online_status, rate
        FROM user INNER JOIN friends 
        ON (friends.user_id_1 = :user_id OR friends.user_id_2 = :user_id) 
        AND user.online_status = true AND friends.friend_request = true LIMIT :last_user_id, 50");
        $sth->execute(array(':user_id' => $user_id, ':last_user_id' => $last_user_id));
        return $sth->fetchAll();
    }
    /*
     * Функция для выбора по поисковому запросу
     *
     */
    public static function Select_Search($user_id, $query)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT user_id, name, surname, sex, small_photo, balance, online_status, rate
        FROM user WHERE user_id != :user_id AND (name LIKE :query OR surname LIKE :query) LIMIT 50");
        $sth->execute(array(':user_id' => $user_id, ':query' => "%$query%"));
        return $sth->fetchAll();
    }
    /*
     * Функция для выбора по поисковому запросу еще 50-ти строк
     *
     */
    public static function Select_See_More_Search($user_id, $last_user_id, $query)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT user_id, name, surname, sex, small_photo, balance, online_status, rate
        FROM user WHERE user_id != :user_id AND (name LIKE :query OR surname LIKE :query) LIMIT :last_user_id, 50");
        $sth->execute(array(':user_id' => $user_id, ':last_user_id' => $last_user_id, ':query' => $query));
        return $sth->fetchAll();
    }
    /*
     * Функция проверки дружбы между клиентами
     *
     */
    public static function Select_Check_Friendship($user_id, $user_id_friend)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT friend_request FROM friend 
        WHERE (user_id_1 = :user_id AND user_id_2 = :user_id_friend) 
        OR (user_id_2 = :user_id AND user_id_1 = :user_id_friend)");
        $sth->execute(array(':user_id' => $user_id, ':user_id_friend' => $user_id_friend));
        return $sth->fetchAll();
    }
    /*
     * Функция для отмены дружбы или принятия заявки
     *
     */
    public static function Update_Friendship($user_id, $user_id_friend, $flag)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("UPDATE friend SET friend_request = :flag 
        WHERE (user_id_1 = :user_id AND user_id_2 = :user_id_friend) 
        OR (user_id_2 = :user_id AND user_id_1 = :user_id_friend)");
        $sth->execute(array(':user_id' => $user_id, ':user_id_friend' => $user_id_friend, ':flag' => $flag));
        return $flag;
    }
    /*
     * Функция для отмены заявки
     *
     */
    public static function Delete_Friendship($user_id, $user_id_friend)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("DELETE FROM friend
        WHERE (user_id_1 = :user_id AND user_id_2 = :user_id_friend) 
        OR (user_id_2 = :user_id AND user_id_1 = :user_id_friend)");
        $sth->execute(array(':user_id' => $user_id, ':user_id_friend' => $user_id_friend));
    }
    /*
     * Функция для выборки списка заявок
     *
     */
    public static function Select_Multi_View_Requests($user_id)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT user_id, name, surname, sex, small_photo, balance, online_status, rate
        FROM user INNER JOIN friends 
        ON friends.user_id_2 = :user_id  AND friends.friend_request = false LIMIT 50");
        $sth->execute(array(':user_id' => $user_id));
        return $sth->fetchAll();
    }
    /*
     * Функция для просмотра еще заявок
     *
     */
    public static function Select_See_More_Requests($user_id, $last_user_id)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT user_id, name, surname, sex, small_photo, balance, online_status, rate
        FROM user INNER JOIN friends 
        ON friends.user_id_2 = :user_id  AND friends.friend_request = false LIMIT :last_user_id, 50");
        $sth->execute(array(':user_id' => $user_id, ':last_user_id' => $last_user_id));
        return $sth->fetchAll();
    }

    /*
    * Добавить продукт
    * */
    public static function Add_product( $product_name, $category, $price, $user_id, $buyer_id, $status, $made_in, $description, $add_date, $product_country, $product_city, $product_photo )
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("INSERT INTO product(product_name,category,price,status,made_in,
`                            description,add_date,product_country,product_city,product_photo )
                             VALUES(:product_name, :category, :price, :made_in, :description, :add_date, 
                              :product_country, :product_city, :product_photo)");
        $sth->execute(array(':product_name' => $product_name, ':category' => $category, ':price' => $price, ':owner_id' => $user_id, ':buyer_id' => $buyer_id, ':status' => $status,':made_in' => $made_in, ':description' => $description,
            ':add_date' => $add_date, ':product_country' => $product_country, ':product_city' => $product_city, ':product_photo' => $product_photo));
    }
    /*
     * Функция для обновления СТАТУСА ТОВАРА на active, sold, disable
     */
    public static function Update_product_status($product_id, $status)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("UPDATE product
                                    SET status =:status
                                    WHERE product_id =:product_id");
        $sth->execute(array(':status' => $status, ':product_id' => $product_id));;
    }

    /*
     * Получить ID овнера и байера если он покупатель или владелец
     * */
    public static function Get_owner_buyer($user_id)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT owner_id, buyer_id
                                    FROM product
                                    WHERE $user_id == :owner_id
                                    OR $user_id == :buyer_id");
        $sth->execute(array(':user_id' => $user_id));;
        return $sth->fetchAll();
    }

    /*
     *  функция для удаления продукта
     * */
    public static function Delete_product($product_id)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("DELETE FROM product
                                    WHERE product_id =: product_id  ");
        $sth->execute(array(':product_id' => $product_id));
    }

    /*
    * Функция для выборки данных О ТОВАРЕ для пользователя
    * */

    public static function Show_product_singleview($product_id)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT product_name, category, price, owner_id, buyer_id, status, 
                                    made_in, description, add_date, max_bid, min_bid,
                                    auction_end, product_country,product_city, pg.pt_large_photo
                                    FROM product
                                    INNER JOIN productgallery pg
                                    WHERE product_id =: product_id  ");
        $sth->execute(array(':product_id' => $product_id));
        return $sth->fetchAll();
    }

    /*
   * Функция для выборки данных О ТОВАРЕ для пользователя
   * */

    public static function Show_product_multiview($product_id)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT p.product_name, p.owner_id, p.price, p.status, a.bid_date, p.auction_end, pg.pt_small_photo
                                    FROM product p
                                    INNER JOIN auction a
                                    INNER JOIN productgallery pg
                                    WHERE p.product_id =: product_id LIMIT 50  "); // показать первые 50 товаров
        $sth->execute(array(':product_id' => $product_id));
        return $sth->fetchAll();
    }

    /*
     * Закидываем товар на аукцион
     * */

    public static function Product_to_auction($product_id, $user_id, $price, $bid_date)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("INSERT INTO auction(product_id, user_id, price, bid_date)
                                    VALUES(:p.product_id, :p.user_id, :p.user_bid, :p.bid_date )
                                    INNER JOIN product p");
        $sth->execute(array(':p.product_id' => $product_id, ':p.user_id' => $user_id, ':p.user_bid' => $price, ':p.bid_date' => $bid_date));
        return $sth->fetchAll(); // возврат для проверки статуса
    }

    /*
     * Выборка ID и PRICE для товара, для отправки товара на аукцион
     * */
    public static function Lot_Helper($product_id)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT ownder_id, price
                                    FROM product
                                    WHERE product_id =: product_id  ");
        $sth->execute(array(':product_id' => $product_id));
        return $sth->fetchAll();
    }

    /*
     * Выборка по поиску товаров, первые 50
     * */
    public  static function Product_Search($product_id, $query)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT product_id, product_name,category, price, status, made_in, description, product_country, product_city, pg.pt_small_photo
                                   FROM product
                                   INNER JOIN productgallery pg
                                   WHERE product_id != :product_id
                                   AND (product_name LIKE :query OR category LIKE :query) LIMIT 50");
        $sth->execute(array(':product_id' => $product_id, ':query' => "%$query%"));
        return $sth->fetchAll();
    }
    /*
     * Редактирование товара
     * */
    public  static function Product_Edit($product_id, $product_name, $category, $price, $made_in, $description, $add_date, $product_country, $product_city, $product_photo)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("UPDATE product
                                    SET status =:status, product_name =: product_name, category =: category, price =: price,
                                    made_in =: made_in, description =: description, add_date =: add_date, product_country =: product_country,
                                    product_city =: product_city, product_photo =: product_photo
                                    WHERE product_id =:product_id");
        $sth->execute(array(':product_id' => $product_id, ':product_name' => $product_name, ':category' => $category, ':price' => $price, ':made_in' => $made_in, ':description' => $description,
            ':add_date' => $add_date, ':product_country' => $product_country, ':product_city' => $product_city, ':product_photo' => $product_photo));;

    }
}

