@extends('adminlte::page')

@section('title', 'Master Tinta')

@section('content_header')
    <h1>Master Tinta</h1>
@endsection

@section('content')
    <a href="{{ route('tinta.create') }}" class="btn btn-primary mb-3">+ Tambah Tinta</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Bobot Coated (g/m²)</th>
                <th>Bobot Uncoated (g/m²)</th>
                <th>Harga Tinta Per Kg (Rp)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tinta as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->bobot_coated }}</td>
                    <td>{{ $item->bobot_uncoated }}</td>
                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('tinta.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('tinta.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus?')" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
