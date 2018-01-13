@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>
                {{ $profileUser->name }}

                <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
            </h1>
        </div>

        @foreach($threads as $thread)
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="level">
                    <div class="flex">
                        <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a> Posted:
                        {{ $thread->title }}
                    </div>

                    {{ $thread->created_at->diffForHumans() }}
                </div>
            </div>

            <div class="panel-body">
                {{ $thread->body }}
            </div>
        </div>
        @endforeach

        {{ $threads->links() }}
    </div>
@endsection
