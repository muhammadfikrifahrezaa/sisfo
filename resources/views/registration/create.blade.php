@extends('layouts.master')

@push('css')
<link href="{{ asset('build/assets') }}/css/plugins/select2/select2.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Buat Registrasi</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <span><a href="{{ route('registration.index') }}"><u>Registrasi</u></a></span>
            </li>
            <li class="breadcrumb-item active">
                <strong>Buat</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-7">
            <form action="{{ route('registration.store') }}" method="post" id="formRegistration">
                @csrf
                @method('POST')

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Jenis Pendaftaran</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <label>Jenis Kunjungan *</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>
                                        <input type="radio" checked="" value="Kunjungan Sakit" id="type_visit1" name="type_visit"> Kunjungan Sakit
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label>
                                        <input type="radio" value="Kunjungan Sehat" id="type_visit2" name="type_visit"> Kunjungan Sehat
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Jenis Perawatan *</label>
                            <select name="type_treatment" id="type_treatment" class="form-control">
                                <option value="Rawat Jalan">Rawat Jalan</option>
                                <option value="Rawat Inap">Rawat Inap</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Data Pasien</h5>
                    </div>
                    <div class="ibox-content">
                        <h5>Data Umum</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Pasien *</label>
                                    <select class="form-control search-patient" name="patient_id" id="patient_id" required></select>
                                    <small class="text-danger" id="patient_id_error"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <div class="input-group date">
                                        <input type="date" id="date_of_birth" class="form-control" readonly>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>RMN</label>
                                    <input type="search" class="form-control" id="registration_number" placeholder="MRN Pasien" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select id="gender" class="form-control" disabled>
                                        <option value="" disabled selected>Pilih</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea id="address" cols="30" rows="2" class="form-control" readonly placeholder="Alamat Pasien"></textarea>
                        </div>
                        <hr class="hr-line-dashed">
                        <h5>Data Kontak</h5>

                        <div class="form-group">
                            <label>Nomor Telepon</label>
                            <input type="text" class="form-control" id="phone_number" readonly placeholder="Nomor Telepon">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Identitas</label>
                                    <select id="type_identity" class="form-control" disabled>
                                        <option value="" disabled selected>Pilih</option>
                                        <option value="KTP">KTP</option>
                                        <option value="SIM">SIM</option>
                                        <option value="Kartu Pelajar">Kartu Pelajar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Identitas</label>
                                    <input type="text" class="form-control" id="no_identity" readonly placeholder="Nomor Identitas">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Dokter & Jadwal</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <label>Pembiayaan</label>
                            <select name="financing" id="financing" class="form-control">
                                <option value="Pribadi">Pribadi</option>
                                <option value="Keluarga">Keluarga</option>
                            </select>
                        </div>
                        <hr class="hr-line-dashed">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Poliklinik</label>
                                    <select name="poli_id" id="poli_id" class="form-control" required>
                                        <option value="" selected disabled>Pilih</option>
                                        @foreach($polis as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger" id="poli_id_error"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Konsultasi</label>
                                    <input type="date" class="form-control" name="consultation_date" id="consultation_date" value="{{ date('Y-m-d') }}" required>
                                    <small class="text-danger" id="consultation_date_error"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Dokter</label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        <option value="" disabled selected>Pilih</option>
                                    </select>
                                    <small class="text-danger" id="user_id_error"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jam Konsultasi</label>
                                    <select name="doctor_schedule_id" id="doctor_schedule_id" class="form-control" required>
                                        <option value="" disabled selected>Pilih</option>
                                    </select>
                                    <small class="text-danger" id="doctor_schedule_id_error"></small>
                                </div>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-sm-offset-2">
                                <button class="btn btn-primary float-right" type="submit"><i class="fa fa-save"></i> Buat Registrasi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('build/assets') }}/js/plugins/select2/select2.full.min.js"></script>
