<?php

class Ipay_Request_ServiceInfo extends Ipay_Request
{
    public function process($request) {

        $order = Ipay_Order::getOrder($request->PersonalAccount);
        $client = Ipay_Client::getClient($order->PersonalAccount);

        $xml = new DOMDocument('1.0','windows-1251');
        $root = $xml->createElement('ServiceProvider_Response');
        $serviceInfo = $xml->createElement('ServiceInfo');

        $amount = $xml->createElement('Amount');
        $amount->setAttribute('Editable',$order->ServiceInfo->Amount->Editable);
        $amount->setAttribute('MinAmount', $order->ServiceInfo->Amount->MinAmount);
        $amount->setAttribute('MaxAmount', $order->ServiceInfo->Amount->MaxAmount);
        $amount->setAttribute('AmountPrecision', $order->ServiceInfo->Amount->AmountPrecision);

        $debt = $xml->createElement('Debt');
        $debt->nodeValue = $order->ServiceInfo->Amount->Debt;
        $penalty = $xml->createElement('Penalty');
        $penalty->nodeValue = $order->ServiceInfo->Amount->Penalty;
        $amount->appendChild($debt);
        $amount->appendChild($penalty);

        $name = $xml->createElement('Name');
        $firstName = $xml->createElement('FirstName');
        $firstName->nodeValue = $client->FirstName;
        $surname = $xml->createElement('Surname');
        $surname->nodeValue = $client->Surname;
        $patronymic = $xml->createElement('Patronymic');
        $patronymic->nodeValue = $client->Patronymic;

        $name->appendChild($firstName);
        $name->appendChild($surname);
        $name->appendChild($patronymic);

        $address = $xml->createElement('Address');

        $city = $xml->createElement('City');
        $city->nodeValue = $client->Address->City;
        $street = $xml->createElement('Street');
        $street->nodeValue = $client->Address->Street;
        $house = $xml->createElement('House');
        $house->nodeValue = $client->Address->House;
        $building = $xml->createElement('Building');
        $building->nodeValue = $client->Address->Building;
        $apartment = $xml->createElement('Apartment');
        $apartment->nodeValue = $client->Address->Apartment;

        $address->appendChild($city);
        $address->appendChild($street);
        $address->appendChild($house);
        $address->appendChild($building);
        $address->appendChild($apartment);

        $info = $xml->createElement('Info');

        foreach ($order->ServiceInfo->Info as $key => $value) {
            $infoLine = $xml->createElement('InfoLine');
            $infoLine->nodeValue = $value;
            $info->appendChild($infoLine);
        }

        $serviceInfo->appendChild($amount);
        $serviceInfo->appendChild($name);
        $serviceInfo->appendChild($address);
        $serviceInfo->appendChild($info);
        $root->appendChild($serviceInfo);
        $xml->appendChild($root);

        return $xml->saveXML();
    }
}
