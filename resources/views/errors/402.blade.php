@extends('errors::layout')

@section('title', __('Payment Required'))
@section('message', __('Payment is required to access this resource.'))

@section('image')
    <img src="{{ asset('media/auth/404-error.png') }}" class="mw-100 mh-300px theme-light-show" alt="Payment Required" />
    <img src="{{ asset('media/auth/404-error-dark.png') }}" class="mw-100 mh-300px theme-dark-show" alt="Payment Required" />
@endsection
