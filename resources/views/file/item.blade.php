<!-- start item -->
<a class="nav-link" href="{{ $file->url() }}">
    <span class="badge badge-secondary float-right">
        {{ app(\App\Services\HumanService::class)->fileSize($file->size) }}
    </span>
    <i class="fal {{ $file->faType() }} bx-fa-style" aria-hidden="true"></i>
    <span>{{ $file->title }}</span>
</a>

<span class="nav-link">
    @foreach($file->tags as $_tag)
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
