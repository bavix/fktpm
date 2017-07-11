<!DOCTYPE html>
<html>
    <head>
        <title>Заявление от {{ $parent_name }}</title>
        <meta charset="utf-8" />

        <link href="{{ asset2('node_modules/bootstrap/dist/css/bootstrap.min.css')  }}" rel="stylesheet"/>
        <style>
            p {
                margin: 0;
                text-indent: 2rem;
                text-align: justify;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">

            <div class="row">
                <div class="col-1"></div>
                <div class="col-11">

                    <header class="row">
                        <div class="col-6"></div>
                        <div class="col-6">
                            <div class="row">
                                <span>Директору&nbsp;МБУ&nbsp;ДО&nbsp;СЮТ</span>
                            </div>
                            <div class="row"><span>М.Ю.&nbsp;Беспалову</span></div>
                            <div class="row">
                                <span>родителя (законного представителя)</span>
                            </div>
                            <div class="row">
                                <span><strong>{{ $parent_name }}</strong></span>
                            </div>
                            <div class="row">
                                <span>проживающего по адресу: <strong>{{ $residential_address }}</strong></span>
                            </div>
                            <div class="row">
                                <span>зарегистрированного по адресу: <strong>{{ $registration_address }}</strong></span>
                            </div>
                            <div class="row">
                                <span>паспорт серия <strong>{{ $passport_serial }}</strong> № <strong>{{ $passport_number }}</strong></span>
                            </div>
                            <div class="row">
                                @php($carbon = \Laravelrus\LocalizedCarbon\LocalizedCarbon::createFromFormat('Y-m-d', $passport_date))
                                <span>дата выдачи: <strong>{{ $carbon->format('d.m.Y') }}</strong></span>
                            </div>
                            <div class="row">
                                <span>кем выдан: <strong>{{ $passport_from }}</strong></span>
                            </div>
                            <div class="row">
                                <span>код подразделения: <strong>{{ $passport_division }}</strong></span>
                            </div>
                            <div class="row">
                                <span>телефон: <strong>{{ $phone }}</strong></span>
                            </div>
                        </div>
                    </header>

                    <br/>
                    <br/>

                    <main class="row">
                        <div class="col-12 text-center">
                            <p></p>
                            <h5>ЗАЯВЛЕНИЕ</h5>
                            <br/>
                        </div>
                        <p class="col-12">
                            <span>Прошу зачислить моего ребенка <strong>{{ $children_name }}</strong>
                            документ <strong>{{ $children_doc_type }}</strong> серия <strong>{{ $children_doc_serial }}</strong>
                            № <strong>{{ $children_doc_number }}</strong>
                            обучающегося школы <strong>{{ $children_school }}</strong>
                            класса <strong>{{ $children_сlass }}</strong>
                            в объединение «<strong>{{ $type['title'] }}</strong>» МБУ&nbsp;ДО&nbsp;СЮТ.</span>
                        </p>
                        <p class="col-12">
                            <span>Обязуюсь контролировать посещение моим ребенком объединения МБУ ДО СЮТ.</span>
                        </p>
                        <p class="col-12">
                            <span>С расписанием кружка, Уставом организации, режимом работы и
                                правилами внутреннего распорядка ознакомлен(а).</span>
                        </p>
                    </main>

                    <br/>
                    <br/>

                    @php($carbon = \Laravelrus\LocalizedCarbon\LocalizedCarbon::createFromFormat('Y-m-d H:i:s', $created_at))
                    @php($local = \Laravelrus\LocalizedCarbon\LocalizedCarbon::instance($carbon))

                    <footer class="row">
                        <div class="col-9">
                            «{{ $local->formatLocalized('%d') }}» {{ $local->formatLocalized('%f %Y') }} г.
                        </div>
                        <div class="col-3 float-right">
                            _____________________
                            <small>(подпись)</small>
                        </div>
                    </footer>

                </div>
            </div>

        </div>

        <script defer async>window.print();</script>
    </body>
</html>
