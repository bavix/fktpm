@extends('layouts.app')

@section('content')
    <article class="row">
        <div class="col-md-12">

            <h1>Подать заявление</h1>

            <form method="POST">

                {{ csrf_field() }}

                <h5>Заявление от</h5>

                <div class="form-group">
                    <label for="parentName">Фамилия Имя Отчество <small>(родитель; в род. падеже)</small></label>
                    <input required type="text" class="form-control" id="parentName" name="parent_name"
                           placeholder="Иванова Ивана Ивановича" />
                </div>

                <div class="form-group">
                    <label for="phone">Номер телефона <small>(мобильный)</small></label>
                    <input required type="text" class="form-control col-md-4" id="phone" name="phone" placeholder="+7 (918) 123-45-67" />
                </div>

                <h5>Паспортные данные <small>(родителя)</small></h5>

                <div class="row">

                    <div class="col-md-5">

                        <div class="form-group">
                            <label for="passportSerial">Серия</label>
                            <input required type="text" class="form-control" id="passportSerial" name="passport_serial"
                                   placeholder="03 09">
                        </div>

                    </div>

                    <div class="col-md-7">

                        <div class="form-group">
                            <label for="passportNumber">Номер</label>
                            <input required type="text" class="form-control" id="passportNumber" name="passport_number"
                                   placeholder="123456" />
                        </div>

                    </div>

                </div>

                <div class="form-group">
                    <label for="passportFrom">Кем выдан</label>
                    <input required type="text" class="form-control" id="passportFrom" name="passport_from"
                           placeholder="ОУФМС России по Краснодарскому краю в Белореченском районе" />
                </div>

                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">
                            <!-- datepicker -->
                            <label for="passportDate">Дата выдачи</label>
                            <input required type="text" class="form-control datepicker" id="passportDate" name="passport_date"
                                placeholder="01.01.2001" />
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="passportDivision">Код подразделения</label>
                            <input required type="text" class="form-control" id="passportDivision" name="passport_division" placeholder="123-456" />
                        </div>

                    </div>

                </div>

                <div class="form-group">
                    <label for="registrationAddress">Адрес регистрации <small>(по паспорту)</small></label>
                    <input required type="text" class="form-control" id="registrationAddress" name="registration_address"
                       placeholder="г. Москва, ул. Красная 44" />
                </div>

                <div class="form-check">
                    <label class="form-check-label">
                        <input id="autoAddress" type="checkbox" class="form-check-input" name="auto_address" />
                        Адрес проживания совподает с адресом регистрации
                    </label>
                </div>

                <div class="form-group">
                    <label for="residentialAddress">Адрес проживания</label>
                    <input required type="text" class="form-control" id="residentialAddress" name="residential_address"
                       placeholder="г. Москва, ул. Пушнина 1" />
                </div>

                <h5>Прошу зачислить моего ребенка</h5>

                <div class="form-group">
                    <label for="childrenName">Фамилия Имя Отчество <small>(ребенок; в род. падеже)</small></label>
                    <input required type="text" class="form-control" id="childrenName" name="children_name"
                           placeholder="Иванова Василия Ивановича" />
                </div>

                <div class="form-group">
                    <label for="childrenDocType">Документ</label>
                    <input required type="text" class="form-control" id="childrenDocType" name="children_doc_type"
                        placeholder="свидетельство о рождении" />
                </div>

                <div class="row">

                    <div class="col-md-5">

                        <div class="form-group">
                            <label for="childrenDocSerial">Серия</label>
                            <input required type="text" class="form-control" id="childrenDocSerial" name="children_doc_serial"
                                placeholder="1-ДН" />
                        </div>

                    </div>

                    <div class="col-md-7">

                        <div class="form-group">
                            <label for="childrenDocNumber">Номер</label>
                            <input required type="text" class="form-control" id="childrenDocNumber" name="children_doc_number"
                               placeholder="123456" />
                        </div>

                    </div>

                </div>

                <div class="form-group">

                    <div class="row">

                        <div class="col-md-7">

                            <label for="childrenSchool">Школа</label>
                            <input required type="text" class="form-control" id="childrenSchool" name="children_school"
                                   placeholder="МБОУ СОШ №123" />

                        </div>

                        <div class="col-md-5">

                            <label for="childrenClass">Класс</label>
                            <input required type="text" class="form-control" id="childrenClass" name="children_сlass"
                                   placeholder="3Б" />

                        </div>

                    </div>

                </div>

                <div class="form-group">
                    <label for="types">Кружок</label>
                    <select required class="form-control" id="types" name="type_id">
                        <option disabled selected>Выберете кружок</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" data-desc="{{ $type->description }}">{{ $type->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-check">
                    <label class="form-check-label">
                        <input id="personal-data" type="checkbox" class="form-check-input" />
                        Разрешить обработку персональных данных
                    </label>
                </div>

                <button type="submit" class="btn btn-secondary" disabled data-personal>Отправить</button>

            </form>

        </div>
    </article>
@endsection
