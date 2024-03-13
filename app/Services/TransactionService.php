<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TransactionService{

    public function create($receiver, $amount, $comment){
        $status = $this->sufficient_balance($amount) ? 'Accepted' : 'Rejected';
        $sender = auth()->user();

        $transaction = Transaction::create([
            'sender_user_id' => $sender->id,
            'receiver_user_id' => $receiver->id,
            'amount' => $amount,
            'status' => $status,
            'comment' => $comment
        ]);

        if($transaction && $status == 'Accepted'){
            $this->withdrawal($sender,$receiver,$amount);
        }
        return $transaction;
    }

    private function withdrawal($sender_user, $receiver_user, $amount){
        $sender_account = $sender_user->account;
        $receiver_account = $receiver_user->account;

        DB::transaction(function () use ($sender_account, $receiver_account, $amount) {
            $sender_account->decrement('balance', $amount);
            $receiver_account->increment('balance', $amount);
        });
    }

    private function sufficient_balance($amount){
        if(auth()->user()->account->balance >= $amount){
            return true;
        }
        return false;
    }
}
