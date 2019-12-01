@extends('layouts.app')

@section('content')
    <section class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Преподаватели</h2>
                </div>
            </div>

            @foreach($items as $item)

                @php($departments = $item->departments)

                @if (!$departments->count())
                    @continue
                @endif

                <div class="card">

                    <div class="card-body">

                    <h3 class="card-title">{{ $item->name }}</h3>

                        @foreach($departments as $department)

                            @php($professors = $department->professors)

                            @if (!$professors->count())
                                @continue
                            @endif

                            <table class="table table-hover">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ $department->name }}</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($professors as $professor)

                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($professor->professorrating)
                                                    <a href="{{ route('professor.rank', [$professor->professorrating]) }}" target="_blank" title="Рейтинг {{ $professor->full_name }}">
                                                        {{ $professor->full_name }}
                                                    </a>
                                                @else
                                                    {{ $professor->full_name }}
                                                @endif
                                            </td>
                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        @endforeach

                    </div>

                </div>

            @endforeach
        </div>
    </section>
@endsection
