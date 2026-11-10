@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6 px-4 sm:px-6 lg:px-8">
        <div>
            <a href="{{ route('kelas.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">&larr; Kembali ke data kelas</a>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Edit Kelas</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Perbarui informasi kelas {{ $kelas->nama_kelas }}.</p>
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
            <form action="{{ route('kelas.update', $kelas) }}" method="POST" data-api-form="{{ url('/api/kelas/'.$kelas->id) }}" data-redirect="{{ route('kelas.index') }}" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label for="nama_kelas" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Kelas</label>
                    <input id="nama_kelas" type="text" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                </div>
                <div>
                    <label for="guru_id" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Wali Kelas</label>
                    <select id="guru_id" name="guru_id" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
                        <option value="">Pilih guru</option>
                        @foreach ($gurus as $guru)
                            <option value="{{ $guru->id }}" @selected(old('guru_id', $kelas->guru_id) == $guru->id)>{{ $guru->nama_guru }} — {{ $guru->mapel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-3 border-t border-gray-100 pt-5 dark:border-gray-700">
                    <a href="{{ route('kelas.index') }}" class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">Batal</a>
                    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
