@extends('adminlte::page')

@section('title', 'Tambah Mesin Finishing')

@section('content_header')
    <h1>Tambah Mesin Finishing</h1>
@endsection

@section('content')
    <form action="{{ route('mesin-finishing.store') }}" method="POST">
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
            <label>Daya Listrik (Watt)</label>
            <input type="number" step="0.01" name="daya_listrik" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Upah Operator per Jam (Rp)</label>
            <input type="number" step="0.01" name="upah_operator_per_jam" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Jumlah Operator</label>
            <input type="number" name="jumlah_operator" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('mesin-finishing.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
