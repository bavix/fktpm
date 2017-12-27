@extends('layouts.app')

@section('content')

    @include('post.notify')

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
                                <a class="nav-link" href="{{ $item->url() }}">
                                    <span class="badge badge-secondary float-right">
                                        {{ \Bavix\Helpers\Str::fileSize($item->size) }}
                                    </span>
                                    <i class="fal {{ $item->faType() }} bx-fa-style" aria-hidden="true"></i>
                                    <span>{{ $item->title }}</span>
                                </a>
                                
                                <span class="nav-link">
                                    @foreach($item->tags as $_tag)
                                        @php($badge = $_tag->is_block ? 'success' : 'primary')
                                        <a href="{{ route('file.tag', [$_tag->slug]) }}" class="badge badge-{{ $badge }}">
                                            <i class="fal fa-tag" aria-hidden="true"></i> {{ $_tag->name }}
                                        </a>
                                    @endforeach
                                </span>
                                
                                <!-- remove style -->
                                <div class="bx-space" style="padding-bottom: .6rem"></div>
                                <!-- end item -->
                                
                                {{--@include('file.item', [--}}
                                    {{--'file' => $item--}}
                                {{--])--}}
                            @empty
                                @include('post.empty')
                            @endforelse
                        </nav>

                        @if (isset($item))
                            @unset($item)
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
