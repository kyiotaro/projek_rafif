<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SiswaResource;
use App\Http\Controllers\Controller;
use App\Models\siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        return SiswaResource::collection(
            siswa::with('kelas.guru')->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_siswa' => 'required|string|max:100',
            'Bb' => 'required|integer|min:0',
            'Tb' => 'required|integer|min:0',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswa = siswa::create($validated)->load('kelas.guru');

        return (new SiswaResource($siswa))->response()->setStatusCode(201);
    }

    public function show(siswa $siswa)
    {
        $siswa->load('kelas.guru');

        return new SiswaResource($siswa);
    }

    public function update(Request $request, siswa $siswa)
    {
        $validated = $request->validate([
            'nama_siswa' => 'sometimes|required|string|max:100',
            'Bb' => 'sometimes|required|integer|min:0',
            'Tb' => 'sometimes|required|integer|min:0',
            'kelas_id' => 'sometimes|required|exists:kelas,id',
        ]);

        $siswa->update($validated);
        $siswa->load('kelas.guru');

        return new SiswaResource($siswa);
    }

    public function destroy(siswa $siswa)
    {
        $siswa->delete();

        return response()->json([
            'message' => 'Data siswa berhasil dihapus.',
        ]);
    }
}
