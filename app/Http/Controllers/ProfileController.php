<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Peminjaman;

class ProfileController extends Controller
{
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
}
