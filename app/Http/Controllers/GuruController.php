<?php

namespace App\Http\Controllers;

use App\Models\guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'keyword' => 'nullable|string|max:100',
            'mapel' => 'nullable|string|max:100',
        ]);

        $sortColumns = [
            'nama_guru' => 'nama_guru',
            'mapel' => 'mapel',
        ];
        $sort = $request->query('sort', 'nama_guru');
        $sort = is_string($sort) && array_key_exists($sort, $sortColumns) ? $sort : 'nama_guru';
        $direction = $request->query('direction', 'asc');
        $direction = is_string($direction) ? strtolower($direction) : 'asc';
        $direction = in_array($direction, ['asc', 'desc'], true) ? $direction : 'asc';

        $query = guru::with('kelas');
        $query->when($filters['keyword'] ?? null, function ($q, $keyword) {
            $keyword = '%' . $keyword . '%';
            $q->where(function ($q) use ($keyword) {
                $q->where('nama_guru', 'like', $keyword)
                    ->orWhere('mapel', 'like', $keyword);
            });
        });
        $query->when($filters['mapel'] ?? null, fn ($q, $mapel) => $q->where('mapel', $mapel));

        $gurus = $query->orderBy($sortColumns[$sort], $direction)->paginate(10)->withQueryString();
        $mapels = guru::query()->select('mapel')->distinct()->orderBy('mapel')->pluck('mapel');
        return view('guru.index', compact('gurus', 'mapels', 'sort', 'direction'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:100',
            'mapel' => 'required|string|max:100',
        ]);

        guru::create($validated);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $guru = guru::with('kelas')->findOrFail($id);
        return view('guru.show', compact('guru'));
    }

    public function edit(string $id)
    {
        $guru = guru::findOrFail($id);
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:100',
            'mapel' => 'required|string|max:100',
        ]);

        $guru = guru::findOrFail($id);
        $guru->update($validated);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $guru = guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
