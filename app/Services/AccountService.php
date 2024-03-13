<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Bank;
use Illuminate\Database\QueryException;

class AccountService{

    public function create($bank_name){
        try {
            $account = Account::create([
                'user_id' => auth()->user()->id,
                'bank_id' =>Bank::where('name',$bank_name)->first()->id,
                'account_number' => $this->generate_number($bank_name),
                'balance' => 0.0,
                'status' => 'Active'
            ]);
            return $account;
        }catch (QueryException $e){
            return ['error' => 'user can only have one account'];
        }
    }

    private function generate_number($bank_name){
        $bank_code = '';
        switch ($bank_name){
            case 'Kaspi':
                $bank_code = '4400 43';
                break;
            case 'Halyk':
                $bank_code = '4405 63';
                break;
            case 'Jusan':
                $bank_code = '5000 12';
                break;
            default:
                $bank_code = '4400 00';
        }
        $number1 = mt_rand(10,99);
        $number2 = mt_rand(1000,9999);
        $number3 = mt_rand(1000,9999);
        $number = $bank_code.$number1.' '.$number2.' '.$number3;
        while(Account::where('account_number', $number)->first()){
            $number1 = mt_rand(1000,9999);
            $number2 = mt_rand(1000,9999);
            $number = $number1.' '.$number2;
        }
        return $number;
    }

}
