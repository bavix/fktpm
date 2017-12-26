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
    <link href="{{ asset2('https://cdn.bavix.ru/bootstrap/next/dist/css/bootstrap.min.css')  }}" rel="stylesheet"/>
    <link href="{{ asset2('/css/app.css') }}" rel="stylesheet"/>

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

    @if (isset($item) && method_exists($item, 'url'))
        @php($canonicalUrl = $item->url())
    @endif

<!-- seo -->
    @if (isset($item, $item->updated_at))
        <meta http-equiv="last-modified" content="{{ $item->updated_at }}"/>
    @endif
    <link rel="canonical" href="{{ $canonicalUrl }}"/>
    @if (isset($items) && $items instanceof Illuminate\Pagination\LengthAwarePaginator)
        @php($currentRoute = request()->route())
        @php($reqAttr = $currentRoute->parameters())

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
        <meta name="keywords" content="{{ keywords($item) }}"/>
    @elseif (!empty($title))
        <meta name="keywords" content="{{ keywords($title) }}"/>
    @endif
    <!-- /seo -->

</head>
<body style="background-image: url('{{ bx_background() }}')">

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
                        <a class="nav-link {{ active('professor') ? 'active' : '' }}" href="{{ route('professor') }}">
                            <i class="fa fa-users text-warning" aria-hidden="true"></i>
                            <span>Преподаватели</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active('couple') ? 'active' : '' }}" href="{{ route('couple') }}">
                            <i class="fa fa-bookmark text-danger" aria-hidden="true"></i>
                            <span>Предметы</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active('helper') ? 'active' : '' }}" href="{{ route('helper') }}">
                            <i class="fa fa-question-circle text-info" aria-hidden="true"></i>
                            <span>Помощь проекту</span>
                        </a>
                    </li>
                </ul>
                {{--<ul class="navbar-nav my-2 my-lg-0">--}}
                    {{--<li class="nav-item">--}}
                        {{--<a class="nav-link" href="https://old.fktpm.ru" title="Старая версия сайта">--}}
                            {{--<i class="fa fa-server text-primary" aria-hidden="true"></i>--}}
                            {{--<span>Старая версия сайта</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
                {{--<form class="form-inline my-2 my-lg-0">--}}
                    {{--<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">--}}
                    {{--<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>--}}
                {{--</form>--}}
            </div>

        </div>

    </nav>

</header>

<div class="container">

    <div class="row">

        <div class="col-xxl-7 col-lg-4 order-lg-2">

            <div class="row grid">

                {{--<form id="search" data-name="card" method="GET" action="{{ route('search', ['files']) }}">--}}
                {{--<div class="input-group">--}}
                {{--<input id="search-files" type="text" name="query" class="form-control" placeholder="Поиск..." value="{{ request()->query('query') }}">--}}
                {{--<span class="input-group-btn">--}}
                {{--<button class="btn btn-info" type="submit">Найти</button>--}}
                {{--</span>--}}
                {{--</div>--}}
                {{--</form>--}}

                @php($links = \App\Models\Link::getActive())
                @if ($links->count())
                    <div class="col-xxl-6 col-lg-12 grid-item">
                        <div class="card" data-name="card">
                            <div class="card-body">

                            <span class="badge badge-pill badge-primary float-right">
                                {{ $links->count() }}
                            </span>

                                <div class="card-title">
                                    <h4>
                                        <i class="fa fa-comments-o text-danger" aria-hidden="true"></i>
                                        <span>Полезные ресурсы</span>
                                    </h4>
                                </div>

                                <div class="card-text row">

                                    <nav class="nav flex-column">
                                        @foreach ($links as $link)
                                            <a class="nav-link" href="{{ $link->url }}" title="{{ $link->title }}" rel="nofollow" target="_blank">
                                                @if ($link->host() === 'vk.com')
                                                    <i class="fa fa-vk bx-fa-style" aria-hidden="true"></i>
                                                @else
                                                    <i class="fa fa-link bx-fa-style" aria-hidden="true"></i>
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

                @php($ads = sape()->return_links())

                @if (!empty($ads))

                    <div class="col-xxl-6 col-lg-12 grid-item">
                        <div class="card" data-name="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h4>
                                        <i class="fa fa-link text-danger" aria-hidden="true"></i>
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

                @foreach (\App\Models\Tag::blocks() as $tag)

                    <div class="col-xxl-6 col-lg-12 grid-item">
                        <div class="card" data-name="card">
                            <div class="card-body">
                                <div class="card-title">
                                <span class="badge badge-pill badge-primary float-right">
                                    {{ $tag->files->count() }}
                                </span>

                                    <h4>
                                        <i class="fa fa-book text-danger" aria-hidden="true"></i>
                                        <span>{{ $tag->name }}</span>
                                    </h4>
                                </div>

                                <div class="card-text row">

                                    <nav class="nav flex-column">
                                        @foreach ($tag->files as $file)
                                            @include('file.item', [
                                                'file' => $file
                                            ])
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

            </div>

        </div>

        <div class="col-xxl-5 col-lg-8 order-lg-1">
            @include('_partials.breadcrumbs')
            @yield('content')
        </div>

    </div>

</div>

<footer class="footer-distributed">

    <div class="container">

        <div class="row">

            <div class="col-12">

                <p class="footer-social float-right" itemscope itemtype="http://schema.org/Organization">
                    <a itemprop="sameAs" target="_blank" href="https://www.facebook.com/rez1dent3" title="Facebook"><i class="fa fa-facebook"></i></a>
                    <a itemprop="sameAs" target="_blank" href="https://www.instagram.com/m.babichev" title="Instagram"><i class="fa fa-instagram"></i></a>
                    <a itemprop="sameAs" target="_blank" href="https://twitter.com/rez1dent3" title="Twitter"><i class="fa fa-twitter"></i></a>
                    <a itemprop="sameAs" target="_blank" href="https://vk.com/rez1dent3" title="VK"><i class="fa fa-vk"></i></a>
                    <a itemprop="sameAs" target="_blank" href="https://github.com/rez1dent3" title="GitHub"><i class="fa fa-github"></i></a>
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

<link href="{{ asset2('https://cdn.bavix.ru/font-awesome/latest/css/font-awesome.min.css') }}" rel="stylesheet"/>
<script src="{{ asset2('https://cdnjs.cloudflare.com/ajax/libs/vanilla-lazyload/10.3.5/lazyload.min.js') }}"></script>
<script src="{{ asset2('/js/lazy.js') }}"></script>

<script src="{{ asset2('https://cdn.bavix.ru/jquery/latest/dist/jquery.min.js') }} "></script>
<script src="{{ asset2('https://cdn.bavix.ru/popper.js/latest/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset2('https://cdn.bavix.ru/bootstrap/next/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset2('/node_modules/masonry-layout/dist/masonry.pkgd.min.js') }}"></script>

@if (active('post.view'))
    <link href="{{ asset2('https://cdn.bavix.ru/lightgallery/latest/dist/css/lightgallery.min.css') }}" rel="stylesheet"/>
    <script src="{{ asset2('https://cdn.bavix.ru/lightgallery/latest/dist/js/lightgallery.min.js') }}"></script>
@endif

<script src="{{ asset2('/js/app.js') }}"></script>

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
