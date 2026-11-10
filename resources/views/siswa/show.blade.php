@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6 px-4 sm:px-6 lg:px-8">
        <div>
            <a href="{{ route('siswa.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">&larr; Kembali ke data siswa</a>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Detail Siswa</h1>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-8">
            <dl data-api-get="{{ url('/api/siswa/'.$siswa->id) }}" class="divide-y divide-gray-100 dark:divide-gray-700">
                <div class="grid gap-1 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama</dt>
                    <dd data-api-field="nama_siswa" class="text-sm text-gray-900 dark:text-white sm:col-span-2">{{ $siswa->nama_siswa }}</dd>
                </div>
                <div class="grid gap-1 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Berat Badan</dt>
                    <dd data-api-field="Bb" data-api-suffix=" kg" class="text-sm text-gray-900 dark:text-white sm:col-span-2">{{ $siswa->Bb }} kg</dd>
                </div>
                <div class="grid gap-1 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tinggi Badan</dt>
                    <dd data-api-field="Tb" data-api-suffix=" cm" class="text-sm text-gray-900 dark:text-white sm:col-span-2">{{ $siswa->Tb }} cm</dd>
                </div>
                <div class="grid gap-1 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kelas</dt>
                    <dd data-api-field="kelas.nama_kelas" data-api-default="Tidak ada kelas" class="text-sm text-gray-900 dark:text-white sm:col-span-2">{{ $siswa->kelas->nama_kelas ?? 'Tidak ada kelas' }}</dd>
                </div>
                <div class="grid gap-1 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Wali Kelas</dt>
                    <dd data-api-field="kelas.guru.nama_guru" data-api-default="Tidak ada guru" class="text-sm text-gray-900 dark:text-white sm:col-span-2">{{ $siswa->kelas->guru->nama_guru ?? 'Tidak ada guru' }}</dd>
                </div>
            </dl>
            <div class="mt-6 flex justify-end">
                <a href="{{ route('siswa.edit', $siswa) }}" class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Edit Siswa</a>
            </div>
        </div>
    </div>
@endsection
