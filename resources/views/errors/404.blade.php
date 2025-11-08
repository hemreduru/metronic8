@extends('errors::layout')

@section('title', __('Not Found'))
@section('message', __('Oops! We can\'t find that page.'))

@section('image')
    <img src="{{ asset('media/auth/404-error.png') }}" class="mw-100 mh-300px theme-light-show" alt="404 Error" />
    <img src="{{ asset('media/auth/404-error-dark.png') }}" class="mw-100 mh-300px theme-dark-show" alt="404 Error" />
@endsection
