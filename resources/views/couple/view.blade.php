@extends('layouts.app')

@section('content')
    <section class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">

                    <h2 class="card-title">Предметы</h2>

                    <table class="table table-bordered table-hover">

                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Предметы</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($items as $item)

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                            </tr>

                        @endforeach

                        @if (isset($item))
                            @unset($item)
                        @endif

                        </tbody>

                    </table>

                </div>
            </div>

        </div>
    </section>
@endsection
