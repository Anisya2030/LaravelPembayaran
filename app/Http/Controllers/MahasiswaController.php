<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;


class MahasiswaController extends Controller
{

    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::all();

        $edit = null;
        if ($request->has('edit_id')) {
            $edit = Mahasiswa::find($request->edit_id);
        }

        return view('mahasiswa.index', compact('mahasiswa', 'edit'));
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

        $mahasiswa = new Mahasiswa($request->except('foto'));

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $filename = time() . '.' . $image->getClientOriginalExtension();

            $img = Image::read($image->getRealPath());
            $img->resize(300, 300)->save(public_path('uploads/' . $filename));

            $mahasiswa->foto = $filename;
        }

        $mahasiswa->save();
        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
    $mahasiswa = Mahasiswa::findOrFail($id);

    $request->validate([
        'nama' => 'required',
        'prodi' => 'required',
        'angkatan' => 'required|digits:4',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Update data biasa
    $mahasiswa->nama = $request->nama;
    $mahasiswa->prodi = $request->prodi;
    $mahasiswa->angkatan = $request->angkatan;

    // Cek dan proses foto baru
    if ($request->hasFile('foto')) {
        // Hapus foto lama dari public/uploads
        $oldPath = public_path('uploads/' . $mahasiswa->foto);
        if ($mahasiswa->foto && file_exists($oldPath)) {
            unlink($oldPath);
        }

        // Simpan foto baru ke public/uploads
        $file = $request->file('foto');
        $fileName = time() . '.' . $file->getClientOriginalExtension();

        $image = Image::read($file->getRealPath())
                      ->resize(300, 300);
        $image->save(public_path('uploads/' . $fileName));

        $mahasiswa->foto = $fileName;
    }

    $mahasiswa->save();

    return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        if ($mahasiswa->foto && file_exists(public_path('uploads/' . $mahasiswa->foto))) {
            unlink(public_path('uploads/' . $mahasiswa->foto));
        }

        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil dihapus');
    }
}
