@extends('adminlte::page')

@section('title', 'Edit Mesin Offset')

@section('content_header')
    <h1>Edit Mesin Offset</h1>
@endsection

@section('content')
    <form action="{{ route('mesin-offset.update', $mesin->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Mesin</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $mesin->nama) }}" required>
        </div>

        <div class="form-group">
            <label>Kecepatan (lembar/jam)</label>
            <input type="number" name="kecepatan" class="form-control" value="{{ old('kecepatan', $mesin->kecepatan) }}" required>
        </div>

        <div class="form-group">
            <label>Ukuran Minimum (mm)</label>
            <div class="row">
                <div class="col">
                    <input type="number" name="min_panjang" class="form-control" placeholder="Panjang" value="{{ old('min_panjang', $mesin->min_panjang) }}" required>
                </div>
                <div class="col">
                    <input type="number" name="min_lebar" class="form-control" placeholder="Lebar" value="{{ old('min_lebar', $mesin->min_lebar) }}" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Ukuran Maksimum (mm)</label>
            <div class="row">
                <div class="col">
                    <input type="number" name="max_panjang" class="form-control" placeholder="Panjang" value="{{ old('max_panjang', $mesin->max_panjang) }}" required>
                </div>
                <div class="col">
                    <input type="number" name="max_lebar" class="form-control" placeholder="Lebar" value="{{ old('max_lebar', $mesin->max_lebar) }}" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Harga CTCP (Rp)</label>
            <input type="number" step="0.01" name="harga_ctcp" class="form-control" value="{{ old('harga_ctcp', $mesin->harga_ctcp) }}" required>
        </div>

        <div class="form-group">
            <label>Harga Plate (Rp)</label>
            <input type="number" step="0.01" name="harga_plate" class="form-control" value="{{ old('harga_plate', $mesin->harga_plate) }}" required>
        </div>

        <div class="form-group">
            <label>Daya Listrik (Watt)</label>
            <input type="number" step="0.01" name="daya_listrik" class="form-control" value="{{ old('daya_listrik', $mesin->daya_listrik) }}" required>
        </div>

        <div class="form-group">
            <label>Upah Operator per Jam (Rp)</label>
            <input type="number" step="0.01" name="upah_operator_per_jam" class="form-control" value="{{ old('upah_operator_per_jam', $mesin->upah_operator_per_jam) }}" required>
        </div>

        <div class="form-group">
            <label>Jumlah Operator</label>
            <input type="number" name="jumlah_operator" class="form-control" value="{{ old('jumlah_operator', $mesin->jumlah_operator) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('mesin-offset.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection