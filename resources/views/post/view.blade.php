@extends('layouts.app')

@section('content')

    <article class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    @if (!$item->instagram_code)
                        <h1 class="card-title">{{ $item->title }}</h1>
                    @endif

                    @if(!empty($item->image))
                        <p class="text-center">
                            <img data-src="/storage/{{ app(\App\Services\ImageService::class)->xs($item->image) }}" style="max-width:100%" />
                        </p>
                    @endif

                    @if (isset($item->content))
                        {!! $item->content !!}
                    @else
                        <p class="card-text">{{ $item->description }}</p>
                    @endif

                    @include("gallery.view")

                    <span class="float-left badge badge-primary">
                        Обновлено: <time datetime="{{ $item->updated_at }}">{{ app(\App\Services\HumanService::class)->diffFor($item->updated_at) }}</time>
                    </span>

                </div>

            </div>

            <div class="card">
                <div class="card-body">
                    <div id="disqus_thread"></div>
                </div>
            </div>

<script>

/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
/*
var disqus_config = function () {
this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};
*/
(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = 'https://fktpm.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>

<script id="dsq-count-scr" src="//fktpm.disqus.com/count.js" async></script>
                            
        </div>
    </article>
@endsection
