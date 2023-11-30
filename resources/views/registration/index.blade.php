@extends('layouts.master')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Data Registrasi</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Filter Registrasi</h5>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-3">
                            <label>Tanggal Pemeriksaan</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="date" name="consultation_date" id="consultation_date" value="{{ date('Y-m-d') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Search</label>
                            <div class="input-group date">
                                <input type="search" name="search" id="search" placeholder="Cari MRN, pasien, antrian" class="form-control">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-md-3">
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
                    </div>
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-3">
                            <label>Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="" selected>Pilih</option>
                                <option value="Dalam Antrian">Dalam Antrian</option>
                                <option value="Pemeriksaan">Pemeriksaan</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="margin-top: 28px;">
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
                <div class="ibox-title">
                    <h5><a class="btn btn-primary" href="{{ route('registration.create') }}"><i class="fa fa-plus-square mr-1"></i> Buat Registrasi</a></h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover registrationTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="1px">No</th>
                                    <th>Waktu Konsul</th>
                                    <th>Nomor Antrian</th>
                                    <th>Pasien</th>
                                    <th>Poli</th>
                                    <th>Dokter</th>
                                    <th>Status</th>
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
    $(function() {
        //TEMPLATES 
        let serverSideTable = $('.registrationTable').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [1, 'asc'],
                [6, 'asc'],
            ],
            ajax: {
                url: "{{ route('registration.create') }}",
                type: "GET",
                data: function(d) {
                    d.consultation_date = $('input[name="consultation_date"]').val()
                    d.search = $('input[name="search"]').val()
                    d.poli_id = $('select[name="poli_id"]').val()
                    d.user_id = $('select[name="user_id"]').val()
                    d.status = $('select[name="status"]').val()
                }
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false,
            }, {
                data: 'consultation_date',
                name: 'consultation_date'
            }, {
                data: 'queue_number',
                name: 'queue_number'
            }, {
                data: 'patient_id',
                name: 'patient_id'
            }, {
                data: 'poli.name',
                name: 'poli.name'
            }, {
                data: 'user.name',
                name: 'user.name'
            }, {
                data: 'status',
                name: 'status'
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

        $(document).on('click', '#cancel', function(e) {
            let id = $(this).data('integrity')
            let queue_number = $(this).closest('tr').find('td:eq(2)').text()
            swal({
                title: "Batalkan Antrian?",
                text: `Nomor Antrian: "${queue_number}" akan dibatalkan`,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Batalkan!",
                closeOnConfirm: false
            }, function() {
                swal.close()
                $.ajax({
                    url: "{{ route('registration.store') }}/" + id,
                    type: "DELETE",
                    dataType: 'json',
                    success: function(response) {
                        serverSideTable.draw();
                        sweetalert('Berhasil', `Registrasi berhasil dibatalkan.`, null, 500, false)
                    },
                    error: function(response) {
                        serverSideTable.draw();
                        sweetalert('Terjadi Kesalahan!', 'Data tidak bisa dibatalkan', 'error')
                    }
                })
            });
        })
    })
</script>
@endpush