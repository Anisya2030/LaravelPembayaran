<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $barangs = Barang::query();
            return DataTables::of($barangs)

                ->make(true);
        }
        return view('barang.index');
    }

    public function create()
    {
        return view('data_mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
        'nim' => 'required',
        'nama' => 'required',
        'prodi' => 'required',
        'angkatan' => 'required',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $mahasiswa = new DataMahasiswa($request->except('foto'));

    if ($request->hasFile('foto')) {
        $image = $request->file('foto');
        $filename = time() . '.' . $image->getClientOriginalExtension();

        $img = Image::read($image->getRealPath());
        $img->resize(300, 300)->save(public_path('uploads/' . $filename));

        $mahasiswa->foto = $filename;
    }

    $mahasiswa->save();
    return redirect()->route('data-mahasiswa.index')->with('success', 'Data berhasil disimpan');
}

    public function edit($id)
    {
        $mahasiswa = DataMahasiswa::findOrFail($id);
        return view('data_mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'prodi' => 'required',
            'angkatan' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $mahasiswa = DataMahasiswa::findOrFail($id);

        $mahasiswa->nim = $request->nim;
        $mahasiswa->nama = $request->nama;
        $mahasiswa->prodi = $request->prodi;
        $mahasiswa->angkatan = $request->angkatan;

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $filename = time() . '.' . $image->getClientOriginalExtension();

            // Resize dan simpan foto
            Image::read($image->getRealPath())->resize(300, 300)->save(public_path('uploads/foto/' . $filename));

            // Hapus foto lama jika ada
            if ($mahasiswa->foto && file_exists(public_path($mahasiswa->foto))) {
                unlink(public_path($mahasiswa->foto));
            }

            $mahasiswa->foto = 'uploads/foto/' . $filename;
        }

        $mahasiswa->save();

        return redirect()->route('data-mahasiswa.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $mahasiswa = DataMahasiswa::findOrFail($id);

        if ($mahasiswa->foto && file_exists(public_path($mahasiswa->foto))) {
            unlink(public_path($mahasiswa->foto));
        }

        $mahasiswa->delete();

        return redirect()->route('data-mahasiswa.index')->with('success', 'Data berhasil dihapus');
    }

}
