@extends('layouts.app')

@section('content')

    <section class="row">

        <div class="col-md-12">

            @forelse ($items as $item)

                <article class="card">

                    @if ($item->image_id)
                        <div class="card-img-top">
                            <a href="{{ $item->url() }}" title="{{ $item->title }}">
                                <img class="img-fluid" src="/upload/{{ $item->image->preview() }}" title="{{ $item->title }}">
                            </a>
                        </div>
                    @endif

                    <div class="card-body">

                        <small class="text-muted">
                            Добавлено
                            <time datetime="{{ $item->created_at }}">{{ \diffForHumans($item->created_at) }}</time>
                        </small>

                        <h3 class="card-title">
                            <a href="{{ $item->url() }}" title="{{ $item->title }}">
                                {{ $item->title }}
                            </a>
                        </h3>

                        @if (isset($item->description))
                            <p class="card-text">{{ $item->description }}</p>
                        @endif

                        @if(method_exists($item, 'category'))
                            <div class="card-text">
                                <small class="text-muted">
                                    Категория:
                                    <a href="{{ $item->category->url() }}"
                                       title="{{ $item->category->title }}" >{{ $item->category->title }}</a>
                                </small>
                            </div>
                        @endif

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
