<?php
class Esegui
{

    private $connDB;
    private $data;
    private $risposta;

    public function __construct($conn, $rispostaClass)
    {
        $this->connDB = $conn;
        $this->risposta = $rispostaClass;
        $this->data = array();
    }
    public function query(string $sql)
    {

        try {

            $result = $this->connDB->query($sql);

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                    $this->data = $row;
                }

                $this->risposta->dati = $this->data;

                $result->free();

                return true;
            } else {
                $result->free();
                $this->risposta->messaggio = $this->connDB->error;
                return false;
            }
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
    public function ckEmail(string $sql)
    {

        try {

            $result = $this->connDB->query($sql);

            if ($result->num_rows >= 2) {

                $result->free();
                return true;
            } else {
                $result->free();
                return false;
            }
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
    public function queryArray(string $sql, string $obj)
    {

        try {

            $result = $this->connDB->query($sql);

            if ($result) {

                $dataArray = array();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $dataArray[] = $row;
                    }
                }

                $this->data[$obj] = $dataArray;

                $this->risposta->dati = $this->data;

                $result->free();

                return true;
            } else {

                $result->free();
                return false;
            }
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
    public function queryArrayKey(string $sql, string $obj)
    {

        try {

            $result = $this->connDB->query($sql);

            if ($result->num_rows > 0) {

                $dataArray = array();

                while ($row = $result->fetch_assoc()) {

                    foreach ($row as $key => $value) {
                        $dataArray[] = array(
                            'nome' => $key,
                            'valore' => $value,
                        );
                    }
                }

                $this->data[$obj] = $dataArray;

                $this->risposta->dati = $this->data;

                $result->free();

                return true;
            } else {
                $result->free();
                return false;
            }
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
    public function queryArrayReturn(string $sql)
    {

        try {

            $result = $this->connDB->query($sql);

            if ($result->num_rows > 0) {

                $dataArray = array();

                while ($row = $result->fetch_assoc()) {
                    $dataArray[] = $row;
                }

                $result->free();

                return $dataArray;
            } else {
                $result->free();
                return false;
            }
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
    public function queryGrid(string $sql)
    {

        try {

            $result = $this->connDB->query($sql);

            if ($result->num_rows > 0) {

                $dataArray = array();

                while ($row = $result->fetch_assoc()) {

                    $keyPrimaria = array_key_first($row);

                    $dataArray[] = array(
                        'id' => $row[$keyPrimaria],
                        'cells' =>  $row,
                        'buttons' => array()
                    );
                }

                $result->free();

                return $dataArray;
            } else {

                $dataArray[] = array(
                    'id' => '',
                    'cells' =>  '',
                    'buttons' => array()
                );
                $result->free();
                return $dataArray;
            }
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
    public function insertUpdate(string $sql,  $last_id = NULL)
    {

        try {

            $result = $this->connDB->query($sql);

            if ($result === true || $this->connDB->affected_rows > 0) {;

                if ($last_id === true) {

                    $this->risposta->dati =  $this->connDB->insert_id;
                }

                return true;
            } else {

                $this->risposta->messaggio = $this->connDB->error;

                return false;
            }
        } catch (Exception $ex) {
            throw new Exception($this->connDB->error);
        }
    }
}
