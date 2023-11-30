@extends('layouts.master')

@push('css')
<link href="{{ asset('build/assets') }}/css/plugins/select2/select2.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Buat Rekam Medis</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <span><a href="{{ route('checkup.index') }}"><u>Rekam Medis</u></a></span>
            </li>
            <li class="breadcrumb-item active">
                <strong>Buat Rekam Medis</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-7">
            <form action="{{ route('checkup.store') }}" method="post" id="formCheckup">
                @csrf
                @method('POST')

                <input type="hidden" name="registration_id" value="{{ $registration->id }}">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Subjective - <u>{{ $registration->queue_number }}</u></h5>
                    </div>
                    <div class="ibox-content">
                        <h5>Jadwal</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Dokter</b></label>
                                    <p class="form-control-static">{{ $registration->user->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Poli</b></label>
                                    <p class="form-control-static">{{ $registration->poli->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Tipe Kunjungan</b></label>
                                    <p class="form-control-static">{{ $registration->type_visit }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Waktu Konsul</b></label>
                                    <p class="form-control-static">{{ $registration->consultation_date }} - {{ $registration->doctor_schedule->start_time }}~{{ $registration->doctor_schedule->end_time }}</p>
                                </div>
                            </div>
                        </div>

                        <hr class="hr-line">
                        <h5>Data Umum</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Pasien</b></label>
                                    <p class="form-control-static">{{ $registration->patient->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Tanggal Lahir</b></label>
                                    <p class="form-control-static">{{ $registration->patient->date_of_birth }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Jenis Kelamin</b></label>
                                    <p class="form-control-static">{{ $registration->patient->gender }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Golongan Darah</b></label>
                                    <p class="form-control-static">{{ $registration->patient->blood_type }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>MRN</b></label>
                                    <p class="form-control-static">{{ $registration->patient->registration_number }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><b>Pembiayaan</b></label>
                                    <p class="form-control-static">{{ $registration->financing }}</p>
                                </div>
                            </div>
                        </div>

                        <hr class="hr-line">
                        <h5>Data Kesehatan</h5>

                        <div class="form-group">
                            <label><b>Riwayat Penyakit</b></label>
                            <table class="table table-bordered table-hover" id="TableDiseaseHistory">
                                <thead>
                                    <tr>
                                        <th>Nama Penyakit</th>
                                        <th width="1px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registration->patient->diseases_histories as $row)
                                    <tr>
                                        <td>{{ $row->disease_name }}</td>
                                        <td><button type="button" class="btn btn-sm btn-danger" data-id="{{ $row->id }}" id="deleteDiseaseHistory"><i class="fa fa-times"></i></button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button class="btn btn-outline btn-sm btn-primary" type="button" data-toggle="modal" data-target="#ModalDiseaseHistory"><i class=" fa fa-plus"></i> Tambah Riwayat Penyakit</button>
                        </div>

                        <hr class="hr-line">

                        <div class="form-group">
                            <label><b>Riwayat Alergi</b></label>
                            <table class="table table-bordered table-hover" id="TableAllergy">
                                <thead>
                                    <tr>
                                        <th>Nama Alergi</th>
                                        <th width="1px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registration->patient->allergies as $row)
                                    <tr>
                                        <td>{{ $row->allergy_name }}</td>
                                        <td><button type="button" class="btn btn-sm btn-danger" data-id="{{ $row->id }}" id="deleteAllergy"><i class="fa fa-times"></i></button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button class="btn btn-outline btn-sm btn-primary" type="button" data-toggle="modal" data-target="#ModalAllergy"><i class="fa fa-plus"></i> Tambah Riwayat Alergi</button>
                        </div>

                        <hr class="hr-line">

                        <div class="form-group">
                            <label><b>Keluhan Utama *</b></label>
                            <textarea name="main_complaint" id="main_complaint" rows="2" class="form-control" placeholder="Tulis disini.." required></textarea>
                            <small class="text-danger" id="main_complaint_error"></small>
                        </div>

                        <div class="form-group">
                            <label><b>Anamnesa *</b></label>
                            <textarea name="anamnesa" id="anamnesa" rows="2" class="form-control" placeholder="Tulis disini.." required></textarea>
                            <small class="text-danger" id="anamnesa_error"></small>
                        </div>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Objective</h5>
                    </div>
                    <div class="ibox-content">

                        <h5>Riwayat Konsultasi</h5>
                        <div class="form-group">
                            <button class="btn btn-outline btn-primary" type="button" data-toggle="modal" data-target="#ModalCheckupHistory"><i class="fa fa-history"></i> Lihat Riwayat Konsultasi</button>
                        </div>

                        <hr class="hr-line">

                        <div class="form-group">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanda-Tanda Vital</th>
                                        <th width="20%" class="text-center">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Suhu tubuh (celcius)</td>
                                        <td><input type="number" class="form-control form-control-sm" name="body_temperature" placeholder="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>Sistole (mmHG)</td>
                                        <td><input type="number" class="form-control form-control-sm" name="sistole" placeholder="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>Diastole (mmHG)</td>
                                        <td><input type="number" class="form-control form-control-sm" name="diastole" placeholder="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>Nadi (menit)</td>
                                        <td><input type="number" class="form-control form-control-sm" name="nadi" placeholder="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>Frekuensi Pernapasan (menit)</td>
                                        <td><input type="number" class="form-control form-control-sm" name="respiratory_frequency" placeholder="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>Tinggi badan (cm)</td>
                                        <td><input type="number" class="form-control form-control-sm" name="height" placeholder="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>Berat badan (kg)</td>
                                        <td><input type="number" class="form-control form-control-sm" name="weight" placeholder="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>Lingkar kepala (cm)</td>
                                        <td><input type="number" class="form-control form-control-sm" name="head_circumference" placeholder="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>Lingkar perut (cm)</td>
                                        <td><input type="number" class="form-control form-control-sm" name="abdominal_circumference" placeholder="0" required></td>
                                    </tr>
                                    <tr>
                                        <td>IMT</td>
                                        <td><input type="number" class="form-control form-control-sm" name="imt" placeholder="0" required></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <hr class="hr-line">
                        <div class="form-group">
                            <label><b>Kesadaran</b></label>
                            <select name="conscious" class="form-control" required>
                                <option value="" selected disabled>Pilih</option>
                                <option value="Compose Mentis">Compose Mentis</option>
                            </select>
                            <small class="text-danger" id="conscious_error"></small>
                        </div>
                        <div class="form-group">
                            <label><b>Catatan Tambahan</b></label>
                            <textarea name="notes" id="notes" rows="2" class="form-control" placeholder="Tulis disini.."></textarea>
                        </div>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Assessment</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <label><b>Diagnosis</b></label>
                            <input type="text" name="diagnosis" class="form-control" placeholder="Tulis disini.." required>
                            <small class="text-danger" id="diagnosis_error"></small>
                        </div>
                        <div class="form-group">
                            <label><b>Prognosa</b></label>
                            <select name="prognosa" class="form-control" required>
                                <option value="" selected disabled>Pilih</option>
                                <option value="Sanam (sembuh)">Sanam (sembuh)</option>
                                <option value="Bonam (baik)">Bonam (baik)</option>
                                <option value="Malam (buruk/jelek)">Malam (buruk/jelek)</option>
                            </select>
                            <small class="text-danger" id="prognosa_error"></small>
                        </div>

                        <hr class="hr-line">

                        <div class="form-group">
                            <label><b>ICD 10</b></label>
                            <table class="table table-bordered table-hover" id="TableICD10">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Penyakit</th>
                                        <th width="1px"></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <button class="btn btn-outline btn-sm btn-primary" type="button" data-toggle="modal" data-target="#ModalICD10"><i class="fa fa-plus"></i> Tambah ICD 10</button>
                        </div>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Plan</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <label><b>Layanan/Tindakan</b></label>
                            <table class="table table-bordered table-hover" id="TableService">
                                <thead>
                                    <tr>
                                        <th>Nama Layanan/Tindakan</th>
                                        <th>Jumlah</th>
                                        <th width="1px"></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <button class="btn btn-outline btn-sm btn-primary" type="button" data-toggle="modal" data-target="#ModalService"><i class="fa fa-plus"></i> Tambah Layanan/Tindakan</button>
                        </div>

                        <hr class="hr-line">

                        <div class="form-group">
                            <label><b>Obat</b></label>
                            <table class="table table-bordered table-hover" id="TableMedicine">
                                <thead>
                                    <tr>
                                        <th>Nama obat</th>
                                        <th>Dosis</th>
                                        <th>Durasi</th>
                                        <th>Satuan</th>
                                        <th>Jumlah</th>
                                        <th width="1px"></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <button class="btn btn-outline btn-sm btn-primary" type="button" data-toggle="modal" data-target="#ModalMedicine"><i class="fa fa-plus"></i> Tambah Obat</button>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <div class="col-sm-12 col-sm-offset-2">
                                <button class="btn btn-primary float-right" type="submit"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>

<div class="modal fade" id="ModalCheckupHistory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title">Riwayat Konsultasi Pasien</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" width="100%" id="TableCheckupHistory">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Dokter</th>
                                    <th>Diagnosa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checkup_histories as $row)
                                <tr>
                                    <td>{{ date('d F Y', strtotime($row->checkup->created_at)) }}</td>
                                    <td>
                                        <b>{{ $row->user->name }}</b> <br>
                                        <small>{{ $row->poli->name }}</small>
                                    </td>
                                    <td>
                                        <b>{{ $row->checkup->main_complaint }}</b> <br>
                                        <small>
                                            @foreach($row->checkup->checkup_icd10s as $icd10)
                                            {{ $icd10->icd10->code }}, {{ $icd10->icd10->name }} <br>
                                            @endforeach
                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-rectangle-o mr-1"></i>Tutup [Esc]</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalDiseaseHistory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="FormDiseaseHistory" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title">Tambah Riwayat Penyakit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="margin-top: -10px;">
                        <label class="col-form-label">Nama Penyakit</label>
                        <input type="text" class="form-control" id="disease_name" name="disease_name" tabindex="1" required maxlength="200">
                        <small class="text-danger" id="disease_name_error"></small>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-rectangle-o mr-1"></i>Tutup [Esc]</button>
                    <button type="submit" class="btn btn-primary ladda-button ladda-button-demo" data-style="zoom-in" id="submit" tabindex="5"><i class="fa fa-check-square mr-1"></i>Tambah [Enter]</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalAllergy" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="FormAllergy" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title">Tambah Riwayat Alergi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="margin-top: -10px;">
                        <label class="col-form-label">Nama Alergi</label>
                        <input type="text" class="form-control" id="allergy_name" name="allergy_name" tabindex="1" required maxlength="200">
                        <small class="text-danger" id="allergy_name_error"></small>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-rectangle-o mr-1"></i>Tutup [Esc]</button>
                    <button type="submit" class="btn btn-primary ladda-button ladda-button-demo" data-style="zoom-in" id="submit" tabindex="5"><i class="fa fa-check-square mr-1"></i>Tambah [Enter]</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalICD10" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="FormAllergy" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title">List ICD 10</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover TableICD10" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Penyakit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-rectangle-o mr-1"></i>Tutup [Esc]</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalService" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="FormService" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title">Tambah Layanan/Tindakan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Layanan ({{ $registration->poli->name }})</label>
                        <select name="name" id="name" class="form-control" required>
                            @foreach($services as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="name_error"></small>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" class="form-control" placeholder="0" value="1" name="qty" id="qty" required>
                        <small class="text-danger" id="qty_error"></small>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-rectangle-o mr-1"></i>Tutup [Esc]</button>
                    <button type="submit" class="btn btn-primary ladda-button ladda-button-demo" data-style="zoom-in" id="submit" tabindex="5"><i class="fa fa-check-square mr-1"></i>Tambah [Enter]</button>

                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalMedicine" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="FormMedicine">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title">Tambah Obat</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Cari Obat</label>
                        <select class="form-control searchMedicine" name="name" id="name" required></select>
                        <small class="text-danger" id="name_error"></small>
                    </div>
                    <div class="form-group">
                        <label>Dosis</label>
                        <input type="text" class="form-control" placeholder="Contoh: 3 x 1" name="dosis" id="dosis" required>
                        <small class="text-danger" id="dosis_error"></small>
                    </div>
                    <div class="form-group">
                        <label>Durasi</label>
                        <input type="text" class="form-control" placeholder="Contoh: x Hari" name="duration" id="duration" required>
                        <small class="text-danger" id="duration_error"></small>
                    </div>
                    <div class="form-group">
                        <label>Satuan</label>
                        <select class="form-control" name="unit" id="unit" required>
                            <option value="Tablet">Tablet</option>
                        </select>
                        <small class="text-danger" id="unit_error"></small>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" class="form-control" placeholder="0" value="1" name="qty" id="qty" required>
                        <small class="text-danger" id="qty_error"></small>
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-rectangle-o mr-1"></i>Tutup [Esc]</button>
                    <button type="submit" class="btn btn-primary ladda-button ladda-button-demo" data-style="zoom-in" id="submit" tabindex="5"><i class="fa fa-check-square mr-1"></i>Tambah [Enter]</button>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('build/assets') }}/js/plugins/select2/select2.full.min.js"></script>
<script>
    $(document).ready(function() {

        function sweetalert(title, msg, type, timer = 60000, confirmButton = true) {
            swal({
                title: title,
                text: msg,
                type: type,
                timer: timer,
                showConfirmButton: confirmButton
            });
        }

        $("#formCheckup").validate({
            messages: {
                main_complaint: "Keluhan Utama tidak boleh kosong",
                anamnesa: "Anamnesa tidak boleh kosong",
                conscious: "Kesadaran tidak boleh kosong",
                diagnosa: "Diagnosis tidak boleh kosong",
                prognosa: "Prognosa tidak boleh kosong",
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

        $('#TableCheckupHistory').DataTable({
            pageLength: 5
        })

        //TEMPLATES 
        let serverSideTableICD10 = $('.TableICD10').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [1, 'asc']
            ],
            ajax: {
                url: "{{ route('checkup.icd10') }}",
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: false,
            }, {
                data: 'code',
                name: 'code'
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'action',
                name: 'action',
                searchable: false,
                orderable: false,
            }],
            search: {
                "regex": true
            }
        });

        // DISEASES HISTORY
        $("#FormDiseaseHistory").validate({
            messages: {
                disease_name: "Nama Penyakit tidak boleh kosong",
            },
            success: function(messages) {
                $(messages).remove();
            },
            errorPlacement: function(error, element) {
                let name = element.attr("name");
                $("#" + name + "_error").text(error.text());
            },
            submitHandler: function(form) {
                $.ajax({
                    url: "{{ route('checkup.patient.disease.store') }}",
                    type: "POST",
                    data: $(form).serialize() + `&patient_id={{ $registration->patient_id }}`,
                    dataType: 'JSON',
                    success: function(res) {
                        $('#ModalDiseaseHistory').modal('hide')
                        $('#TableDiseaseHistory').find('tbody').append(
                            `<tr>
                                <td>${res.data.disease_name}</td>
                                <td><button type="button" class="btn btn-sm btn-danger" data-id="${res.data.id}" id="deleteDiseaseHistory"><i class="fa fa-times"></i></button></td>
                            </tr>`
                        )
                        sweetalert('Berhasil', 'Data berhasil ditambahkan', null, 500, false)
                    },
                    error: function(res) {
                        sweetalert('Gagal', 'Terjadi kesalah', 'error')
                    }
                })
            }
        });

        $(document).on('click', '#deleteDiseaseHistory', function(e) {
            let id = $(this).data('id')
            let table = $(this).closest('tr')
            let name = table.find('td:eq(0)').text()
            swal({
                title: "Hapus?",
                text: `Data "${name}" akan terhapus!`,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, hapus!",
                closeOnConfirm: false
            }, function() {
                swal.close()
                $.ajax({
                    url: "{{ route('checkup.patient.disease.store') }}/" + id,
                    type: "DELETE",
                    dataType: 'json',
                    success: function(response) {
                        table.closest('tr').remove()
                        sweetalert('Berhasil', `Data berhasil dihapus.`, null, 500, false)
                    },
                    error: function(response) {
                        sweetalert('Tidak terhapus!', 'Terjadi kesalahan saat menghapus data.', 'error')
                    }
                })
            });
        })

        // ALLERGY HISTORY
        $("#FormAllergy").validate({
            messages: {
                allergy_name: "Nama Alergi tidak boleh kosong",
            },
            success: function(messages) {
                $(messages).remove();
            },
            errorPlacement: function(error, element) {
                let name = element.attr("name");
                $("#" + name + "_error").text(error.text());
            },
            submitHandler: function(form) {
                $.ajax({
                    url: "{{ route('checkup.patient.allergy.store') }}",
                    type: "POST",
                    data: $(form).serialize() + `&patient_id={{ $registration->patient_id }}`,
                    dataType: 'JSON',
                    success: function(res) {
                        $('#ModalAllergy').modal('hide')
                        $('#TableAllergy').find('tbody').append(
                            `<tr>
                                <td>${res.data.allergy_name}</td>
                                <td><button type="button" class="btn btn-sm btn-danger" data-id="${res.data.id}" id="deleteAllergy"><i class="fa fa-times"></i></button></td>
                            </tr>`
                        )
                        sweetalert('Berhasil', 'Data berhasil ditambahkan', null, 500, false)
                    },
                    error: function(res) {
                        sweetalert('Gagal', 'Terjadi kesalah', 'error')
                    }
                })
            }
        });

        $(document).on('click', '#deleteAllergy', function(e) {
            let id = $(this).data('id')
            let table = $(this).closest('tr')
            let name = table.find('td:eq(0)').text()
            swal({
                title: "Hapus?",
                text: `Data "${name}" akan terhapus!`,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, hapus!",
                closeOnConfirm: false
            }, function() {
                swal.close()
                $.ajax({
                    url: "{{ route('checkup.patient.allergy.store') }}/" + id,
                    type: "DELETE",
                    dataType: 'json',
                    success: function(response) {
                        table.closest('tr').remove()
                        sweetalert('Berhasil', `Data berhasil dihapus.`, null, 500, false)
                    },
                    error: function(response) {
                        sweetalert('Tidak terhapus!', 'Terjadi kesalahan saat menghapus data.', 'error')
                    }
                })
            });
        })

        // ICD 10
        $(document).on('click', '#selectICD10', function(e) {
            let id = $(this).data('id')
            let row = $(this).closest('tr')
            let code = row.find('td:eq(1)').text()
            let name = row.find('td:eq(2)').text()
            let table = $('#TableICD10')

            if (table.find('tr[id=' + code + ']').length > 0) {
                sweetalert('Sudah ada!', 'Data ICD 10 sudah ada dalam table.', 'warning')
            } else {
                table.find('tbody').append(
                    `<tr id="${code}">
                        <td>
                            <input type="hidden" value="${id}" name="icd10_id[]">
                            ${code}
                        </td>
                        <td>${name}</td>
                        <td><button type="button" class="btn btn-sm btn-danger" id="deleteRow"><i class="fa fa-times"></i></button></td>
                    </tr>`
                )
            }
        })

        $(document).on('click', '#deleteRow', function(e) {
            $(this).closest('tr').remove()
        })

        // SERVICE
        $("#FormService").validate({
            messages: {
                name: "Nama Layanan tidak boleh kosong",
                qty: "Jumalh tidak boleh kosong",
            },
            success: function(messages) {
                $(messages).remove();
            },
            errorPlacement: function(error, element) {
                let name = element.attr("name");
                $("#" + name + "_error").text(error.text());
            },
            submitHandler: function(form) {
                let id = $(form).find('#name').val()
                let name = $(form).find('#name').text()
                let qty = $(form).find('#qty').val()

                $('#ModalService').modal('hide')
                $('#TableService').find('tbody').append(
                    `<tr>
                        <td>
                            <input type="hidden" name="service_id[]" value="${id}">
                            <input type="hidden" name="service_qty[]" value="${qty}">
                            ${name}
                        </td>
                        <td>${qty}</td>
                        <td><button type="button" class="btn btn-sm btn-danger" id="deleteRow"><i class="fa fa-times"></i></button></td>
                    </tr>`
                )
                sweetalert('Berhasil', 'Data berhasil ditambahkan', null, 500, false)
            }
        });

        // MEDICINE
        $(".searchMedicine").select2({
            dropdownParent: $('#ModalMedicine'),
            placeholder: "Cari Kode/Nama Obat",
            allowClear: true,
            minimumInputLength: 2,
            ajax: {
                url: "{{ route('checkup.medicine') }}",
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
                            'text': `${data.name} (${data.code})`,
                        }
                    })
                    return {
                        results: result
                    }
                },
            }
        })

        $("#FormMedicine").validate({
            messages: {
                name: "Obat tidak boleh kosong",
                dosis: "Dosis tidak boleh kosong",
                duration: "Durasi tidak boleh kosong",
                unit: "Satuan tidak boleh kosong",
                qty: "Jumalh tidak boleh kosong",
            },
            success: function(messages) {
                $(messages).remove();
            },
            errorPlacement: function(error, element) {
                let name = element.attr("name");
                $("#" + name + "_error").text(error.text());
            },
            submitHandler: function(form) {
                let id = $(form).find('#name').val()
                let name = $(form).find('#name').text()
                let dosis = $(form).find('#dosis').val()
                let duration = $(form).find('#duration').val()
                let unit = $(form).find('#unit').val()
                let qty = $(form).find('#qty').val()
                let notes = $(form).find('#notes').val()

                $('#ModalMedicine').modal('hide')
                $('#TableMedicine').find('tbody').append(
                    `<tr>
                        <td>
                            <input type="hidden" name="medicine_id[]" value="${id}">
                            <input type="hidden" name="medicine_dosis[]" value="${dosis}">
                            <input type="hidden" name="medicine_duration[]" value="${duration}">
                            <input type="hidden" name="medicine_unit[]" value="${unit}">
                            <input type="hidden" name="medicine_qty[]" value="${qty}">
                            <input type="hidden" name="medicine_notes[]" value="${notes}">
                            <b>${name}</b> <br> <small>${notes}</small>
                        </td>
                        <td>${dosis}</td>
                        <td>${duration}</td>
                        <td>${qty}</td>
                        <td>${notes}</td>
                        <td><button type="button" class="btn btn-sm btn-danger" id="deleteRow"><i class="fa fa-times"></i></button></td>
                    </tr>`
                )
                sweetalert('Berhasil', 'Data berhasil ditambahkan', null, 500, false)
            }
        });
    })
</script>
@endpush