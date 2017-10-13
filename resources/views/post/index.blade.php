@extends('layouts.app')

@section('content')

    <section class="row">

        <div class="col-md-12">

            @forelse ($items as $item)

                <article class="card">

                    @if ($item->image_id)
                        <div class="card-img-top">
                            <a href="{{ $item->url() }}" title="{{ $item->title }}">
                                <img src="/upload/{{ $item->image->preview() }}" title="{{ $item->title }}">
                            </a>
                        </div>
                    @endif

                    <div class="card-body">

                        <a href="{{ $item->url() }}" title="{{ $item->title }}">
                            <h3 class="card-title">{{ $item->title }}</h3>
                        </a>

                        @if(method_exists($item, 'category'))
                            <h5 class="card-subtitle mb-2 text-muted">
                                Категория:
                                <a href="{{ $item->category->url() }}"
                                   title="{{ $item->category->title }}" >{{ $item->category->title }}</a>
                            </h5>
                        @endif

                        @if (isset($item->description))
                            <p class="card-text">{{ $item->description }}</p>
                        @endif

                        <span class="float-right badge badge-dark">
                            <small>Добавлено: {{ \diffForHumans($item->created_at) }}</small>
                        </span>

                        <a href="{{ $item->url() }}" title="{{ $item->title }}" class="card-link">Подробнее »</a>
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
