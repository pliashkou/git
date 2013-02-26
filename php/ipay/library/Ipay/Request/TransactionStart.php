<?php

class Ipay_Request_TransactionStart extends Ipay_Request
{

    public function process($request){

        $xml = new DOMDocument('1.0','windows-1251');
        $root = $xml->createElement('ServiceProvider_Response');
        $transactionStart = $xml->createElement('TransactionStart');
        $serviceProvider_TrxId = $xml->createElement('ServiceProvider_TrxId');
        $serviceProvider_TrxId->nodeValue = Ipay_Transaction_Manager::getTransactionId();

        $info = $xml->createElement('Info');

        $infoline = $xml->createElement('InfoLine');
        $infoline->nodeValue = 'New operation #'.Ipay_Transaction_Manager::getTransactionId();

        $info->appendChild($infoline);

        $transactionStart->appendChild($serviceProvider_TrxId);
        $transactionStart->appendChild($info);

        $root->appendChild($transactionStart);
        $xml->appendChild($root);

        Ipay_Transaction_Manager::addTransaction(
            array(
                'id' => Ipay_Transaction_Manager::getTransactionId(),
                'transactionId' => (string)$request->TransactionStart->TransactionId,
                'amount' => (string)$request->TransactionStart->Amount,
                'agent' => (string)$request->TransactionStart->Agent,
                'authorizationType' => (string)$request->TransactionStart->AuthorizationType
            )
        );

        return $xml->saveXML();


    }


}
