@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <ais-index
            index-name="threads"
            app-id="{{ config('scout.algolia.id') }}"
            api-key="{{ config('scout.algolia.key') }}"
            query="{{ request('q') }}"
        >
            <div class="col-md-8">
                <ais-results>
                    <template scope="{ result }">
                        <ul>
                            <li>
                                <a :href="result.path">
                                    <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                                </a>
                            </li>
                        </ul>
                    </template>
                </ais-results>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <img src="https://www.algolia.com/assets/pricing_new/algolia-powered-by-ac7dba62d03d1e28b0838c5634eb42a9.svg" alt="Algolia powered by">
                    </div>
                    <div class="panel-body">
                        <ais-search-box>
                            <ais-input placeholder="Find threads.." :autofocus="true" class="form-control"></ais-input>
                        </ais-search-box>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Filter by Channel
                    </div>
                    <div class="panel-body">
                        <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>
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
        </ais-index>
    </div>
</div>
@endsection
