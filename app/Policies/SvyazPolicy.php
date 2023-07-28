<?php

namespace App\Policies;

use App\Models\Poliv;
use App\Models\Registration;
use App\Models\User;
use App\Models\svyaz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SvyazPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function destroy (User $user){
        return 'sergey@krimm.ru' == $user->email;
    }

    public function showAdd (User $user){

        $user_reg = Registration::where('user_id', $user->id)->first();

        if ($user_reg){
            if (($user_reg->post_id == 4 and $user_reg->activation) or ('sergey@krimm.ru' == $user->email) or ($user_reg->post_id == 2 and $user_reg->activation) or ($user_reg->post_id == 3 and $user_reg->activation)){
            return true;
        }
        }
       return false;

    }

    public function limitView(User $user){
        $user_reg = Registration::where('user_id', $user->id)->first();
        if($user_reg){
            if (($user_reg->post_id == 1) or ('sergey@krimm.ru' == $user->email)){
                return true;
            }
        }
        return false;
       // return response("User can't perform this action.", 401);
    }

}
