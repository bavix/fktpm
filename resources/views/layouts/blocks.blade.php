@foreach (\App\Models\Tag::blocks() as $tag)

    <div class="col-xxl-6 col-lg-12 grid-item">
        <div class="card" data-name="card">
            <div class="card-body">
                <div class="card-title">
                    <span class="badge badge-pill badge-primary float-right">
                        {{ $tag->files->count() }}
                    </span>

                    <h4>
                        <i class="fal fa-book text-danger" aria-hidden="true"></i>
                        <span>{{ $tag->name }}</span>
                    </h4>
                </div>

                <div class="card-text row">

                    <nav class="nav flex-column">
                        @foreach ($tag->files as $item)
                            @include('file.item', ['file' => $item])
                        @endforeach
                    </nav>

                    <div class="col-12">
                        <a href="{{ route('helper') }}" class="btn btn-outline-success btn-block">Как добавить материал?</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endforeach
