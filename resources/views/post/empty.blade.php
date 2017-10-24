@extends('layouts.app')

@section('content')
    <article class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="text-center">{{ $message }}</h4>
                </div>

                <div class="panel-body row">
                    <img class="mx-auto" src="/image/students-128.png" title="Логотип" alt="Логотип" />
                </div>
            </div>
        </div>
    </article>
@endsection
