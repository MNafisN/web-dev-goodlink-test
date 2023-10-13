<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function userLogin(Request $request)
    {
        $user = User::find(1);
        if(isset($user)){
            Auth::login($user);
            $request->session()->regenerate();
        }

        return redirect('/');    
    }

}
