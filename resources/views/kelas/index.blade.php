@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Data akademik</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Data Kelas</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Daftar kelas, wali kelas, dan siswa di setiap kelas.</p>
            </div>
            <a href="{{ route('kelas.create') }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Tambah Kelas</a>
        </div>

        @if (session('success'))
            <div role="status" class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800 dark:border-green-800 dark:bg-green-900/30 dark:text-green-200">{{ session('success') }}</div>
        @endif

        <form action="{{ route('kelas.index') }}" method="GET" class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:items-end dark:border-gray-700 dark:bg-gray-800">
            <div class="flex-1">
                <label for="keyword" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Cari data kelas</label>
                <input id="keyword" type="search" name="keyword" value="{{ request('keyword') }}" placeholder="Nama siswa, kelas, atau guru" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
            </div>
            <div class="sm:w-64">
                <label for="guru" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Wali kelas</label>
                <select id="guru" name="guru" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                    <option value="">Semua wali kelas</option>
                    @foreach ($gurus as $guru)
                        <option value="{{ $guru->id }}" @selected(request('guru') == $guru->id)>{{ $guru->nama_guru }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('kelas.index') }}" class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Reset</a>
                <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Cari</button>
            </div>
        </form>

        <div data-api-container class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">No.</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"><a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_kelas', 'direction' => $sort === 'nama_kelas' && $direction === 'asc' ? 'desc' : 'asc']) }}">Nama Kelas</a></th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Wali Kelas</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Siswa</th>
                            <th scope="col" class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody data-api-list="{{ url('/api/kelas') }}" class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($kelas as $item)
                            <tr data-api-id="{{ $item->id }}" class="align-top hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $loop->iteration + ($kelas->currentPage() - 1) * $kelas->perPage() }}</td>
                                <td data-api-field="nama_kelas" class="whitespace-nowrap px-5 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $item->nama_kelas }}</td>
                                <td data-api-field="guru.nama_guru" data-api-default="Tidak ada guru" class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $item->guru->nama_guru ?? 'Tidak ada guru' }}</td>
                                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">
                                    @if ($item->siswa->isNotEmpty())
                                        <ul class="space-y-1">
                                            @foreach ($item->siswa as $siswa)
                                                <li>{{ $siswa->nama_siswa }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-gray-400">Belum ada siswa</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('kelas.show', $item) }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Detail</a>
                                        <a href="{{ route('kelas.edit', $item) }}" class="font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Edit</a>
                                        <form action="{{ route('kelas.destroy', $item) }}" method="POST" data-api-delete="{{ url('/api/kelas/'.$item->id) }}" data-confirm="Apakah Anda yakin ingin menghapus kelas ini?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 hover:text-red-500 dark:text-red-400">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-10 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada data kelas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div>{{ $kelas->links() }}</div>
    </div>
@endsection
