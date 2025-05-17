@extends('adminlte::page')

@section('title', 'Master Plano')

@section('content_header')
    <h1>Master Plano</h1>
@endsection

@section('content')
    <a href="{{ route('kertas-plano.create') }}" class="btn btn-primary mb-3">+ Tambah Kertas Plano</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Panjang (mm)</th>
                <th>Lebar (mm)</th>
                <th>Gramasi (gsm)</th>
                <th>Harga / Lembar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kertas_plano as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->panjang }}</td>
                    <td>{{ $item->lebar }}</td>
                    <td>{{ $item->gramasi }}</td>
                    <td>Rp {{ number_format($item->harga_per_lembar, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('kertas-plano.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('kertas-plano.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus?')" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
