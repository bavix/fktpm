@extends('layouts.app')

@section('content')
    <section class="row">
        <div class="col-12">

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

                            <table class="table table-bordered table-hover">

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
                                                    <a href="{{ route('professor.rank', [$professor->professorrating]) }}" target="_blank" title="Рейтинг {{ $professor->fullName() }}">
                                                        {{ $professor->fullName() }}
                                                    </a>
                                                @else
                                                    {{ $professor->fullName() }}
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

            @if (isset($item))
                @unset($item)
            @endif

        </div>
    </section>
@endsection
