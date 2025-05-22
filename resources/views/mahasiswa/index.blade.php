@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Mahasiswa</h2>

    {{-- Pesan Sukses --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Validasi Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah / Edit Mahasiswa --}}
    <div class="card mb-4">
        <div class="card-header">
            {{ isset($edit) ? 'Edit Mahasiswa' : 'Tambah Mahasiswa' }}
        </div>
        <div class="card-body">
            <form
                action="{{ isset($edit) ? route('mahasiswa.update', $edit->id) : route('mahasiswa.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @if (isset($edit))
                    @method('PUT')
                @endif

                <div class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <input
                            type="text"
                            name="nim"
                            class="form-control"
                            placeholder="NIM"
                            value="{{ old('nim', $edit->nim ?? '') }}"
                            required>
                    </div>
                    <div class="col-md-2">
                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            placeholder="Nama"
                            value="{{ old('nama', $edit->nama ?? '') }}"
                            required>
                    </div>
                    <div class="col-md-2">
                        <input
                            type="text"
                            name="prodi"
                            class="form-control"
                            placeholder="Prodi"
                            value="{{ old('prodi', $edit->prodi ?? '') }}"
                            required>
                    </div>
                    <div class="col-md-2">
                        <input
                            type="text"
                            name="angkatan"
                            class="form-control"
                            placeholder="Angkatan"
                            value="{{ old('angkatan', $edit->angkatan ?? '') }}"
                            required>
                    </div>
                    <div class="col-md-2">
                        <label for="foto">Foto</label>
                        <input
                            type="file"
                            name="foto"
                            id="foto"
                            class="form-control"
                            accept="image/*"
                            onchange="previewFoto(this)">

                        {{-- Preview Foto Lama (jika edit) --}}
                        @if (isset($edit) && $edit->foto)
                            <img id="previewFotoLama" src="{{ asset('uploads/' . $edit->foto) }}" class="mt-2 rounded" width="60" height="60" style="object-fit: cover">
                        @endif
                        {{-- Preview Foto Baru --}}
                        <img id="previewFotoBaru" class="mt-2 rounded d-none" width="60" height="60" style="object-fit: cover">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-{{ isset($edit) ? 'warning' : 'primary' }}">
                            {{ isset($edit) ? 'Update' : 'Simpan' }}
                        </button>
                        @if (isset($edit))
                            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary mt-2">Batal</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Mahasiswa --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Foto</th>
                    <th>Prodi</th>
                    <th>Angkatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mahasiswa as $mhs)
                    <tr>
                        <td>{{ $mhs->nim }}</td>
                        <td>{{ $mhs->nama }}</td>
                        <td>
                            @if ($mhs->foto)
                                <img src="{{ asset('uploads/' . $mhs->foto) }}" width="60" height="60" class="rounded-circle" style="object-fit: cover">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $mhs->prodi }}</td>
                        <td>{{ $mhs->angkatan }}</td>
                        <td>
                            <a href="{{ route('mahasiswa.index', ['edit_id' => $mhs->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('mahasiswa.destroy', $mhs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-muted">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Script Preview Gambar --}}
<script>
    function previewFoto(input) {
        const preview = document.getElementById('previewFotoBaru');
        const previewLama = document.getElementById('previewFotoLama');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if (previewLama) previewLama.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
