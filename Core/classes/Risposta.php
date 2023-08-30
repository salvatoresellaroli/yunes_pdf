<?php

class Risposta
{

    public $codiceErrore;
    public $messaggio;
    public $dati;

    public function __construct()
    {

        $this->codiceErrore = '';
        $this->messaggio = '';
        $this->dati = '';
    }

}
