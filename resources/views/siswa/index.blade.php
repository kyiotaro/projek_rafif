@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Data akademik</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Data Siswa</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Informasi nama, berat badan, tinggi badan, dan kelas siswa.</p>
            </div>
            <a href="{{ route('siswa.create') }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Tambah Siswa</a>
        </div>

        @if (session('success'))
            <div role="status" class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800 dark:border-green-800 dark:bg-green-900/30 dark:text-green-200">{{ session('success') }}</div>
        @endif

        <form action="{{ route('siswa.index') }}" method="GET" class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div>
                    <label for="keyword" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Cari siswa</label>
                    <input id="keyword" type="search" name="keyword" value="{{ request('keyword') }}" placeholder="Nama, berat, atau tinggi badan" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                </div>
                <div>
                    <label for="kelas" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Kelas</label>
                    <select id="kelas" name="kelas" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                        <option value="">Semua kelas</option>
                        @foreach ($kelas as $item)
                            <option value="{{ $item->id }}" @selected(request('kelas') == $item->id)>{{ $item->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                @foreach ([
                    ['name' => 'bb_min', 'label' => 'Berat minimum (kg)'],
                    ['name' => 'bb_max', 'label' => 'Berat maksimum (kg)'],
                    ['name' => 'tb_min', 'label' => 'Tinggi minimum (cm)'],
                    ['name' => 'tb_max', 'label' => 'Tinggi maksimum (cm)'],
                ] as $filter)
                    <div>
                        <label for="{{ $filter['name'] }}" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $filter['label'] }}</label>
                        <input id="{{ $filter['name'] }}" type="number" min="0" name="{{ $filter['name'] }}" value="{{ request($filter['name']) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                    </div>
                @endforeach
            </div>
            <div class="mt-4 flex flex-wrap justify-end gap-3">
                <a href="{{ route('siswa.index') }}" class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Reset</a>
                <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Terapkan Filter</button>
            </div>
        </form>

        <div data-api-container class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">No.</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"><a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_siswa', 'direction' => $sort === 'nama_siswa' && $direction === 'asc' ? 'desc' : 'asc']) }}">Nama</a></th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"><a href="{{ request()->fullUrlWithQuery(['sort' => 'bb', 'direction' => $sort === 'bb' && $direction === 'asc' ? 'desc' : 'asc']) }}">Berat Badan</a></th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400"><a href="{{ request()->fullUrlWithQuery(['sort' => 'tb', 'direction' => $sort === 'tb' && $direction === 'asc' ? 'desc' : 'asc']) }}">Tinggi Badan</a></th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Kelas</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Wali Kelas</th>
                            <th scope="col" class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody data-api-list="{{ url('/api/siswa') }}" class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($siswas as $siswa)
                            <tr data-api-id="{{ $siswa->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $loop->iteration + ($siswas->currentPage() - 1) * $siswas->perPage() }}</td>
                                <td data-api-field="nama_siswa" class="whitespace-nowrap px-5 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $siswa->nama_siswa }}</td>
                                <td data-api-field="Bb" class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $siswa->Bb }}</td>
                                <td data-api-field="Tb" class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $siswa->Tb }}</td>
                                <td data-api-field="kelas.nama_kelas" data-api-default="Tidak ada kelas" class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $siswa->kelas->nama_kelas ?? 'Tidak ada kelas' }}</td>
                                <td data-api-field="kelas.guru.nama_guru" data-api-default="Tidak ada guru" class="whitespace-nowrap px-5 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $siswa->kelas->guru->nama_guru ?? 'Tidak ada guru' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('siswa.show', $siswa) }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Detail</a>
                                        <a href="{{ route('siswa.edit', $siswa) }}" class="font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">Edit</a>
                                        <form action="{{ route('siswa.destroy', $siswa) }}" method="POST" data-api-delete="{{ url('/api/siswa/'.$siswa->id) }}" data-confirm="Apakah Anda yakin ingin menghapus siswa ini?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 hover:text-red-500 dark:text-red-400">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-5 py-10 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada data siswa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div>{{ $siswas->links() }}</div>
    </div>
@endsection
