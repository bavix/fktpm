@extends('layouts.app')

@section('content')

    <section class="row">

        <div class="col-md-12">

            @forelse ($items as $item)

                <article class="card">

                    @if (method_exists($item, 'image') && $item->image_id)
                        <a class="card-img-top text-center" href="{{ $item->url() }}" title="{{ $item->title }}">
                            <img class="img-fluid" src="/upload/{{ $item->image->preview() }}" title="{{ $item->title }}">
                        </a>
                    @endif

                    <div class="card-body">

                        @if(method_exists($item, 'category'))
                            <div class="card-text">
                                <small class="text-muted">
                                    Категория:
                                    <a href="{{ $item->category->url() }}"
                                       title="{{ $item->category->title }}" >{{ $item->category->title }}</a>
                                </small>
                            </div>
                        @endif

                        <h3 class="card-title">
                            <a href="{{ $item->url() }}" title="{{ $item->title }}">
                                {{ $item->title }}
                            </a>
                        </h3>

                        @if (isset($item->description))
                            <p class="card-text">{{ $item->description }}</p>
                        @endif

                        <div class="card-text">
                            <small class="text-muted">
                                Добавлено
                                <time datetime="{{ $item->created_at }}">{{ \diffForHumans($item->created_at) }}</time>
                            </small>
                        </div>

                        <a href="{{ $item->url() }}" title="{{ $item->title }}" class="btn-link">Подробнее »</a>

                    </div>

                </article>

            @empty
                @include('post.empty')
            @endforelse

            @if (isset($item))
                @unset($item)
            @endif

        </div>

        <div class="col-md-12">
            {{ $items->links('pagination::bootstrap-4') }}
        </div>

    </section>

@endsection
