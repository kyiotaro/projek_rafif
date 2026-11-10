@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6 px-4 sm:px-6 lg:px-8">
        <div>
            <a href="{{ route('guru.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">&larr; Kembali ke data guru</a>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Detail Guru</h1>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-8">
            <dl data-api-get="{{ url('/api/guru/'.$guru->id) }}" class="divide-y divide-gray-100 dark:divide-gray-700">
                <div class="grid gap-1 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Guru</dt>
                    <dd data-api-field="nama_guru" class="text-sm text-gray-900 dark:text-white sm:col-span-2">{{ $guru->nama_guru }}</dd>
                </div>
                <div class="grid gap-1 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Mata Pelajaran</dt>
                    <dd data-api-field="mapel" class="text-sm text-gray-900 dark:text-white sm:col-span-2">{{ $guru->mapel }}</dd>
                </div>
                <div class="grid gap-1 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kelas Wali</dt>
                    <dd class="text-sm text-gray-900 dark:text-white sm:col-span-2">
                        @forelse ($guru->kelas as $item)
                            <span class="me-2 inline-flex rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">{{ $item->nama_kelas }}</span>
                        @empty
                            Belum menjadi wali kelas.
                        @endforelse
                    </dd>
                </div>
            </dl>
            <div class="mt-6 flex justify-end">
                <a href="{{ route('guru.edit', $guru) }}" class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Edit Guru</a>
            </div>
        </div>
    </div>
@endsection
