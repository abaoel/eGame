<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;

use App\Events\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\User;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
        Route::get('/chat',function () 
        {
                $users = User::where('status', 1)
                ->orderBy('name')
                ->take(100)
                ->get();

                return view('chat',[
            'users' => $users
        ]);
        })->name('chat');

        Route::post('/send-message', function (Request $request)
        {
                $user = User::find(\Auth::id());
                $user->status=1;
                $user->alias='Emong The Great';
                $user->save();
                
                event(
                        new Message(
                                $user->name,
                                $request->input('message')
                        )
                       
                );

                return ["succes" => true];

        });

        Route::get('/', function () {
            //App::setLocale('jp') ;   
            return view('home');
        })->name('home');


       
        Route::post('/posts/{post}/likes', [PostLikeController::class, 'store'])->name('posts.likes');
        Route::delete('/posts/{post}/likes', [PostLikeController::class, 'destroy'])->name('posts.likes');

        Route::get('/posts', [PostController::class, 'index'])->name('posts');

        Route::post('/posts/game', [PostController::class, 'game'])->name('game');
        Route::post('/posts/score', [PostController::class, 'score'])->name('score');
        Route::post('/posts/startgame', [PostController::class, 'startgame'])->name('startgame');

        
        Route::get('/posts/lang/jp', [PostController::class, 'japlang'])->name('japlang');
        Route::get('/posts/lang/en', [PostController::class, 'englang'])->name('englang');

        Route::post('/posts', [PostController::class, 'store']);
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
        


        Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::post('/login', [LoginController::class, 'store']);

        Route::get('/register', [RegisterController::class,'index'])->name('register');
       
        Route::post('/register', [RegisterController::class,'store']);

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



       

        


