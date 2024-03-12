<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function create(Request $request){
        $transaction = $this->transactionService->create(
            $request->input('phone_number'),
            $request->input('amount')
        );

        return response()->json($transaction);
    }
}
