<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

use Illuminate\Support\Facades\Http;



class AdminController extends Controller
{

    public function returns()
{
    // Fetch pending returns (not yet returned)
    $pendingReturns = Peminjaman::where('status', '!=', 'Dikembalikan')
        ->orderBy('return_date', 'asc')
        ->get()
        ->map(function ($loan) {
            // Calculate return status and add extra details
            $returnDate = Carbon::parse($loan->return_date);
            $now = Carbon::now();
            
            // Determine status badge
            if ($now->greaterThan($returnDate)) {
                $statusBadge = 'badge-danger';
                $statusText = 'Terlambat';
            } elseif ($now->diffInDays($returnDate) <= 3) {
                $statusBadge = 'badge-warning';
                $statusText = 'Segera';
            } else {
                $statusBadge = 'badge-primary';
                $statusText = 'Normal';
            }
            
            $loan->status_badge = $statusBadge;
            $loan->status_text = $statusText;
            
            return $loan;
        });

    // Fetch recently returned books
    $returnedBooks = Peminjaman::where('status', 'Dikembalikan')
        ->orderBy('actual_return_date', 'desc')
        ->take(10)
        ->get();

    // Fetch overdue books
    $overdueBooks = Peminjaman::where('status', '!=', 'Dikembalikan')
        ->where('return_date', '<', Carbon::now())
        ->orderBy('return_date', 'asc')
        ->get()
        ->map(function ($loan) {
            // Calculate days overdue and late fee
            $overdueDate = Carbon::parse($loan->return_date);
            $daysOverdue = $overdueDate->diffInDays(Carbon::now());
            
            // Calculate late fee (example: Rp 5000 per day)
            $lateFee = $daysOverdue * 5000;
            
            $loan->days_overdue = $daysOverdue;
            $loan->late_fee = $lateFee;
            
            return $loan;
        });

    return view('layouts.admin_returns', [
        'pendingReturns' => $pendingReturns,
        'returnedBooks' => $returnedBooks,
        'overdueBooks' => $overdueBooks
    ]);
}
    public function showLoginForm()
    {
        return view('auth.leader');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->level === 'admin') {
                return redirect()->route('dashboard_admin');
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'Akses hanya untuk admin']);
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function dashboard()
    {
        // Mengambil 5 peminjaman terbaru
        $recentBorrowings = Peminjaman::orderBy('borrow_date', 'desc')->take(5)->get();
    
        // Mengambil data tren peminjaman dalam 5 bulan terakhir
        $trendData = Peminjaman::selectRaw('MONTH(borrow_date) as month, COUNT(*) as total')
            ->where('borrow_date', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy(DB::raw('MONTH(borrow_date)'))
            ->orderBy('month')
            ->get();
    
        // Menyiapkan array untuk bulan dan total peminjaman
        $months = [];
        $totals = [];
    
        // Looping dari 5 bulan terakhir ke bulan sekarang
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('n'); // Bulan 1-12
            $label = now()->subMonths($i)->format('M Y'); // Format Bulan Tahun (Jan 2025)
            
            // Cari data tren berdasarkan bulan
            $found = $trendData->where('month', $month)->first();
            $months[] = $label;
            $totals[] = $found ? $found->total : 0;
        }
    
        // Mengambil data dari API Google Books
        $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
            'q' => 'subject:books', // query bisa disesuaikan dengan jenis buku
            'maxResults' => 1, // Ambil 1 buku untuk statistik
            'key' => 'AIzaSyCY7R-wqUzpb7P0GYbGsIkQwRQpLzhSRWk', // API key
        ]);
    
        // Mengecek apakah response berhasil
        if ($response->successful()) {
            // Mengambil jumlah buku yang ditemukan
            $totalBooksFromApi = $response->json()['totalItems']; 
        } else {
            $totalBooksFromApi = 0; // Mengatur ke 0 jika gagal
        }
    
        // Mengambil jumlah buku yang dipinjam
        $totalBorrowedBooks = Peminjaman::count();
    
        // Mengambil jumlah buku yang terlambat dikembalikan
        $overdueBooks = Peminjaman::where('return_date', '<', now())->where('status', '!=', 'returned')->count();
    
        // Mengambil semua data pengguna dengan level 'user'
        $allUsers = User::where('level', 'user')->get();
    
        // Menyediakan data untuk tampilan
        return view('layouts.dashboard_admin', compact('recentBorrowings', 'months', 'totals', 'totalBooksFromApi', 'totalBorrowedBooks', 'overdueBooks', 'allUsers'));
    }
    
    
}
