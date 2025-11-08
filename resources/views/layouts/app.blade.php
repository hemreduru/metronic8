@extends('layouts.master')

@section('content')
    <!-- Page Heading -->
    @isset($header)
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                {{ $header }}
            </h1>
        </div>
    @endisset

    <!-- Page Content -->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container-xxl" id="kt_content_container">
            {{ $slot }}
        </div>
    </div>
@endsection
