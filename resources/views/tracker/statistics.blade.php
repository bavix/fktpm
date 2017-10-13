@extends('layouts.app')

@section('content')
    <article class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>{{ __('blocks.statistics') }}</h1>
                </div>

                <div class="panel-body">

                    <h2>Посещаемость сайта</h2>

                    <canvas class="no-visually" style="width: 100%; height: 400px" id="chart"></canvas>

                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td>Всего посещений</td>
                                <td class="text-right">{{ \App\Models\Tracker::hostAllCount() }}</td>
                            </tr>
                            <tr>
                                <td>Посещений сегодня</td>
                                <td class="text-right">{{ \App\Models\Tracker::hostCount() }}</td>
                            </tr>

                            <tr>
                                <td>Всего визитов</td>
                                <td class="text-right">{{ \App\Models\Tracker::hitAllCount() }}</td>
                            </tr>
                            <tr>
                                <td>Визитов сегодня</td>
                                <td class="text-right">{{ \App\Models\Tracker::hitCount() }}</td>
                            </tr>

                            <tr>
                                <td>Сейчас онлайн</td>
                                <td class="text-right">{{ \App\Models\Tracker::onlineCount() }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div class="panel-body">

                    <h2>Контент сайта</h2>

                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td>Всего постов</td>
                                <td class="text-right">{{ $newCount }}</td>
                            </tr>
                            <tr>
                                <td>Всего страниц</td>
                                <td class="text-right">{{ $pageCount }}</td>
                            </tr>
                            <tr>
                                <td>Всего альбомов</td>
                                <td class="text-right">{{ $albumCount }}</td>
                            </tr>
                            <tr>
                                <td>Всего опросов</td>
                                <td class="text-right">{{ $pollCount }}</td>
                            </tr>
                            <tr>
                                <td>Всего ссылок</td>
                                <td class="text-right">{{ $linkCount }}</td>
                            </tr>
                            <tr>
                                <td>Всего заявлений</td>
                                <td class="text-right">{{ $statementCount }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </article>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script>
        var chart = new Chart(document.getElementById('chart').getContext('2d'), {
            type: 'line' // 'bar'
            , data: {
                labels: {!! $chartLabels !!}
                , datasets: [{
                    label: "Текущий месяц"
                    , backgroundColor: 'rgba(255, 206, 86, 0.5)'
                    , borderColor: 'rgb(61, 98, 119)'
                    , data: {!! $chartDataCurrent !!}

                    , pointRadius: 4
                    , pointHoverRadius: 6
                    , pointHitRadius: 30
                    , pointBorderWidth: 2
                }, {
                    label: "Прошлый месяц"
                    , backgroundColor: 'rgba(54, 162, 235, 0.5)'
                    , borderColor: 'rgb(61, 98, 119)'
                    , data: {!! $chartDataLast !!}

                    , pointRadius: 4
                    , pointHoverRadius: 6
                    , pointHitRadius: 30
                    , pointBorderWidth: 2
                }]
            }
        });
    </script>

@endsection
