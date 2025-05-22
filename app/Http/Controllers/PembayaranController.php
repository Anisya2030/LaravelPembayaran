<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::all();
        return view('pembayaran.index', compact('pembayarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'ekstrakurikuler' => 'required',
            'jan' => 'required|integer',
            'feb' => 'required|integer',
            'mar' => 'required|integer',
            'diskon' => 'required|numeric',
            'status' => 'required|in:Lunas,Belum Lunas',
        ]);

        Pembayaran::create($request->all());
        return redirect()->back()->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'kelas' => 'required',
            'ekstrakurikuler' => 'required',
            'jan' => 'required|integer',
            'feb' => 'required|integer',
            'mar' => 'required|integer',
            'diskon' => 'required|numeric',
            'status' => 'required|in:Lunas,Belum Lunas',
        ]);

        $pembayaran->update($request->all());
        return redirect()->back()->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->back()->with('success', 'Pembayaran berhasil dihapus.');
    }
}
