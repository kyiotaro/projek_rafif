@extends('layouts.app')
@section('content')

@if(session('success'))
<div style="color:green;">
  {{ session('success') }}
</div>
@endif

<h1>Data Guru</h1>
<p>Selamat datang di Sistem Informasi Data Guru.</p>

<a href="{{ route('guru.create') }}">Tambah Guru</a>

<table border="1" cellpadding="8" cellspacing="0" style="margin-top: 12px; width: 100%;">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Guru</th>
      <th>Mata Pelajaran</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody data-api-list="{{ url('/api/guru') }}">
  @forelse($gurus as $index => $guru)
    <tr data-api-id="{{ $guru->id }}">
      <td>{{ $index + 1 }}</td>
      <td data-api-field="nama_guru">{{ $guru->nama_guru }}</td>
      <td data-api-field="mapel">{{ $guru->mapel }}</td>
      <td>
        <a href="{{ route('guru.edit', $guru->id) }}">edit</a>
        <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" data-api-delete="{{ url('/api/guru/'.$guru->id) }}" data-confirm="Apakah Anda yakin ingin menghapus guru ini?" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus guru ini?')">hapus</button>
        </form>
      </td>
    </tr>
  @empty
    <tr>
      <td colspan="4">Belum ada data guru.</td>
    </tr>
  @endforelse
  </tbody>
</table>
@endsection