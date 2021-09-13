@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            <h4><strong>{{  __('Home')  }}</strong></h4>
            <p>
            {{  __('This is a test game. That allows multi-player to play simultaneosly.')  }}
            </p>
        </div>
    </div>
@endsection