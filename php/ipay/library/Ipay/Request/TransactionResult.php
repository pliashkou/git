<?php

class Ipay_Request_TransactionResult extends Ipay_Request
{
    public function process($request){

        $transaction = Ipay_Transaction_Manager::getTransaction((string)$request->TransactionResult->TransactionId);

        $xml = new DOMDocument('1.0','windows-1251');
        $root = $xml->createElement('ServiceProvider_Responcse');
        $transactionResult = $xml->createElement('TransactionResult');

        $info = $xml->createElement('Info');
        $infoline = $xml->createElement('InfoLine');

        if (!(string)$request->TransactionResult->ErrorText) {

            $infoline->nodeValue = '������ ������ ������� ���������.';

            // ���� ����� ���������, �� ����� ������ ������ ���������

            $transaction->result = 'success';
            $transaction->save();

        } else {

            $infoline->nodeValue = '����� ������!';

            $transaction = Ipay_Transaction_Manager::getTransaction((string)$request->TransactionResult->TransactionId);
            $transaction->result = 'error';
            $transaction->errorText = (string)$request->TransactionResult->ErrorText;
            $transaction->save();

        };

        $info->appendChild($infoline);
        $transactionResult->appendChild($info);
        $root->appendChild($transactionResult);
        $xml->appendChild($root);
    }
}
