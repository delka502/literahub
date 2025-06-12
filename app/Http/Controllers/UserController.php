<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Carbon;

use App\Models\Peminjaman; // Pastikan model Peminjaman sudah ada

class UserController extends Controller
{
    public function showloginUser()
    {
        return view('auth.login');
    }

    public function showregisterUser()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Simpan user ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => 'user', // Default level
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->level === 'user') {
                return redirect()->route('dashboard_user'); // Sesuaikan nama route dashboard user
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'Akses hanya untuk pengguna biasa']);
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function dashboard()
    {
        return view('layouts.dashboard_user'); // Ganti jika file blade ada di lokasi lain
    }

    /**
     * Menampilkan halaman profil pengguna (hanya tampilan)
     */
    public function profile()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Hitung buku yang sedang dipinjam (return_date di masa depan)
        $jumlahDipinjam = Peminjaman::where('user_id', $user->id)
                            ->whereDate('return_date', '>', $today)
                            ->count();

        // Hitung buku yang dikembalikan (return_date lewat atau hari ini)
        $jumlahDikembalikan = Peminjaman::where('user_id', $user->id)
                                ->whereDate('return_date', '<=', $today)
                                ->count();

        return view('user.profile', compact('jumlahDipinjam', 'jumlahDikembalikan'));
    }
    /**
     * Menampilkan halaman koleksi buku (hanya tampilan)
     */
    public function bookmarksUser()
    {
        // Tampilkan hanya tampilan bookmarks tanpa implementasi data
        return view('user.bookmarks');
    }

    /**
     * Menampilkan halaman riwayat peminjaman (hanya tampilan)
     */
   public function historyUser()
    {

        return view('user.history');
    }
    
    /**
     * Proses logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}