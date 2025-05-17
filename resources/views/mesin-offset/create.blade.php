@extends('adminlte::page')

@section('title', 'Tambah Mesin Offset')

@section('content_header')
    <h1>Tambah Mesin Offset</h1>
@endsection

@section('content')
    <form action="{{ route('mesin-offset.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama Mesin</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Kecepatan (lembar/jam)</label>
            <input type="number" name="kecepatan" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Ukuran Minimum (mm)</label>
            <div class="row">
                <div class="col">
                    <input type="number" name="min_panjang" class="form-control" placeholder="Panjang" required>
                </div>
                <div class="col">
                    <input type="number" name="min_lebar" class="form-control" placeholder="Lebar" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Ukuran Maksimum (mm)</label>
            <div class="row">
                <div class="col">
                    <input type="number" name="max_panjang" class="form-control" placeholder="Panjang" required>
                </div>
                <div class="col">
                    <input type="number" name="max_lebar" class="form-control" placeholder="Lebar" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Harga CTCP (Rp)</label>
            <input type="number" step="0.01" name="harga_ctcp" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Harga Plate (Rp)</label>
            <input type="number" step="0.01" name="harga_plate" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Daya Listrik (Watt)</label>
            <input type="number" step="0.01" name="daya_listrik" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Upah Operator per Jam (Rp)</label>
            <input type="number" step="0.01" name="upah_operator_per_jam" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('mesin-offset.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
