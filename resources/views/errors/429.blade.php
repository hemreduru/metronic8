@extends('errors::layout')

@section('title', __('Too Many Requests'))
@section('message', __('Too many requests. Please slow down and try again later.'))

@section('image')
    <img src="{{ asset('media/auth/500-error.png') }}" class="mw-100 mh-300px theme-light-show" alt="Too Many Requests" />
    <img src="{{ asset('media/auth/500-error-dark.png') }}" class="mw-100 mh-300px theme-dark-show" alt="Too Many Requests" />
@endsection
