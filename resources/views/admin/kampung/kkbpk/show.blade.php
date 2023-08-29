@extends('layouts.admin')


@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<style>
    .icheck-container {
        padding-top: calc(.375rem + 1px)!important;
    }

    .d-inline {
        margin-right: 1rem!important;
    }

    .form-group.row {
        border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    }

    input[type=number] {
        text-align: end!important;
    }

</style>
@endpush

@section('content-header')
    @include('admin.kampung.kkbpk.include.breadcrumb')
@endsection

@section('content')
<div class="container">
    <h3 class="mt-4 mb-3">Perkembangan Program Bangga Kencana</h3>

    <div id="disabled-form" class="container">

        @include('admin.kampung.kkbpk.include.form')

    </div>
</div>
@endsection

@push('scripts')
<script>
    $("#disabled-form :input").attr("disabled", true);
</script>
@endpush