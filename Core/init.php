<?php
# Initi PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
require_once __DIR__ . '/lib/vendor/autoload.php';
//error_reporting(0);
error_reporting(E_ALL); //Solo in DEBUG
ini_set('error_reporting', E_ALL); //Solo in DEBUG
# Headers abilitare se si usa server Linux
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description, token, search,key');
# Impostazioni DEV
$isDEBUG = true;
# Importazioni Classi
require_once __DIR__ . '/classes/Common.php';
require_once __DIR__ . '/classes/Esegui.php';
require_once __DIR__ . '/classes/Risposta.php';
require_once __DIR__ . '/classes/Logger.php';
require_once __DIR__ . '/classes/Email.php';
require_once __DIR__ . '/function.php';

$aqaw = __DIR__ ;
# Inizializzazione Classi
$mail = new PHPMailer(true);
$log = new Logger();
$sendMail = new Email($mail, $log);
$risposta = new Risposta();

# Costanti
define("IS_DEBUG", $isDEBUG);
define("IP_CLIENT", $_SERVER['REMOTE_ADDR']);
define("HOSTNAME", gethostbyaddr($_SERVER['REMOTE_ADDR']));
define("USER_AGENT", $_SERVER['HTTP_USER_AGENT']);
define("NOME_SERVER", $_SERVER["SERVER_NAME"]);
define("DELAY_SEND", 5); # Ritardo invio email

$versioneAPI = 1;
if ($isDEBUG) {
    define("PATH_LOG", $_SERVER["DOCUMENT_ROOT"] . "/pdf/LOG/"); # Log
    define("DIR_FILE", $_SERVER["DOCUMENT_ROOT"] . "/pdf/Attachments/"); # Cartella destinazione pdf diete del database
} else {
    define("PATH_LOG", $_SERVER["DOCUMENT_ROOT"] . "/api/v" . $versioneAPI . "/LOG/"); # Log
    define("DIR_FILE", $_SERVER["DOCUMENT_ROOT"] . "/api/Attachments/"); # Cartella destinazione pdf diete del database
}