<script>
    $(function() {

        function sweetalert(title, msg, type, timer = 60000, confirmButton = true) {
            swal({
                title: title,
                text: msg,
                type: type,
                timer: timer,
                showConfirmButton: confirmButton
            });
        }

        $("#formRegistration").validate({
            messages: {
                patient_id: "Tanggal Lahir tidak boleh kosong",
                poli_id: "Nomor Identitas tidak boleh kosong",
                user_id: "Jenis Kelamin tidak boleh kosong",
                consultation_date: "Golongan Darah tidak boleh kosong",
                doctor_schedule_id: "Alamat tidak boleh kosong",
            },
            success: function(messages) {
                $(messages).remove();
            },
            errorPlacement: function(error, element) {
                let name = element.attr("name");
                $("#" + name + "_error").text(error.text());
            },
            submitHandler: function(form) {
                form.submit()
            }
        });

        $(".search-patient").select2({
            placeholder: "Cari Nama Pasien",
            allowClear: true,
            minimumInputLength: 3,
            ajax: {
                url: "{{ route('registration.patient') }}",
                dataType: 'json',
                type: "GET",
                quietMillis: 50,
                data: function(params) {
                    return {
                        searchTerm: params.term
                    };
                },
                processResults: function(res) {
                    let result = []
                    res.data.forEach(function(data, index) {
                        result[index] = {
                            'id': data.id,
                            'text': data.name,
                        }
                    })
                    return {
                        results: result
                    }
                },
            }
        });

        $('#patient_id').on('change', function(e) {
            let id = $(this).val()

            $.ajax({
                url: "{{ url('/registration/patient') }}/" + id,
                method: "GET",
                dataType: 'json',
                success: function(res) {
                    $('#date_of_birth').val(res.data.date_of_birth)
                    $('#registration_number').val(res.data.registration_number)
                    $('#gender').val(res.data.gender)
                    $('#address').val(res.data.address)
                    $('#phone_number').val(res.data.phone_number)
                    $('#type_identity').val(res.data.type_identity)
                    $('#no_identity').val(res.data.no_identity)
                },
                error: function(res) {
                    sweetalert('Terjadi Kesalahan!', 'Data tidak ditemukan', 'error')
                }
            })
        })

        $(document).on('change', '#consultation_date', function(e) {
            $('#poli_id').val('')
        })

        $(document).on('change', '#poli_id', function(e) {
            let poliId = $(this).val()
            let date = $('#consultation_date').val()

            $.ajax({
                url: "{{ url('/registration/doctor') }}/" + poliId + '/' + date,
                method: "GET",
                dataType: 'json',
                success: function(res) {
                    $('#user_id').find('option').remove()
                    $('#doctor_schedule_id').find('option').remove()

                    let doctor = `<option value="" selected disabled>Pilih</option>`
                    res.data.forEach(function(data, index) {
                        doctor += `<option value="${data.user.id}">${data.user.name}</option>`
                    })
                    $('#user_id').append(doctor)
                },
                error: function(res) {
                    sweetalert('Terjadi Kesalahan!', 'Data tidak ditemukan', 'error')
                }
            })
        })

        $(document).on('change', '#user_id', function(e) {
            let userId = $(this).val()
            let date = $('#consultation_date').val()
            let poliId = $('#poli_id').val()

            $.ajax({
                url: "{{ url('/registration/doctor-schedule') }}/" + poliId + '/' + date + '/' + userId,
                method: "GET",
                dataType: 'json',
                success: function(res) {
                    $('#doctor_schedule_id').find('option').remove()

                    let doctor = `<option value="" selected disabled>Pilih</option>`
                    res.data.forEach(function(data, index) {
                        doctor += `<option value="${data.id}">${data.start_time} - ${data.end_time}</option>`
                    })
                    $('#doctor_schedule_id').append(doctor)
                },
                error: function(res) {
                    sweetalert('Terjadi Kesalahan!', 'Data tidak ditemukan', 'error')
                }
            })
        })

    })
</script>
@endpush