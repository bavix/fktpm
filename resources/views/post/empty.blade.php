@extends('layouts.app')

@section('content')
    <article class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h4 class="card-title">{{ $message ?? 'Ничего не найдено' }}</h4>
                    <img src="/image/students-128.png" title="fktpm" alt="fktpm" />
                </div>
            </div>
        </div>
    </article>
@endsection
