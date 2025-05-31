@extends('adminlte::page')

@section('title', 'Edit Kertas Plano')

@section('content_header')
    <h1>Edit Data Kertas Plano</h1>
@endsection

@section('content')
    <form action="{{ route('kertas-plano.update', $kertas_plano->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Kertas</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $kertas_plano->nama) }}" required>
        </div>

        <div class="form-group">
            <label>Panjang (mm)</label>
            <input type="number" name="panjang" class="form-control" value="{{ old('panjang', $kertas_plano->panjang) }}" required>
        </div>

        <div class="form-group">
            <label>Lebar (mm)</label>
            <input type="number" name="lebar" class="form-control" value="{{ old('lebar', $kertas_plano->lebar) }}" required>
        </div>

        <div class="form-group">
            <label>Gramasi (gsm)</label>
            <input type="number" name="gramasi" class="form-control" value="{{ old('gramasi', $kertas_plano->gramasi) }}" required>
        </div>

        <div class="form-group">
            <label>Jenis Kertas</label>
            <select name="jenis_kertas" class="form-control" required>
                <option value="coated" {{ old('jenis_kertas', $kertas_plano->jenis_kertas) == 'coated' ? 'selected' : '' }}>Coated</option>
                <option value="uncoated" {{ old('jenis_kertas', $kertas_plano->jenis_kertas) == 'uncoated' ? 'selected' : '' }}>Uncoated</option>
            </select>
        </div>

        <div class="form-group">
            <label>Harga per Lembar</label>
            <input type="number" step="0.01" name="harga_per_lembar" class="form-control" value="{{ old('harga_per_lembar', $kertas_plano->harga_per_lembar) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('kertas-plano.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection