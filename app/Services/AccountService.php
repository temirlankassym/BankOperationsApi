<?php

namespace App\Services;

use App\Models\Account;

class AccountService{

    public function create(){
        $account = Account::create([
            'user_id' => auth()->user()->id,
            'account_number' => '4400 4302 '.$this->generate_number(),
            'balance' => 0.0
        ]);
        return $account;
    }

    private function generate_number(){
        $number1 = mt_rand(1000,9999);
        $number2 = mt_rand(1000,9999);
        $number = $number1.' '.$number2;
        while(Account::where('account_number', $number)->first()){
            $number1 = mt_rand(1000,9999);
            $number2 = mt_rand(1000,9999);
            $number = $number1.' '.$number2;
        }
        return $number;
    }

}
