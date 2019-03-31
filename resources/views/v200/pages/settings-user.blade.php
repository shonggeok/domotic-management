@extends('v200.layouts.app')
@section('page_title', env('APP_NAME').' - '. ucfirst(__('common.settings')) .' '. ucfirst(__('common.user')))
@php
    $timezone = 'UTC';
    $date_format = 'd/m/Y';
    $language = 'en';
    if (isset($settings_user) && count($settings_user)>0) {
        foreach ($settings_user as $settings) {
            if ($settings->option_key === 'timezone') {
                $timezone = $settings->option_value;
            }
            if ($settings->option_key === 'date_format') {
                $date_format = $settings->option_value;
            }
            if ($settings->option_key === 'language') {
                $language = $settings->option_value;
            }
        }
    }
@endphp
@section('main_content')
    <div class="card mb-4">
        <div class="card-block">
            <h3 class="card-title">{{ __('common.settings') }} {{ __('common.user') }}</h3>
            @if(session()->has('success'))
                <div class="alert alert-success">
                    <p class="text-capitalize">{{ session()->get('success') }}</p>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    <p class="text-capitalize">{{ session()->get('error') }}</p>
                </div>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" action="{{ Route('settings_user_update') }}">
                @csrf
                @method('PATCH')
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="timezone">{{ __('common.timezone') }}</label>
                    <div class="col-md-9">
                        <select class="form-control" name="timezone">
                            <option value="{{ $timezone }}">{{ $timezone }}</option>
                            @php
                                $timezone_list = timezone_identifiers_list();
                                foreach ($timezone_list as $key => $value) {
                                    echo "<option value=\"$value\">$value</option>";
                                }
                            @endphp
                        </select>
                    <!--<input type="password" name="old_password" class="form-control {{ $errors->has('old_password') ? 'is-invalid' : '' }}">-->
                    </div>
                </div>
                <!-- date format -->
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="date_format">{{ __('common.date_format') }}</label>
                    <div class="col-md-9">
                        <select class="form-control" name="date_format">
                            <option value="{{ $date_format }}">{{ $date_format }}</option>
                            <option value="d/m/Y">d/m/Y</option>
                            <option value="m/d/Y">m/d/Y</option>
                        </select>
                    </div>
                </div>
                <!-- /date format -->
                <!-- language -->
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="language">{{ __('common.language') }}</label>
                    <div class="col-md-9">
                        <select class="form-control" name="language">
                            <option value="{{ $language }}">{{ $language }}</option>
                            <option value="en">en</option>
                            <option value="it">it</option>
                        </select>
                    </div>
                </div>
                <!-- /language -->
                <button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
            </form>
        </div>
    </div>
@endsection