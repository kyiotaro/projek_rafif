<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuruResource;
use App\Models\guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        return GuruResource::collection(guru::with('kelas')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:100',
            'mapel' => 'required|string|max:100',
        ]);

        $guru = guru::create($validated)->load('kelas');

        return (new GuruResource($guru))->response()->setStatusCode(201);
    }

    public function show(guru $guru)
    {
        $guru->load('kelas');

        return new GuruResource($guru);
    }

    public function update(Request $request, guru $guru)
    {
        $validated = $request->validate([
            'nama_guru' => 'sometimes|required|string|max:100',
            'mapel' => 'sometimes|required|string|max:100',
        ]);

        $guru->update($validated);
        $guru->load('kelas');

        return new GuruResource($guru);
    }

    public function destroy(guru $guru)
    {
        $guru->delete();

        return response()->json([
            'message' => 'Data guru berhasil dihapus.',
        ]);
    }
}
