<?php

class Ipay_Client
{
    public $id;
    public $surname;
    public $firstname;
    public $patronymic;

    public static function getClient($id){
        $clients = self::getClients();

        foreach($clients as $client) {
            if ($client->id == $id)
                return $client;
        }

        return false;
    }

    public function save() {

    }

    public function register() {
        $clients = self::getClients();
        $this->id = self::getId();
        if (count($clients) > 0) {
            array_push($clients,$this->toArray());
            file_put_contents('clients.txt',json_encode($clients));
        } else {
            $clients = array();
            array_push($clients,$this->toArray());
            file_put_contents('clients.txt',json_encode($clients));
        }
    }

    public static function getClients() {
        return json_decode(@file_get_contents('clients.txt'));
    }

    public static function getId() {
        $clients = self::getClients();

        if (count($clients) > 0)
        {
            $max = $clients[0]->id;

            foreach($clients as $client) {
                if ($client->id > $max) {
                    $max = $client->id;
                }
            }
            return $max+1;
        } else {
            return 1;
        }
    }

    public function toArray() {
        return array(
            'id' => $this->id,
            'FirstName' => $this->firstname,
            'Surname' => $this->surname,
            'Patronymic' => $this->patronymic
        );
    }
}
