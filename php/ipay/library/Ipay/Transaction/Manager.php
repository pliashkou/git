<?php

class Ipay_Transaction_Manager
{

    public static function getTransaction($id){
        $transactions = self::getTransactions();

        foreach($transactions as $transaction) {

            if ($transaction->transactionId == $id)
                return new Ipay_Transaction($transaction);
        }

        return false;
    }

    public static function getTransactions() {
        if ($transactions = json_decode(@file_get_contents('transactions.txt'))) {
            return $transactions;
        } else {
            return array();
        }
    }

    public static function saveTransaction($transaction) {

        $transactions = self::getTransactions();

        for( $i = 0; $i < count($transactions); $i++) {
            if ($transactions[$i]->transactionId == $transaction->transactionId) {
                $transactions[$i] = $transaction;
            }
        }

        @file_put_contents('transactions.txt',json_encode($transactions));
    }

    public static function addTransaction(array $transaction) {

        $transactions = self::getTransactions();
        array_push($transactions,$transaction);

        @file_put_contents('transactions.txt',json_encode($transactions));
    }

    public static function getTransactionId() {
        $transactions = self::getTransactions();
        $max = 0;
        if (count($transactions) > 0) {
            $max = $transactions[0]->id;
            foreach ($transactions as $transaction) {
                if ($transaction->id > $max) {
                    $max = $transaction->id;
                }
            }

        }

        return $max+1;
    }
}
