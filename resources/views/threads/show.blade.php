@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <span class="flex">
                                <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a> Posted:
                                {{ $thread->title }}
                            </span>

                            @can('update', $thread)
                            <form action="{{ $thread->path() }}" method="POST">
                                {{ csrf_field() }}

                                {{ method_field('DELETE') }}

                                <button type="submit" class="btn btn-link">Delete Thread</button>
                            </form>
                            @endcan
                        </div>
                    </div>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>

                <replies :data="{{ $thread->replies }}" @removed="repliesCount--"></replies>

                {{--  {{ $replies->links() }}  --}}

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
                        <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a>, and has
                        <span v-text="repliesCount"></span> {{ str_plural("comment", $thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection
