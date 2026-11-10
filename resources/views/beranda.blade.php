@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
        <section class="overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-700 via-indigo-600 to-sky-600 px-6 py-12 text-white shadow-lg sm:px-10 sm:py-16">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-indigo-100">Sistem Informasi</p>
            <h1 class="mt-4 max-w-2xl text-3xl font-bold tracking-tight sm:text-4xl">Data Siswa</h1>
            <p class="mt-4 max-w-2xl text-base leading-7 text-indigo-50">Kelola informasi siswa, guru, dan kelas dalam satu tempat.</p>
            <a href="{{ route('dashboard') }}" class="mt-8 inline-flex items-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-indigo-700 shadow-sm hover:bg-indigo-50">Lihat dashboard</a>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <div class="mb-5">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Cari siswa</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Temukan data siswa berdasarkan nama atau kelas.</p>
            </div>
            <form method="GET" action="{{ route('siswa.index') }}" class="grid gap-4 sm:grid-cols-[1fr_1fr_auto] sm:items-end">
                <div>
                    <label for="keyword" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama siswa</label>
                    <input id="keyword" type="search" name="keyword" value="{{ request('keyword') }}" placeholder="Masukkan nama siswa" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:placeholder-gray-500">
                </div>
                <div>
                    <label for="kelas" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Kelas</label>
                    <select id="kelas" name="kelas" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                        <option value="">Semua kelas</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}" @selected(request('kelas') == $k->id)>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('beranda') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Reset</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Cari</button>
                </div>
            </form>
        </section>

        <section>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Kelola data</h2>
            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                @foreach ([
                    ['label' => 'Siswa', 'deskripsi' => 'Lihat dan kelola data siswa.', 'route' => 'siswa.index'],
                    ['label' => 'Guru', 'deskripsi' => 'Lihat dan kelola data guru.', 'route' => 'guru.index'],
                    ['label' => 'Kelas', 'deskripsi' => 'Lihat dan kelola data kelas.', 'route' => 'kelas.index'],
                ] as $menu)
                    <a href="{{ route($menu['route']) }}" class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-indigo-300 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-indigo-500">
                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $menu['label'] }}</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $menu['deskripsi'] }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    </div>
@endsection
