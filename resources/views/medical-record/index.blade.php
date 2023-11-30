@extends('layouts.master')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Rekam Medis</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Filter Rekam Medis</h5>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-3">
                            <label>Tanggal Rekam Medis</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="date" name="created_at" id="created_at" value="{{ date('Y-m-d') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Search</label>
                            <div class="input-group date">
                                <input type="search" name="search" id="search" placeholder="Cari MRN, nama pasien" class="form-control">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>Poliklinik</label>
                            <select name="poli_id" id="poli_id" class="form-control">
                                <option value="" selected>Pilih</option>
                                @foreach($polis as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Dokter</label>
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="" selected>Pilih</option>
                                @foreach($doctors as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1" style="margin-top: 28px;">
                            <button class="btn btn-primary" id="btnFilter"><i class="fa fa-filter mr-1"></i>Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover medicalRecordTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="1px">No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Pasien</th>
                                    <th>Dokter</th>
                                    <th class="text-right" width="1px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    $(document).ready(function() {

        let serverSideTable = $('.medicalRecordTable').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [1, 'asc']
            ],
            ajax: {
                url: "{{ route('checkup.create') }}",
                type: "GET",
                data: function(d) {
                    d.created_at = $('input[name="created_at"]').val()
                    d.search = $('input[name="search"]').val()
                    d.poli_id = $('select[name="poli_id"]').val()
                    d.user_id = $('select[name="user_id"]').val()
                }
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false,
            }, {
                data: 'created_at',
                name: 'created_at'
            }, {
                data: 'patient',
                name: 'patient'
            }, {
                data: 'doctor',
                name: 'doctor'
            }, {
                data: 'action',
                name: 'action',
                searchable: false,
                orderable: false
            }],
            search: {
                "regex": true
            }
        });

        $('#btnFilter').click(function(e) {
            e.preventDefault()
            serverSideTable.draw();
        })

    });
</script>
@endpush