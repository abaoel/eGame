<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>eGames</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body class="bg-gray-200">
        <nav class="p-6 bg-white flex justify-between mb-6">
            <ul class="flex items-center">
                <li>
                    <a href="/" class="p-3">{{ __('Home') }}</a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}" class="p-3">{{ __('Dashboard') }}</a>
                </li>
                <li>
                    <a href="{{ route('posts') }}" class="p-3">{{ __('Game') }}</a>
                </li>
            </ul>

            <ul class="flex items-center">

                @auth
                    <li>
                        <a href="" class="p-3">{{ auth()->user()->name }}</a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="post" class="p-3 inline">
                            @csrf
                            <button type="submit">{{ __('Logout') }}</button>
                        </form>
                    </li>
                @endauth

                @guest
                    <li>
                        <a href="{{ route('login') }}" class="p-3">{{ __('Login') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="p-3">{{ __('Register') }}</a>
                    </li>
                @endguest
                <select name="lang" id="lang" onchange="window.location.href=this.options[this.selectedIndex].value;">
                    <option value="/">
                        @if(Session::has("locale"))
                            {{ Session::get("locale") }}
                        @else
                            {{ __('Language') }}
                        @endif
                    </option>
                    <option value="/posts/lang/en">English</option>
                    <option value="/posts/lang/jp">Japanese</option>
                    
                </select>
               
            </ul>

           
           
        </nav>
        @yield('content')
        
    </body>
</html>