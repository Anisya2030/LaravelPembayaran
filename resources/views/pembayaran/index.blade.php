@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Data Pembayaran</h3>

    {{-- Tombol Tambah --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">
        + Tambah Pembayaran
    </button>

    {{-- Modal Form Tambah Pembayaran --}}
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('pembayaran.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="nis" class="form-control mb-2" placeholder="NIS" required>
                        <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
                        <input type="text" name="kelas" class="form-control mb-2" placeholder="Kelas" required>
                        <input type="text" name="ekstrakurikuler" class="form-control mb-2" placeholder="Ekstrakurikuler" required>
                        <input type="number" name="jan" class="form-control mb-2" placeholder="Pembayaran Jan" required>
                        <input type="number" name="feb" class="form-control mb-2" placeholder="Pembayaran Feb" required>
                        <input type="number" name="mar" class="form-control mb-2" placeholder="Pembayaran Mar" required>
                        <input type="number" name="diskon" step="0.01" class="form-control mb-2" placeholder="Diskon (%)" required>
                        <select name="status" class="form-select mb-2" required>
                            <option value="Lunas">Lunas</option>
                            <option value="Belum Lunas">Belum Lunas</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Data Pembayaran --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Ekstrakurikuler</th>
                <th>Jan</th>
                <th>Feb</th>
                <th>Mar</th>
                <th>Diskon</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembayarans as $p)
                <tr>
                    <td>{{ $p->nis }}</td>
                    <td>{{ $p->nama }}</td>
                    <td>{{ $p->kelas }}</td>
                    <td>{{ $p->ekstrakurikuler }}</td>
                    <td>{{ $p->jan }}</td>
                    <td>{{ $p->feb }}</td>
                    <td>{{ $p->mar }}</td>
                    <td>{{ $p->diskon }}%</td>
                    <td>{{ ($p->jan + $p->feb + $p->mar) - (($p->diskon / 100) * ($p->jan + $p->feb + $p->mar)) }}</td>
                    <td>{{ $p->status }}</td>
                    <td>
                        {{-- Tombol Edit --}}
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $p->id }}">Edit</button>

                        {{-- Form Hapus --}}
                        <form action="{{ route('pembayaran.destroy', $p->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>

                {{-- Modal Edit --}}
                <div class="modal fade" id="editModal{{ $p->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="{{ route('pembayaran.update', $p->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Pembayaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" name="nama" class="form-control mb-2" value="{{ $p->nama }}" required>
                                    <input type="number" name="jan" class="form-control mb-2" value="{{ $p->jan }}" required>
                                    <input type="number" name="diskon" class="form-control mb-2" value="{{ $p->diskon }}" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            @endforeach
        </tbody>
    </table>
</div>
@endsection
