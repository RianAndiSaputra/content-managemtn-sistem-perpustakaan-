<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::all();
        return view('buku.index', compact('bukus'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_buku' => 'required|string|max:255',
            'penulis_buku' => 'required|string|max:255',
            'penerbit_buku' => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric|digits:4',
            'isbn_buku' => 'required|string|unique:bukus',
            'kategori_buku' => 'required|string|max:255',
            'jumlah_buku_tersedia' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('buku.create')
                ->withErrors($validator)
                ->withInput();
        }

        Buku::create($request->all());

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validator = Validator::make($request->all(), [
            'judul_buku' => 'required|string|max:255',
            'penulis_buku' => 'required|string|max:255',
            'penerbit_buku' => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric|digits:4',
            'isbn_buku' => 'required|string|unique:bukus,isbn_buku,' . $buku->id_buku . ',id_buku',
            'kategori_buku' => 'required|string|max:255',
            'jumlah_buku_tersedia' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('buku.edit', $buku->id_buku)
                ->withErrors($validator)
                ->withInput();
        }

        $buku->update($request->all());

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Buku $buku)
    {
        try {
            $buku->delete();
            return redirect()->route('buku.index')
                ->with('success', 'Buku berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('buku.index')
                ->with('error', 'Buku tidak dapat dihapus karena masih terkait dengan data lain!');
        }
    }
}