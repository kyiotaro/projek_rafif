@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6 px-4 sm:px-6 lg:px-8">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Data siswa</p>
            <h1 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">Nama siswa: {{ $nama }}</h1>
            <a href="{{ route('siswa.index') }}" class="mt-5 inline-flex font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Kembali ke daftar siswa</a>
        </div>
    </div>
@endsection
