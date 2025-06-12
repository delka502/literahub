<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;
    
    // Nama tabel
    protected $table = 'peminjaman';
    
    // Kolom yang bisa diisi
    protected $fillable = [
        'book_id',
        'book_title',
        'book_authors',
        'book_isbn',
        'fullname',
        'student_id',
        'borrow_date',
        'return_date',
        'actual_return_date',
        'purpose',
        'status',
        'notes',
        'rating',
        'review',
        'extension_history'
        
    ];
    
    // Cast tipe data
    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'actual_return_date' => 'date',
        'extension_history' => 'array'
    ];
    
    /**
     * Check if book is overdue
     */
    public function isOverdue()
    {
        if ($this->status == 'Dikembalikan') {
            return false;
        }
        
        return Carbon::now()->gt($this->return_date);
    }
    
    /**
     * Get days remaining until return date
     */
    public function daysRemaining()
    {
        if ($this->status == 'Dikembalikan') {
            return 0;
        }
        
        return max(0, Carbon::now()->diffInDays($this->return_date, false));
    }
    
    /**
     * Get return status for display
     */
    public function getReturnStatus()
    {
        if ($this->status == 'Dikembalikan') {
            return 'Dikembalikan';
        } elseif ($this->isOverdue()) {
            return 'Terlambat';
        } else {
            return 'Dipinjam';
        }
    }
    
    /**
     * Get properly formatted timeline for display
     */
    public function getTimeline()
    {
        $timeline = [];
        
        // Add borrow event
        $timeline[] = [
            'type' => 'borrowed',
            'icon' => 'fa-arrow-right',
            'badge_class' => 'badge-borrowed',
            'title' => 'Buku Dipinjam',
            'date' => Carbon::parse($this->borrow_date)->format('d F Y'),
            'time' => Carbon::parse($this->created_at)->format('H:i'),
            'description' => 'Durasi peminjaman: ' . Carbon::parse($this->borrow_date)->diffInDays($this->return_date) . ' hari'
        ];
        
        // Add extension event if exists
        if (!empty($this->extension_history)) {
            $extension = is_array($this->extension_history) ? $this->extension_history : json_decode($this->extension_history, true);
            
            if ($extension) {
                $timeline[] = [
                    'type' => 'extension',
                    'icon' => 'fa-sync',
                    'badge_class' => 'badge-processing',
                    'title' => 'Perpanjangan Peminjaman',
                    'date' => Carbon::parse($extension['extended_at'])->format('d F Y'),
                    'time' => Carbon::parse($extension['extended_at'])->format('H:i'),
                    'description' => 'Perpanjangan ' . $extension['days_extended'] . ' hari hingga ' . Carbon::parse($extension['new_return_date'])->format('d F Y')
                ];
            }
        }
        
        // Add return event if returned
        if ($this->status == 'Dikembalikan' && $this->actual_return_date) {
            $returnDate = Carbon::parse($this->actual_return_date);
            $dueDate = Carbon::parse($this->return_date);
            
            $returnDescription = 'Dikembalikan ';
            if ($returnDate->lt($dueDate)) {
                $returnDescription .= $returnDate->diffInDays($dueDate) . ' hari lebih awal';
            } elseif ($returnDate->gt($dueDate)) {
                $returnDescription .= 'terlambat ' . $returnDate->diffInDays($dueDate) . ' hari';
            } else {
                $returnDescription .= 'tepat waktu';
            }
            
            $timeline[] = [
                'type' => 'returned',
                'icon' => 'fa-arrow-left',
                'badge_class' => 'badge-returned',
                'title' => 'Buku Dikembalikan',
                'date' => $returnDate->format('d F Y'),
                'time' => $returnDate->format('H:i'),
                'description' => $returnDescription
            ];
        }
        
        return $timeline;
    }
    
    public function user()
{
    return $this->belongsTo(User::class);
}
    /**
     * Get progress percentage for return deadline
     */
    public function getProgressPercentage()
    {
        if ($this->status == 'Dikembalikan') {
            return 100;
        }
        
        $borrowDate = Carbon::parse($this->borrow_date);
        $returnDate = Carbon::parse($this->return_date);
        $today = Carbon::now();
        
        $totalDays = $borrowDate->diffInDays($returnDate);
        $daysElapsed = $borrowDate->diffInDays($today);
        
        return min(100, max(0, ($daysElapsed / $totalDays) * 100));
    }
   
}