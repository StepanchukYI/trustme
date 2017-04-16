<?php


$login = $_REQUEST['login'];
$report = $_REQUEST['report'];

function Log_wrire($login, $report){
    $name = "log/". date("Y-m-d");

    $fp = fopen($name, "a");
    $test = fwrite($fp, "Client: "  . $login . " Error: " . $report . " Date: " . date(DATE_RSS) . "\n");
    if ($test)
    {
        echo "ok";
    }
    else{
        echo "error";
    }
    fclose($fp);
}
