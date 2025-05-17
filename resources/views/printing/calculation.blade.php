@extends('adminlte::page')

@section('title', 'Kalkulasi Cetak Offset')

@section('content_header')
    <h1>Kalkulasi Cetak Offset</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">

        @if(session('calculation_result'))
            <div class="alert alert-info">
                <h4><i class="icon fas fa-info-circle"></i> Hasil Kalkulasi Kertas</h4>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Jenis Kertas:</strong> {{ session('calculation_result')['kertas']->nama }}</p>
                        <p><strong>Ukuran Plano:</strong> {{ session('calculation_result')['kertas']->panjang }}x{{ session('calculation_result')['kertas']->lebar }} mm</p>
                        <p><strong>Harga per Lembar:</strong> Rp {{ number_format(session('calculation_result')['kertas']->harga_per_lembar, 0, ',', '.') }}</p>
                        <p><strong>Potongan Dibutuhkan:</strong> {{ number_format(session('calculation_result')['lembar_dibutuhkan'], 0, ',', '.') }} lembar</p>
                        <p><strong>Plano Dibutuhkan:</strong> {{ session('calculation_result')['plano_dibutuhkan'] }} lembar</p>
                        <p><strong>Luas Area Cetak:</strong> {{ number_format(session('calculation_result')['luas_area_cetak'], 0, ',', '.') }} mm<sup>2</sup></p>
                        <p><strong>Total Harga Kertas:</strong> Rp {{ number_format(session('calculation_result')['total_harga_kertas'], 0, ',', '.') }}</p>
                        <p><strong>Jumlah Potongan per Plano:</strong> {{ session('calculation_result')['jumlah_potongan'] }}</p>
                    </div>
                </div>
                <hr>
                <h5>Detail Input</h5>
                <ul>
                    <li>Oplag: {{ session('calculation_result')['input']['oplag'] }}</li>
                    <li>Insheet: {{ session('calculation_result')['input']['insheet'] }}%</li>
                    <li>Warna Proses:
                        @php
                            $warnaProsesIds = session('calculation_result.input.warna_proses') ?? [];
                            $namaWarnaProses = $tintasProses->whereIn('id', $warnaProsesIds)->pluck('nama')->toArray();
                        @endphp
                        {{ implode(', ', $namaWarnaProses) }}
                    </li>
                    <li>Warna Khusus:
                        @php
                            $warnaKhususIds = session('calculation_result.input.warna_khusus') ?? [];
                            $namaWarnaKhusus = $tintasKhusus->whereIn('id', $warnaKhususIds)->pluck('nama')->toArray();
                        @endphp
                        {{ implode(', ', $namaWarnaKhusus) }}
                    </li>
                </ul>
            </div>
        @endif

            <form action="{{ route('printing.calculate') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="oplag">Oplag</label>
                            <input type="number" class="form-control" id="oplag" name="oplag"
                                   value="{{ old('oplag', session('calculation_result.input.oplag') ?? '') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="insheet">Insheet (%)</label>
                            <input type="number" class="form-control" id="insheet" name="insheet"
                                   value="{{ old('insheet', session('calculation_result.input.insheet') ?? '0') }}" min="0" max="100" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="jenis_kertas">Jenis Kertas</label>
                    <select class="form-control select2" id="jenis_kertas" name="jenis_kertas" required>
                        @foreach($kertasPlanos as $kertas)
                            <option value="{{ $kertas->id }}"
                                {{ old('jenis_kertas', session('calculation_result.input.jenis_kertas') ?? '') == $kertas->id ? 'selected' : '' }}>
                                {{ $kertas->nama }} ({{ $kertas->panjang }}x{{ $kertas->lebar }}mm)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ukuran Potong (mm)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Panjang"
                                       name="cut_width" value="{{ old('cut_width', session('calculation_result.input.cut_width') ?? '') }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">x</span>
                                </div>
                                <input type="number" class="form-control" placeholder="Lebar"
                                       name="cut_height" value="{{ old('cut_height', session('calculation_result.input.cut_height') ?? '') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ukuran Jadi (mm)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Panjang"
                                       name="panjang_jadi" value="{{ old('panjang_jadi', session('calculation_result.input.panjang_jadi') ?? '') }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">x</span>
                                </div>
                                <input type="number" class="form-control" placeholder="Lebar"
                                       name="lebar_jadi" value="{{ old('lebar_jadi', session('calculation_result.input.lebar_jadi') ?? '') }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mesin_offset">Mesin Offset</label>
                            <select class="form-control" id="mesin_offset" name="mesin_offset" required>
                                @foreach($mesinOffsets as $mesin)
                                    <option value="{{ $mesin }}"
                                        {{ old('mesin_offset', session('calculation_result.input.mesin_offset') ?? '') == $mesin ? 'selected' : '' }}>
                                        {{ $mesin->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="warna_proses">Warna Proses</label>
                            <select class="form-control select2" id="warna_proses" name="warna_proses[]" multiple="multiple" required>
                                @foreach($tintasProses as $tinta)
                                    <option value="{{ $tinta->id }}"
                                        {{ (collect(old('warna_proses', session('calculation_result.input.warna_proses') ?? []))->contains($tinta->id)) ? 'selected' : '' }}>
                                        {{ $tinta->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Pilih maksimal 4 warna proses.</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="warna_khusus">Warna Khusus</label>
                    <select class="form-control select2" id="warna_khusus" name="warna_khusus[]" multiple="multiple" required>
                        @foreach($tintasKhusus as $tinta)
                            <option value="{{ $tinta->id }}"
                                {{ (collect(old('warna_khusus', session('calculation_result.input.warna_khusus') ?? []))->contains($tinta->id)) ? 'selected' : '' }}>
                                {{ $tinta->nama }}
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted"></small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-calculator"></i> Hitung Kalkulasi
                </button>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Inisialisasi select2
            $('.select2').select2({
                maximumSelectionLength: 4 // Batas maksimal 4 warna
            });

            // Validasi form
            $('form').validate({
                rules: {
                    oplag: {
                        required: true,
                        min: 1
                    },
                    insheet: {
                        required: true,
                        min: 0,
                        max: 100
                    }
                },
                messages: {
                    oplag: {
                        required: "Oplag harus diisi",
                        min: "Oplag minimal 1"
                    },
                    insheet: {
                        required: "Insheet harus diisi",
                        min: "Insheet minimal 0%",
                        max: "Insheet maksimal 100%"
                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@stop