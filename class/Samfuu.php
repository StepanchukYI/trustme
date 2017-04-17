<?php

function logging($login, $report, $foo_name)
{
    $name = "../log/" . date("Y-m-d").".log";
    $fp = fopen($name, "a");

    $test = fwrite($fp, "Parameters: " . $login .
        "\nFunction name: " .$foo_name.
        "\nResponse text: " . $report.
        "\nDate: " . date(DATE_RSS) .
        "\n----------------------------------------------------------\n");

    if ($test) {
        fclose($fp);
    } else {
        echo "error";
    }
}
