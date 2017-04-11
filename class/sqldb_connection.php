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
    private function DB_connect(){
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
     *  Пример инкапсуляции и запроса в SQL через использование PDO
     * это только пример для выобки. все запросы в БД посылаются по похожему принципу.
     */
    public function Auth_Select($login){
        $dbh = sqldb_connection::DB_connect();
        $sth = $dbh->prepare("SELECT login, password,xo_online FROM clients WHERE login= :login ");
        $sth->execute(array( ':login' => $login ));
        return $sth->fetchAll();
    }
}