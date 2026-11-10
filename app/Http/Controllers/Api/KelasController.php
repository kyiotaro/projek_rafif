<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KelasResource;
use App\Models\kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        return KelasResource::collection(kelas::with(['guru', 'siswa'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'guru_id' => 'required|exists:guru,id',
        ]);

        $kelas = kelas::create($validated)->load(['guru', 'siswa']);

        return (new KelasResource($kelas))->response()->setStatusCode(201);
    }

    public function show(kelas $kelas)
    {
        $kelas->load(['guru', 'siswa']);

        return new KelasResource($kelas);
    }

    public function update(Request $request, kelas $kelas)
    {
        $validated = $request->validate([
            'nama_kelas' => 'sometimes|required|string|max:50',
            'guru_id' => 'sometimes|required|exists:guru,id',
        ]);

        $kelas->update($validated);
        $kelas->load(['guru', 'siswa']);

        return new KelasResource($kelas);
    }

    public function destroy(kelas $kelas)
    {
        $kelas->delete();

        return response()->json([
            'message' => 'Data kelas berhasil dihapus.',
        ]);
    }
}
