@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a New Thread</div>

                <div class="panel-body">
                    @if(count($errors))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/threads">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="title">Choose a Channel</label>
                            <select name="channel_id" id="channel_id" class="form-control" required>
                                <option value="">Choose One</option>
                                @foreach(App\Channel::all() as $channel)
                                    <option value="{{ $channel->id }}"
                                        {{ (old('channel_id') == $channel->id) ? 'selected' : ''}}
                                    >
                                        {{ $channel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
                        </div>

                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea name="body" id="body" rows="8" class="form-control" required>{{ old('body') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
