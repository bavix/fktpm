<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <meta http-equiv="x-dns-prefetch-control" content="on"/>
    <link rel="dns-prefetch" href="https://graph.instagram.com"/>
    <link rel="dns-prefetch" href="https://www.instagram.com"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php($fullTitle = config('app.name'))
    @if(isset($title))
        @php($fullTitle = $title . ' / ' . $fullTitle)
    @endif

    <title>{{ $fullTitle }}</title>

    <!-- Styles -->
    <link href="{{ asset2('vendor/lightGallery/css/lightgallery.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset2('node_modules/bootstrap/dist/css/bootstrap.min.css')  }}" rel="stylesheet"/>

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="/css/app.css" rel="stylesheet"/>

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
<body>


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
                <ul class="navbar-nav my-2 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="https://old.fktpm.ru" title="Старая версия сайта">
                            <i class="fa fa-server text-primary" aria-hidden="true"></i>
                            <span>Старая версия сайта</span>
                        </a>
                    </li>
                </ul>
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

        <div class="col-lg-4 order-lg-2">

            {{--<form id="search" data-name="card" method="GET" action="{{ route('search', ['files']) }}">--}}
                {{--<div class="input-group">--}}
                    {{--<input id="search-files" type="text" name="query" class="form-control" placeholder="Поиск..." value="{{ request()->query('query') }}">--}}
                    {{--<span class="input-group-btn">--}}
                        {{--<button class="btn btn-info" type="submit">Найти</button>--}}
                    {{--</span>--}}
                {{--</div>--}}
            {{--</form>--}}

            @php($links = \App\Models\Link::query()->where('active', 1)->get())
            @if ($links->count())

                <div class="card" data-name="card">
                    <div class="card-body">

                        <span class="badge badge-pill badge-primary float-right">
                            {{ $links->count() }}
                        </span>

                        <div class="card-title">
                            <h4>
                                <i class="fa fa-comments-o text-danger" aria-hidden="true"></i>
                                <span>Социальные сети</span>
                            </h4>
                        </div>

                        <div class="card-text row">

                            <nav class="nav flex-column">
                                @foreach ($links as $link)
                                    <a class="nav-link" href="{{ $link->url }}" title="{{ $link->title }}" rel="nofollow" target="_blank">
                                        <i class="fa fa-link text-gray-dark" aria-hidden="true"></i>
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

            @endif

            @foreach (\App\Models\Tag::blocks() as $tag)

                @if (!$tag->files->count())
                    @continue
                @endif

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

                                    <!-- start item -->
                                    <a class="nav-link" href="{{ $file->url() }}">
                                        <span class="badge badge-secondary float-right">
                                            {{ \Bavix\Helpers\Str::fileSize($file->size) }}
                                        </span>
                                        <i class="fa {{ $file->faType() }} text-gray-dark" aria-hidden="true"></i>
                                        <span>{{ $file->title }}</span>
                                    </a>
                                    <span class="nav-link">
                                        @foreach($file->tags as $_tag)
                                            @php($badge = $_tag->is_block ? 'success' : 'primary')
{{--                                            <a href="/files/{{ $_tag->slug }}" class="badge badge-{{ $badge }}">--}}
                                            <span class="badge badge-{{ $badge }}">
                                                <i class="fa fa-tag" aria-hidden="true"></i> {{ $_tag->name }}
                                            </span>
                                            {{--</a>--}}
                                        @endforeach
                                    </span>
                                    <!-- remove style -->
                                    <div class="bx-space" style="padding-bottom: .6rem"></div>
                                    <!-- end item -->

                                @endforeach

                            </nav>

                            <div class="col-12">
                                <a href="{{ route('helper') }}" class="btn btn-outline-success btn-block">Как добавить материал?</a>
                            </div>

                        </div>
                    </div>
                </div>

            @endforeach

        </div>

        <div class="col-lg-8 order-lg-1">

            {{--<div class="row" data-notify>--}}
                {{--<div class="col-12">--}}
                    {{--<div class="alert alert-info">--}}
                        {{--Используйте <code>#ФКТиПМ</code> в <a href="https://instagram.com/"--}}
                                                              {{--target="_blank">instagram</a>!--}}
                        {{--И ваш пост будет, автоматически, добавлен в ленту событий, в течение трех часов.--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            @yield('content')
       </div>

    </div>

</div>

<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script src="/node_modules/popper.js/dist/umd/popper.min.js"></script>
<script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/js/app.js"></script>

@foreach (\App\Models\Counter::query()->where('active', 1)->get() as $counter)
    {{{ $counter->code }}}
@endforeach

</body>
</html>
