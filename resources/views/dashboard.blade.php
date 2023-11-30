@extends('layouts.master')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Total Pasien</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $patient_today }}</h1>
                        <small>Hari Ini</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Dalam Antrian</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $patient_in_queue }}</h1>
                        <small>Hari Ini</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Selesai</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $patient_done }}</h1>
                        <small>Hari Ini</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Dibatalkan</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $patient_canceled }}</h1>
                        <small>Hari Ini</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@push('script')
<script>
    $(function() {

    })
</script>
@endpush