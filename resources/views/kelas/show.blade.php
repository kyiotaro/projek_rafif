@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6 px-4 sm:px-6 lg:px-8">
        <div>
            <a href="{{ route('kelas.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">&larr; Kembali ke data kelas</a>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Detail Kelas</h1>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-8">
            <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                <div class="grid gap-1 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Kelas</dt>
                    <dd data-api-field="nama_kelas" class="text-sm text-gray-900 dark:text-white sm:col-span-2">{{ $kelas->nama_kelas }}</dd>
                </div>
                <div class="grid gap-1 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Wali Kelas</dt>
                    <dd data-api-get="{{ url('/api/kelas/'.$kelas->id) }}" class="text-sm text-gray-900 dark:text-white sm:col-span-2"><span data-api-field="guru.nama_guru" data-api-default="Tidak ada guru">{{ $kelas->guru->nama_guru ?? 'Tidak ada guru' }}</span><span data-api-field="guru.mapel" data-api-prefix=" — " data-api-default="">@if ($kelas->guru) — {{ $kelas->guru->mapel }}@endif</span></dd>
                </div>
                <div class="grid gap-1 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Daftar Siswa</dt>
                    <dd class="text-sm text-gray-900 dark:text-white sm:col-span-2">
                        @forelse ($kelas->siswa as $siswa)
                            <div class="py-1">{{ $siswa->nama_siswa }}</div>
                        @empty
                            Belum ada siswa di kelas ini.
                        @endforelse
                    </dd>
                </div>
            </dl>
            <div class="mt-6 flex justify-end">
                <a href="{{ route('kelas.edit', $kelas) }}" class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Edit Kelas</a>
            </div>
        </div>
    </div>
@endsection
