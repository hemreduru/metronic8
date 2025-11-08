@extends('errors::layout')

@section('title', __('Unauthorized'))
@section('message', __('You need to log in to access this page.'))

@section('image')
    <img src="{{ asset('media/auth/404-error.png') }}" class="mw-100 mh-300px theme-light-show" alt="Unauthorized" />
    <img src="{{ asset('media/auth/404-error-dark.png') }}" class="mw-100 mh-300px theme-dark-show" alt="Unauthorized" />
@endsection
