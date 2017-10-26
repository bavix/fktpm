@extends('layouts.app')

@section('content')
    <article class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title">{{ $message }}</h4>
                    <img src="/image/students-128.png" title="Логотип" alt="Логотип" />
                </div>
            </div>
        </div>
    </article>
@endsection
