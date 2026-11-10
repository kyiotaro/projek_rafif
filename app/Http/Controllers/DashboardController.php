<?php

namespace App\Http\Controllers;

use App\Models\siswa;
use App\Models\guru;
use App\Models\kelas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function beranda()
    {
        $judul = "Beranda";
        $kelas = kelas::orderBy('nama_kelas')->get();

        return view('beranda', compact('judul', 'kelas'));
    }
    public function dashboard()
    {
        $judul = "Dashboard";
        $jumlahSiswa = siswa::count();
        $jumlahGuru = guru::count();
        $jumlahKelas = kelas::count();

        return view('dashboard', compact('judul', 'jumlahSiswa', 'jumlahGuru', 'jumlahKelas'));
    }
    public function guru() {
        $judul = "Guru";
        return view('guru', compact('judul'));
    }
    public function kelas() {
        $judul = "Kelas";
        return view('kelas', compact('judul'));
    }
    public function profil() {
        $judul = "Profil";
        return view('profil', compact('judul'));
    }
    public function siswa() {
        $judul = "Siswa";
        $siswas = siswa::all();
        return view('siswa', compact('judul'));
    }
    public function namaSiswa($nama) {
        return view('siswa.nama', compact('nama'));
    }

    public function create() {
        $judul = "Create";
        return view('create', compact('judul'));
    }
}
