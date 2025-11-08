@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@extends('errors::layout')

@section('title', __('Service Unavailable'))
@section('message', __($exception->getMessage() ?: 'The service is temporarily unavailable. Please try again later.'))

@section('image')
    <img src="{{ asset('media/auth/500-error.png') }}" class="mw-100 mh-300px theme-light-show" alt="Service Unavailable" />
    <img src="{{ asset('media/auth/500-error-dark.png') }}" class="mw-100 mh-300px theme-dark-show" alt="Service Unavailable" />
@endsection
