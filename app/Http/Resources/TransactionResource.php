<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $sender = User::find($this->sender_user_id);
        $receiver = User::find($this->receiver_user_id);
        return [
            'status' => $this->status,
            'sender' => $sender['first_name'].' '.substr($sender['last_name'],0,1).' '.$sender->phone_number,
            'receiver' => $receiver['first_name'].' '.substr($receiver['last_name'],0,1).' '.$receiver->phone_number,
            'amount' => $this->amount,
            'comment' => $this->comment
        ];
    }
}
