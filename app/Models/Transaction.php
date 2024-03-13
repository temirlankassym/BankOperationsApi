<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_user_id',
        'receiver_user_id',
        'amount',
        'status',
        'comment'
    ];

    public function account(){
        return $this->hasOne(Account::class);
    }

}
