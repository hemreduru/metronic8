@extends('layouts.master')
@section('page-title', __('common.dashboard'))
@section('content')
    <div class="card">
        <div class="card-body">
            <h1>{{ __('common.welcome') }}, {{ auth()->user()->name }}!</h1>
            <p>{{ __('common.dashboard_welcome_message') }}</p>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ __('common.total_users') }}</h5>
                    <p class="card-text fs-2">{{ $totalUsers ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ __('common.total_posts') }}</h5>
                    <p class="card-text fs-2">{{ $totalPosts ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
