@extends('layouts.app')

@section('content')
    <article class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">

                    <h2 class="card-title">Помощь проекту</h2>

                    <p>Сайт, как и студенты, нуждается в новых лекциях!
                        Если вы обладаете электронным материалом поделитесь!
                        Используя удобный, для вас, вид связи с администратором.</p>

                    <h3>Контакты</h3>

                    <p>Электронная почта: <a href="mailto:info@babichev.net" title="Бабичев Максим">info@babichev.net</a></p>
                    <p>Вконтакте: <a href="https://vk.com/rez1dent3">rez1dent3</a></p>
                    <p>Сайт: <a href="https://babichev.net" title="Бабичев Максим">babichev.net</a></p>

                    <h3>Материальная помощь</h3>

                    <p>Сайт находится на хостинге <a href="https://ln4.ru/DigOn" title="DigitalOcean">DigitalOcean</a>,
                        на оплату которого уходит 10$ в месяц.</p>

                    <p>Любая помощь проекту — это добрый шаг с вашей стороны, вы становитесь хотя бы немного,
                        но соавтором проекта и непосредственным образом влияете на его дальнейшее развитие.</p>

                    @include('helper.donate')

                </div>
            </div>

        </div>
    </article>
@endsection
