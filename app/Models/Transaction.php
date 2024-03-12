<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_account_id',
        'receiver_account_id',
        'amount',
        'status'
    ];

    public function sender_account(){
        return $this->belongsTo(Account::class);
    }

    public function receiver_account(){
        return $this->belongsTo(Account::class);
    }

}
