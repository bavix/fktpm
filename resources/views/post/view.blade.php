@extends('layouts.app')

@section('content')
    <article class="row">
        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h1>{{ $item->title }}</h1>

                    @if(method_exists($item, 'tagged'))
                        @php($tags = $item->tags)
                        @if (count($tags))
                            <small class="text-muted">
                                @foreach ($tags as $tag)
                                    <a class="bx-tag" href="{{ $item->routeTag($tag->slug) }}"
                                       title="{{ $tag->name }}">{{ $tag->name }}</a>
                                @endforeach
                            </small>
                        @endif
                    @endif

                </div>

                <div class="panel-body">

                    @if(!empty($item->image))
                        <p class="text-center">
                            <img src="/upload/{{ $item->image->preview() }}" style="max-width:100%" />
                        </p>
                    @endif

                    @if (isset($item->content))
                        {!! $item->content !!}
                    @else
                        <p class="card-text">{{ $item->description }}</p>
                    @endif

                    @include("gallery.view")

                    <hr class="if-visually" />

                    <span class="if-visually float-left badge badge-primary">
                        <small>
                            Обновлено: <time datetime="{{ $item->updated_at }}">{{ \diffForHumans($item->updated_at) }}</time>
                        </small>
                    </span>
                </div>

            </div>
        </div>
    </article>
@endsection
