@if($_logo)

    <div class="form-group {!! !$errors->has($errorKey) ?: 'has-error' !!}">

        <label for="{{$id}}" class="col-sm-2 control-label">{{$label}}</label>

        <div class="col-sm-8">

            @include('admin::form.error')

            <img id="{{ $id }}" class="img-thumbnail" src="/storage/{{ $_logo }}">

            @include('admin::form.help-block')

        </div>
    </div>

@endif