@extends('adminlte::page')

@section('title', 'Master Finishing')

@section('content_header')
    <h1>Finishing</h1>
@endsection

@section('content')
    <a href="{{ route('finishings.create') }}" class="btn btn-primary mb-3">+ Tambah Finishing</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kecepatan</th>
                <th>Daya Listrik</th>
                <th>Upah Operator</th>
                <th>Jumlah Operator</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mesinFinishing as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kecepatan }} lembar/jam</td>
                    <td>{{ $item->daya_listrik }} Watt</td>
                    <td>Rp {{ number_format($item->upah_operator_per_jam, 0, ',', '.') }}</td>
                    <td>{{ $item->jumlah_operator }} Orang</td>
                    <td>
                        <a href="{{ route('mesin-finishing.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('mesin-finishing.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus?')" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
