@extends('adminlte::page')

@section('title', 'Tambah Plano')

@section('content_header')
    <h1>Tambah Kertas Plano</h1>
@endsection

@section('content')
    <form action="{{ route('kertas-plano.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama Kertas</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Panjang (mm)</label>
            <input type="number" name="panjang" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Lebar (mm)</label>
            <input type="number" name="lebar" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Gramasi (gsm)</label>
            <input type="number" name="gramasi" class="form-control" required>

        <div class="form-group">
            <label>Harga per Lembar</label>
            <input type="number" step="0.01" name="harga_per_lembar" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('kertas-plano.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
