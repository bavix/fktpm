<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" prefix="og: http://ogp.me/ns#">
<head>
    @if (config('debugbar.enabled'))
        @php($debugBar = Debugbar::getJavascriptRenderer())
        {!! $debugBar->renderHead() !!}
    @endif

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php($fullTitle = config('app.name'))
    @if(isset($title))
        @php($fullTitle = $title . ' — ' . $fullTitle)
    @endif

    <title>{{ $fullTitle }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/awakening.css') }}" rel="stylesheet"/>

    <link rel="icon" type="image/ico" href="/favicons/favicon.ico"/>
    <link rel="apple-touch-icon" sizes="57x57" href="/favicons/apple-icon-57x57.png"/>
    <link rel="apple-touch-icon" sizes="60x60" href="/favicons/apple-icon-60x60.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="/favicons/apple-icon-72x72.png"/>
    <link rel="apple-touch-icon" sizes="76x76" href="/favicons/apple-icon-76x76.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="/favicons/apple-icon-114x114.png"/>
    <link rel="apple-touch-icon" sizes="120x120" href="/favicons/apple-icon-120x120.png"/>
    <link rel="apple-touch-icon" sizes="144x144" href="/favicons/apple-icon-144x144.png"/>
    <link rel="apple-touch-icon" sizes="152x152" href="/favicons/apple-icon-152x152.png"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-icon-180x180.png"/>
    <link rel="icon" type="image/png" sizes="192x192"  href="/favicons/android-icon-192x192.png"/>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png"/>
    <link rel="icon" type="image/png" sizes="96x96" href="/favicons/favicon-96x96.png"/>
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png"/>
    <link rel="manifest" href="/favicons/manifest.json">

    <meta name="msapplication-TileColor" content="#ffffff"/>
    <meta name="msapplication-TileImage" content="/favicons/ms-icon-144x144.png"/>
    <meta name="theme-color" content="#ffffff"/>

    @php($canonicalUrl = request()->url())

    <!-- seo -->
    @if (isset($item, $item->updated_at))
        <meta http-equiv="last-modified" content="{{ $item->updated_at }}"/>
    @endif
    <link rel="canonical" href="{{ $canonicalUrl }}"/>
    @if (isset($items) && $items instanceof Illuminate\Pagination\LengthAwarePaginator)
        @php($currentRoute = request()->route())
        @php($reqAttr = $currentRoute->originalParameters())

        @php($reqAttr['pageQuery'] = 'page/' . ($items->currentPage() - 1))
        @if ($items->currentPage() > 1)
            <link rel="prev" href="{{ route($currentRoute->getName(), $reqAttr) }}"/>
        @endif

        @php($reqAttr['pageQuery'] = 'page/' . ($items->currentPage() + 1))
        @if ($items->currentPage() < $items->lastPage())
            <link rel="next" href="{{ route($currentRoute->getName(), $reqAttr) }}"/>
        @endif
    @endif

    <meta property="og:title" content="{{ $fullTitle }}"/>
    <meta property="og:description" content="{{ $description ?? '' }}"/>
    <meta property="og:url" content="{{ $canonicalUrl }}"/>
    <meta property="og:type" content="website"/>

    {{--<meta property="og:image" content="{{ $qrModel->qr() }}"/>--}}
    {{--<meta name="twitter:image:src" content="{{ $qrModel->qr() }}"/>--}}

    <meta name="twitter:site" content="{{ config('app.name') }}"/>
    <meta name="twitter:title" content="{{ $fullTitle }}"/>
    <meta name="twitter:description" content="{{ $description ?? '' }}"/>
    <meta name="twitter:domain" content="{{ request()->getHost() }}"/>

    @if (!empty($description))
        <meta name="description" content="{{ $description }}"/>
    @endif

    @if(!empty($item))
        <meta name="keywords" content="{{ app(\App\Services\SeoService::class)->keywords($item) }}"/>
    @elseif (!empty($title))
        <meta name="keywords" content="{{ app(\App\Services\SeoService::class)->keywords($title) }}"/>
    @endif
    <!-- /seo -->

</head>
<body style="background-image: url('{{ asset('image/background.png') }}')">

<header>

    <nav class="navbar navbar-expand-md navbar-light bg-faded">

        <div class="container">

            <a class="navbar-brand" href="/">ФКТиПМ</a>

            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbars"
                    aria-controls="navbars"
                    aria-expanded="false"
                    aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbars">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('professor*') ? 'active' : '' }}" href="{{ route('professor') }}">
                            <i class="fal fa-users text-warning" aria-hidden="true"></i>
                            <span>Преподаватели</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('couple*') ? 'active' : '' }}" href="{{ route('couple') }}">
                            <i class="fal fa-bookmark text-danger" aria-hidden="true"></i>
                            <span>Предметы</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('help*') ? 'active' : '' }}" href="{{ route('helper') }}">
                            <i class="fal fa-question-circle text-info" aria-hidden="true"></i>
                            <span>Помощь проекту</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('*veresk-art-krd', '*veresk_art_krd')  ? 'active' : '' }}" href="{{ route('post.username', ['username' => 'veresk_art_krd']) }}">
                            <i class="fal fa-layer-group text-info" aria-hidden="true"></i>
                            <span>Вереск</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

    </nav>

</header>

