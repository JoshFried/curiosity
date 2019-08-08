@extends('layouts.app')
@section('content')
<div class="container">

    <div class="row md-8-offset-2">
        <div class="topOfProfile" style="padding: 40px 0;">
            <h3>{{ $profileUser->name }}</h3>
            <small>Member since: {{ $profileUser->created_at->diffForHumans() }}</small>
        </div>

        @foreach ($threads as $thread)
        <div class="card">
            <div class="card-header">
                <div class="level">
                    <span class="flex">
                        <a href="#">{{ $thread->creator->name }}</a> posted
                        {{ $thread->title }}
                    </span>
                    <span>{{ $thread->created_at->diffForHumans() }}</span>
                </div>
            </div>

            <div class="card-body">
                {{ $thread->body }}
            </div>
        </div>
    </div>
    @endforeach
    {{ $threads->links() }}
</div>
</div>


@endsection
