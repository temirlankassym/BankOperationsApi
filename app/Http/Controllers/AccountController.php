<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountCreateRequest;
use App\Http\Resources\AccountResource;
use App\Http\Resources\UserResource;
use App\Models\Account;
use App\Models\Bank;
use App\Models\User;
use App\Models\Transaction;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    private AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function create(AccountCreateRequest $request){
        $account = $this->accountService->create($request->validated()['bank_name']);

        if($account['error']) return response()->json($account['error']);

        return response()->json([
           'success' => 'true',
           'account' => new AccountResource($account)
        ],201);
    }

    public function show(){
        $account = auth()->user()->account;

        return response()->json([
           'account' => new AccountResource($account)
        ]);
    }

    public function destroy(){
        $account = auth()->user()->account;
        Transaction::where('receiver_user_id', $account->user->id)->delete();
        Transaction::where('sender_user_id', $account->user->id)->delete();

        $account->delete();

        return response()->json([
            'Success'
        ], 200);
    }

}
