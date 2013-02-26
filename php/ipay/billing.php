<?php

set_include_path('./library/');
require_once './library/autoloader.php';
require_once './library/Ipay.php';

ini_set('display_errors',1);

$_SERVER['REQUEST_METHOD'] = 'POST';
////
//$_POST['XML'] = '<?xml version="1.0" encoding="windows-1251"
//<ServiceProvider_Request>
//  <DateTime>20120918160422</DateTime>
//  <Version>1</Version>
//  <RequestType>TransactionStart</RequestType>
//  <ServiceNo>1</ServiceNo>
//  <PersonalAccount>1</PersonalAccount>
//  <Currency>974</Currency>
//  <RequestId>15442</RequestId>
//  <CheckWidth>50</CheckWidth>
//  <TransactionStart>
//    <Amount>246460</Amount>
//    <TransactionId>663573</TransactionId>
//    <Agent>369</Agent>
//    <AuthorizationType>iPay</AuthorizationType>
//  </TransactionStart>
//</ServiceProvider_Request>';



//$_POST['XML'] = '<?xml version="1.0" encoding="windows-1251"
//<ServiceProvider_Request>
//  <DateTime>20120918172556</DateTime>
//  <Version>1</Version>
//  <RequestType>TransactionResult</RequestType>
//  <ServiceNo>1</ServiceNo>
//  <PersonalAccount>1</PersonalAccount>
//  <Currency>974</Currency>
//  <RequestId>15446</RequestId>
//  <TransactionResult>
//    <TransactionId>663575</TransactionId>
//    <ServiceProvider_TrxId>2</ServiceProvider_TrxId>
//    <ErrorText>???????? ????????</ErrorText>
//  </TransactionResult>
//</ServiceProvider_Request>';

//$_POST['XML'] = '<?xml version="1.0" encoding="windows-1251"
//<ServiceProvider_Request>
//  <DateTime>20120918184719</DateTime>
//  <Version>1</Version>
//  <RequestType>TransactionResult</RequestType>
//  <ServiceNo>1</ServiceNo>
//  <PersonalAccount>1</PersonalAccount>
//  <Currency>974</Currency>
//  <RequestId>15460</RequestId>
//  <TransactionResult>
//    <TransactionId>663580</TransactionId>
//    <ServiceProvider_TrxId>7</ServiceProvider_TrxId>
//    <ErrorText>Платёж просрочен</ErrorText>
//  </TransactionResult>
//</ServiceProvider_Request>';
//
$iPay = new Ipay();

//$orders = new Ipay_Order();
//$client = new Ipay_Client();


//print_r($orders->getOrders());
//$orders->addOrder(array(
//    'PersonalAccount' => 11,
//    'ServiceInfo' => array(
//        'Amount' => array(
//            'Editable' => 0,
//            'MinAmount' => 0,
//            'MaxAmount' => 1000000,
//            'AmountPrecision' => 10,
//            'Debt' => 123123,
//            'Penalty' => 111
//        ),
//        'ClientId' => 1,
//        'Address' => array(
//            'City' => 'Minsk',
//            'Street' => 'Kozlova',
//            'House' => '12',
//            'Building' => '1',
//            'Apartment' => '114',
//        ),
//        'Info' => array(
//            'InfoLine' => 'Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test Test'
//        )
//    )
//));

//print_r($iPay->getRequest());

echo $iPay->processRequest()->getResult();

//$a = $iPay->getRequest()->DateTime;

//file_put_contents('requests.txt',$iPay->getRequest()->asXML().PHP_EOL.PHP_EOL, FILE_APPEND);
//file_put_contents('log.txt',$_POST['XML']);
//echo $iPay->processRequest()->getResult();
//file_put_contents('log.txt',serialize($iPay->getResult()),FILE_APPEND);

//$transaction = Ipay_Transaction_Manager::getTransaction(2344);
//print_r($transaction);











