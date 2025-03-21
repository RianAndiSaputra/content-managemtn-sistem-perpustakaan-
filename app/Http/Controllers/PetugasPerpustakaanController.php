<?php

namespace App\Http\Controllers;

use App\Models\PetugasPerpustakaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PetugasPerpustakaanController extends Controller
{
    public function index()
    {
        $petugass = PetugasPerpustakaan::all();
        return view('petugas.index', compact('petugass'));
    }

    public function create()
    {
        return view('petugas.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_petugas' => 'required|string|max:255',
            'username_petugas' => 'required|string|unique:petugas_perpustakaans',
            'password_petugas' => 'required|string|min:6',
            'email_petugas' => 'required|email|unique:petugas_perpustakaans',
        ]);

        if ($validator->fails()) {
            return redirect()->route('petugas.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Hash password sebelum menyimpan
        $request->merge([
            'password_petugas' => Hash::make($request->password_petugas)
        ]);

        PetugasPerpustakaan::create($request->all());

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas Perpustakaan berhasil ditambahkan!');
    }

    public function show(PetugasPerpustakaan $petuga)
    {
        return view('petugas.show', compact('petuga'));
    }

    public function edit(PetugasPerpustakaan $petuga)
    {
        return view('petugas.edit', compact('petuga'));
    }

    public function update(Request $request, PetugasPerpustakaan $petuga)
    {
        $validator = Validator::make($request->all(), [
            'nama_petugas' => 'required|string|max:255',
            'username_petugas' => 'required|string|unique:petugas_perpustakaans,username_petugas,' . $petuga->id_petugas . ',id_petugas',
            'email_petugas' => 'required|email|unique:petugas_perpustakaans,email_petugas,' . $petuga->id_petugas . ',id_petugas',
            'password_petugas' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('petugas.edit', $petuga->id_petugas)
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Jika password baru disediakan, hash password
        if (!empty($data['password_petugas'])) {
            $data['password_petugas'] = Hash::make($data['password_petugas']);
        } else {
            // Jika tidak, hapus kunci password dari array data
            unset($data['password_petugas']);
        }

        $petuga->update($data);

        return redirect()->route('petugas.index')
            ->with('success', 'Petugas Perpustakaan berhasil diperbarui!');
    }

    public function destroy(PetugasPerpustakaan $petuga)
    {
        try {
            $petuga->delete();
            return redirect()->route('petugas.index')
                ->with('success', 'Petugas Perpustakaan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('petugas.index')
                ->with('error', 'Petugas Perpustakaan tidak dapat dihapus karena masih terkait dengan data lain!');
        }
    }
}