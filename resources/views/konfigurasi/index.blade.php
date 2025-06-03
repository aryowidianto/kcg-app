@extends('adminlte::page')

@section('title', 'Konfigurasi')

@section('content_header')
    <h1>Konfigurasi Aplikasi</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><i class="fas fa-cogs"></i> Pengaturan Umum</h3>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="info-box bg-light">
                        <span class="info-box-icon bg-info"><i class="fas fa-bolt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tarif PLN</span>
                            <span class="info-box-number">
                                {{-- Ganti dengan value dari database jika sudah ada --}}
                                <strong>Rp {{ number_format( session('tarif_pln', 1500), 0, ',', '.') }} / kWh</strong>
                            </span>
                            <a href="#" class="btn btn-sm btn-outline-primary mt-2" data-toggle="modal" data-target="#modalTarifPLN">
                                <i class="fas fa-edit"></i> Ubah Tarif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Tarif PLN -->
    <div class="modal fade" id="modalTarifPLN" tabindex="-1" role="dialog" aria-labelledby="modalTarifPLNLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('konfigurasi.updateTarifPLN') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title" id="modalTarifPLNLabel">Ubah Tarif PLN</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tarif_pln">Tarif PLN (Rp/kWh)</label>
                            <input type="number" class="form-control" name="tarif_pln" id="tarif_pln" value="{{ session('tarif_pln', 1500) }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop