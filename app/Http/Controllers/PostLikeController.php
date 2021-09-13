<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Like;
use App\Events\Message;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function __construct()
    {
        
        $this->middleware(['auth']);
    }

    public function store(Post $post, Request $request)
    {
        

        if ($post->likedBy($request->user())) {
            return response(null, 409);
        }
       
        $post->likes()->create([
            'user_id' => $request->user()->id,
            'post_id' => $post->id,
            'userfullname' => $request->user()->name
        ]);

        
        $Likes = Like::all();

        $Likes = json_encode($Likes);
     

        event(
            new Message(
                $request->user()->id,
                    $Likes
                )
            
        );

        
       
        

        return back();

    }

    public function destroy(Post $post, Request $request)
    {
        $request->user()->likes()->where('post_id', $post->id)->delete();

        return back();
    }
}
