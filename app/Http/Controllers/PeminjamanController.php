<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // <-- Pastikan ini ada
use Illuminate\Support\Str; // <-- Tambahkan ini untuk memotong string

class PeminjamanController extends Controller
{
    /**
     * INI ADALAH METHOD BARU UNTUK HALAMAN RAK BUKU
     * Menampilkan buku yang sedang aktif dipinjam oleh pengguna.
     */
    public function rakBuku()
    {
        // 1. Dapatkan user yang sedang login
        $user = Auth::user();
        if (!$user) {
            // Jika tidak ada user login, arahkan ke halaman login
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat rak buku Anda.');
        }

        // 2. Ambil data peminjaman yang masih aktif untuk user ini
        // Menggunakan paginate() untuk membatasi 6 buku per halaman
        $daftarPeminjaman = Peminjaman::where('user_id', $user->id)
            ->whereIn('status', ['Dipinjam', 'Terlambat']) // Hanya tampilkan yang masih dipinjam/terlambat
            ->orderBy('return_date', 'asc') // Urutkan berdasarkan yang paling cepat jatuh tempo
            ->paginate(6); // Ganti angka 6 sesuai jumlah buku yang ingin ditampilkan per halaman

        // 3. Ambil data untuk kartu statistik (opsional tapi bagus untuk UX)
        $totalPinjaman = Peminjaman::where('user_id', $user->id)
                                    ->whereIn('status', ['Dipinjam', 'Terlambat'])
                                    ->count();

        // Cari 1 buku yang akan segera berakhir (dalam 7 hari ke depan)
        $segeraBerakhir = Peminjaman::where('user_id', $user->id)
            ->whereIn('status', ['Dipinjam', 'Terlambat'])
            ->where('return_date', '>', now())
            ->where('return_date', '<=', now()->addDays(7))
            ->orderBy('return_date', 'asc')
            ->first();

        // 4. Kirim semua data ke view 'bookmarks'
        return view('bookmarks', [ // <-- DIUBAH DI SINI
            'daftarPeminjaman' => $daftarPeminjaman,
            'totalPinjaman' => $totalPinjaman,
            'segeraBerakhir' => $segeraBerakhir,
        ]);
    }

    // --- Letakkan method-method Anda yang lain di sini ---

    /**
     * Menyimpan data peminjaman buku ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'book_id' => 'required',
            'book_title' => 'required',
            'fullname' => 'required',
            'student_id' => 'required',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after:borrow_date',
            'purpose' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            // Simpan data peminjaman
            $peminjaman = new Peminjaman();
            $peminjaman->book_id = $request->book_id;
            $peminjaman->book_title = $request->book_title;
            $peminjaman->book_authors = $request->book_authors;
            $peminjaman->book_isbn = $request->book_isbn;
            $peminjaman->fullname = $request->fullname;
            $peminjaman->student_id = $request->student_id;
            $peminjaman->borrow_date = $request->borrow_date;
            $peminjaman->return_date = $request->return_date;
            $peminjaman->purpose = $request->purpose;
            
            // Tambahkan user_id jika user sudah login
            /** @var \Illuminate\Contracts\Auth\Guard $auth */
            $auth = auth();

            if ($auth->check()) {
                $peminjaman->user_id = $auth->id();
            }

            
            $peminjaman->save();

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman buku berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Menampilkan daftar peminjaman untuk pengguna tertentu
     */
    public function userLoans($studentId)
    {
        $peminjaman = Peminjaman::where('student_id', $studentId)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                                    
        return view('peminjaman.user-loans', compact('peminjaman'));
    }
    
    /**
     * Menampilkan semua peminjaman (untuk admin)
     */
    public function index()
    {
        $peminjaman = Peminjaman::orderBy('created_at', 'desc')->get();
        
        return view('admin.peminjaman.index', compact('peminjaman'));
    }


    public function history()
    {
        /** @var \Illuminate\Contracts\Auth\Guard $auth */
        $auth = auth();
        $user = $auth->user();

        
        // Gunakan student_id yang cocok dengan nama pengguna (ini hanya sementara)
        // Idealnya, gunakan user_id setelah migrasi
        $peminjaman = Peminjaman::where('user_id', $user->id)
            ->orWhere('fullname', 'like', '%' . $user->name . '%')
            ->orWhere('student_id', $user->id) // Jika student_id sama dengan user id
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('user.history', compact('peminjaman'));
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Pastikan hanya pemilik peminjaman yang bisa melihat detailnya
        /** @var \Illuminate\Contracts\Auth\Guard $auth */
        $auth = auth();
        $user = $auth->user();

        if ($peminjaman->user_id != $user->id && 
            $peminjaman->fullname != $user->name && 
            $peminjaman->student_id != $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak diizinkan melihat data ini'
            ], 403);
        }
        
        return response()->json([
            'success' => true,
            'data' => $peminjaman
        ]);
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'Dikembalikan';
        $peminjaman->actual_return_date = now();
        $peminjaman->save(); 

        return redirect()->back()->with('success', 'Buku berhasil ditandai sebagai dikembalikan.');
    }


    public function extend($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Pastikan hanya pemilik peminjaman yang bisa memperpanjang
        /** @var \Illuminate\Contracts\Auth\Guard $auth */
        $auth = auth();
        $user = $auth->user();

        if ($peminjaman->user_id != $user->id && 
            $peminjaman->fullname != $user->name && 
            $peminjaman->student_id != $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak diizinkan memperpanjang peminjaman ini'
            ], 403);
        }
        
        // Cek apakah peminjaman bisa diperpanjang
        if ($peminjaman->status == 'Dikembalikan') {
            return response()->json([
                'success' => false,
                'message' => 'Buku sudah dikembalikan, tidak bisa diperpanjang'
            ], 400);
        }
        
        // Pengecekan status terlambat yang lebih akurat
        if (Carbon::parse($peminjaman->return_date)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman sudah terlambat, tidak bisa diperpanjang'
            ], 400);
        }
        
        if (!empty($peminjaman->extension_history)) {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman sudah pernah diperpanjang sebelumnya'
            ], 400);
        }
        
        // Perpanjang peminjaman 7 hari
        $currentReturnDate = Carbon::parse($peminjaman->return_date);
        $newReturnDate = $currentReturnDate->copy()->addDays(7);
        
        $extensionHistory = [
            'extended_at' => Carbon::now()->toDateTimeString(),
            'old_return_date' => $currentReturnDate->toDateString(),
            'new_return_date' => $newReturnDate->toDateString(),
            'days_extended' => 7
        ];
        
        $peminjaman->return_date = $newReturnDate;
        $peminjaman->extension_history = json_encode($extensionHistory); // Simpan sebagai JSON
        $peminjaman->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil diperpanjang',
            'data' => $peminjaman
        ]);
    }
}