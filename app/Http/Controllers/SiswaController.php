<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::all();
        return view('siswa.index', compact('siswas'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nisn_siswa' => 'required|string|unique:siswas',
            'nama_siswa' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'alamat_siswa' => 'required|string',
            'nomor_telepon' => 'required|string|max:15',
            'email_siswa' => 'required|email|unique:siswas',
        ]);

        if ($validator->fails()) {
            return redirect()->route('siswa.create')
                ->withErrors($validator)
                ->withInput();
        }

        Siswa::create($request->all());

        return redirect()->route('siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function show(Siswa $siswa)
    {
        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validator = Validator::make($request->all(), [
            'nisn_siswa' => 'required|string|unique:siswas,nisn_siswa,' . $siswa->id_siswa . ',id_siswa',
            'nama_siswa' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'alamat_siswa' => 'required|string',
            'nomor_telepon' => 'required|string|max:15',
            'email_siswa' => 'required|email|unique:siswas,email_siswa,' . $siswa->id_siswa . ',id_siswa',
        ]);

        if ($validator->fails()) {
            return redirect()->route('siswa.edit', $siswa->id_siswa)
                ->withErrors($validator)
                ->withInput();
        }

        $siswa->update($request->all());

        return redirect()->route('siswa.index')
            ->with('success', 'Siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa)
    {
        try {
            $siswa->delete();
            return redirect()->route('siswa.index')
                ->with('success', 'Siswa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('siswa.index')
                ->with('error', 'Siswa tidak dapat dihapus karena masih terkait dengan data lain!');
        }
    }
}