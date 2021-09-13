<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Events\Message;

use Illuminate\Support\facades\App;
use Illuminate\Support\facades\Session;

class LogoutController extends Controller
{
    public function store()
    {
        if(\Auth::id())
        {
            $user = User::find(\Auth::id());
            $user->status=0;
            $user->alias = '';
            $user->save();
                    
           
        }
        

        $users = User::where('status', 1)
                ->orderBy('name')
                ->take(100)
                ->get();

        $users = json_encode($users );        

        event(
                new Message(
                    'logout',
                        $users 
                )
                
        );

        Session::put("gamestarted", '0');

        auth()->logout();
       
        return redirect()->route('home');
    }
}
