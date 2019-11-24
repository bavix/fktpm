@extends('layouts.app')

@section('content')

    <section class="row">

        <div class="col-12">

            @forelse ($items as $item)

                <article class="card">

                    @if (method_exists($item, 'image') && $item->image_id)
                        <a class="card-img-top text-center" href="{{ app(\App\Services\RouteService::class)->post($item) }}" title="{{ $item->title }}">
                            <img class="img-fluid" data-src="/storage/{{ app(\App\Services\ImageService::class)->xs($item->image) }}" title="{{ $item->title }}">
                        </a>
                    @endif

                    <div class="card-body">

                        @if(method_exists($item, 'category'))
                            <div class="card-text">
                                <small class="text-muted">
                                    Категория:
                                    <a href="{{ app(\App\Services\RouteService::class)->postCategory($item->category) }}"
                                       title="{{ $item->category->title }}" >{{ $item->category->title }}</a>
                                </small>
                            </div>
                        @endif

                        @if(method_exists($item, 'tags'))
                            @php($tags = $item->tags)
                            @if (count($tags))
                                <div class="card-text">
                                    <small class="text-muted">
                                        @foreach ($tags as $tag)
                                            <a class="bx-tag" href="{{ app(\App\Services\RouteService::class)->postTag($tag) }}"
                                               title="{{ $tag->name }}">#{{ $tag->name }}</a>
                                        @endforeach
                                    </small>
                                </div>
                            @endif
                        @endif

                        @if (!$item->instagram_code)
                            <h3 class="card-title">
                                <a href="{{ app(\App\Services\RouteService::class)->post($item) }}" title="{{ $item->title }}">
                                    {{ $item->title }}
                                </a>
                            </h3>
                        @endif

                        @if (isset($item->description))
                            <p class="card-text">{{ $item->description }}</p>
                        @endif

                        <div class="card-text">
                            <small class="text-muted">
                                Добавлено
                                <time datetime="{{ $item->created_at }}">{{ app(\App\Services\HumanService::class)->diffFor($item->created_at) }}</time>
                            </small>
                        </div>

                        <a href="{{ app(\App\Services\RouteService::class)->post($item) }}" title="{{ $item->title }}" class="btn-link">Подробнее »</a>

                    </div>

                </article>

            @empty
                @include('post.empty')
            @endforelse

        </div>

        <div class="col-md-12">
            {{ $items->links('pagination::bootstrap-4') }}
        </div>

    </section>

@endsection
