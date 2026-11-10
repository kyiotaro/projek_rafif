@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">Ringkasan</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Dashboard</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Ringkasan data pada Sistem Informasi Data Siswa.</p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['label' => 'Siswa', 'jumlah' => $jumlahSiswa, 'route' => 'siswa.index', 'warna' => 'indigo'],
                ['label' => 'Guru', 'jumlah' => $jumlahGuru, 'route' => 'guru.index', 'warna' => 'sky'],
                ['label' => 'Kelas', 'jumlah' => $jumlahKelas, 'route' => 'kelas.index', 'warna' => 'violet'],
            ] as $ringkasan)
                <a href="{{ route($ringkasan['route']) }}" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Jumlah {{ $ringkasan['label'] }}</p>
                    <p class="mt-3 text-3xl font-bold text-gray-900 dark:text-white">{{ $ringkasan['jumlah'] }}</p>
                    <span class="mt-4 inline-flex text-sm font-semibold text-indigo-600 dark:text-indigo-400">Lihat data {{ strtolower($ringkasan['label']) }} <span aria-hidden="true" class="ms-1">&rarr;</span></span>
                </a>
            @endforeach
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Selamat datang</h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Gunakan menu di bagian atas untuk melihat dan mengelola data siswa, guru, serta kelas.</p>
            <a href="{{ route('beranda') }}" class="mt-5 inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Buka beranda</a>
        </div>
    </div>
@endsection
