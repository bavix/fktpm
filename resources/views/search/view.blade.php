@extends('layouts.app')

@section('content')
    <section class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Поиск по сайту</h3>
                    <p>Функционал находится в разработке!</p>
                </div>
            </div>

            {{--<ul class="nav nav-pills">--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link {{ $action === 'files' ? 'active' : '' }}" href="{{ route('search', ['files']) }}">Файлы</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link {{ $action === 'posts' ? 'active' : '' }}" href="{{ route('search', ['posts']) }}">Посты</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link {{ $action === 'professors' ? 'active' : '' }}" href="{{ route('search', ['professors']) }}">Преподаватели</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link {{ $action === 'couples' ? 'active' : '' }}" href="{{ route('search', ['couples']) }}">Предметы</a>--}}
                {{--</li>--}}
            {{--</ul>--}}

            {{--<br />--}}

            {{--<form>--}}
                {{--<div class="input-group">--}}
                    {{--<input type="text" class="form-control" placeholder="Search for..." aria-label="Search for...">--}}
                    {{--<span class="input-group-btn">--}}
                        {{--<button class="btn btn-secondary" type="button">Найти!</button>--}}
                    {{--</span>--}}
                {{--</div>--}}
            {{--</form>--}}

            {{--<br />--}}

            {{--<div class="results">--}}
                {{--hello world--}}
            {{--</div>--}}

        </div>
    </section>
@endsection
