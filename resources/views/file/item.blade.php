<!-- start item -->
<a class="nav-link" href="{{ $file->url() }}">
    <span class="badge badge-secondary float-right">
        {{ \Bavix\Helpers\Str::fileSize($file->size) }}
    </span>
    <i class="fal {{ $file->faType() }} bx-fa-style" aria-hidden="true"></i>
    <span>{{ $file->title }}</span>
</a>

<span class="nav-link">
    @foreach($file->tags as $_tag)
        @php($badge = $_tag->is_block ? 'success' : 'primary')
        <a href="{{ route('file.tag', [$_tag->slug]) }}" class="badge badge-{{ $badge }}">
            <i class="fal fa-tag" aria-hidden="true"></i> {{ $_tag->name }}
        </a>
    @endforeach
</span>

<!-- remove style -->
<div class="bx-space" style="padding-bottom: .6rem"></div>
<!-- end item -->
