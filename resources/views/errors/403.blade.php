@extends('errors::layout')

@section('title', __('Access Denied'))
@section('message', __($exception->getMessage() ?: 'You don\'t have permission to access this resource.'))

@section('image')
    <img src="{{ asset('media/auth/404-error.png') }}" class="mw-100 mh-300px theme-light-show" alt="Access Denied" />
    <img src="{{ asset('media/auth/404-error-dark.png') }}" class="mw-100 mh-300px theme-dark-show" alt="Access Denied" />
@endsection
