@extends('adminlte::page')

@section('title', 'Master Mesin Offset')

@section('content_header')
    <h1>Master Mesin Offset</h1>
@endsection

@section('content')
    <a href="{{ route('mesin-offset.create') }}" class="btn btn-primary mb-3">+ Tambah Mesin</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kecepatan</th>
                <th>Ukuran Min</th>
                <th>Ukuran Max</th>
                <th>Harga CTCP</th>
                <th>Harga Plate</th>
                <th>Daya Listrik</th>
                <th>Upah Operator</th>
                <th>Jumlah Operator</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mesin as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kecepatan }} lembar/jam</td>
                    <td>{{ $item->min_panjang }} x {{ $item->min_lebar }} mm</td>
                    <td>{{ $item->max_panjang }} x {{ $item->max_lebar }} mm</td>
                    <td>Rp {{ number_format($item->harga_ctcp, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->harga_plate, 0, ',', '.') }}</td>
                    <td>{{ $item->daya_listrik }} Watt</td>
                    <td>Rp {{ number_format($item->upah_operator_per_jam, 0, ',', '.') }}</td>
                    <td>{{ $item->jumlah_operator }} Orang</td>
                    <td>
                        <a href="{{ route('mesin-offset.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('mesin-offset.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus?')" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
