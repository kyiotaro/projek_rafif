@extends('layouts.app')
@section('content')

@if(session('success'))

<div style="color:green;">
  {{ session('success') }}
</div>

@endif

<h1>{{ $judul }}</h1>
<p>Selamat datang di Sistem Informasi Data Siswa.</p>
@endsection