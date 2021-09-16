<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\Message;

use Illuminate\Support\facades\App;
use Illuminate\Support\facades\Session;

class PostController extends Controller
{
    public function index(Request $request)
    {
        
        $posts = Post::latest()->with(['user', 'likes'])->paginate(20);
        return view('posts.index',[
            'posts' => $posts
        ]);
    }

    public function store(Request $request)
    {
       
        $this->validate($request, [
            'body' => 'required'
        ]);

        

        $request->user()->posts()->create([
            'body' => $request->body
        ]);

        return back();
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return back();
    }

    public function score(Request $request)
    {
        $iswinner = '';

        if($request->input("iswinner") == '1'){

            $iswinner = 'Winner';
        }

        $userscore = array(
                    "userid"=>\Auth::id(), 
                    "score"=>$request->input("score"),
                    'winner' => $iswinner
                    );

        $userscore = json_encode($userscore);             

        event(
            new Message(
                    "gamescore",
                    $userscore
            )
            
        );
    } 
    
    public function startgame(Request $request)
    {
        event(
            new Message(
                    "startgame",
                    \Auth::id() 
            )
            
        );

        return ["succes" => true];

    } 

    public function game(Request $request)
    {

        if(\Auth::id())
        {
            $user = User::find(\Auth::id());
            $user->status=1;
            $user->alias=$request->input('username');
            $user->save();
                    
           
        }
        else
        {
            $user = User::where('status', 0)->where('name', 'Guest')->first();
            $user->status=1;
            $user->alias=$request->input('username');
            $user->save();

            \Auth::loginUsingId($user->id);
        }

        $users = User::where('status', 1)
                ->orderBy('name')
                ->take(100)
                ->get();

        $users_count = count($users);        
        $users = json_encode($users );        

        event(
                new Message(
                        "users",
                        $users 
                )
                
        );
        
        Session::put("gamestarted", '1');
       

        return ["succes" => true];
        
    }

    public function japlang(Request $request)
    {
        App::setLocale('jp');
        Session::put("locale", 'jp');
        return redirect()->back();
    }

    public function englang(Request $request)
    {
        App::setLocale('en');
        Session::put("locale", 'en');
        return redirect()->back();
    }

}
