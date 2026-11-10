@extends('layouts.app')
@section('content')

@if(session('success'))
<div style="color:green;">
  {{ session('success') }}
</div>
@endif

<h1>Data Kelas</h1>
<p>Selamat datang di Sistem Informasi Data Kelas.</p>

<a href="{{ route('kelas.create') }}">Tambah Kelas</a>

<table border="1" cellpadding="8" cellspacing="0" style="margin-top: 12px; width: 100%;">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Kelas</th>
      <th>Guru</th>
      <th>Siswa</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody data-api-list="{{ url('/api/kelas') }}">
  @forelse($kelas as $index => $k)
    <tr data-api-id="{{ $k->id }}">
      <td>{{ $index + 1 }}</td>
      <td data-api-field="nama_kelas">{{ $k->nama_kelas }}</td>
      <td data-api-field="guru.nama_guru" data-api-default="Tidak ada guru">{{ $k->guru->nama_guru ?? 'Tidak ada guru' }}</td>
      <td>
        <ol>
          @forelse($k->siswa as $siswa)
            <li>{{ $siswa->nama_siswa }}</li>
          @empty
            <li>Belum ada siswa</li>
          @endforelse
        </ol>
      </td>
      <td>
        <a href="{{ route('kelas.edit', $k->id) }}">edit</a>
        <form action="{{ route('kelas.destroy', $k->id) }}" method="POST" data-api-delete="{{ url('/api/kelas/'.$k->id) }}" data-confirm="Apakah Anda yakin ingin menghapus kelas ini?" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">hapus</button>
        </form>
      </td>
    </tr>
  @empty
    <tr>
      <td colspan="3">Belum ada data kelas.</td>
    </tr>
  @endforelse
  </tbody>
</table>
@endsection