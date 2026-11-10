<?php

namespace App\Http\Controllers;

use App\Models\siswa;
use App\Models\kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $filters = $request->validate([
            'keyword' => 'nullable|string|max:100',
            'kelas' => 'nullable|integer|exists:kelas,id',
            'bb_min' => 'nullable|integer|min:0',
            'bb_max' => 'nullable|integer|min:0|gte:bb_min',
            'tb_min' => 'nullable|integer|min:0',
            'tb_max' => 'nullable|integer|min:0|gte:tb_min',
        ]);

        $sortColumns = [
            'nama_siswa' => 'nama_siswa',
            'bb' => 'Bb',
            'tb' => 'Tb',
        ];
        $sort = $request->query('sort', 'nama_siswa');
        $sort = is_string($sort) && array_key_exists($sort, $sortColumns) ? $sort : 'nama_siswa';
        $direction = $request->query('direction', 'asc');
        $direction = is_string($direction) ? strtolower($direction) : 'asc';
        $direction = in_array($direction, ['asc', 'desc'], true) ? $direction : 'asc';

        $query = Siswa::with('kelas');
        $query->when($filters['keyword'] ?? null, function ($q, $keyword) {
            $keyword = '%' . $keyword . '%';

            $q->where(function ($q) use ($keyword) {
                $q->where('nama_siswa', 'like', $keyword)
                    ->orWhere('Bb', 'like', $keyword)
                    ->orWhere('Tb', 'like', $keyword);
            });
        });

        $query->when($filters['kelas'] ?? null, fn ($q, $kelas) => $q->where('kelas_id', $kelas));
        $query->when($filters['bb_min'] ?? null, fn ($q, $bb) => $q->where('Bb', '>=', $bb));
        $query->when($filters['bb_max'] ?? null, fn ($q, $bb) => $q->where('Bb', '<=', $bb));
        $query->when($filters['tb_min'] ?? null, fn ($q, $tb) => $q->where('Tb', '>=', $tb));
        $query->when($filters['tb_max'] ?? null, fn ($q, $tb) => $q->where('Tb', '<=', $tb));

        $siswas = $query->orderBy($sortColumns[$sort], $direction)->paginate(10)->withQueryString();
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('siswa.index', compact('siswas', 'kelas', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = kelas::orderBy('nama_kelas')->get();
        return view('siswa.create', compact('kelas'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_siswa' => 'required|string|max:100',
            'Bb' => 'required|integer|min:0',
            'Tb' => 'required|integer|min:0',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        siswa::create($validated);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $siswa = siswa::with(['kelas.guru'])->findOrFail($id);
        return view('siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $siswa = siswa::findOrFail($id);
        $kelas = kelas::orderBy('nama_kelas')->get();
        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_siswa' => 'required|string|max:100',
            'Bb' => 'required|integer|min:0',
            'Tb' => 'required|integer|min:0',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswa = siswa::findOrFail($id);
        $siswa->update($validated);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
