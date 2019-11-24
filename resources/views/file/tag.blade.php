@extends('layouts.app')

@section('content')

    <section class="row">

        <div class="col-12">

            <div class="card" data-name="card">
                <div class="card-body">
                    <div class="card-title">
                        <span class="badge badge-pill badge-primary float-right">{{ $items->count() }}</span>
                        <h4>
                            <i class="fal fa-tag text-danger" aria-hidden="true"></i>
                            <span>{{ $title }}</span>
                        </h4>
                    </div>

                    <div class="card-text row">

                        <nav class="nav flex-column">
                            @forelse ($items as $item)

                                <!-- start item -->
                                <a class="nav-link" href="{{ app(\App\Services\RouteService::class)->file($item) }}">
                                    <span class="badge badge-secondary float-right">
                                        {{ app(\App\Services\HumanService::class)->fileSize($item->size) }}
                                    </span>
                                    <i class="fal {{ app(\App\Services\FileService::class)->icon($item) }} bx-fa-style" aria-hidden="true"></i>
                                    <span>{{ $item->title }}</span>
                                </a>
                                
                                <span class="nav-link">
                                    @foreach($item->tags as $_tag)
                                        @if ($_tag->is_block)
                                            <a href="{{ route('file.tag', [$_tag->slug]) }}" class="badge badge-success">
                                                <i class="fal fa-tags" aria-hidden="true"></i> {{ $_tag->name }}
                                            </a>
                                        @else
                                            <a href="{{ route('file.tag', [$_tag->slug]) }}" class="badge badge-primary">
                                                <i class="fal fa-tag" aria-hidden="true"></i> {{ $_tag->name }}
                                            </a>
                                        @endif
                                    @endforeach
                                </span>
                                
                                <!-- remove style -->
                                <div class="bx-space" style="padding-bottom: .6rem"></div>
                                <!-- end item -->
                            @empty
                                @include('post.empty')
                            @endforelse
                        </nav>

                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
