<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionCreateRequest;
use App\Http\Resources\TransactionResource;
use App\Models\User;
use App\Services\TransactionService;
use App\Models\Account;

class TransactionController extends Controller
{

    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function create(TransactionCreateRequest $request){
        $data = $request->validated();

        $phone = $data['phone_number'] ?? Account::where('account_number', $data['account_number'])->first()->user->phone_number;
        $comment = $data['comment'] ?? "";

        if(!$phone) return response()->json(['error' => 'Invalid data'], 400);

        $receiver = User::where('phone_number',$phone)->first();

        if(auth()->user()->account->status == 'Blocked' || $receiver->account->status == "Blocked"){
                return response()->json("user is blocked");
        }

        $transaction = $this->transactionService->create($receiver,$data['amount'],$comment);

        return response()->json(new TransactionResource($transaction));
    }

    public function show(){
        $received = auth()->user()->account->transactions_received;
        $sent = auth()->user()->account->transactions_sent;
        $transactions = $received->concat($sent)->sortByDesc('created_at');

        return response()->json(TransactionResource::collection($transactions));
    }
}
