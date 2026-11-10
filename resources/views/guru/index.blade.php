@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Data akademik</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Data Guru</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Informasi guru dan mata pelajaran yang diampu.</p>
            </div>
            <a href="{{ route('guru.create') }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Tambah Guru</a>
        </div>

        @if (session('success'))
            <div role="status" class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800 dark:border-green-800 dark:bg-green-900/30 dark:text-green-200">{{ session('success') }}</div>
        @endif

        <form action="{{ route('guru.index') }}" method="GET" class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:items-end dark:border-gray-700 dark:bg-gray-800">
            <div class="flex-1">
                <label for="keyword" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Cari guru</label>
                <input id="keyword" type="search" name="keyword" value="{{ request('keyword') }}" placeholder="Nama guru atau mata pelajaran" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
            </div>
            <div class="sm:w-64">
                <label for="mapel" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Mata pelajaran</label>
                <select id="mapel" name="mapel" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                    <option value="">Semua mata pelajaran</option>
                    @foreach ($mapels as $mapel)
                        <option value="{{ $mapel }}" @selected(request('mapel') === $mapel)>{{ $mapel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('guru.index') }}" class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Reset</a>
                <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Cari</button>
            </div>
        </form>

        <div data-api-container class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">No.</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"><a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_guru', 'direction' => $sort === 'nama_guru' && $direction === 'asc' ? 'desc' : 'asc']) }}">Nama Guru</a></th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"><a href="{{ request()->fullUrlWithQuery(['sort' => 'mapel', 'direction' => $sort === 'mapel' && $direction === 'asc' ? 'desc' : 'asc']) }}">Mata Pelajaran</a></th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Jumlah Kelas</th>
                            <th scope="col" class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody data-api-list="{{ url('/api/guru') }}" class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($gurus as $guru)
                            <tr data-api-id="{{ $guru->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $loop->iteration + ($gurus->currentPage() - 1) * $gurus->perPage() }}</td>
                                <td data-api-field="nama_guru" class="whitespace-nowrap px-5 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $guru->nama_guru }}</td>
                                <td data-api-field="mapel" class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $guru->mapel }}</td>
                                <td data-api-field="kelas.length" class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $guru->kelas->count() }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('guru.show', $guru) }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Detail</a>
                                        <a href="{{ route('guru.edit', $guru) }}" class="font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Edit</a>
                                        <form action="{{ route('guru.destroy', $guru) }}" method="POST" data-api-delete="{{ url('/api/guru/'.$guru->id) }}" data-confirm="Apakah Anda yakin ingin menghapus guru ini?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 hover:text-red-500 dark:text-red-400">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-10 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada data guru.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div>{{ $gurus->links() }}</div>
    </div>
@endsection
