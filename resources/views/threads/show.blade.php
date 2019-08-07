@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        <div class="col-md-8">
            <div class="card mb-4">


                <div class="card-header">
                    <a href="">{{ $thread->creator->name }}</a> posted
                    {{ $thread->title }}
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>


            @foreach ($replies as $reply)
            @include('threads.reply')
            @endforeach

            {{ $replies->links() }}

            @if (auth()->check())
                    <form action="{{ $thread->path() . '/replies'}}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea id="body" class="form-control " style="margin-bottom: 20px;" type="text"
                                name="body" placeholder="Have something to say?" rows="5"></textarea>
                            <button class="btn btn-default" type="submit">Post</button>
                        </div>
                    </form>
            @else

            <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to post!</p>
            @endif

        </div>

        <div class="col-md-4">
            <div class="card">

                <div class="card-body">
                    <p class="card-text">
                        This thread was published {{ $thread->created_at->diffForHumans() }} by 
                        <a href="#">{{ $thread->creator->name }}</a>, and currently has 
                        {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>




@endsection
