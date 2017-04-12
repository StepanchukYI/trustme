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
        $dsn = 'mysql:dbname=Team_4;host=127.0.0.1';
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
        $sth = $dbh->prepare("SELECT user_id, login, password,xo_online FROM clients WHERE email= :login OR phone= :login");
        $sth->execute(array(':login' => $login));
        return $sth->fetchAll();
    }


    /*
     * Функция для обновления статуса ЗАРЕГЕСТРИРОВАННОГО ПОЛЬЗОВАТЕЛЯ на онлайл или офлайн
     */
    public static function Update_online_status($id, $value)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("UPDATE user SET online_status =:online_status  WHERE user_ID =:id");
        $sth->execute(array(':online_status' => $value, ':id' => $id));
    }

    /*
     * Функция для выборки и сравнения данных первичной регистрации пользователя.
     */
    public static function Registration($phone, $email)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT login,email FROM clients WHERE phone=:phone OR email =:email ");
        $sth->execute(array(':phone' => $phone, ':email' => $email));
        return $sth->fetchAll();
    }

    /*
     * Функция для внесения в базу минимальных данных о пользователе
     *
     */
    public static function Registration_min($name, $phone, $password, $email, $code)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("INSERT INTO user(name,password,email,phone,temp_code ) 
                          VALUES(:login, :password, :email, :phone, :code)");
        $sth->execute(array(':name' => $name, ':password' => $password, ':email' => $email, ':phone' => $phone, ':code' => $code));
    }
    /*
     * Функция для внесения в базу почти всех данных о пользователя
     *
     */
    public static function Registration_full($email, $email_2, $surname, $birth_day, $birth_month, $birth_year, $sex, $country, $city)
    {
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("UPDATE user SET email_2=:email_2, surname =: surname, birth_day = :birth_day, birth_month =:
        :birth_month, birth_year =:birth_year, sex = :sex, country = :country, city = :city WHERE email=:email");
        $sth->execute(array(':email_2' => $email_2, ':surname' => $surname, ':birth_day' => $birth_day,
            ':birth_month' => $birth_month, ':birth_year' => $birth_year, ':sex' => $sex, ':country' => $country,
            ':city' => $city, ':email' => $email,));
    }
}

