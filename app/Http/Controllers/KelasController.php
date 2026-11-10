<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\guru;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'keyword' => 'nullable|string|max:100',
            'guru' => 'nullable|integer|exists:guru,id',
        ]);

        $sortColumns = [
            'nama_kelas' => 'nama_kelas',
        ];
        $sort = $request->query('sort', 'nama_kelas');
        $sort = is_string($sort) && array_key_exists($sort, $sortColumns) ? $sort : 'nama_kelas';
        $direction = $request->query('direction', 'asc');
        $direction = is_string($direction) ? strtolower($direction) : 'asc';
        $direction = in_array($direction, ['asc', 'desc'], true) ? $direction : 'asc';

        $query = kelas::with(['guru', 'siswa']);
        $query->when($filters['keyword'] ?? null, function ($q, $keyword) {
            $keyword = '%' . $keyword . '%';
            $q->where(function ($q) use ($keyword) {
                $q->where('nama_kelas', 'like', $keyword)
                    ->orWhereHas('guru', fn ($guru) => $guru->where('nama_guru', 'like', $keyword))
                    ->orWhereHas('siswa', fn ($siswa) => $siswa->where('nama_siswa', 'like', $keyword));
            });
        });
        $query->when($filters['guru'] ?? null, fn ($q, $guru) => $q->where('guru_id', $guru));

        $kelas = $query->orderBy($sortColumns[$sort], $direction)->paginate(10)->withQueryString();
        $gurus = guru::orderBy('nama_guru')->get();
        return view('kelas.index', compact('kelas', 'gurus', 'sort', 'direction'));
    }

    public function create()
    {
        $gurus = guru::orderBy('nama_guru')->get();
        return view('kelas.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'guru_id' => 'required|exists:guru,id',
        ]);

        kelas::create($validated);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $kelas = kelas::with(['guru', 'siswa'])->findOrFail($id);
        return view('kelas.show', compact('kelas'));
    }

    public function edit(string $id)
    {
        $kelas = kelas::findOrFail($id);
        $gurus = guru::orderBy('nama_guru')->get();
        return view('kelas.edit', compact('kelas', 'gurus'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'guru_id' => 'required|exists:guru,id',
        ]);

        $kelas = kelas::findOrFail($id);
        $kelas->update($validated);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $kelas = kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}
