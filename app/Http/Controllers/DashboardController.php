<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = strtolower($user->role->nama_role ?? '');

        $totalPengguna = User::count();
        $totalMahasiswa = Mahasiswa::count();
        $totalMataKuliah = Matakuliah::count();

        if ($role === 'admin') {
            $dataMahasiswa = Mahasiswa::latest()->take(5)->get();
            $dataMataKuliah = Matakuliah::all();
            $dataNilai = Nilai::with(['mahasiswa', 'matakuliah'])->latest()->take(5)->get();

            return view('dashboard.admin', compact('user', 'totalPengguna', 'totalMahasiswa', 'totalMataKuliah', 'dataMahasiswa', 'dataMataKuliah', 'dataNilai'));
        }

        if ($role === 'dosen') {
            $dataMahasiswa = Mahasiswa::all();
            $dataMataKuliah = Matakuliah::all();
            $dataNilai = Nilai::with(['mahasiswa', 'matakuliah'])->latest()->get();

            return view('dashboard.dosen', compact('user', 'totalPengguna', 'totalMahasiswa', 'totalMataKuliah', 'dataMahasiswa', 'dataMataKuliah', 'dataNilai'));
        }

        if ($role === 'mahasiswa') {
            $mhs = Mahasiswa::where('user_id', $user->id)->first();
            $dataMahasiswa = $mhs ? collect([$mhs]) : collect();
            $dataNilai = $mhs ? Nilai::with('matakuliah')->where('mahasiswa_id', $mhs->id)->get() : collect();
            $dataMataKuliah = Matakuliah::all();

            return view('dashboard.mahasiswa', compact('user', 'totalPengguna', 'totalMahasiswa', 'totalMataKuliah', 'dataMahasiswa', 'dataMataKuliah', 'dataNilai'));
        }

        abort(403);
    }
}
