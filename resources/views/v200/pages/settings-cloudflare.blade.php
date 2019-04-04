@extends('v200.layouts.app')
@section('page_title', env('APP_NAME').' - '. ucfirst(__('common.settings')) .' Cloudflare')

@section('main_content')
    <div class="card mb-4">
        <div class="card-block">
            <h3 class="card-title">{{ __('common.settings') }} Cloudflare</h3>
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
            <form method="post" action="{{ Route('settings_cloudflare_update') }}">
                @csrf
                @method('PATCH')
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="api_key">API key</label>
                    <div class="col-md-9">
                        <input type="text" name="api_key" value="{{ isset($settings_cloudflare->api_key) ? $settings_cloudflare->api_key : '' }}" class="form-control {{ $errors->has('api_key') ? 'is-invalid' : '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="email">{{ __('common.email') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="email" value="{{ isset($settings_cloudflare->email) ? $settings_cloudflare->email : '' }}" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="domain_list">{{ __('cloudflare.domain_list') }}</label>
                    <div class="col-md-9">
                        <input type="text" name="domain_list" value="{{ isset($settings_cloudflare->domain_list) ? $settings_cloudflare->domain_list : '' }}" class="form-control {{ $errors->has('domain_list') ? 'is-invalid' : '' }}">
                    </div>
                </div>
                <!-- /date format -->
                <button type="submit" class="btn btn-primary">{{ __('common.update') }}</button>
            </form>
        </div>
    </div>
@endsection