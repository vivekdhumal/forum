@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a> Posted:
                    {{ $thread->title }}
                </div>

                <div class="panel-body">
                    {{ $thread->body }}
                </div>
            </div>

            @foreach($replies as $reply)
                @include('threads.reply')
            @endforeach

            {{ $replies->links() }}

            @auth
                @if(count($errors))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ $thread->path() . '/replies' }}" method="post">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <textarea name="body" class="form-control" required rows="5" placeholder="Have something to say?">{{ old('body') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-default">Post</button>
                </form>
            @else
                <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
            @endauth
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    This thread was published {{ $thread->created_at->diffForHumans() }} by
                    <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a>, and has {{ $thread->replies_count }} {{ str_plural("comment", $thread->replies_count) }}.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