<div class="container">

    <div class="row">

        <div class="col-xxl-5 col-lg-8">

            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- fktpm -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-6538258592702189"
                 data-ad-slot="5840642326"
                 data-ad-format="auto"></ins>
            <script defer async>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>

            {{ Breadcrumbs::render(request()->route()->getName(), $item ?? null) }}
            @yield('content')
        </div>

        <div id="vue-files" class="col-xxl-7 col-lg-4">

            <div class="row grid">

                @php($links = app(\App\Services\LinkService::class)->fetchAll())
                @if ($links->count())
                    <div class="col-xxl-6 col-lg-12 grid-item">
                        <div class="card" data-name="card">
                            <div class="card-body">

                            <span class="badge badge-pill badge-primary float-right">
                                {{ $links->count() }}
                            </span>

                                <div class="card-title">
                                    <h4>
                                        <i class="fal fa-comments text-danger" aria-hidden="true"></i>
                                        <span>Полезные ресурсы</span>
                                    </h4>
                                </div>

                                <div class="card-text row">

                                    <nav class="nav flex-column">
                                        @foreach ($links as $link)
                                            <a class="nav-link" href="{{ $link->url }}" title="{{ $link->title }}" rel="nofollow" target="_blank">
                                                @if (preg_match('~vk\.com~', $link->url))
                                                    <i class="fab fa-vk bx-fa-style" aria-hidden="true"></i>
                                                @else
                                                    <i class="fal fa-link bx-fa-style" aria-hidden="true"></i>
                                                @endif
                                                <span>{{ $link->title }}</span>
                                            </a>
                                        @endforeach
                                    </nav>

                                    <div class="col-12">
                                        <a href="{{ route('helper') }}" class="btn btn-outline-success btn-block">Как добавить материал?</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @php($sape = app(\App\Services\SapeService::class)->client())
                @if ($sape)
                    @php($ads = $sape->return_links())
                    @php($noHtml = \trim(\strip_tags($ads)))
                @endif

                @if (!empty($noHtml))

                    <div class="col-xxl-6 col-lg-12 grid-item">
                        <div class="card" style="background-color: #f7f7b8;" data-name="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h4>
                                        <i class="fal fa-link text-danger" aria-hidden="true"></i>
                                        <span>Реклама</span>
                                    </h4>
                                </div>

                                <div class="card-text row">
                                    {!! $ads !!}
                                </div>
                            </div>
                        </div>
                    </div>

                @endif

                <div v-for="block in blocks" class="col-xxl-6 col-lg-12 grid-item">
                    <div class="card" data-name="card">
                        <div class="card-body">
                            <div class="card-title">
                                <span v-text="block.count" class="badge badge-pill badge-primary float-right"></span>

                                <h4>
                                    <i class="fal fa-book text-danger" aria-hidden="true"></i>
                                    <span v-text="block.title"></span>
                                </h4>
                            </div>

                            <div class="card-text row">
                                <nav class="nav flex-column">
                                    <div v-for="file in block.files">

                                        <a class="nav-link" :href="file.url">
                                            <span class="badge badge-secondary float-right" v-text="file.size"></span>
                                            <i class="fal bx-fa-style" :class="file.class" aria-hidden="true"></i>
                                            <span v-text="file.title"></span>
                                        </a>

                                        <span class="nav-link">
                                            <a v-for="tag in file.tags" :href="tag.url"
                                               class="badge" style="margin-left: .15rem;"
                                               :class="[tag.exists ? 'badge-success' : 'badge-primary']">
                                                <i class="fal" :class="[tag.exists ? 'fa-tags' : 'fa-tag']"
                                                   aria-hidden="true"></i> <span v-text="tag.title"></span>
                                            </a>
                                        </span>

                                        <div class="bx-space" style="padding-bottom: .6rem"></div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<footer class="footer-distributed">

    <div class="container">

        <div class="row">

            <div class="col-12">

                <p class="footer-social float-right" itemscope itemtype="http://schema.org/Organization">
                    <a itemprop="sameAs" target="_blank" href="https://www.facebook.com/rez1dent3" title="Facebook"><i class="fab fa-facebook"></i></a>
                    <a itemprop="sameAs" target="_blank" href="https://www.instagram.com/m.babichev" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a itemprop="sameAs" target="_blank" href="https://twitter.com/rez1dent3" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a itemprop="sameAs" target="_blank" href="https://vk.com/rez1dent3" title="VK"><i class="fab fa-vk"></i></a>
                    <a itemprop="sameAs" target="_blank" href="https://github.com/rez1dent3" title="GitHub"><i class="fab fa-github"></i></a>
                </p>

                <p class="footer-links">
                    <a href="{{ route('post') }}" title="Посты">Посты</a>
                    ·
                    <a href="{{ route('professor') }}" title="Преподаватели">Преподаватели</a>
                    ·
                    <a href="{{ route('couple') }}" title="Предметы">Предметы</a>
                    ·
                    <a href="{{ route('helper') }}" title="Помощь проекту">Помощь проекту</a>
                </p>

                <p class="footer-company">
                    <a href="https://bavix.ru/" title="bavix - разработка и техническая поддержка">bavix</a> © 2013 - {{ date('Y') }}
                </p>
            </div>

        </div>

    </div>

</footer>

<script async src="{{ mix('js/manifest.js') }}"></script>
<script async src="{{ mix('js/vendor.js') }}"></script>
<script async src="{{ mix('js/awakening.js') }}"></script>

@foreach (\App\Models\Counter::query()->where('active', 1)->get() as $counter)
    {!! $counter->code !!}
@endforeach

@if (!empty($debugBar))
    {!! $debugBar->render() !!}
@endif

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "url": "{{ route('post') }}",
  "logo": "https://fktpm.ru/favicons/android-icon-192x192.png"
}
</script>

</body>
</html>
