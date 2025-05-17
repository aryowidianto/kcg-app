@extends('adminlte::page')

@section('title', 'Edit Tinta')

@section('content_header')
    <h1>Edit Data Tinta</h1>
@endsection

@section('content')
    <form action="{{ route('tinta.update', $tinta->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Tinta</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $tinta->nama) }}" required>
        </div>

        <div class="form-group">
            <label>Jenis Tinta</label>
            <select name="jenis" class="form-control" required>
                <option value="">Pilih Jenis Tinta</option>
                <option value="warna proses" {{ old('jenis', $tinta->jenis) == 'warna proses' ? 'selected' : '' }}>Warna Proses</option>
                <option value="warna khusus" {{ old('jenis', $tinta->jenis) == 'warna khusus' ? 'selected' : '' }}>Warna Khusus</option>
            </select>
        </div>

        <div class="form-group">
            <label>Bobot Coated (g/m²)</label>
            <input type="number" step="0.01" name="bobot_coated" class="form-control" value="{{ old('bobot_coated', $tinta->bobot_coated) }}" required>
        </div>

        <div class="form-group">
            <label>Bobot Uncoated (g/m²)</label>
            <input type="number" step="0.01" name="bobot_uncoated" class="form-control" value="{{ old('bobot_uncoated', $tinta->bobot_uncoated) }}" required>
        </div>

        <div class="form-group">
            <label>Harga Tinta Per Kg (Rp)</label>
            <input type="number" step="0.01" name="harga" class="form-control" value="{{ old('harga', $tinta->harga) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('tinta.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection