<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_id',
        'account_number',
        'balance',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function transactions_sent(){
        return $this->hasMany(Transaction::class, 'sender_user_id');
    }

    public function transactions_received(){
        return $this->hasMany(Transaction::class, 'receiver_user_id');
    }

    public function bank(){
        return $this->belongsTo(Bank::class);
    }
}
