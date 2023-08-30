<?php
/**
 * Logger
 */
class Logger extends Exception
{
    public $errore;
    private $dataFile;
    private $data_ita;

    public function __construct()
    {
        $this->dataFile = date("Y-m-d");
        $this->data_ita = date("d-m-Y H:i:s");
    }

    /**
     * scrivi
     *
     * @param  mixed $controller Nome da dare alla cartella
     * @param  mixed $type Indica lo stato del log es. inzio, fine 
     * @param  mixed $titolo Titolo  
     * @param  mixed $descrizione eventuale descrizione
     * @return void
     */
    public function scrivi(string $controller, int $type, string $titolo = '', string $descrizione = '')
    {

        try {

            $dir = PATH_LOG . '/' . $this->dataFile  . '/';

            if (!file_exists($dir)) {
                mkdir($dir, 0777);
            }

            $nomeFile = $controller . '.log';

            $br = '==========================================================================================================================';

            $fp = fopen($dir . $nomeFile, "a+");
            # Start
            if ($type === 1) {

                fwrite($fp, $br . "\r\n");

                fwrite($fp, "                                     " . $titolo . "\r\n");

                fwrite($fp, "[" . $this->data_ita . "]  -  LOG: " . $controller . "\r\n");

                fwrite($fp,  "[" . $this->data_ita . "]  -  IP: " . IP_CLIENT . "\r\n");

                fwrite($fp,  "[" . $this->data_ita . "]  -  HOSTNAME: " . HOSTNAME . "\r\n");

                fwrite($fp,  "[" . $this->data_ita . "]  -  USER_AGENT: " . USER_AGENT . "\r\n");

                fwrite($fp, "**************************************************************************************************************************\r\n");
            }
            # Middle
            if ($type === 2) {
                fwrite($fp, $titolo . "\r\n");
                fwrite($fp, "\r\n");
                fwrite($fp, $descrizione . "\r\n");
                fwrite($fp, "\r\n");
            }
            # End
            if ($type === 3) {

                fwrite($fp, $br . "\r\n");
            }

            fclose($fp);
            # Elimina i logo piu vecchi di 3 giorni
            svuotaCartella(PATH_LOG . '/');

        } catch (Exception $ex) {

            throw new Exception($ex->getMessage());

            $dir = PATH_LOG . '/errore_log/';

            $fp = fopen($dir . $nomeFile, "a+");

            fwrite($fp, "[" . $this->data_ita . "]  - errore scrittura log \r\n");

            fwrite($fp, $ex->getMessage() . "\r\n");

            fwrite($fp, $br . "\r\n");

            fclose($fp);
        }
    }
}
abstract class logType
{
    const start = 1;
    const middle = 2;
    const end = 3;
}
