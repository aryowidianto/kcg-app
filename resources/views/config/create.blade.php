@extends('adminlte::page')

@section('title', 'Tambah Config')

@section('content_header')
    <h1>Tambah Config</h1>
@endsection

@section('content')
    <form action="{{ route('config.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Tarif PLN (Rp/kWh)</label>
            <input type="number" name="tarif_pln" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Gaji Per Jam (Rp)</label>
            <input type="number" name="gaji_per_jam" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('config.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
