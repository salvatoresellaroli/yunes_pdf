<?php
// Fuso orario italiano "Utilizzato su server linux"
date_default_timezone_set('Europe/Rome');

if ($dbProduzione) {

    $db_host = 'hostingssd79.netsons.net'; // Host - 192.168.1.15
    $db_utente = 'hggddwjn_dev'; // Nome utente del Database
    $db_password = '3H*4-EXT!m$?'; // Password del Database
    $db_nomedb = 'hggddwjn_antur'; // Nome del Database

} else {
    $db_host = '192.168.88.231'; // Host -
    $db_utente = 'webuser'; // Nome utente del Database
    $db_password = 'HMJTLrwJA2gcs2WvDkrdZndu2nSUQH8U'; // Password del Database
    $db_nomedb = 'dieta'; // Nome del Database
}

$conn = new mysqli($db_host, $db_utente, $db_password, $db_nomedb);

// Check connection
if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
}

$conn->query("SET lc_time_names = 'it_IT'");

$conn->set_charset("utf8");
