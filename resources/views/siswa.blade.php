@extends('layouts.app')
@section('content')

@if(session('success'))

<div style="color:green;">
  {{ session('success') }}
</div>

@endif
<h1>Data Siswa</h1>
<p>Selamat datang di Sistem Informasi Data Siswa.</p>

<table border="1" cellpadding="8" cellspacing="0">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Berat Badan</th>
      <th>Tinggi Badan</th>
      <th>Kelas</th>
      <th>Wali kelas</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody data-api-list="{{ url('/api/siswa') }}">
  @foreach($siswas as $index => $s)
    <tr data-api-id="{{ $s->id }}">
      <td>{{ $index + 1 }}</td>
      <td data-api-field="nama_siswa">{{ $s->nama_siswa }}</td>
      <td data-api-field="Bb">{{ $s->Bb }}</td>
      <td data-api-field="Tb">{{ $s->Tb }}</td>
      <td data-api-field="kelas.nama_kelas" data-api-default="Tidak ada kelas">{{ $s->kelas->nama_kelas ?? 'Tidak ada kelas' }}</td>
      <td data-api-field="kelas.guru.nama_guru" data-api-default="Tidak ada guru">{{ $s->kelas->guru->nama_guru ?? 'Tidak ada guru' }}</td>
      <td>
        <a href="{{ route('siswa.edit', $s->id) }}">edit</a>
        <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" data-api-delete="{{ url('/api/siswa/'.$s->id) }}" data-confirm="Apakah Anda yakin ingin menghapus siswa ini?" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit">hapus</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>

{{ $siswas->links() }}

@endsection