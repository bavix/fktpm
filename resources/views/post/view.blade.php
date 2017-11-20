@extends('layouts.app')

@section('content')

    @include('post.notify')

    <article class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    <h1 class="card-title">{{ $item->title }}</h1>

                    @if(!empty($item->image))
                        <p class="text-center">
                            <img src="/storage/{{ $item->image->md() }}" style="max-width:100%" />
                        </p>
                    @endif

                    @if (isset($item->content))
                        {!! $item->content !!}
                    @else
                        <p class="card-text">{{ $item->description }}</p>
                    @endif

                    @include("gallery.view")

                    <span class="float-left badge badge-primary">
                        Обновлено: <time datetime="{{ $item->updated_at }}">{{ \diffForHumans($item->updated_at) }}</time>
                    </span>

                </div>

            </div>
        </div>
    </article>
@endsection
