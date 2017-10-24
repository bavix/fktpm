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

    {{--<link rel="icon" type="image/ico" href="/favicons/favicon.ico"/>--}}
    {{--<link rel="apple-touch-icon" sizes="57x57" href="/favicons/apple-icon-57x57.png"/>--}}
    {{--<link rel="apple-touch-icon" sizes="60x60" href="/favicons/apple-icon-60x60.png"/>--}}
    {{--<link rel="apple-touch-icon" sizes="72x72" href="/favicons/apple-icon-72x72.png"/>--}}
    {{--<link rel="apple-touch-icon" sizes="76x76" href="/favicons/apple-icon-76x76.png"/>--}}
    {{--<link rel="apple-touch-icon" sizes="114x114" href="/favicons/apple-icon-114x114.png"/>--}}
    {{--<link rel="apple-touch-icon" sizes="120x120" href="/favicons/apple-icon-120x120.png"/>--}}
    {{--<link rel="apple-touch-icon" sizes="144x144" href="/favicons/apple-icon-144x144.png"/>--}}
    {{--<link rel="apple-touch-icon" sizes="152x152" href="/favicons/apple-icon-152x152.png"/>--}}
    {{--<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-icon-180x180.png"/>--}}
    {{--<link rel="icon" type="image/png" sizes="192x192"  href="/favicons/android-icon-192x192.png"/>--}}
    {{--<link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png"/>--}}
    {{--<link rel="icon" type="image/png" sizes="96x96" href="/favicons/favicon-96x96.png"/>--}}
    {{--<link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png"/>--}}
    {{--<link rel="manifest" href="/favicons/manifest.json">--}}

    {{--<meta name="msapplication-TileColor" content="#ffffff"/>--}}
    {{--<meta name="msapplication-TileImage" content="/favicons/ms-icon-144x144.png"/>--}}
    {{--<meta name="theme-color" content="#ffffff"/>--}}

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
                        <a class="nav-link" href="/professors">
                            <i class="fa fa-users text-warning" aria-hidden="true"></i>
                            <span>Преподаватели</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/couples">
                            <i class="fa fa-bookmark text-danger" aria-hidden="true"></i>
                            <span>Предметы</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/helper">
                            <i class="fa fa-question-circle text-info" aria-hidden="true"></i>
                            <span>Помощь проекту</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

    </nav>

</header>

<div class="container">

    <div class="row">

        <div class="col-lg-4 order-lg-2">

            <form id="search" data-name="card" method="GET" action="/search">
                <div class="input-group">
                    <input type="text" name="query" class="form-control" placeholder="Поиск..." value="">
                    <span class="input-group-btn">
                                <button class="btn btn-info" type="submit">Найти</button>
                            </span>
                </div>
            </form>

            <div class="card" data-name="card">
                <div class="card-body">

                    <h4 class="card-title">
                                <span class="badge badge-pill badge-danger float-right">
                                    socials
                                </span>
                        <i class="fa fa-vk text-primary" aria-hidden="true"></i>
                    </h4>

                    <div class="card-text row">

                        <nav class="nav flex-column">
                            <a class="nav-link" href="#">
                                <i class="fa fa-link text-gray-dark" aria-hidden="true"></i>
                                <span>*КубГУ*</span>
                            </a>
                            <a class="nav-link" href="#">
                                <i class="fa fa-link text-gray-dark" aria-hidden="true"></i>
                                <span>Справочная КубГУ</span>
                            </a>
                            <a class="nav-link" href="#">
                                <i class="fa fa-link text-gray-dark" aria-hidden="true"></i>
                                <span>ПРОФКОМ КубГУ</span>
                            </a>
                            <a class="nav-link" href="#">
                                <i class="fa fa-link text-gray-dark" aria-hidden="true"></i>
                                <span>Деканат ФКТиПМ</span>
                            </a>
                        </nav>

                        <div class="col-12">
                            <a href="#" class="btn btn-outline-success btn-block">Как добавить материал?</a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card" data-name="card">
                <div class="card-body">
                    <h4 class="card-title">
                        <span class="badge badge-pill badge-primary float-right">5</span>
                        <i class="fa fa-book text-danger" aria-hidden="true"></i>
                        <span>6й-семестр</span>
                    </h4>

                    <div class="card-text row">

                        <nav class="nav flex-column">
                            <a class="nav-link" href="#">
                                <span class="badge badge-secondary float-right">947.31 KB</span>
                                <i class="fa fa-file-archive-o text-gray-dark" aria-hidden="true"></i>
                                <span>MVC Example Администрирование локальных сетей</span>
                            </a>
                            <a class="nav-link" href="#">
                                <span class="badge badge-secondary float-right">247.15 KB</span>
                                <i class="fa fa-file-archive-o text-gray-dark" aria-hidden="true"></i>
                                <span>Практика 1(Подколзин)</span>
                            </a>
                            <a class="nav-link" href="#">
                                <span class="badge badge-secondary float-right">4.68 MB</span>
                                <i class="fa fa-file-archive-o text-gray-dark" aria-hidden="true"></i>
                                <span>Практика 2(Подколзин)</span>
                            </a>
                            <a class="nav-link" href="#">
                                <span class="badge badge-secondary float-right">1.33 MB</span>
                                <i class="fa fa-file-pdf-o text-gray-dark" aria-hidden="true"></i>
                                <span>Самоучитель по html</span>
                            </a>
                            <a class="nav-link" href="#">
                                <span class="badge badge-secondary float-right">3.02 MB</span>
                                <i class="fa fa-file-pdf-o text-gray-dark" aria-hidden="true"></i>
                                <span>Самоучитель по css</span>
                            </a>
                        </nav>

                        <div class="col-12">
                            <a href="#" class="btn btn-outline-success btn-block">Как добавить материал?</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8  order-lg-1">

            <div class="row" data-notify>
                <div class="col-12">
                    <div class="alert alert-info">
                        Используйте <code>#ФКТиПМ</code> в <a href="https://instagram.com/"
                                                              target="_blank">instagram</a>!
                        И ваш пост будет, автоматически, добавлен в ленту событий, в течение трех часов.
                    </div>
                </div>
            </div>

            @yield('content')

        </div>

    </div>

</div>

<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script src="/node_modules/popper.js/dist/umd/popper.min.js"></script>
<script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/js/app.js"></script>

</body>
</html>
