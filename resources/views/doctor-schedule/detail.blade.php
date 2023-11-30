@extends('layouts.master')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Jadwal</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <span><a href="{{ route('doctor-schedule.index') }}"><u>Jadwal Dokter</u></a></span>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detail</strong>
            </li>
        </ol>
    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Data Dokter</button></h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive" style="margin-bottom: -20px;">
                        <table class="table table-bordered" width="100%">
                            <tr>
                                <th width="250px">Nama</th>
                                <td width="50px" class="text-center">:</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th width="250px">Nomor Telepon</th>
                                <td width="50px" class="text-center">:</td>
                                <td>{{ $user->phone_number }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5><button class="btn btn-primary btn-sm" data-toggle="modal" data-mode="add" data-target="#ModalAddEdit"><i class="fa fa-plus-square mr-1"></i> Tambah Jadwal</button></h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover scheduleTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Poli</th>
                                    <th>Hari</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th width="1%">Aksi</th>
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

<div class="modal fade" id="ModalAddEdit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAddEdit" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">

                    <div class="form-group">
                        <label>Poli</label>
                        <select name="poli_id" id="poli_id" class="form-control" required>
                            @foreach($polis as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="poli_id_error"></small>
                    </div>
                    <div class="form-group">
                        <label>Hari</label>
                        <select name="day" id="day" class="form-control" required>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                        <small class="text-danger" id="day_error"></small>
                    </div>
                    <div class="form-group">
                        <label>Jam Mulai</label>
                        <input type="time" name="start_time" id="start_time" class="form-control" required>
                        <small class="text-danger" id="start_time_error"></small>
                    </div>
                    <div class="form-group">
                        <label>Jam Selesai</label>
                        <input type="time" name="end_time" id="end_time" class="form-control" required>
                        <small class="text-danger" id="end_time_error"></small>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-rectangle-o mr-1"></i>Tutup [Esc]</button>
                    <button type="submit" class="btn btn-primary ladda-button ladda-button-demo" data-style="zoom-in" id="submit" tabindex="5"><i class="fa fa-check-square mr-1"></i>Simpan [Enter]</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@push('script')
<script>
    $(document).ready(function() {

        let serverSideTable = $('.scheduleTable').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [2, 'asc']
            ],
            ajax: {
                url: "{{ route('doctor-schedule.data', $user->id) }}",
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false,
            }, {
                data: 'poli.name',
                name: 'poli.name'
            }, {
                data: 'day',
                name: 'day'
            }, {
                data: 'start_time',
                name: 'start_time'
            }, {
                data: 'end_time',
                name: 'end_time'
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

        //BASE 
        let ladda = $('.ladda-button-demo').ladda();

        function LaddaStart() {
            ladda.ladda('start');
        }

        function LaddaAndDrawTable() {
            ladda.ladda('stop');
            serverSideTable.draw()
        }

        function sweetalert(title, msg, type, timer = 60000, confirmButton = true) {
            swal({
                title: title,
                text: msg,
                type: type,
                timer: timer,
                showConfirmButton: confirmButton
            });
        }

        $('#ModalAddEdit').on('shown.bs.modal', function(e) {
            let button = $(e.relatedTarget)
            let modal = $(this)
            if (button.data('mode') == 'edit') {
                let id = button.data('integrity')
                let closeTr = button.closest('tr')
                $('#formAddEdit').attr('action', "{{ route('doctor-schedule.store') }}/" + id).attr('method', 'PATCH')

                modal.find('#modal-title').text('Ubah Jadwal');
                modal.find('#day').val(closeTr.find('td:eq(2)').text())
                modal.find('#start_time').val(closeTr.find('td:eq(3)').text())
                modal.find('#end_time').val(closeTr.find('td:eq(4)').text())

                $.get('{{ route("doctor-schedule.store") }}/' + id, function(poli_id) {
                    modal.find('#poli_id').val(poli_id)
                })
            } else {
                $('#formAddEdit').trigger('reset').attr('action', "{{ route('doctor-schedule.store') }}").attr('method', 'POST')
                modal.find('#modal-title').text('Tambah Jadwal');
            }
        })

        $("#formAddEdit").validate({
            messages: {
                poli_id: "Poli saat ini tidak boleh kosong",
                day: "Hari sampai tidak boleh kosong",
                start_time: "Jam Mulai tidak boleh kosong",
                end_time: "Jam Selesai tidak boleh kosong",
            },
            success: function(messages) {
                $(messages).remove();
            },
            errorPlacement: function(error, element) {
                let name = element.attr("name");
                $("#" + name + "_error").text(error.text());
            },
            submitHandler: function(form) {
                LaddaStart()
                $.ajax({
                    url: $(form).attr('action'),
                    type: $(form).attr('method'),
                    data: $(form).serialize(),
                    dataType: 'JSON',
                    success: function(res) {
                        $('#ModalAddEdit').modal('hide')
                        LaddaAndDrawTable()
                        sweetalert('Berhasil', res.msg, null, 500, false)
                    },
                    error: function(res) {
                        LaddaAndDrawTable()
                        sweetalert('Gagal', 'Terjadi kesalah', 'error')
                    }
                })
            }
        });


        $(document).on('click', '#delete', function(e) {
            let id = $(this).data('integrity')
            swal({
                title: "Hapus?",
                text: `Data akan terhapus!`,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, hapus!",
                closeOnConfirm: false
            }, function() {
                swal.close()
                $.ajax({
                    url: "{{ route('doctor-schedule.store') }}/" + id,
                    type: "DELETE",
                    dataType: 'json',
                    success: function(response) {
                        LaddaAndDrawTable()
                        sweetalert("Terhapus!", `Data berhasil dihapus.`, null, 500, false)
                    },
                    error: function(response) {
                        LaddaAndDrawTable()
                        sweetalert("Tidak terhapus!", `Terjadi kesalahan saat menghapus data.`, 'error')
                    }
                })
            });
        });

    });
</script>
@endpush