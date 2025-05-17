@extends('adminlte::page')

@section('title', 'Tambah Tinta')

@section('content_header')
    <h1>Tambah Tinta</h1>
@endsection

@section('content')
    <form action="{{ route('tinta.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama Tinta</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Jenis Tinta</label>
            <select name="jenis" class="form-control" required>
                <option value="">Pilih Jenis Tinta</option>
                <option value="warna proses">Warna Proses</option>
                <option value="warna khusus">Warna Khusus</option>
            </select>
        </div>

        <div class="form-group">
            <label>Bobot Coated (g/m²)</label>
            <input type="number" step="0.01" name="bobot_coated" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Bobot Uncoated (g/m²)</label>
            <input type="number" step="0.01" name="bobot_uncoated" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Harga Tinta Per Kg (Rp)</label>
            <input type="number" step="0.01" name="harga" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('tinta.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
