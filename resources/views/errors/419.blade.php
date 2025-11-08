@extends('errors::layout')

@section('title', __('Page Expired'))
@section('message', __('Your session has expired. Please refresh the page and try again.'))

@section('image')
    <img src="{{ asset('media/auth/500-error.png') }}" class="mw-100 mh-300px theme-light-show" alt="Page Expired" />
    <img src="{{ asset('media/auth/500-error-dark.png') }}" class="mw-100 mh-300px theme-dark-show" alt="Page Expired" />
@endsection
