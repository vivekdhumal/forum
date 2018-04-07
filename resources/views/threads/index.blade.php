@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            @include('threads._list')

            {{ $threads->render() }}
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <img src="https://www.algolia.com/assets/pricing_new/algolia-powered-by-ac7dba62d03d1e28b0838c5634eb42a9.svg" alt="Algolia powered by">
                </div>
                <div class="panel-body">
                    <form action="/threads/search">
                        <div class="form-group">
                            <input type="text" class="form-control" name="q">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            @if(count($trending))
            <div class="panel panel-default">
                <div class="panel-heading">Trending Threads</div>
                <div class="panel-body">
                    <ul class="list-group">
                        @foreach($trending as $thread)
                            <li class="list-group-item"><a href="{{ $thread->path }}">{{ $thread->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
