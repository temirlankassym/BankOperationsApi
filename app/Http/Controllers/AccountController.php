<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Account;
use App\Models\User;
use App\Services\AccountService;

class AccountController extends Controller
{

    private AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function create(){
        $account = $this->accountService->create();

        return response()->json([
           'success' => 'true',
           'account' => $account
        ],201);
    }

    public function show(){
        $user = User::find(auth()->user()->id);

        return response()->json([
           'user' => new UserResource($user)
        ]);
    }

}
