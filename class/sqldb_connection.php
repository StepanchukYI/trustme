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
    // последняя ебаная проверка БИТБАКЕТА ЕБАНАВРОТ!

}

