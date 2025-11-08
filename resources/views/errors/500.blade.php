@extends('errors::layout')

@section('title', __('Server Error'))
@section('message', __('Something went wrong! Please try again later.'))

@section('image')
    <img src="{{ asset('media/auth/500-error.png') }}" class="mw-100 mh-300px theme-light-show" alt="Server Error" />
    <img src="{{ asset('media/auth/500-error-dark.png') }}" class="mw-100 mh-300px theme-dark-show" alt="Server Error" />
@endsection
