@extends('v200.layouts.app')
@section('page_title', env('APP_NAME').' - '. ucfirst(__('common.change')) . ' password')

@section('main_content')
    <div class="card mb-4">
    <div class="card-block">
        <h3 class="card-title">{{ __('common.change') }} password</h3>
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
        <form method="post" action="{{ Route('password_update') }}">
            @csrf
            @method('PATCH')
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="old_password">{{ __('common.old') }} password</label>
                <div class="col-md-9">
                    <input type="password" name="old_password" class="form-control {{ $errors->has('old_password') ? 'is-invalid' : '' }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="new_password">{{ __('common.new') }} password</label>
                <div class="col-md-9">
                    <input type="password" name="new_password" class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="new_password_confirmation">{{ __('common.confirm') }} {{ __('common.new') }} password</label>
                <div class="col-md-9">
                    <input type="password" name="new_password_confirmation" class="form-control {{ $errors->has('new_password_confirmation') ? 'is-invalid' : '' }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
        </form>
    </div>
    </div>
@endsection