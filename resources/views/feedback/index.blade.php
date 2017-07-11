@extends('layouts.app')

@section('content')
    <article class="row">
        <div class="col-md-12">

            <h1>{{ __('blocks.feedback') }}</h1>

            <form method="POST">

                {{ csrf_field() }}

                <div class="form-group">
                    <label for="name">{{ __('blocks.lastName') }} {{ __('blocks.name') }} {{ __('blocks.middleName') }}</label>
                    <input required type="text" class="form-control" id="name" name="name" placeholder="{{ __('blocks.examples.fullNameField') }}">
                </div>

                <div class="form-group">
                    <label for="communication">{{ __('blocks.email') }} / {{  __('blocks.phone') }} / {{ __('blocks.residentialAddress') }}</label>
                    <input required type="text" class="form-control" id="communication" name="communication" placeholder="{{ __('blocks.examples.feedbackField') }}">
                </div>

                <div class="form-group">
                    <label for="content">{{ __('blocks.text') }}</label>
                    <textarea required class="form-control" id="content" rows="9" name="content" placeholder="{{ __('blocks.examples.inputTextField') }}"></textarea>
                </div>

                <div class="form-check">
                    <label class="form-check-label">
                        <input id="personal-data" type="checkbox" class="form-check-input" />
                        {{ __('blocks.allowProcessingPersonalInformation') }}
                    </label>
                </div>

                <button type="submit" class="btn btn-secondary" disabled data-personal>{{ __('blocks.submit') }}</button>

            </form>

        </div>
    </article>
@endsection
