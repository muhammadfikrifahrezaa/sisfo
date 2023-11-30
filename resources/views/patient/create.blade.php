@extends('layouts.master')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Tambah Pasien</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <span><a href="{{ route('patient.index') }}"><u>Pasien</u></a></span>
            </li>
            <li class="breadcrumb-item active">
                <strong>Tambah</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Data Pasien</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{ route('patient.store') }}" method="post" id="formPatient">
                        @csrf
                        @method('POST')

                        <div class="form-group">
                            <label>Nomor Registrasi</label>
                            <input type="text" name="registration_number" class="form-control" value="{{ $registration_number }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                            <small class="text-danger" id="name_error"></small>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Telepon</label>
                                    <input type="text" class="form-control" name="phone_number" id="phone_number" required>
                                    <small class="text-danger" id="phone_number_error"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" required>
                                    <small class="text-danger" id="date_of_birth_error"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Identitas</label>
                                    <select name="type_identity" id="type_identity" class="form-control" required>
                                        <option value="KTP">KTP</option>
                                        <option value="SIM">SIM</option>
                                        <option value="Kartu Pelajar">Kartu Pelajar</option>
                                    </select>
                                    <small class="text-danger" id="type_identity_error"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Identitas</label>
                                    <input type="text" class="form-control" name="no_identity" id="no_identity" required>
                                    <small class="text-danger" id="no_identity_error"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <small class="text-danger" id="gender_error"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Golongan Darah</label>
                                    <select name="blood_type" id="blood_type" class="form-control" required>
                                        <option value="O">O</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                    </select>
                                    <small class="text-danger" id="blood_type_error"></small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="address" id="address" required cols="30" rows="2" class="form-control"></textarea>
                            <small class="text-danger" id="address_error"></small>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group row">
                            <div class="col-sm-12 col-sm-offset-2">
                                <button class="btn btn-primary float-right" type="submit"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(function() {

        $("#formPatient").validate({
            messages: {
                name: "Nama tidak boleh kosong",
                phone_number: "Nomor Telepon tidak boleh kosong",
                date_of_birth: "Tanggal Lahir tidak boleh kosong",
                type_identity: "Jenis Identitas tidak boleh kosong",
                no_identity: "Nomor Identitas tidak boleh kosong",
                gender: "Jenis Kelamin tidak boleh kosong",
                blood_type: "Golongan Darah tidak boleh kosong",
                address: "Alamat tidak boleh kosong",
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

    })
</script>
@endpush