<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccountResource;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Redis;

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

    public function show($id){
        $user = User::find($id);
        return $user;
    }

    public function showFromCache($id){
        $redis = Redis::get('user:'.$id);

        if($redis){
            return response()->json([
                'From Cache',
                json_decode($redis)
            ]);
        }

        $fromDb = $this->show($id);
        Redis::set('user:'.$id,$fromDb);

        return response()->json([
            'From Database',
            $fromDb
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
