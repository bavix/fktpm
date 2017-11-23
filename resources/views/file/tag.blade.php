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
                            <i class="fa fa-tag text-danger" aria-hidden="true"></i>
                            <span>{{ $title }}</span>
                        </h4>
                    </div>

                    <div class="card-text row">

                        <nav class="nav flex-column">
                            @forelse ($items as $item)
                                @include('file.item', [
                                    'file' => $item
                                ])
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
