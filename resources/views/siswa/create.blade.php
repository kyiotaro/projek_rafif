@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6 px-4 sm:px-6 lg:px-8">
        <div>
            <a href="{{ route('siswa.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">&larr; Kembali ke data siswa</a>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Tambah Siswa</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Lengkapi informasi siswa berikut.</p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-8">
            @if ($errors->any())
                <div role="alert" class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/30 dark:text-red-200">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('siswa.store') }}" method="POST" data-api-form="{{ url('/api/siswa') }}" data-redirect="{{ route('siswa.index') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="nama_siswa" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Siswa</label>
                    <input id="nama_siswa" type="text" name="nama_siswa" value="{{ old('nama_siswa') }}" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                </div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="Bb" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Berat Badan (kg)</label>
                        <input id="Bb" type="number" name="Bb" min="0" value="{{ old('Bb') }}" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label for="Tb" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Tinggi Badan (cm)</label>
                        <input id="Tb" type="number" name="Tb" min="0" value="{{ old('Tb') }}" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                    </div>
                </div>
                <div>
                    <label for="kelas_id" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Kelas</label>
                    <select id="kelas_id" name="kelas_id" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                        <option value="">Pilih kelas</option>
                        @foreach ($kelas as $item)
                            <option value="{{ $item->id }}" @selected(old('kelas_id') == $item->id)>{{ $item->nama_kelas }}</option>
                        @endforeach
                    </select>
                    @if ($kelas->isEmpty())
                        <p class="mt-2 text-sm text-amber-700 dark:text-amber-300">Belum ada kelas. Buat data guru dan kelas terlebih dahulu.</p>
                    @endif
                </div>
                <div class="flex justify-end gap-3 border-t border-gray-100 pt-5 dark:border-gray-700">
                    <a href="{{ route('siswa.index') }}" class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Batal</a>
                    <button type="submit" @disabled($kelas->isEmpty()) class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-50">Simpan Siswa</button>
                </div>
            </form>
        </div>
    </div>
@endsection
