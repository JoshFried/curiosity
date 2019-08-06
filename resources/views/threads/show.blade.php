@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">


                <div class="card-header">
                    <a href="">{{ $thread->creator->name }}</a> posted
                    {{ $thread->title }}
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding-bottom: 30px">
    <div class="row justify-content-center">
        <div class="col-md-8  ">
            @foreach ($thread->replies as $reply)
            @include('threads.reply')
            @endforeach
        </div>
    </div>
</div>

@if (auth()->check())
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8  ">

                <form action="{{ $thread->path() . '/replies'}}" method="post">
                    @csrf
                    <div class="form-group">
                        <textarea id="body" class="form-control " style="margin-bottom: 20px;" type="text" name="body" placeholder="Have something to say?" rows="5" ></textarea>
                        <button class="btn btn-default" type="submit">Post</button>
                    </div>
                </form>
            
            </div>
        </div>
    </div>
@else 
    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to post!</p>
@endif
@endsection
