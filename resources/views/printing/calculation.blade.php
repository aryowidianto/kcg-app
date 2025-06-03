@extends('adminlte::page')

@section('title', 'Kalkulasi Cetak Offset')

@section('content_header')
    <h1>Kalkulasi Cetak Offset</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">

            @if (session('calculation_result'))
                <div class="alert alert-info">
                    <h4><i class="icon fas fa-info-circle"></i> Hasil Kalkulasi</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-paperclip"></i> Kertas</h5>
                            <p><strong>Jenis Kertas:</strong> {{ session('calculation_result')['kertas']->nama }}</p>
                            <p><strong>Gramasi:</strong> {{ session('calculation_result.kertas')->gramasi }} g/m²</p>
                            <p><strong>Ukuran Potong:</strong>
                                {{ session('calculation_result')['input']['cut_width'] }}x{{ session('calculation_result')['input']['cut_height'] }}
                                mm</p>
                            <p><strong>Ukuran Plano:</strong>
                                {{ session('calculation_result')['kertas']->panjang }}x{{ session('calculation_result')['kertas']->lebar }}
                                mm</p>
                            <p><strong>Jumlah Potongan per Plano:</strong>
                                {{ session('calculation_result')['jumlah_potongan'] }}</p>
                            <p><strong>Potongan Dibutuhkan:</strong>
                                {{ number_format(session('calculation_result')['lembar_dibutuhkan'], 0, ',', '.') }} lembar
                            </p>
                            <p><strong>Plano Dibutuhkan:</strong> {{ session('calculation_result')['plano_dibutuhkan'] }}
                                lembar</p>
                            <p><strong>Total Harga Kertas:</strong> Rp
                                {{ number_format(session('calculation_result')['total_harga_kertas'], 0, ',', '.') }}</p>

                        </div>

                        <!-- Kolom Tinta -->
                        <div class="col-md-6">

                            <h5><i class="fas fa-fill-drip"></i> Tinta</h5>
                            <p><strong>Raster:</strong> {{ session('calculation_result')['raster'] }}%</p>
                            <p><strong>Luas Area Cetak:</strong>
                                {{ number_format(session('calculation_result')['luas_area_cetak'], 1, ',', '.') }} m²</p>
                            @foreach (session('calculation_result')['tinta_proses_details'] as $tintaDetail)
                                <p><strong>{{ $tintaDetail['nama'] }}:</strong>
                                    {{ number_format($tintaDetail['lembar_per_kg'], 1, ',', '.') }} Lbr/Kg,
                                    Butuh Tinta: {{ number_format($tintaDetail['kebutuhan_kg'], 1, ',', '.') }} Kg
                                </p>
                            @endforeach
                            @foreach (session('calculation_result')['tinta_khusus_details'] as $tintaDetail)
                                <p><strong>{{ $tintaDetail['nama'] }}:</strong>
                                    {{ number_format($tintaDetail['lembar_per_kg'], 1, ',', '.') }} Lbr/Kg,
                                    Butuh tinta: {{ number_format($tintaDetail['kebutuhan_kg'], 1, ',', '.') }} Kg
                                </p>
                            @endforeach
                            <p><strong>Biaya Tinta Proses:</strong> Rp
                                {{ number_format(session('calculation_result')['biaya_tinta_proses'], 0, ',', '.') }}</p>
                            <p><strong>Biaya Tinta Khusus:</strong> Rp
                                {{ number_format(session('calculation_result')['biaya_tinta_khusus'], 0, ',', '.') }}</p>
                            <p><strong>Total Biaya Tinta:</strong> <span class="text-danger">Rp
                                    {{ number_format(session('calculation_result')['total_biaya_tinta'], 0, ',', '.') }}</span>
                            </p>
                            <br>
                            {{-- HPP Section --}}
                            @if (isset(session('calculation_result')['hpp']))
                                <div class="mt-3">
                                    <h5><i class="fas fa-money-bill-wave"></i> HPP (Harga Pokok Produksi)</h5>
                                    @foreach (session('calculation_result')['hpp']['biaya_tinta_proses'] as $key => $biayaTinta)
                                        <p>
                                            <b> Tinta {{session('calculation_result')['tinta_proses_details'][$key]['nama']}}:</b> Rp {{ number_format($biayaTinta, 1, ',', '.') }}
                                        </p>
                                    @endforeach
                                    @foreach (session('calculation_result')['hpp']['biaya_tinta_khusus'] as $key => $biayaTinta)
                                        <p>
                                            <b>Tinta {{$key}}:</b> Rp {{ number_format($biayaTinta, 1, ',', '.') }}
                                        </p>
                                    @endforeach
                                    <p><strong>Listrik:</strong> Rp
                                        {{ number_format(session('calculation_result')['hpp']['biaya_listrik'], 0, ',', '.') }}
                                    </p>
                                    <p><strong>Gaji:</strong> Rp
                                        {{ number_format(session('calculation_result')['hpp']['biaya_gaji'], 0, ',', '.') }}
                                    </p>
                                    <p><strong>Subtotal:</strong> Rp
                                        {{ number_format(session('calculation_result')['hpp']['subtotal'], 0, ',', '.') }}
                                    </p>
                                    <p><strong>Operational ({{session('calculation_result')['input']['operational']}}%):</strong> Rp
                                        {{ number_format(session('calculation_result')['hpp']['operational'], 0, ',', '.') }}
                                    </p>
                                    <p><strong>Total HPP: <span class="text-danger">Rp
                                            {{ number_format(session('calculation_result')['hpp']['hpp'], 0, ',', '.') }}</span>
                                    </strong></p>
                                </div>
                            @endif

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
                                $namaWarnaProses = $tintasProses
                                    ->whereIn('id', $warnaProsesIds)
                                    ->pluck('nama')
                                    ->toArray();
                            @endphp
                            {{ implode(', ', $namaWarnaProses) }}
                        </li>
                        <li>Warna Khusus:
                            @php
                                $warnaKhususIds = session('calculation_result.input.warna_khusus') ?? [];
                                $namaWarnaKhusus = $tintasKhusus
                                    ->whereIn('id', $warnaKhususIds)
                                    ->pluck('nama')
                                    ->toArray();
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
                                value="{{ old('insheet', session('calculation_result.input.insheet') ?? '0') }}"
                                min="0" max="100" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="jenis_kertas">Jenis Kertas</label>
                    <select class="form-control select2" id="jenis_kertas" name="jenis_kertas" required>
                        @foreach ($kertasPlanos as $kertas)
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
                                <input type="number" class="form-control" placeholder="Panjang" name="cut_width"
                                    value="{{ old('cut_width', session('calculation_result.input.cut_width') ?? '') }}"
                                    required>
                                <div class="input-group-append">
                                    <span class="input-group-text">x</span>
                                </div>
                                <input type="number" class="form-control" placeholder="Lebar" name="cut_height"
                                    value="{{ old('cut_height', session('calculation_result.input.cut_height') ?? '') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ukuran Jadi (mm)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Panjang" name="panjang_jadi"
                                    value="{{ old('panjang_jadi', session('calculation_result.input.panjang_jadi') ?? '') }}"
                                    required>
                                <div class="input-group-append">
                                    <span class="input-group-text">x</span>
                                </div>
                                <input type="number" class="form-control" placeholder="Lebar" name="lebar_jadi"
                                    value="{{ old('lebar_jadi', session('calculation_result.input.lebar_jadi') ?? '') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mesin_offset">Mesin Offset</label>
                            <select class="form-control" id="mesin_offset" name="mesin_offset" required>
                                @foreach ($mesinOffsets as $mesin)
                                    <option value="{{ $mesin->id }}"
                                        {{ old('mesin_offset', session('calculation_result.input.mesin_offset') ?? '') == $mesin ? 'selected' : '' }}>
                                        {{ $mesin->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="acuan_cetak">Acuan Cetak</label>
                            <select class="form-control" id="acuan_cetak" name="acuan_cetak" required>
                                <option value="ctcp"
                                    {{ old('acuan_cetak', session('calculation_result.input.acuan_cetak') ?? '') == 'ctcp' ? 'selected' : '' }}>
                                    CTCP</option>
                                <option value="plate"
                                    {{ old('acuan_cetak', session('calculation_result.input.acuan_cetak') ?? '') == 'plate' ? 'selected' : '' }}>
                                    Plate</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="warna_proses">Warna Proses</label>
                            <select class="form-control select2" id="warna_proses" name="warna_proses[]" multiple="multiple"
                                required>
                                @foreach ($tintasProses as $tinta)
                                    <option value="{{ $tinta->id }}"
                                        {{ collect(old('warna_proses', session('calculation_result.input.warna_proses') ?? []))->contains($tinta->id) ? 'selected' : '' }}>
                                        {{ $tinta->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Pilih maksimal 4 warna proses.</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="warna_khusus">Warna Khusus</label>
                            <select class="form-control select2" id="warna_khusus" name="warna_khusus[]"
                                multiple="multiple" required>
                                @foreach ($tintasKhusus as $tinta)
                                    <option value="{{ $tinta->id }}"
                                        {{ collect(old('warna_khusus', session('calculation_result.input.warna_khusus') ?? []))->contains($tinta->id) ? 'selected' : '' }}>
                                        {{ $tinta->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted"></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Raster (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Raster" name="raster"
                                    value="{{ old('raster', session('calculation_result.input.raster') ?? '') }}"
                                    required>
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Operational (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Operational" name="operational"
                                    value="{{ old('operational', session('calculation_result.input.operational') ?? '') }}"
                                    required>
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>



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
                    insheet: {
                        required: "Insheet harus diisi",
                        min: "Insheet minimal 0%",
                        max: "Insheet maksimal 100%"
                    },
                    raster: {
                        required: "Raster harus diisi",
                        min: "Raster minimal 10"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
        // Auto-calculate gramasi saat pilih kertas
        $('#jenis_kertas').change(function() {
            const kertasId = $(this).val();
            if (kertasId) {
                $.get(`/api/kertas/${kertasId}`, function(data) {
                    $('#gramasi_display').text(`${data.gramasi} g/m² (${data.jenis_kertas})`);
                });
            }
        });
    </script>
@stop
