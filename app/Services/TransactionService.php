<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;

class TransactionService{

    public function create($phone, $amount){
        $status = $this->sufficient_balance($phone, $amount) ? 'Accepted' : 'Rejected';
        $sender = auth()->user();
        $receiver = User::where('phone_number',$phone)->first();

        $transaction = Transaction::create([
            'sender_account_id' => $sender->id, // it's user ID
            'receiver_account_id' => $receiver->id, // it's user ID
            'amount' => $amount,
            'status' => $status
        ]);

        if($transaction && $status == 'Accepted'){
            $this->withdrawal($sender,$receiver,$amount);
        }
        return $transaction;
    }

    private function withdrawal($sender_user, $receiver_user, $amount){
        $sender_account = $sender_user->account;
        $receiver_account = $receiver_user->account;

        $sender_account->update(['balance'=>$sender_account->balance-$amount]);
        $receiver_account->update(['balance'=>$receiver_account->balance+$amount]);
    }

    private function sufficient_balance($phone, $amount){
        if(User::where('phone_number',$phone)->first()->account->balance >= $amount){
            return true;
        }
        return false;
    }
}
