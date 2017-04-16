<?php

function loging($login, $report)
{
    $name = "../log/" . date("Y-m-d").".log";
    $fp = fopen($name, "a");

    $test = fwrite($fp, "Client: " . $login . " Chto Bilo: " . $report . " Date: " . date(DATE_RSS) . "\n");

    if ($test) {
        fclose($fp);
    } else {
        echo "error";
    }
}
