@extends('layouts.master')

@push('css')
<link href="{{ asset('build/assets') }}/css/plugins/select2/select2.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Detail Rekam Medis</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <span><a href="{{ route('checkup.index') }}"><u>Rekam Medis</u></a></span>
            </li>
            <li class="breadcrumb-item active">
                <strong>Detail Rekam Medis</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-7">

            <div class="ibox">
                <div class="ibox-title">
                    <h5>Subjective - <u>{{ $checkup->registration->queue_number }}</u></h5>
                </div>
                <div class="ibox-content">
                    <h5>Jadwal</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Dokter</b></label>
                                <p class="form-control-static">{{ $checkup->registration->user->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Poli</b></label>
                                <p class="form-control-static">{{ $checkup->registration->poli->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Tipe Kunjungan</b></label>
                                <p class="form-control-static">{{ $checkup->registration->type_visit }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Waktu Konsul</b></label>
                                <p class="form-control-static">{{ $checkup->registration->consultation_date }} - {{ $checkup->registration->doctor_schedule->start_time }}~{{ $checkup->registration->doctor_schedule->end_time }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="hr-line">
                    <h5>Data Umum</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Pasien</b></label>
                                <p class="form-control-static">{{ $checkup->registration->patient->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Tanggal Lahir</b></label>
                                <p class="form-control-static">{{ $checkup->registration->patient->date_of_birth }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Jenis Kelamin</b></label>
                                <p class="form-control-static">{{ $checkup->registration->patient->gender }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Golongan Darah</b></label>
                                <p class="form-control-static">{{ $checkup->registration->patient->blood_type }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>MRN</b></label>
                                <p class="form-control-static">{{ $checkup->registration->patient->registration_number }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Pembiayaan</b></label>
                                <p class="form-control-static">{{ $checkup->registration->financing }}</p>
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checkup->registration->patient->diseases_histories as $row)
                                <tr>
                                    <td>{{ $row->disease_name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr class="hr-line">

                    <div class="form-group">
                        <label><b>Riwayat Alergi</b></label>
                        <table class="table table-bordered table-hover" id="TableAllergy">
                            <thead>
                                <tr>
                                    <th>Nama Alergi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checkup->registration->patient->allergies as $row)
                                <tr>
                                    <td>{{ $row->allergy_name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr class="hr-line">

                    <div class="form-group">
                        <label><b>Keluhan Utama</b></label>
                        <textarea readonly name="main_complaint" id="main_complaint" rows="2" class="form-control" placeholder="Tulis disini..">{{ $checkup->main_complaint }}</textarea>
                    </div>

                    <div class="form-group">
                        <label><b>Anamnesa</b></label>
                        <textarea readonly name="anamnesa" id="anamnesa" rows="2" class="form-control" placeholder="Tulis disini..">{{ $checkup->anamnesa }}</textarea>
                    </div>
                </div>
            </div>

            <div class="ibox">
                <div class="ibox-title">
                    <h5>Objective</h5>
                </div>
                <div class="ibox-content">
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
                                    <td><input type="number" readonly class="form-control form-control-sm" name="body_temperature" value="{{ $checkup->body_temperature }}" placeholder="0" step="0.00"></td>
                                </tr>
                                <tr>
                                    <td>Sistole (mmHG)</td>
                                    <td><input type="number" readonly class="form-control form-control-sm" name="sistole" value="{{ $checkup->sistole }}" placeholder="0" step="0.00"></td>
                                </tr>
                                <tr>
                                    <td>Diastole (mmHG)</td>
                                    <td><input type="number" readonly class="form-control form-control-sm" name="diastole" value="{{ $checkup->diastole }}" placeholder="0" step="0.00"></td>
                                </tr>
                                <tr>
                                    <td>Nadi (menit)</td>
                                    <td><input type="number" readonly class="form-control form-control-sm" name="nadi" value="{{ $checkup->nadi }}" placeholder="0" step="0.00"></td>
                                </tr>
                                <tr>
                                    <td>Frekuensi Pernapasan (menit)</td>
                                    <td><input type="number" readonly class="form-control form-control-sm" name="respiratory_frequency" value="{{ $checkup->respiratory_frequency }}" placeholder="0" step="0.00"></td>
                                </tr>
                                <tr>
                                    <td>Tinggi badan (cm)</td>
                                    <td><input type="number" readonly class="form-control form-control-sm" name="height" value="{{ $checkup->height }}" placeholder="0" step="0.00"></td>
                                </tr>
                                <tr>
                                    <td>Berat badan (kg)</td>
                                    <td><input type="number" readonly class="form-control form-control-sm" name="weight" value="{{ $checkup->weight }}" placeholder="0" step="0.00"></td>
                                </tr>
                                <tr>
                                    <td>Lingkar kepala (cm)</td>
                                    <td><input type="number" readonly class="form-control form-control-sm" name="head_circumference" value="{{ $checkup->head_circumference }}" placeholder="0" step="0.00"></td>
                                </tr>
                                <tr>
                                    <td>Lingkar perut (cm)</td>
                                    <td><input type="number" readonly class="form-control form-control-sm" name="abdominal_circumference" value="{{ $checkup->abdominal_circumference }}" placeholder="0" step="0.00"></td>
                                </tr>
                                <tr>
                                    <td>IMT</td>
                                    <td><input type="number" readonly class="form-control form-control-sm" name="imt" value="{{ $checkup->imt }}" placeholder="0" step="0.00"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr class="hr-line">
                    <div class="form-group">
                        <label><b>Kesadaran</b></label>
                        <input type="text" readonly name="conscious" class="form-control" value="{{ $checkup->conscious }}">
                    </div>
                    <div class="form-group">
                        <label><b>Catatan Tambahan</b></label>
                        <textarea readonly name="notes" id="notes" rows="2" class="form-control" placeholder="Tulis disini..">{{ $checkup->notes }}</textarea>
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
                        <input type="text" readonly name="diagnosis" class="form-control" value="{{ $checkup->diagnosis }}">
                    </div>
                    <div class="form-group">
                        <label><b>Prognosa</b></label>
                        <input type="text" readonly name="prognosa" class="form-control" value="{{ $checkup->prognosa }}">
                    </div>

                    <hr class="hr-line">

                    <div class="form-group">
                        <label><b>ICD 10</b></label>
                        <table class="table table-bordered table-hover" id="TableICD10">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Penyakit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checkup->checkup_icd10s as $row)
                                <tr>
                                    <td>{{ $row->icd10->code }}</td>
                                    <td>{{ $row->icd10->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checkup->checkup_services as $row)
                                <tr>
                                    <td>{{ $row->service->name }}</td>
                                    <td>{{ $row->qty }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checkup->checkup_medicines as $row)
                                <tr>
                                    <td>
                                        <b>{{ $row->medicine->name }}</b>
                                        <small>{{ $row->notes }}</small>
                                    </td>
                                    <td>{{ $row->dosis }}</td>
                                    <td>{{ $row->duration }}</td>
                                    <td>{{ $row->unit }}</td>
                                    <td>{{ $row->qty }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <div class="col-sm-12 col-sm-offset-2">
                            <a class="btn btn-default float-right" href="{{ route('checkup.index') }}"><i class="fa fa-arrow-left"></i> Kembali</a>
                        </div>
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

    })
</script>
@endpush