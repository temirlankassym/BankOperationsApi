<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccountResource;
use App\Http\Resources\UserResource;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function block(User $user){
        $account = $user->account;
        $account->update(['status'=>'Blocked']);
        return response()->json(new AccountResource($account));
    }

    public function unlock(User $user){
        $account = $user->account;
        $account->update(['status'=>'Active']);
        return response()->json(new AccountResource($account));
    }

    public function show(User $user){
        return response()->json([
            'user' => new UserResource($user)
        ]);
    }

    public function destroy(User $user){
        Transaction::where('receiver_user_id', $user->id)->delete();
        Transaction::where('sender_user_id', $user->id)->delete();

        $user->account->delete();

        return response()->json([
            'Success'
        ], 200);
    }
}
